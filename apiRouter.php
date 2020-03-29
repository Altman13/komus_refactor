<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "./config/config.php";
require './vendor/autoload.php';

require './controllers/HomeController.php';
require './controllers/ReportController.php';
//require './controllers/CallsController.php';
require './controllers/LoginController.php';
require './controllers/ApiController.php';
require_once './config/dependencies.php';

//$app = new \Slim\App;
// $app->add(new Tuupola\Middleware\JwtAuthentication([
//      "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));

$app->get('/api/calls', CallsController::class . ':show');
$app->post('/api/calls', CallsController::class . ':make');
$app->get('/api/login', LoginController::class . ':inter');
$app->post('/api/login', LoginController::class . ':inter');
$app->get('/api/report/{all}', ReportController::class . ':show');
$app->get('/api/report/{operator}', ReportController::class . ':show');
$app->get('/api/report/{date}', ReportController::class . ':show');
$app->put('/api/base', BaseController::class . ':inject');
//Get xml, json, html, 
$app->get('/api/getpoint', ApiController::class . ':show');
//Post xml, json, formdata
$app->post('/api/postpoint', ApiController::class . ':create');

// $app->post('/api/mail', MailController::class . ':send');
// $app->post('/api/user', UsersController::class . ':create');
// $app->get('/api/user', UsersController::class . ':show');

// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");
//     $newResponse = $response->withStatus(302);
//     return $newResponse;
//});
$app->run();
