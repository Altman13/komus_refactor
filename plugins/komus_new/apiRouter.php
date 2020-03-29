<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './controllers/ApiController.php';
require './controllers/UserController.php';
require './controllers/LoginController.php';
require './controllers/CallsController.php';
require './controllers/ReportController.php';
require './controllers/HomeController.php';

require_once './config/dependencies.php';

//$app = new \Slim\App;
// $app->add(new Tuupola\Middleware\JwtAuthentication([
//      "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));

$app->put('/api/base', BaseController::class . ':inject');
$app->post('/api/login', LoginController::class . ':inter');
$app->get('/api/login', LoginController::class . ':inter');
$app->post('/api/calls', CallsController::class . ':make');
$app->get('/api/calls', CallsController::class . ':show');
$app->post('/api/user', UserController::class . ':create');
$app->get('/api/user', UserController::class . ':show');
$app->get('/api/report', ReportController::class . ':show');

//xml, json, html, 
$app->get('/api/getpoint', ApiController::class . ':show');
$app->post('/api/postpoint', ApiController::class . ':create');

$app->post('/api/mail', MailController::class . ':send');

// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");
//     $newResponse = $response->withStatus(302);
//     return $newResponse;
//});
$app->run();
