<?php

    require 'environment.php';

    $config = [];

    if (ENVIRONMENT == 'development') {
        define('BASE_URL', 'http://localhost:8080');
        $config = [
            'dbname' => 'marketplace',
            'host' => 'localhost',
            'dbuser' => 'root',
            'dbpass' => ''
        ];
    } else {
        define('BASE_URL', 'https://meusite.com.br');
        $config = [
            'dbname' => 'estrutura_mvc',
            'host' => 'localhost',
            'dbuser' => 'andre-moura',
            'dbpass' => 'andre'
        ];
    }

    global $db;
