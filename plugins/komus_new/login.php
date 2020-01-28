<?php

if ($_POST['username'] and $_POST['password']) {
    $select = $db->prepare("SELECT users.password, users.salt FROM users
                            WHERE users.username=:username");
    $select->bindparam(':username', $_POST['username'], PDO::PARAM_STR);
    try {
        $select->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
    }
    $data = $select->fetch(PDO::PARAM_STR);
    $login_ok = false;
    $pass = $_POST['password'];
    $check_password = hash('sha256', $pass . $data['salt']);
    if ($check_password === $data['password']) {
        $login_ok = true;
    } else {
        die('Произошла ошибка при выборе пользователя из базы');
    }
    if ($login_ok) {
        // TODO: Передалать таблицу users, сгенерировать токен для каджого пользователяы при импорте пользователей, 
        // который будем возвращать на пару пароль/логин
        // Кроме того  поле users.name должно быть уникальным
        $user_select = $db->prepare("SELECT users.token, users.groups_id
                                        FROM users");
        $user_select->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $user_select->execute();
        try {
            $user = $user_select->fetch();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
        }
        echo $user;
    }
}
