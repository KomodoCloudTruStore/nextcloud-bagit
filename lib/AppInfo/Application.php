<?php
namespace OCA\Bagit\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

use OCA\Bagit\Controller\BagitController;
use OCA\Bagit\Service\BagitService;
use OCA\Bagit\Db\BagitBagMapper;
use OCA\Bagit\Storage\BagitStorage;

class Application extends App {

    public function __construct(array $urlParams=array())
    {
        parent::__construct('bagit', $urlParams);
        $container = $this->getContainer();

        /*
         * Controllers
         */

        $container->registerService('BagitController', function(IAppContainer $c){
            return new BagitController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('BagitService')
            );
        });

        /**
         * Services
         */

        $container->registerService('BagitService', function(IAppContainer $c){
            return new BagitService(
                $c->query('ServerContainer')->getActivityManager(),
                $c->query('ServerContainer')->getUserSession(),
                $c->query('BagitBagMapper'),
                $c->query('BagitStorage')
            );
        });

        /**
         * Mappers
         */

        $container->registerService('BagitBagMapper', function(IAppContainer $c){
            return new BagitBagMapper(
                $c->query('ServerContainer')->getDatabaseConnection()
            );
        });

        /**
         * Storage
         */

        $container->registerService('BagitStorage', function(IAppContainer $c){
            return new BagitStorage(
                $c->query('ServerContainer'),
                $c->query('ServerContainer')->getUserSession()
            );
        });
    }
}