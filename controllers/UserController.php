<?php
require "../models/users.php";
use Komus\User;

class UserController
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function Read()
    {
    }
    public function Create()
    {
        $this->user->Create();
    }
    //TODO: дописать назначение ролей операторам
    public function Update($id)
    {
        # code...
    }
}
