<?php

namespace OCA\BagIt\Service;

use OCA\BagIt\Storage\BagItStorage;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\Activity\IManager;
use OCP\IUserSession;
use OCP\IUser;
use OCA\BagIt\Db\BagItBag;
use OCA\BagIt\Db\BagItBagMapper;

class BagItService
{

    private $mapper;
    private $activityManager;
    private $storage;
    protected $session;

    public function __construct(IManager $activity, IUserSession $session, BagitBagMapper $mapper, BagItStorage $storage)
    {
        $this->mapper = $mapper;
        $this->activityManager = $activity;
        $this->session = $session;
        $this->storage = $storage;
    }

    private function handleException($e)
    {
        if ($e instanceof DoesNotExistException ||
            $e instanceof MultipleObjectsReturnedException
        ) {
            throw new BagItServiceNotFoundException($e->getMessage());
        } else {
            throw $e;
        }
    }

    public function createBag($id) {

        $node = $this->storage->getFilesAppNode($id);

        $this->storage->createBag($node);

    }

    public function validate()
    {

        return true;
    }

    public function createEvent($bagId)
    {
        $actor = $this->session->getUser();
        if ($actor instanceof IUser) {
            $actor = $actor->getUID();
        } else {
            $actor = '';
        }
        $event = $this->activityManager->generateEvent();
        $event->setApp('bagit');
        $event->setType('bagit_bags');
        $event->setAffectedUser($actor);
        $event->setAuthor($actor);
        $event->setTimestamp(time());
        $event->setSubject('Created new Bag');
        $event->setObject('bagit', $bagId);
        $this->activityManager->publish($event);
    }

    public function index()
    {

        return $this->storage->getBagsAsJSON();

    }

    public function show($id)
    {
        return $this->storage->getBagContents($id);
    }

    public function create($id)
    {

        $this->createBag($id);

        $bag = new BagItBag();
        $bag->setFileId($id);
        $bag->setName('collection-' . $id . '.tar.gz');
        $bag->setReplicaD(0);
        $bag->setReplicaSm(0);
        $bag->setSize(0);
        $bag->setTimestamp(date("Y-m-d H:i:s"));
        $createdBag = $this->mapper->insert($bag);
        $this->createEvent($createdBag->getId());
        return $createdBag;

    }
}