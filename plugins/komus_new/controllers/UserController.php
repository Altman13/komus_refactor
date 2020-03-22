<?php
require "../models/users.php";
class UserController
{
    private $users;
    public function __construct(Users $users)
    {
        $this->users = $users;
    }
    public function Read()
    {
    }
    public function Create()
    {
        $this->users->Create();
    }
    //TODO: дописать назначение ролей операторам
    public function Update($id)
    {
        # code...
    }
}
