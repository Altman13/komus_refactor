<?php
error_reporting(E_ERROR | E_PARSE);
$request_body = file_get_contents('php://input');
$number = 10;
function generate_password($number)
{
    $arr = array(
        'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'r', 's',
        't', 'u', 'v', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F',
        'G', 'H', 'I', 'J', 'K', 'L',
        'M', 'N', 'O', 'P', 'R', 'S',
        'T', 'U', 'V', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6',
        '7', '8', '9', '0', '.', ',',
        '(', ')', '[', ']', '!', '?',
        '&', '^', '%', '@', '*', '$',
        '<', '>', '/', '|', '+', '-',
        '{', '}', '`', '~'
    );
    // Генерируем пароль
    $pass = "";
    for ($i = 0; $i < $number; $i++) {
        // Вычисляем случайный индекс массива
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}
$depassword = generate_password(intval(10));
$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
$password = hash('sha256', $depassword . $salt);
//TODO : добавить группу пользователя при добавлении
$insert_users = $db->prepare("INSERT INTO users (username, email, password, salt, depass, cookie)
                                VALUES (:login, :mail, :pass, :salt, :depass, :cookie)");
$insert_users->bindParam(':login', $login, PDO::PARAM_STR);
$insert_users->bindParam(':mail', $_POST['user_mail'], PDO::PARAM_STR);
$insert_users->bindParam(':salt', $salt, PDO::PARAM_STR);
$insert_users->bindParam(':pass', $password, PDO::PARAM_STR);
//TODO : убрать после отладки depass из базы
$insert_users->bindParam(':depass', $depassword, PDO::PARAM_STR);
//$insert_users->bindParam(':cookie', $cookie, PDO::PARAM_STR);
try {
    $insert_users->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при регистрации нового пользователя ' . $th->getMessage());
}
