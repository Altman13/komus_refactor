<?php
require '../vendor/autoload.php';
$app = new Slim\App;
$router = new \Bramus\Router\Router();

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => "/api", /* or ["/api", "/admin"] */
    "secret" => getenv("JWT_SECRET")
]));
$router->get('/api/report', function() {
    echo 'get report';
});
$router->get('/api/report/period', function($date_begin, $date_end) {
    echo 'get report period';
});
$router->get('/api/report/operator/'{id}, function($id) {
    echo 'get report operator';
});
$router->get('/api/contacts', function() {
    echo 'get contacts';
});
$router->post('/api/contacts', function() {
    echo 'post contacts';
});
$router->get('/api/filter/recall', function() {
    echo 'get contacts filter recall';
});
$router->get('/api/helpers', function() {
    echo 'get helpers';
});
$router->get('/api/search', function() {
    echo 'get search';
});
$router->get('/api/entrypoint', function() {
    echo 'get enterypoint';
});
$router->post('/api/entrypoint', function($request) {
    echo 'post enterypoint';
});
$router->run();