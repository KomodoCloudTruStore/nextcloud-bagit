<?php

use OCP\AppFramework\App;
use OCP\Util;

$app = new App('bagit');
$container = $app->getContainer();

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [

        'id' => 'bagit',
        'order' => 10,
        'href' => $urlGenerator->linkToRoute('bagit.bagit.index_view'),
        'icon' => $urlGenerator->imagePath('bagit', 'app.svg'),
        'name' => \OC::$server->getL10N('bagit')->t('BagIt'),
    ];

});

$eventDispatcher = \OC::$server->getEventDispatcher();
$eventDispatcher->addListener('OCA\Files::loadAdditionalScripts', function () {
    Util::addStyle('bagit', 'style');
    Util::addScript('bagit', 'bagit.tabview');
    Util::addScript('bagit', 'bagit.plugin');
});