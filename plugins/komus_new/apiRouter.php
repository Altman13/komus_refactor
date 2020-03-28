<?php

use Komus\Calls;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "./config/config.php";
require './vendor/autoload.php';

require './controllers/HomeController.php';
require './controllers/ReportController.php';
require './controllers/CallsController.php';
require './controllers/LoginController.php';
require './controllers/ApiController.php';


$config = [
    'settings' => [
        'displayErrorDetails' => true,
        "db" => [
            "host" => $host,
            "dbname" => $dbname,
            "user" => $username,
            "pass" => $password
        ],
        // 'logger' => [
        //     'name' => 'slim-app',
        //     'level' => Monolog\Logger::DEBUG,
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],
    ],
];
$app = new \Slim\App($config);

$container = $app->getContainer();
$container ['con'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

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
