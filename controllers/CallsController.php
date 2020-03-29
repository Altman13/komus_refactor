<?php
use Komus\Calls;

class CallsController
{
    private $calls;
    //TODO:  разобраться почему не работает DI
    public function __construct()
    {
        require "config/config.php";
        $this->calls = new Calls($db);
    }
    public function show()
    {
        echo $this->calls->Read();
        //return json_encode($calls);
    }
    public function make()
    {
        $this->calls->Create();
        //return json_encode($calls);
    }
}
