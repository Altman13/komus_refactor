<?php
require "models/User.php";
use Komus\User;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class UserController
{
    private $user;
    public function __construct(Container $container)
    {
        $this->user = $container['user'];
    }
    public function show()
    {

    }
    public function create()
    {
        $this->user->create();
    }
    //TODO: дописать назначение ролей операторам
    public function update($id)
    {
        # code...
    }
}
