<?php
require 'calls.php';
require 'contacts.php';
require 'config\config.php';

$call = new Calls($db);
$call->Read();
// $contacts = new Contacts($db);
// $contacts->Read();
