<?php

    global $routes;
    $routes = [
        '/stores/login' => '/stores/login',
        '/stores/register' => '/stores/register',
        '/stores/{id}' => '/stores/manage/:id',

        '/product/{id}' => '/products/manage/:id',
        '/products' => '/products/search',
        '/product' => '/products/insert',
    ];
