<?php
    require 'calls.php';
    require 'config\config.php';
    $call = new Calls($db);
    $call->Read();