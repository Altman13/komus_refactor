<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "./config/config.php";
require './vendor/autoload.php';

require './controllers/HomeController.php';
require './controllers/ReportController.php';
require './controllers/CallsController.php';
require './controllers/LoginController.php';
require './controllers/ApiController.php';

// create container and configure it
// $settings = require 'settings.php';
// $container = new \Slim\Container($settings);
// $container['pdo'] = function ($container) {
//     $cfg = $container->get('settings')['db'];
//     return new \PDO($cfg['dsn'], $cfg['user'], $cfg['password']);
// };
// $container['books'] = function ($container) {
//     return new ($container->get('pdo'));
// };
// // create app instance
// $app = new \Slim\App($container);
$config = [
    'settings' => [
        'displayErrorDetails' => true,

        // 'logger' => [
        //     'name' => 'slim-app',
        //     'level' => Monolog\Logger::DEBUG,
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],
    ],
];
$app = new \Slim\App($config);
//$app = new \Slim\App;
// $app->add(new Tuupola\Middleware\JwtAuthentication([
//      "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));


$app->get('/api/calls', CallsController::class . ':show');
$app->post('/api/calls', CallsController::class . ':make');
$app->post('/api/login', LoginController::class . ':inter');
// //TODO: реализовать универсальный метод выборки отчетов, выборку делать через входные параметры
$app->get('/api/report', ReportController::class . ':show');

//$app->get('/api/home', HomeController::class . ':home');
// // $app->get('/api/reports/{operator}', ReportController::class . ':show');
// // $app->get('/api/reports/{date}', ReportController::class . ':show');
// $app->post('/api/base', BaseController::class . ':inject');
// $app->post('/api/mail', MailController::class . ':send');
// $app->post('/api/user', UsersController::class . ':create');
// $app->get('/api/user', UsersController::class . ':show');

// //Get xml, json, html, 
// $app->get('/api/getpoint', ApiController::class . ':show');
// //Post xml, json, formdata
// $app->post('/api/postpoint', ApiController::class . ':create');

// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");
//     $newResponse = $response->withStatus(302);
//     return $newResponse;
//});
$app->run();
