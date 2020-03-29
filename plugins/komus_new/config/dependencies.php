<?php

use Komus\Login;
use Komus\Base;
use Komus\Contacts;
use Komus\MailLog;
use Komus\User;

require_once "config.php";

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
$container['login'] = function ($c) {
    $login = new Login($c['pdo']);
    return $login;
};
$container['base'] = function ($c) {
    $base = new Base($c['pdo']);
    return $base;
};
$container['login'] = function ($c) {
    $user = new User($c['pdo']);
    return $user;
};
$container['login'] = function ($c) {
    $login = new Login($c['pdo']);
    return $login;
};
$container['login'] = function ($c) {
    $login = new Login($c['pdo']);
    return $login;
};
$container['login'] = function ($c) {
    $login = new Login($c['pdo']);
    return $login;
};