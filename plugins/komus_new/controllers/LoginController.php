<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class LoginController
{
    private $login;
    private $resp;
    public function __construct(Container $container)
    {
        $this->login = $container['login'];
    }
    //TODO : добавить счетчик неудачных попыток входа
    public function inter(Request $request, Response $response, $args)
    {
        // if ($request->getAttribute('has_errors')) {
        //     $errors = $request->getAttribute('errors');
        //     $response->getBody()->write("Произошла ошибка валидации данных пользователя " . $errors . PHP_EOL);
        //     $this->resp =$response->withStatus(500);
        // } else {
            try {
                $user_data = json_decode($request->getBody());
                $this->resp = $this->login->sign($user_data->userpassword, $user_data->username);
            } catch (\Throwable $th) {
                $response->getBody()->write("Произошла ошибка при попытке входа на сайт " . $th->getMessage() . PHP_EOL);
                $this->resp = $response->withStatus(500);
            }
            return $this->resp;
        }
    //}
    //TODO : убедиться в нужности функции, так как токен лежит в localstorage
    public function exit($token)
    {
        $this->login->signOut($token);
    }
}
