<?php

namespace OCA\BagIt\AppInfo;

use \OCP\AppFramework\App;
use \OCA\BagIt\Service\BagItService;
use \OCA\BagIt\Controller\ViewController;
use \OCA\BagIt\Storage\BagItStorage;


class Application extends App {

    public function __construct(array $urlParams=array())
    {
        parent::__construct('bagit', $urlParams);

        $container = $this->getContainer();
        /*
         * Controllers
         */

        $container->registerService('ViewController', function($c){
            return new ViewController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('BagItService')
            );
        });

        /**
         * Services
         */

        $container->registerService('BagItService', function($c) {
            return new BagItService(

                $c->query('ServerContainer')->getActivityManager(),
                $c->query('ServerContainer')->getUserSession(),
                $c->query('BagItStorage')

            );
        });

        /**
         * Storage
         */

        $container->registerService('BagItStorage', function($c){
            return new BagItStorage(
                $c->query('ServerContainer')->getUserFolder()
            );
        });

    }

}