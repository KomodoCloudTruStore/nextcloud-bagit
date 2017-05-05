<?php

namespace OCA\BagIt\Service;

use Exception;
use OCA\BagIt\Service\BagitNotFoundException;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\Activity\IManager;
use OCP\IUserSession;
use OCP\IUser;
use OCA\BagIt\Db\BagitBag;
use OCA\BagIt\Db\BagitBagMapper;

class BagitService
{

    private $mapper;
    private $activityManager;
    protected $session;

    public function __construct(IManager $activity, IUserSession $session, BagitBagMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->activityManager = $activity;
        $this->session = $session;
    }

    private function handleException($e)
    {
        if ($e instanceof DoesNotExistException ||
            $e instanceof MultipleObjectsReturnedException
        ) {
            throw new BagitNotFoundException($e->getMessage());
        } else {
            throw $e;
        }
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
        try {
            return $this->mapper->findAll();
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function show($id)
    {
        try {
            return $this->mapper->show($id);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function create($id)
    {

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