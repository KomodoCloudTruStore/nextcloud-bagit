<?php

return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'bag#index', 'url' => '/bags', 'verb' => 'GET'],
		['name' => 'bag#create', 'url' => '/bags', 'verb' => 'POST'],
		['name' => 'bag#show', 'url' => '/bags/{id}', 'verb' => 'GET'],
		['name' => 'bag#destroy', 'url' => '/bags/{id}', 'verb' => 'DELETE'],
		['name' => 'bag#update', 'url' => '/bags', 'verb' => 'PATCH']

    ]
];