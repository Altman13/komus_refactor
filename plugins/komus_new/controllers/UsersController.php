<?php
require "config/config.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
//$file_name = $_FILES["operatorsfile"]["name"];
$operators_file = 'c:/Users/temp/Downloads/temp.xls';
//TODO: Реализовать назначение в группы пользователей
/** Реализовать панель управления для админа и старшего оператора
 * в которой будет реализация раздачи прав и назначения групп пользователям
 */
//TODO: сделать проверку на добавление операторов, только тех, которых еще нет в базе
/** чтобы не дублировались пользователи */
//TODO: реализовать проверку на пустые поля при добавлении операторов

$inputFileType = PhpOffice\PhpSpreadsheet\IOFactory::identify($operators_file);
$objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
if ($inputFileType == 'OOCalc') {
    $objReader->setLoadSheetsOnly('Операторы');
}
try {
    $objPHPExcel = $objReader->load($operators_file);
} catch (\Throwable $th) {
    die('Произошла ошибка при попытке чтения файла с операторами ' . $th->getMessage() . PHP_EOL);
}

$operators = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
foreach ($operators as $operator) {
    $operator_fist_name = $operator['C'] . ' ' . $operator['D'];
    $operator_last_name = $operator['B'];
    $operator_login = $operator['E'];
    $operator_depass = $operator['F'];
    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    $password = hash('sha256', $operator_depass . $salt);
    $insert_users = $db->prepare("INSERT INTO users (user_login, user_firstname, user_lastname, user_password, salt, depass, 
                                                        timezone_id, groups_id)
                                        VALUES (:operator_login, :operator_fist_name, :operator_last_name, :pass, :salt, :depass, 1, 1)");
    $insert_users->bindParam(':operator_login', $operator_login, PDO::PARAM_STR);
    $insert_users->bindParam(':operator_fist_name', $operator_fist_name, PDO::PARAM_STR);
    $insert_users->bindParam(':operator_last_name', $operator_last_name, PDO::PARAM_STR);
    $insert_users->bindParam(':salt', $salt, PDO::PARAM_STR);
    $insert_users->bindParam(':pass', $password, PDO::PARAM_STR);
    //TODO : убрать после отладки depass из базы
    $insert_users->bindParam(':depass', $operator_depass, PDO::PARAM_STR);
    try {
        $insert_users->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при добавлении оператора в базу ' . $th->getMessage());
    }
}
echo 'Операторы добавлены. ' . PHP_EOL;