<?php

namespace Komus;

class Login
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function sign($user_name, $user_password)
    {
        //TODO: поправить кодировку у некоторых таблиц
        $unicode =$this->db->prepare("SET NAMES utf8 COLLATE utf8_unicode_ci");
        $unicode->execute();
        //TODO: валидация
        echo $user_name.PHP_EOL;
        echo $user_password.PHP_EOL;
        $users_data = $this->db->prepare("SELECT users.groups_id, salt, token FROM users
        WHERE users.password=? AND users.name=?");
        try {
            $users_data->execute([$user_name, $user_password]);
            $user_data = $users_data->fetch();
            //$user_data = json_encode($user_data, JSON_UNESCAPED_UNICODE);
            var_dump($user_data);
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
        }
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
    public function signOut($user)
    {
        if ($user) {
        }
    }
}
