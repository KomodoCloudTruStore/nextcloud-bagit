<?php

namespace OCA\BagIt\AppInfo;

use \OCP\AppFramework\App;
use \OCA\BagIt\Controller\ViewController;


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
                $c->query('Request')
            );
        });

    }

}