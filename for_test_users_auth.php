<?php
require 'vendor/autoload.php';
require 'config/config.php';

$req_body = $request->getBody();
$users_data = json_decode($req_body);
//TODO : добавить счетчик неудачных попыток входа
$users_data = $db->prepare("SELECT users.groups_id, salt, token FROM users
                        WHERE user_login=:username");
$users_data->bindparam(':username', $users_data->login, PDO::PARAM_STR);
try {
    $users_data->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
}
$user_data = $users_data->fetch(PDO::PARAM_STR);
$check_password = hash('sha256', $users_data->password . $user_data['salt']);
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
