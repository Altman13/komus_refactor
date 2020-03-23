<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Komus\Login;

class LoginController
{
    private $login;
    public function __construct()
    {
        require "config/config.php";
        $this->login = new Login($db);
    }
    //TODO : добавить счетчик неудачных попыток входа
    public function inter($request, $response, $args)
    {
            $user_data = json_decode($request->getBody());
            try {
                $resp = $this->login->Sign($user_data->username, $user_data->password);
            } catch (\Throwable $th) {
                $response->getBody()->write("Произошла ошибка при попытке входа на сайт " . $th->getMessage() . PHP_EOL);
                $resp = $response->withStatus(500);
            }
            return $resp;
    }
    //TODO : убедиться в нужности функции, так как токен лежит в localstorage
    public function exit($token)
    {
        $this->login->Signout($token);
    }
}
