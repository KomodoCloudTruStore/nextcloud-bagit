<?php

return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'bag#index', 'url' => '/bags', 'verb' => 'GET'],
		['name' => 'bag#create', 'url' => '/bags', 'verb' => 'POST'],
		['name' => 'bag#show', 'url' => '/bags/{id}', 'verb' => 'GET'],
		['name' => 'bag#destroy', 'url' => '/bags/{id}', 'verb' => 'DELETE']

    ]
];

//return [
//    'routes' => [
//        ['name' => 'bagit#index_view', 'url' => '/', 'verb' => 'GET'],
//        ['name' => 'bagit#index', 'url' => '/bags', 'verb' => 'GET'],
//        ['name' => 'bagit#create', 'url' => '/bags/{id}', 'verb' => 'POST'],
//        ['name' => 'bagit#show', 'url' => '/bags/{id}', 'verb' => 'GET'],
//        ['name' => 'bagit#show_updates', 'url' => '/bags/{id}/updates', 'verb' => 'GET']
//    ]
//];