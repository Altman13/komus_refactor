<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
$user='';
$password='';

$payload = [
    "user" => $user,
    "passwords" =>$password
];
echo $token = JWT::encode($payload, "thisissecret", "HS256");
