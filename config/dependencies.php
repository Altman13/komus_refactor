<?php

require_once "vendor/autoload.php";
require_once "config.php";

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

// $app->add(new Tuupola\Middleware\JwtAuthentication([
//     "path" => "/api", /* or ["/api", "/admin"] */
//     "secret" => getenv("JWT_SECRET")
// ]));

$container = $app->getContainer();
$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'],
        $settings['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
