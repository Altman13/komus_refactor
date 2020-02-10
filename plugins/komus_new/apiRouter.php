<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "config/config.php";
require 'vendor/autoload.php';
require 'controllers/HomeController.php';
require 'controllers/ReportsController.php';
require 'controllers/CallsController.php';
require 'controllers/EntryPointController.php';

$app = new \Slim\App;

// $app->add(new Tuupola\Middleware\JwtAuthentication([
//      "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));

$app->get('/api/home', HomeController::class . ':home');
$app->get('/api/calls', CallsController::class . ':show');
$app->post('/api/calls', CallsController::class . ':create');
//TODO: реализовать универсальный метод выборки отчетов, выборку делать через входные параметры
$app->get('/api/reports', ReportController::class . ':show');
$app->get('/api/reports/{operator}', ReportController::class . ':show');
$app->get('/api/reports/{date}', ReportController::class . ':show');
$app->post('/api/base', BaseController::class . ':inject');
$app->post('/api/mail', MailController::class . ':send');
$app->post('/api/user', UsersController::class . ':create');
$app->get('/api/user', UsersController::class . ':show');

//Get xml, json, html, 
$app->$app->get('/api/entrypoint', ApiEntryPoint::class . ':show');
//Post xml, json, formdata
$app->post('/api/entrypoint', ApiEntryPoint::class . ':create');
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    $newResponse = $response->withStatus(302);
    return $newResponse;
});
$app->run();
