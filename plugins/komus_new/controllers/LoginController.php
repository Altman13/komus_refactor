<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");

use Komus\Login;

class LoginController
{
    private $login;
    //protected $container;
    // public function __construct(Login $login /*ContainerInterface $container*/)
    public function __construct()
    {
        require "config/config.php";
        $this->login = new Login($db);
    }
    //TODO : добавить счетчик неудачных попыток входа
    public function inter()
    {
        // $data = json_decode($request->getBody());
        // var_dump($data);
        // try {
        //     $user_data=$this->login->login($data->username, $data->password);
        // } catch (\Throwable $th) {
        //     die('Произошла ошибка при попытке входа на сайт '.$th->getMessage());
        // }
        // return $user_data;
    }
    //TODO : убедиться в нужности функции, так как токен лежит в localstorage
    public function exit($token)
    {
        $this->login->Signout($token);
    }
}
