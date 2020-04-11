<?php
require_once "vendor/autoload.php";
use Respect\Validation\Validator as v;

$username = "root";
$password = "";
$host = "127.0.0.1";
$dbname = "komus_new";

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");

// $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
// try {
//     $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
// } catch (PDOException $ex) {
//     die("Failed to connect to the database: " . $ex->getMessage());
// }
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//header('Content-Type: text/html; charset=utf-8');
//session_start();

$usernameValidator = v::alnum()->noWhitespace()->length(1, 10);
//TODO: длина пароля

$passwordValidator = v::alnum()->noWhitespace()->length(1, 10);
$validators = array(
  'username' => $usernameValidator,
  'userpassword' => $passwordValidator
);

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        "db" => [
            "host" => $host,
            "dbname" => $dbname,
            "user" => $username,
            "pass" => $password,
            "charset" => "utf8",
        ],
        // 'logger' => [
        //     'name' => 'slim-app',
        //     'level' => Monolog\Logger::DEBUG,
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],
    ],
];
$app = new \Slim\App($config);