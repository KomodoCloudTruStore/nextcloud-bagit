<?php

namespace OCA\Bagit\Tests\Storage;

use \OCA\Bagit\Storage\BagItStorage;
use PHPUnit_Framework_TestCase;


class BagitStorageTest extends PHPUnit_Framework_TestCase {

    public $storage;

    public function setUp() {

        parent::setUp();

        $this->storage = new BagitStorage('admin');

    }

    public function tearDown()
    {
        parent::tearDown();

        $this->storage->clearBagItFolder();

    }

    public function testInit()
    {

        $this->storage = new BagitStorage('admin');

        $this->assertTrue(true);

    }

    public function testGetNodeFromFilesApp()
    {

        $node = $this->storage->getFilesAppNode(3);

        $this->assertEquals('Documents', $node->getName());

    }

    public function testIsFolder()
    {

        $node = $this->storage->getFilesAppNode(3);

        $this->assertTrue($this->storage->isFolder($node));
        $this->assertFalse($this->storage->isFile($node));

    }

    public function testIsNotFolder()
    {

        $node = $this->storage->getFilesAppNode(4);

        $this->assertFalse($this->storage->isFolder($node));
        $this->assertTrue($this->storage->isFile($node));

    }

    public function testFlattenFolderStructure()
    {
        $node = $this->storage->getFilesAppNode(3);

        $flatList = $this->storage->flattenFolderStructure($node);

        $this->assertTrue(count($flatList) == 2);

    }

    public function testFlattenFolderStructureComplex()
    {

        $node = $this->storage->getFilesAppNode(39);

        $flatList = $this->storage->flattenFolderStructure($node);

        $this->assertTrue(count($flatList) == 4);

    }

    public function testCreateBag()
    {

        $node = $this->storage->getFilesAppNode(3);

        $this->storage->createBag($node, 'sha256');

        $this->assertTrue(true);

    }

    public function testGetBags()
    {

        $node = $this->storage->getFilesAppNode(3);

        $this->storage->createBag($node, 'sha256');

        $bags = $this->storage->getBags();

        $this->assertTrue(count($bags) == 1);

    }

    public function testGetBagsAsJSON()
    {

        $node = $this->storage->getFilesAppNode(3);

        $this->storage->createBag($node, 'sha256');

        $bags = $this->storage->getBagsAsJSON();

        $this->assertTrue(count($bags) == 1);

    }

}