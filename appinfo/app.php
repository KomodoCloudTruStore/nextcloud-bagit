<?php

use OCP\Util;
use OCA\Bagit\AppInfo\Application;

$app = new Application();
$container = $app->getContainer();

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [

        'id' => 'bagit',
        'order' => 10,
        'href' => $urlGenerator->linkToRoute('bagit.bagit.index_view'),
        'icon' => $urlGenerator->imagePath('bagit', 'app.svg'),
        'name' => \OC::$server->getL10N('bagit')->t('Bagit'),
    ];

});

$eventDispatcher = \OC::$server->getEventDispatcher();
$eventDispatcher->addListener('OCA\Files::loadAdditionalScripts', function () {
    Util::addStyle('bagit', 'style');
    Util::addScript('bagit', 'bagit.tabview');
    Util::addScript('bagit', 'bagit.plugin');
});