<?php
require "../models/calls.php";
require "config/config.php";
class CallsController
{
    private $calls;
    public function __construct(Calls $calls)
    {
        $this->calls = $calls;
    }
    public public function show()
    {
        echo $this->calls->Read();
    }
}
