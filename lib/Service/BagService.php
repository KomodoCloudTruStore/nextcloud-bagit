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

	public function create($fileId, $userId, $hash='md5', $createEvent=true) {

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

		if ($createEvent) {

			$this->createActivityEvent($userId, 'create_bagit_subject', $fileId);

		}

		return $this->mapper->insert($bag);
	}

	public function createActivityEvent($userId, $subject, $fileId)
	{

		$userFolder = $this->server->getUserFolder($userId)->getParent();
		$originalFolder = $userFolder->getById($fileId)[0];

		$path = $originalFolder->getInternalPath();


		$event = $this->activity->generateEvent();

		$event->setApp('bagit');
		$event->setType('bagit');
		$event->setAffectedUser($userId);
		$event->setAuthor($userId);
		$event->setSubject($subject, [$userId, $path]);
		$event->setObject('files', (int) $fileId);

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

	public function update($fileId, $userId) {

		$bags = $this->mapper->findByFileId($fileId, $userId);

		$bagId = $bags[0]->getBagId();

    	$this->delete($bagId, $userId, false);
    	$this->create($fileId, $userId, 'md5', false);

    	try {

            $bag = new Bag();

            $bag->setUserId($userId);
			$bag->setFileId($fileId);
			$bag->setBagId($bagId);
            $bag->setStatus('updated');
            $bag->setTimestamp(date("Y-m-d H:i:s"));

			$this->createActivityEvent($userId, 'update_bagit_subject', $fileId);

            return $this->mapper->insert($bag);

        } catch(Exception $e) {

            $this->handleException($e);

        }

    }

	public function validate($fileId, $userId) {

		$bags = $this->mapper->findByFileId($fileId, $userId);

		$bagId = $bags[0]->getBagId();

    	try {

			$bag = new Bag();

			$bag->setUserId($userId);
			$bag->setFileId($fileId);
			$bag->setBagId($bagId);
			$bag->setStatus('validated');
			$bag->setTimestamp(date("Y-m-d H:i:s"));

			$this->createActivityEvent($userId, 'validate_bagit_subject', $fileId);

			return $this->mapper->insert($bag);

		} catch(Exception $e) {

			$this->handleException($e);
			return false;

		}

	}

    public function delete($bagId, $userId, $createEvent=true) {
        try {
            $bags = $this->mapper->findByBagId($bagId, $userId);

            $fileId = $bags[0]->getFileId();
            foreach ($bags as $bag) {

            	$this->mapper->delete($bag);

			}

			$userFolder = $this->server->getUserFolder($userId)->getParent();
			$bagStorage = new BagStorage($userFolder);

			$bagStorage->deleteBag($bagId);

			if ($createEvent) {

				$this->createActivityEvent($userId, 'delete_bagit_subject', $fileId);

			}

			return true;

        } catch(Exception $e) {
            $this->handleException($e);
            return false;
        }
    }

}