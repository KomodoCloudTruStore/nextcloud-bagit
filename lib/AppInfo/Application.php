<?php
namespace OCA\BagIt\AppInfo;

use OC\Files\View;

use OCA\BagIt\Controller\PageController;

use OCP\AppFramework\App;
use OCP\Util;

class Application extends App
{

    public function __construct()
    {
        parent::__construct('bagit');

        $container = $this->getContainer();
        $server = $this->getContainer()->getServer();

		// Allow automatic DI for the View, until we migrated to Nodes API

		$container->registerService(View::class, function() {

			return new View('');

		}, false);

		// Aliases for the controllers so we can use the automatic DI

		$container->registerAlias('PageController', PageController::class);

		$eventDispatcher = $this->getContainer()->getServer()->getEventDispatcher();

		$eventDispatcher->addListener('OCA\Files::loadAdditionalScripts', function () {

			Util::addStyle('bagit', 'style');
			Util::addScript('bagit', 'bagit.tabview');
			Util::addScript('bagit', 'bagit.plugin');

		});



    }

}
