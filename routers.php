<?php

    global $routes;
    $routes = [
        '/stores/login' => '/stores/login',
        '/stores/register' => '/stores/register',
        '/stores/get-store' => '/stores/get-store',
        '/stores/{id}/address' => '/stores/address/:id',
        '/stores/{id}' => '/stores/manage/:id',

        '/products/new' => '/products/insert',
        '/products/my-list' => '/products/my-products',
        '/product/{id}' => '/products/manage/:id',
        '/products' => '/products/search',

        '/categories' => '/categories/index'
    ];
