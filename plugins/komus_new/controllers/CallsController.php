<?php
require "../models/calls.php";
require "config/config.php";
$callController = new Calls($db);
echo $callController->Read();