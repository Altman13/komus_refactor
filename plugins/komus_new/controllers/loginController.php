<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
require "../models/login.php";
class LoginController
{
    private $login;
    public function __construct(Login $login)
    {
        $this->login = $login;
    }
    public function inter()
    {
        $this->login->login();
    }
    public function exit($token)
    {
        $this->login->logout($token);
    }
}
