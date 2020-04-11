<?php
use Komus\Calls;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;
class CallsController
{
    private $calls;
    public function __construct(Container $container)
    {
        $this->calls = $container['calls'];
    }
    public function show()
    {
        echo $this->calls->read();
    }
    public function make()
    {
        $this->calls->create();
    }
}
