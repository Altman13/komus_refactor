<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

require "config/config.php";
require "models/login.php";

class LoginController
{
    private $login;
    protected $container;

    public function __construct(Login $login, ContainerInterface $container)
    {
        $this->container = $container;
        $this->login = $login;
    }
    //TODO : добавить счетчик неудачных попыток входа
    public function inter($request)
    {
        $data = json_decode($request->getBody());
        try {
            $user_data=$this->login->login($data->username, $data->password);
        } catch (\Throwable $th) {
            die('Произошла ошибка при попытке входа на сайт '.$th->getMessage());
        }
        return $user_data;
    }
    //TODO : убедиться в нужности функции, так как токен лежит в localstorage
    public function exit($token)
    {
        $this->login->logout($token);
    }
}
