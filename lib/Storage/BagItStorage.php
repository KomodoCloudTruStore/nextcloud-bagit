<?php

namespace OCA\BagIt\Storage;


use OCP\IUserSession;


class BagItStorage {

    private $folder;
    private $storage;

    public function __construct(IUserSession $session)
    {
        $this->folder = \OC::$server->getUserFolder($session->getUser()->getUID());
        $this->storage = $this->folder->getStorage();
    }

    public function checkForApplicationFolder()
    {
        $this->storage->mkdir('bagit');
    }

    public function getBagStuff($id) {

        $bagFolder = $this->storage->getLocalFile('/bagit/' . $id);

    }

    public function getNode($id) {
        return $this->folder->getById($id)[0];
    }


    public function makeBag($id)
    {

        $stuff = $this->getNode($id);

        $root = $this->storage->getLocalFile('/');

        $this->storage->mkdir('/bagit/' . $id);
        $this->storage->mkdir('/bagit/' . $id . '/data');

        $this->storage->touch('/bagit/' . $id . '/manifest-md5.txt');
        $this->storage->touch('/bagit/' . $id . '/bagit.txt');


    }

}