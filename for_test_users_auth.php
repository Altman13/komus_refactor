<?php
require 'vendor/autoload.php';
require 'config/config.php';
$req_body = $request->getBody();
$users_data = json_decode($req_body);
$users_pass_hash_salt = $db->prepare("SELECT user_password, users.salt FROM users
                        WHERE user_login=:username");
$users_pass_hash_salt->bindparam(':username', $users_data->login, PDO::PARAM_STR);
try {
    $users_pass_hash_salt->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
}
$users_data = $users_pass_hash_salt->fetch(PDO::PARAM_STR);
$check_password = hash('sha256', $user_password . $users_data['salt']);
$users_password_hash = $db->prepare("SELECT user_password FROM users
                                            WHERE user_password =:pass_hash");
$users_password_hash->bindParam(':pass_hash', $check_password, PDO::PARAM_STR);
try {
    $users_password_hash->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при проверке пароля пользователя ' . $th->getMessage());
}
$psw_hash = $users_password_hash->fetchColumn();
// return $hash;
// if ($check_password === $users_data->password) {
if ($check_password == $psw_hash) {
    //TODO : разобраться с token
    $get_users_token = $db->prepare("SELECT user.token from users 
                                        WHERE  user.name=:user_name AND user_password=:user_password");
    $get_users_token->bindParam(':user_name', $users_data->login, PDO::PARAM_STR);
    $get_users_token->bindParam(':user_password', $users_data->password, PDO::PARAM_STR);
    try {
        $get_users_token->execute();
    } catch (\Throwable $th) {
        die("Произошла ошибка при попытке получить токен пользователя " . $th->getMessage());
    }
} else {
    die('Введенны некорректные данные для авторизации');
}
$users_token = $get_users_token->fetch();
return $users_token;
