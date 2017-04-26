<?php

namespace OCA\BagIt\Storage;


class BagItStorage {

    private $storage;
    private $bagItNode;

    public function __construct($storage){

        $this->storage = $storage;

        if (!$this->storage->nodeExists('.bagit/')) {

            $this->storage->newFolder('.bagit/');

        }

        $this->bagItNode = $this->storage->get('.bagit/');

    }

    public function createBagItFile($bag)
    {

        $bagitFile = $bag->newFile('bagit.txt');
        $bagitFile->putContent('BagIt-Version: 0.97\\n');
        $bagitFile->putContent('Tag-File-Character-Encoding: UTF-8');

    }

    public function traverseFiles($node, $meta, $data) {

        $directory = new \RecursiveDirectoryIterator(($node->getPath()));
        $iterator = new \RecursiveIteratorIterator($directory);

        foreach ($iterator as $info) {

            $meta->putContent($info);

        }

    }

    public function createBag($id) {

        $toBeBagged = $this->storage->getById($id);

        $tobeBaggedName = $toBeBagged[0]->getName();

        $bag = $this->bagItNode->newFolder($tobeBaggedName);

        $data = $this->bagItNode->newFolder($tobeBaggedName . '/data');

        $this->createBagItFile($bag);

        $meta =  $bag->newFile('manifest-md5.txt');

        //TODO Correct this error...

        //$this->traverseFiles($toBeBagged[0], $meta, $data);

        return true;

    }

    public function getABag($id) {

        $response = [];

        $count = 0;

        foreach ($this->getNode($id)->getDirectoryListing() as $child) {

            $response[$count] = [

                'id' => $child->getId(),
                'name' => $child->getName(),
                'path' => $child->getInternalPath(),
                'size' => $child->getSize(),
                'time' => $child->getMTime(),
                'type' => $child->getType()

            ];

            $count = $count + 1;

        }

        return $response;

    }

    public function getBags()
    {

        $response = [];

        $count = 0;

        foreach ($this->bagItNode->getDirectoryListing() as $child) {

            $response[$count] = [

                'id' => $child->getId(),
                'name' => $child->getName(),
                'path' => $child->getInternalPath()

            ];

            $count = $count + 1;

        }

        return $response;

    }

    public function getNode($id) {
        try {
            return $this->storage->getById($id)[0];
        } catch(\OCP\Files\NotFoundException $e) {
            throw new BagItStorageException('Node does not exist');
        }
    }

    public function getHash($id, $type) {

        if ($type === "md5") {

            return $this->getMD5($id, $this->storage);

        } elseif ($type === "sha256") {

            return $this->getSHA256($id, $this->storage);

        } else {

            throw new BagItStorageException('Unsupported Algorithm');

        }

    }

    public function getMD5($id, $storage) {

        $node = $this->getNode($id, $storage);

        return $node->getStorage()->hash('md5', $node->getInternalPath());

    }

    public function getSHA256($id, $storage) {

        $node = $this->getNode($id, $storage);

        return $node->getStorage()->hash('sha256', $node->getInternalPath());

    }

}