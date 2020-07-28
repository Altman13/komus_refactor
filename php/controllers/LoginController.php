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
        try {
            $user_data = json_decode($request->getBody());
            $this->resp = $this->login->sign($user_data->data->userpassword, $user_data->data->username);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при попытке входа на сайт " . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
    }
}
