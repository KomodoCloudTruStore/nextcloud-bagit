<?php

return [
    'routes' => [
        ['name' => 'bagit#index_view', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'bagit#index', 'url' => '/bags', 'verb' => 'GET'],
        ['name' => 'bagit#create', 'url' => '/bags/{id}', 'verb' => 'POST'],
        ['name' => 'bagit#show', 'url' => '/bags/{id}', 'verb' => 'GET']
    ]
];