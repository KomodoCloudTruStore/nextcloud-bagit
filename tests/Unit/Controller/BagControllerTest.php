<?php
namespace OCA\BagIt\Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\BagIt\Controller\BagController;
use OCA\BagIt\Service\NotFoundException;


class BagControllerTest extends PHPUnit_Framework_TestCase {

    protected $controller;
    protected $service;
    protected $userId = 'test-user';
    protected $request;

    public function setUp() {

        $this->request = $this->getMockBuilder('OCP\IRequest')->getMock();

        $this->service = $this->getMockBuilder('OCA\BagIt\Service\BagService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new BagController(
            'bagit', $this->request, $this->service, $this->userId
        );
    }

    public function testCreate()
    {

        $expected = $this->userId;

        $this->service->expects($this->once())
            ->method('create')
            ->with($this->equalTo($this->userId))
            ->will($this->returnValue($expected));

        $actual = $this->controller->create();

        $this->assertEquals($expected, $actual);

    }

}