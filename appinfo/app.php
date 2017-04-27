<?php

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [

        'id' => 'bagit',
        'order' => 10,
        'href' => $urlGenerator->linkToRoute('bagit.view.index'),
        'icon' => $urlGenerator->imagePath('bagit', 'app.svg'),
        'name' => \OC::$server->getL10N('bagit')->t('BagIt'),
    ];

});