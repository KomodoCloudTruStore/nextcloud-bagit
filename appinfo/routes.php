<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. view#index -> OCA\BagIt\Controller\ViewController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
        ['name' => 'bagit#index_view', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'bagit#index', 'url' => '/bags', 'verb' => 'GET'],
        ['name' => 'bagit#create', 'url' => '/bags/{id}', 'verb' => 'POST'],
        ['name' => 'bagit#show', 'url' => '/bags/{id}', 'verb' => 'GET']
    ]
];