<?php
namespace OCA\BagIt\Tests\Unit\Service;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\BagIt\Db\Bag;
use OCA\BagIt\Service\BagService;

class BagServiceTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var \OCP\IServerContainer
	 */

	private $server;

	/**
	 * @var \OCP\Activity\IManager
	 */
    private $activity;

    /**
     * @var \OCA\BagIt\Db\BagMapper
     */
    private $mapper;

	/**
	 * @var \OCA\BagIt\Service\BagService
	 */

	protected $service;

    private $userId = 'test-user';

    public function setUp() {

        $this->server = $this->getMockBuilder('OCP\IServerContainer')->getMock();
        $this->activity = $this->getMockBuilder('OCP\Activity\IManager')->getMock();

    	$this->mapper = $this->getMockBuilder('OCA\BagIt\Db\BagMapper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new BagService($this->server, $this->activity, $this->mapper);

    }

    public function testFindAll()
    {

		$items = $this->service->findAll('admin');

    	$this->assertTrue(true);

    }

}