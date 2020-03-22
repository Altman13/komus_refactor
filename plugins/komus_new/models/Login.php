<?php

namespace Komus;

class Login
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    //TODO : добавить валидацию, проверить на пустоту
    public function Sign($user_name, $user_password)
    {
        $users_data = $this->db->prepare("SELECT users.groups_id, salt, token FROM users
                        WHERE login=:username");
        $users_data->bindparam(':username', $user_name, PDO::PARAM_STR);
        try {
            $users_data->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
        }
        $user_data = $users_data->fetch(PDO::PARAM_STR);
        $check_password = hash('sha256', $user_password . $user_data['salt']);
        if ($check_password == $user_data['token']) {
            $user_group = $user_data['groups_id'];
            $user_token = $user_data['token'];
            $u = array('user_group', 'user_token');
            $user = compact($u);
            $user_data = json_encode($user);
            return $user_data;
        } else {
            die('Введенны некорректные данные для авторизации');
        }
    }
    public function Signout($user)
    {
        if ($user) {
        }
    }
}
