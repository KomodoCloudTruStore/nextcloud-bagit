<?php

use \OCA\BagIt\AppInfo\Application;

\OC::$server->getNavigationManager()->add(function() {

	$urlGenerator = \OC::$server->getURLGenerator();

	return [
		'id' => 'bagit',
		'order' => 4,
		'href' => $urlGenerator->linkToRoute('bagit.page.index'),
		'icon' => $urlGenerator->imagePath('bagit', 'app.svg'),
		'name' => \OC::$server->getL10N('bagit')->t('BagIt'),
	];

});

$app = new Application();
