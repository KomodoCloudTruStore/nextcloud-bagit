<?php
namespace OCA\BagIt\Tests\Integration\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\App;

use OCA\BagIt\Db\Bag;

class BagIntegrationTest extends PHPUnit_Framework_TestCase
{

    private $controller;
    private $mapper;
    private $userId = 'test-user';

    public function setUp() {

        parent::setUp();

        $app = new App('bagit');
        $container = $app->getContainer();

        $container->registerService('UserId', function($c) {
            return $this->userId;
        });

        $this->controller = $container->query(
            'OCA\BagIt\Controller\BagController'
        );

        $this->mapper = $container->query(
            'OCA\BagIt\Db\BagMapper'
        );

    }

    public function testCreate()
    {

        $bag = new Bag();

        $bag->setUserId($this->userId);
        $bag->setStatus('created');
        $bag->setSize(100);
        $bag->setTimestamp(date("Y-m-d H:i:s"));

		$this->mapper->insert($bag);

        $actualUserId = $bag->getUserId();

		$expectedUserId = $this->userId;

		$this->assertEquals($expectedUserId, $actualUserId);

		$this->mapper->delete($bag);

    }

}
