<?php
require "plugins/komus_new/models/calls.php";
class CallsController
{
    private $calls;
    public function __construct(Calls $calls)
    {
        $this->calls = $calls;
    }
    public function show()
    {
        echo $this->calls->Read();
    }
}
