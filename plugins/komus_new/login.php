<?php
/*
    точка входа на сайт для операторов и старших операторов
    require_once './dumper.php';
    вход через форму ввода пароля
*/
//TODO: реализовать отправку уведомлений на почту по всем исключительным ситуациям
if ($_POST['username'] and $_POST['password']) {

    $select = $db->prepare("SELECT users.password, users.salt, users.cookie FROM users
                            WHERE users.username=:username");
    $select->bindparam(':username', $_POST['username'], PDO::PARAM_STR);
    try {
        $select->execute();
    } catch (\Throwable $th) {
        echo 'Произошла ошибка при выборе пользователя из базы ' . $th->getMessage();
    }
    $data = $select->fetch(PDO::PARAM_STR);
    $login_ok = false;
    $pass = $_POST['password'];
    $check_password = hash('sha256', $pass . $data['salt']);
    if ($check_password === $data['password']) {
        $login_ok = true;
    }
    if ($login_ok) {
        $operator_select = $db->prepare("SELECT user.fio as fio, users.password as pass, users.cookie as cookie
                                        FROM users, user
                                        WHERE user.users_idusers=users.idusers
                                        AND users.username=:username
                                        AND groups_users.id= ");
        $operator_select->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $operator_select->execute();
        try {
            $oper = $operator_select->fetch();
        } catch (\Throwable $th) {
            echo 'Произошла ошибка при выборе оператора из базы '. $th->getMessage();
        }
        
        if ($oper) {
            $cookie_name = 'user';
            $cookie_value = $oper['cookie'];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            $_SESSION['operator'] = $oper['fio'];
            //TODO: точка входа после авторизации
            header("Location: index.php");
        } else {
            //если не оператор-значит входит старший оператор
            $st_operator_select = $db->prepare("SELECT user.fio as fio, users.password as pass, users.cookie as cookie
                                        FROM users, user
                                        WHERE user.users_iduser=users.idusers
                                        AND users.username=:username
                                        AND groups_users.id= ");
            $st_operator_select->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            try {
                $st_operator_select->execute();
            } catch (\Throwable $th) {
                echo 'Произошла ошибка при выборе  старшего оператора из базы '. $th->getMessage();
            }
            $st_oper = $st_operator_select->fetch();
            if ($st_oper) {
                $cookie_name = 'st_operator';
                $cookie_value = $st_oper['cookie'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                $_SESSION['st_operator'] = $st_oper['fio'];
                //TODO: точка входа после авторизации
                header("Location: index.php");
            } else {
                header("Location: ../index.html");
            }
        }
    } else {
        //TODO: реализовать счетчик для неудачных попыток входа
        echo 'Данные для входа введены не верно';
        //header("Location: ../index.html");
    }
}
