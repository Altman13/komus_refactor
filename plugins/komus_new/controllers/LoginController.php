<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class LoginController
{
    private $login;
    public function __construct(ContainerInterface $container)
    {
        $this->login = $container['login'];
    }
    //TODO : добавить счетчик неудачных попыток входа
    public function inter($request, $response, $args)
    {
        $resp = '';
        if ($request->getAttribute('has_errors')) {
            $errors = $request->getAttribute('errors');
            $response->getBody()->write("Произошла ошибка валидации данных пользователя " . $errors . PHP_EOL);
            $resp =$response->withStatus(500);
        } else {
            $user_data = json_decode($request->getBody());
            try {
                $resp = $this->login->sign($user_data->username, $user_data->userpassword);
            } catch (\Throwable $th) {
                $response->getBody()->write("Произошла ошибка при попытке входа на сайт " . $th->getMessage() . PHP_EOL);
                $resp = $response->withStatus(500);
            }
            return $resp;
        }
    }
    //TODO : убедиться в нужности функции, так как токен лежит в localstorage
    public function exit($token)
    {
        $this->login->signOut($token);
    }
}
