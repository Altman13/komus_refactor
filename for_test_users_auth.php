<?php
require 'vendor/autoload.php';
require 'config/config.php';

$req_body = $request->getBody();
$users_data = json_decode($req_body);

//TODO : переименовать поле user_password->token и добавить счетчик неудачных попыток входа
$users_pass_hash_salt = $db->prepare("SELECT users.groups_id, salt, user_password FROM users
                        WHERE user_login=:username");
$users_pass_hash_salt->bindparam(':username', $users_data->login, PDO::PARAM_STR);
try {
    $users_pass_hash_salt->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
}
$users_data = $users_pass_hash_salt->fetch(PDO::PARAM_STR);
$check_password = hash('sha256', $users_data->password . $users_data['salt']);

if ($check_password == $users_data['user_password']) {
    $u_data = json_encode($users_data);
    return $u_data;
} else {
    die('Введенны некорректные данные для авторизации');
}
