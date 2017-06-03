<?php
namespace OCA\BagIt\Tests\Unit\Service;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\BagIt\Db\Bag;
use OCA\BagIt\Service\BagService;

class BagServiceTest extends PHPUnit_Framework_TestCase {

    private $service;
    private $mapper;
    private $userId = 'test-user';

    public function setUp() {

        $this->mapper = $this->getMockBuilder('OCA\BagIt\Db\BagMapper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new BagService($this->mapper);

    }

    public function testInit()
    {

        $this->assertTrue(true);

    }

}