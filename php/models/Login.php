<?php

namespace Komus;

use PDO;

class Login
{
    private $db;
    private $ret;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function sign($user_password, $user_name)
    {
        try {
            //TODO: валидация
            $payload = [
                "user" => $user_name,
                "passwords" => $user_password,
            ];
            $token = \Firebase\JWT\JWT::encode($payload, "thisissecret", "HS256");

            $users_data = $this->db->prepare("SELECT users.groups_id, token, CONCAT(users.firstname,' ', users.lastname) as 
                                            user_fio, users.id FROM users
                                            WHERE users.token=:token");
            $users_data->bindParam(':token', $token, PDO::PARAM_STR);
            $users_data->execute();
            $user_data = $users_data->fetch();
        } catch (\Throwable $th) {
            $this->ret = 'Произошла ошибка при выборе пользователя из базы ' . $th->getMessage();
        }
        if ($token == $user_data['token']) {
            $user_id = $user_data['id'];
            $user_group = $user_data['groups_id'];
            $user_token = $user_data['token'];
            $user_fio = $user_data['user_fio'];
            $token_exp  = date("Y-m-d H:i:s", strtotime("+9 hours"));
            $u = array('user_id', 'user_group', 'user_token', 'token_exp', 'user_fio');
            $user = compact($u);
            $user_data = json_encode($user);
            $this->ret = $user_data;
        } else {
            $this->ret = 'Введенны некорректные данные для авторизации';
        }
        return $this->ret;
    }
    public function signOut($user)
    {
        if ($user) {
        }
    }
}
