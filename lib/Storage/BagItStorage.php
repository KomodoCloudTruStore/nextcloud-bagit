<?php

namespace OCA\Bagit\Storage;

use \DateTime;

use OCP\IServerContainer;

use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\Node;

class BagitStorage {

    private $userId;
    private $userFilesFolder;

    public function __construct(IServerContainer $server, $UserId)
    {

        $this->userId = $UserId;
        $this->userFilesFolder = $server->getUserFolder($this->userId);
        $this->userBagitFolder = $this->getUserBagItFolder();

    }

    private function createBagItTxtFile(Folder $bagFolder)
    {

        $file = $bagFolder->newFile('bagit.txt');

        $lineOne = 'BagIt-Version: 0.97';
        $lineTwo = 'Tag-File-Character-Encoding: UTF-8';

        $file->putContent($lineOne . PHP_EOL . $lineTwo);

    }

    private function createDataDirectory(Folder $bagFolder, array $files) {

        $dataFolder = $bagFolder->newFolder('data');

        foreach($files as $file) {

            $this->initializeParentFolders($dataFolder, $file);

            $bagPath = $file->getInternalPath();

            $bagPath = substr($bagPath, 6);

            $bagItFile = $dataFolder->newFile($bagPath);

            $fileContent = $file->getContent();

            $bagItFile->putContent($fileContent);

        }

    }

    private function createManifest(Folder $bagFolder, array $files, $hash='md5')
    {

        $manifestFile = $bagFolder->newFile('manifest-'. $hash .'.txt');

        $content = '';

        foreach($files as $file) {

            $fileHash = $this->getHash($file, $hash);
            $bagPath = 'data/' . $file->getInternalPath();

            $content = $content . $fileHash . ' ' . $bagPath . PHP_EOL;

        }

        $manifestFile->putContent($content);

    }

    private function initializeParentFolders(Folder $dataRoot, File $file)
    {

        $parentQueue = [];

        $parentDirectory = $file->getParent();

        array_unshift($parentQueue, $parentDirectory);

        while (count($parentQueue) > 0) {

            $parent = array_shift($parentQueue);

            if ($parent->getName() != substr($parent->getInternalPath(), 6)) {

                $grandParent = $parent->getParent();
                array_unshift($parentQueue, $parent);
                array_unshift($parentQueue, $grandParent);

            } else {

                $dataRoot->newFolder($parent->getName());

            }

        }

    }

    public function clearBagItFolder()
    {

        $this->userBagitFolder->delete();

    }

    public function createBag(Node $node, $hash='md5')
    {

        $today = new DateTime();

        $bagFolderName = $node->getId() . '-' . $today->getTimestamp();

        $bagFolder = $this->userBagitFolder->newFolder($bagFolderName);

        $this->createBagItTxtFile($bagFolder);

        $bagFiles = $this->flattenFolderStructure($node);

        $this->createManifest($bagFolder, $bagFiles, $hash);

        $this->createDataDirectory($bagFolder, $bagFiles);

    }

    public function flattenFolderStructure(Node $node)
    {

        $queue = [$node];
        $nodes = [];

        while (count($queue) > 0) {

            $node = array_shift($queue);

            if ($this->isFolder($node)) {

                foreach($node->getDirectoryListing() as $child) {

                    array_push($queue, $child);

                }

            } else {

                array_push($nodes, $node);

            }

        }

        return $nodes;

    }

    public function getBagContents($id)
    {

        $node = $this->getBagItAppNode($id);

        $jsonArray = [];

        foreach($node->getDirectoryListing() as $n) {

            $temp = [];

            $temp['id'] = $n->getId();
            $temp['name'] = $n->getName();
            $temp['replica_d'] = 100;
            $temp['replica_sm'] = 100;
            $temp['size'] = $n->getSize();
            $temp['timestamp'] = $n->getMTime();

            if ($this->isFolder($n)) {

                $temp['type'] = 'dir';

            } else {

                $temp['type'] = 'file';

            }


            array_push($jsonArray, $temp);

        }

        $json = json_encode($jsonArray);

        return $json;



    }

    public function getBags()
    {

        return $this->userBagitFolder->getDirectoryListing();

    }

    public function getBagsAsJSON() {

        $jsonArray = [];

        foreach($this->getBags() as $bag) {

            $dataFolder = $bag->get('/data');
            $rootDataFolder = $dataFolder->getDirectoryListing()[0];

            $bagObj = [];

            $bagObj['id'] = $bag->getId();
            $bagObj['name'] = $rootDataFolder->getName();
            $bagObj['replica_d'] = 100;
            $bagObj['replica_sm'] = 100;
            $bagObj['size'] = $bag->getSize();
            $bagObj['timestamp'] = $bag->getMTime();
            $bagObj['type'] = 'bag';

            array_push($jsonArray, $bagObj);

        }

        $json = json_encode($jsonArray);

        return $json;

    }

    public function getBagItAppNode($id)
    {

        return $this->userBagitFolder->getById($id)[0];

    }

    public function getFilesAppNode($id)
    {

        return $this->userFilesFolder->getById($id)[0];

    }

    public function getHash($file, $hash='md5') {

        if ($hash == 'sha256') {

            return $this->getSHA256($file);

        } else {

            return $this->getMD5($file);

        }

    }

    public function getMD5(File $file) {

        return $file->hash('md5');

    }

    public function getSHA256(File $file) {

        return $file->hash('sha256');

    }

    public function getUserBagItFolder()
    {

        $userRoot = $this->userFilesFolder->getParent();

        if (!$userRoot->nodeExists('bagit')) {

            return $userRoot->newFolder('bagit');

        }

        return $userRoot->get('/bagit');

    }

    public function isFile(Node $node)
    {

        return $node->getType() == 'file';


    }

    public function isFolder(Node $node)
    {

        return $node->getType() == 'dir';


    }


}