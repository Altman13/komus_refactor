<?php
require '../vendor/autoload.php';
$router = new \Bramus\Router\Router();

$router->get('/about', function() {
    echo 'About Page Contents';
});

$router->run();