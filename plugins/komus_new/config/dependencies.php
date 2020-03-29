<?php
    
    require_once "../vendor/autoload.php";

    $container = $app->getContainer();
    $container["className"] = function ($container) {
        return new className();
    };
    $container ['pdo'] = function ($c) {
        $settings = $c->get('settings')['db'];
        $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
            $settings['user'], $settings['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };