<?php

namespace Komus;

use PDO;

class Login
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function sign($user_password, $user_name)
    {
        //TODO: валидация
        $payload = [
            "user" => $user_name,
            "passwords" => $user_password,
        ];
        $token =\Firebase\JWT\JWT::encode($payload, "thisissecret", "HS256");
        
        $users_data = $this->db->prepare("SELECT users.groups_id, token FROM users
        WHERE users.token=:token");
        $users_data->bindParam(':token', $token, PDO::PARAM_STR);
        try {
            $users_data->execute();
            $user_data = $users_data->fetch();
        } catch (\Throwable $th) {
            echo ('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
        }
        if ($token == $user_data['token']) {
            $user_group = $user_data['groups_id'];
            $user_token = $user_data['token'];
            $token_exp  = date("Y-m-d H:i:s", strtotime("+9 hours"));
            $u = array('user_group', 'user_token', 'token_exp');
            $user = compact($u);
            $user_data = json_encode($user);
            return $user_data;
        } else {
            echo ('Введенны некорректные данные для авторизации');
        }
    }
    public function signOut($user)
    {
        if ($user) {
        }
    }
}
