<?php

namespace OCA\BagIt\AppInfo;

use \OCP\AppFramework\App;
use \OCA\BagIt\Controller\BagItController;
use \OCA\BagIt\Service\BagItService;
use \OCA\BagIt\Db\BagItBagMapper;


class Application extends App {

    public function __construct(array $urlParams=array())
    {
        parent::__construct('bagit', $urlParams);

        $container = $this->getContainer();

        /*
         * Controllers
         */

        $container->registerService('BagItController', function ($c) {
            return new BagItController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('BagItService')
            );
        });

        /**
         * Services
         */
        $container->registerService('BagItService', function ($c) {
            return new BagItService(
                $c->query('ServerContainer')->getActivityManager(),
                $c->query('ServerContainer')->getUserSession(),
                $c->query('BagItBagMapper')
            );
        });
        /**
         * Mappers
         */
        $container->registerService('BagItBagMapper', function ($c) {
            return new BagItBagMapper(
                $c->query('ServerContainer')->getDb()
            );
        });

    }

}