<?php

    require 'environment.php';

    $config = [];

    if (ENVIRONMENT == 'development') {
        define('BASE_URL', 'http://marketplace.com');
        $config = [
            'dbname' => 'marketplace',
            'host' => 'localhost',
            'dbuser' => 'andre-moura',
            'dbpass' => 'andre',
            'jwt_secret_key' => 'andre-moura!'
        ];
    } else if (ENVIRONMENT == 'development2') {
        define('BASE_URL', 'http://localhost:8080');
        $config = [
            'dbname' => 'marketplace',
            'host' => 'localhost',
            'dbuser' => 'root',
            'dbpass' => '',
            'jwt_secret_key' => 'andre-moura!'
        ];
    } else {
        define('BASE_URL', 'https://meusite.com.br');
        $config = [
            'dbname' => 'estrutura_mvc',
            'host' => 'localhost',
            'dbuser' => 'andre-moura',
            'dbpass' => 'andre',
            'jwt_secret_key' => 'andre-moura!'
        ];
    }
