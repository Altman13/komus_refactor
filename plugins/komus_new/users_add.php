<?php
require "config/config.php";
require "vendor/autoload.php";
error_reporting(E_ERROR | E_PARSE);

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();

//TODO: Реализовать назначение в группы пользователей
/** Реализовать панель управления для админа и старшего оператора
 * в которой будет реализация раздачи прав и назначения групп пользователям
 */

$request_body = file_get_contents('php://input');
$operators_file = 'data/operators.xls';
if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $operators_file)) {

    //Проверка есть ли такой пользователь(по логину)
    // try {
    //     //code...
    // } catch (\Throwable $th) {
    //     //throw $th;
    // }
    //Добавление в групы
    //$depassword 
    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    $password = hash('sha256', $depassword . $salt);
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
    
} 
