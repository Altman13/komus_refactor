<?php
header("Access-Control-Allow-Origin: *");
require "../../config/config.php";
require 'calls.php';
require 'contacts.php';

$call = new Calls($db);
$call->Read();
// $contacts = new Contacts($db);
// $contacts->Read();
