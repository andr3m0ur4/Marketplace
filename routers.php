<?php

    global $routes;
    $routes = [
        '/stores/login' => '/store/login',
        '/stores/register' => '/store/register',
        '/stores/{id}' => '/store/manage/:id',

        '/product/{id}' => '/product/manage/:id',
        '/products' => '/product/search',
        '/product' => '/product/insert',
    ];
