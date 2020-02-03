<?php

require "../config/config.php";
require 'calls.php';
require 'contacts.php';
//__DIR__ 
require '../vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->run();


$call = new Calls($db);
echo $call->Read();
// $contacts = new Contacts($db);
// $contacts->Read();
