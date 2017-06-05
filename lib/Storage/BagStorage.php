<?php

namespace OCA\BagIt\Storage;

use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\Node;

class BagStorage
{

	const BAGIT_VERSION = '0.97';
	const BAGIT_ENCODING = 'UTF-8';

	private $userFolder;
	private $filesAppFolder;
	private $bagItAppFolder;

	public function __construct(Folder $userFolder) {

		$this->userFolder = $userFolder;
		$this->bagItAppFolder = $this->setBagItFolder();
		$this->filesAppFolder = $this->setFilesFolder();

	}

	private function setBagItFolder()
	{

		if ($this->userFolder->nodeExists('bagit')) {

			return $this->userFolder->get('bagit');

		} else {

			return $this->userFolder->newFolder('bagit');

		}

	}

	private function setFilesFolder()
	{

		return $this->userFolder->get('files');

	}

	public function createBagItTextFile(Folder $parent)
	{

		$file = $parent->newFile('bagit.txt');
		$lineOne = 'BagIt-Version: ' . BagStorage::BAGIT_VERSION;
		$lineTwo = 'Tag-File-Character-Encoding: ' . BagStorage::BAGIT_ENCODING;
		$file->putContent($lineOne . PHP_EOL . $lineTwo);

		return $file;

	}

	public function createDataDirectory(Folder $parent, array $files) {

		$dataFolder = $parent->newFolder('data');

		foreach($files as $file) {

			$this->initializeParentFolders($dataFolder, $file);
			$bagPath = $file->getInternalPath();
			$bagPath = substr($bagPath, 6);
			$bagItFile = $dataFolder->newFile($bagPath);
			$fileContent = $file->getContent();
			$bagItFile->putContent($fileContent);

		}

		return $dataFolder;
	}

	public function createManifestFile(Folder $parent, array $files, $hash='md5')
	{

		$manifestFile = $parent->newFile('manifest-'. $hash .'.txt');
		$content = '';

		foreach($files as $file) {

			$fileHash = $this->getHash($file, $hash);
			$bagPath = 'data/' . $file->getInternalPath();
			$content = $content . $fileHash . ' ' . $bagPath . PHP_EOL;

		}

		$manifestFile->putContent($content);

		return $manifestFile;
	}

	public function createBag($fileId, $hash='md5')
	{

		$node = $this->filesAppFolder->getById($fileId)[0];

		$bagFolderName = $node->getName();

		$bagFolder = $this->bagItAppFolder->newFolder($bagFolderName);
		$this->createBagItTextFile($bagFolder);

		$bagFiles = $this->flattenFolderStructure($node);
		$this->createManifestFile($bagFolder, $bagFiles, $hash);
		$this->createDataDirectory($bagFolder, $bagFiles);

		return $bagFolder;
	}

	public function deleteBag($fileId)
	{

		$node = $this->bagItAppFolder->getById($fileId)[0];

		$node->delete();

	}

	public function getBagContents($id)
	{
		$node = $this->bagItAppFolder->getById($id)[0];
		$jsonArray = [];
		foreach($node->getDirectoryListing() as $n) {
			$temp = [];
			$temp['id'] = $n->getId();
			$temp['name'] = $n->getName();
			$temp['replica_d'] = 0;
			$temp['replica_sm'] = 0;
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

	public function getBagItAppFolder()
	{

		return $this->bagItAppFolder;

	}

	public function getFilesAppFolder()
	{

		return $this->filesAppFolder;

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

	public function initializeParentFolders(Folder $dataRoot, File $file)
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

	public function isFile(Node $node)
	{
		return $node->getType() == 'file';
	}

	public function isFolder(Node $node)
	{
		return $node->getType() == 'dir';
	}

}