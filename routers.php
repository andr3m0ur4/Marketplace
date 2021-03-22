<?php

    global $routes;
    $routes = [
        '/stores/login' => '/stores/login',
        '/stores/register' => '/stores/register',
        '/stores/get-store' => '/stores/get-store',
        '/stores/{id}/address' => '/stores/address/:id',
        '/stores/{id}' => '/stores/manage/:id',

        '/product/{id}' => '/products/manage/:id',
        '/products' => '/products/search',
        '/product' => '/products/insert',

        '/categories' => '/categories/index'
    ];
