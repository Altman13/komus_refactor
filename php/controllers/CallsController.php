<?php
use Komus\Calls;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;
class CallsController
{
    private $calls;
    private $ret;
    public function __construct(Container $container)
    {
        $this->calls = $container['calls'];
        $this->ret = array('data' => '', 'error' => '', 'error_text' => '');
    }
    public function show()
    {
        $this->ret = $this->calls->read();
        return $this->ret;
    }
    public function make()
    {
        //$this->calls->create();
        
    }
}
