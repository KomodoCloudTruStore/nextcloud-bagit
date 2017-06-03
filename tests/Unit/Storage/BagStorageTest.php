<?php

namespace OCA\BagIt\Tests\Unit\Storage;

use PHPUnit_Framework_TestCase;

use OCA\BagIt\Storage\BagStorage;

class BagStorageTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var \OCP\Files\Folder
	 */

	private $testFolder;

	/**
	 * @var \OCP\Files\Folder
	 */

	private $userFolder;

	public function setUp()
	{

		$root = \OC::$server->getRootFolder();

		$this->testFolder = $root->newFolder('unit-tests');

		$this->userFolder = $this->testFolder->newFolder('test-user');

		$this->userFolder->newFolder('files');
		$this->userFolder->newFolder('bagit');


	}

	public function tearDown() {

		$this->testFolder->delete();

	}

	public function testNewFileConflict()
	{

		$conflict = $this->testFolder->newFolder('conflict-test');

		$conflict->newFolder('same-name');
		$conflict->newFolder('same-name');

		$this->assertEquals(1, count($conflict->getDirectoryListing()));

	}

	public function testSetBagItAppFolder()
	{

		$userFolder = $this->testFolder->newFolder('test-bagit-check');
		$userFolder->newFolder('files');

		$storage = new BagStorage($userFolder);

		$this->assertTrue(!is_null($storage->getBagItAppFolder()));

	}

	/**
	 * @expectedException \OCP\Files\NotFoundException
	 */

	public function testFilesAppNotInstalled()
	{

		$userFolder = $this->testFolder->newFolder('test-files-check');
		$userFolder->newFolder('bagit');

		$storage = new BagStorage($userFolder);

	}

}