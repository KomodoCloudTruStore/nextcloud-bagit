<?php
namespace OCA\BagIt\Service;

use Exception;

use OCA\BagIt\Storage\BagStorage;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\BagIt\Db\Bag;
use OCA\BagIt\Db\BagMapper;
use OCP\IServerContainer;
use OCP\Activity\IManager;

class BagService
{

    private $mapper;
    private $server;
    private $activity;

    public function __construct(IServerContainer $server, IManager $activity, BagMapper $mapper){

        $this->mapper = $mapper;
        $this->server = $server;
        $this->activity = $activity;

    }

	public function create($fileId, $userId, $hash='md5') {

		$userFolder = $this->server->getUserFolder($userId)->getParent();
		$bagStorage = new BagStorage($userFolder);

		$bagFolder = $bagStorage->createBag($fileId, $hash);
		$bagId = $bagFolder->getId();


		$bag = new Bag();

		$bag->setFileId($fileId);
		$bag->setBagId($bagId);
		$bag->setUserId($userId);
		$bag->setStatus('created');
		$bag->setTimestamp(date("Y-m-d H:i:s"));

		$this->createActivityEvent($userId, 'Bag Created', $bagId);

		return $this->mapper->insert($bag);
	}

	public function createActivityEvent($userId, $subject, $fileId)
	{

		$event = $this->activity->generateEvent();

		$event->setApp('bagit');
		$event->setType('bags');
		$event->setAffectedUser($userId);
		$event->setAuthor($userId);
		$event->setTimestamp(time());
		$event->setSubject($subject);
		$event->setObject('files', $fileId);

		$this->activity->publish($event);

	}

    public function findAll($userId) {

        $items = [];

    	$bags = $this->mapper->findAll($userId);

		$userFolder = $this->server->getUserFolder($userId)->getParent();

		foreach($bags as $bag) {

        	$folder = $userFolder->getById($bag->getBagId())[0];

			$item = [

				'id' => $bag->getBagId(),
				'name' => $folder->getName(),
				'replica_d' => 0,
				'replica_sm' => 0,
				'size' => $folder->getSize(),
				'timestamp' => $bag->getTimestamp(),
				'type' => 'bag'

			];

			array_push($items, $item);

		}

		return $items;

    }

    private function handleException ($e) {

        if ($e instanceof DoesNotExistException ||
            $e instanceof MultipleObjectsReturnedException) {
            throw new NotFoundException($e->getMessage());
        } else {
            throw $e;
        }

    }

    public function findByBagId($bagId, $userId) {

		return $this->mapper->findByBagId($bagId, $userId);

	}

	public function findByFileId($fileId, $userId) {

		return $this->mapper->findByFileId($fileId, $userId);

	}

	public function showContent($fileId, $userId) {

		$userFolder = $this->server->getUserFolder($userId)->getParent();
		$bagStorage = new BagStorage($userFolder);

		return $bagStorage->getBagContents($fileId);
	}

	public function update($fileId, $bagId, $userId) {

        try {

            $bag = new Bag();

            $bag->setUserId($userId);
			$bag->setFileId($fileId);
			$bag->setBagId($bagId);
            $bag->setStatus('updated');
            $bag->setTimestamp(date("Y-m-d H:i:s"));

			$this->createActivityEvent($userId, 'Bag Updated', $bagId);

            return $this->mapper->insert($bag);

        } catch(Exception $e) {

            $this->handleException($e);

        }

    }

    public function delete($bagId, $userId) {
        try {
            $bags = $this->mapper->findByBagId($bagId, $userId);
            foreach ($bags as $bag) {

				$this->mapper->delete($bag);

			}

			$userFolder = $this->server->getUserFolder($userId)->getParent();
			$bagStorage = new BagStorage($userFolder);

			$bagStorage->deleteBag($bagId);

			$this->createActivityEvent($userId, 'Bag Deleted', $bagId);

			return true;

        } catch(Exception $e) {
            $this->handleException($e);
            return false;
        }
    }

}