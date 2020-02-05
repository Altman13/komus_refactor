<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require "config/config.php";
require 'vendor/autoload.php';
//require 'controllers/callController.php';
require 'vendor/autoload.php';
require 'controllers/HomeController.php';

$app = new \Slim\App;
$app->get('/api/home', HomeController::class . ':home');
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    $newResponse = $response->withStatus(302);
    return $newResponse;
});
$app->run();

//$app = new Slim\App;
//$router = new \Bramus\Router\Router();

// $app->add(new Tuupola\Middleware\JwtAuthentication([
//      "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));
//$router->get('/calls/', '\Controllers\callController');
// $router->get('/calls/', function() {
  
// });

// $router->get('/api/report', function() {
//     echo 'get report';
// }); 
// $router->get('/api/report/period', function($date_begin, $date_end) {
//     echo 'get report period';
// });
// $router->get('/api/report/operator/'{id}, function($id) {
//     echo 'get report operator';
// });
// $router->get('/api/contacts', function() {
//     echo 'get contacts';
// });
// $router->post('/api/contacts', function($request) {
//     echo 'post contacts';
// });
// $router->get('/api/filter/recall', function() {
//     echo 'get contacts filter recall';
// });
// $router->get('/api/handbook', function() {
//     echo 'get handbook';
// });
// $router->get('/api/search', function() {
//     echo 'get search';
// });
// $router->get('/api/entrypoint', function() {
//     echo 'get enterypoint';
// });
// $router->post('/api/entrypoint', function($request) {
//     echo 'post enterypoint';
// });
//$router->run();