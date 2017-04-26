<?php

namespace OCA\BagIt\Service;


use Exception;

use OCA\BagIt\Storage\BagItStorage;
use OCP\Activity\IManager;
use OCP\IUserSession;
use OCP\IUser;

class BagItService {

    private $activityManager;
    protected $session;
    private $storage;

    public function __construct(IManager $activity, IUserSession $session, BagItStorage $storage){

        $this->activityManager = $activity;
        $this->storage = $storage;
        $this->session = $session;

    }

    public function createEvent($id)
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
        $event->setSubject('Created a new Bag...');
        $event->setObject('Node', $id);
        $this->activityManager->publish($event);
    }


    private function handleException ($e) {
        throw $e;
    }

    public function createBag($id) {

        //$this->createEvent($id);

        return $this->storage->createBag($id);

    }

    public function getBags() {

        return $this->storage->getBags();

    }

    public function getABag($id) {

        return $this->storage->getABag($id);

    }



}