<?php
require "config/config.php";
require "vendor/autoload.php";
error_reporting(E_ERROR | E_PARSE);

//TODO: Реализовать назначение в группы пользователей
/** Реализовать панель управления для админа и старшего оператора
 * в которой будет реализация раздачи прав и назначения групп пользователям
 */
//TODO: сделать проверку на добавление операторов, только тех, которых еще нет в базе
/** чтобы не дублировались пользователи */
$request_body = file_get_contents('php://input');
$operators_file = 'data/operators.xls';
//TODO: убрать сохранение файла на сервере
if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $operators_file)) {

    $inputFileType = PhpOffice\PhpSpreadsheet\IOFactory::identify($operators_file);
    $objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    if ($inputFileType == 'OOCalc') {
        $objReader->setLoadSheetsOnly('Операторы');
    }
    $objPHPExcel = $objReader->load($operators_file);
    $operators = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    foreach ($operators as $operator) {
        $operator_fist_name = $operator['C'].' '.$operator['D'];
        $operator_last_name = $operator['B'];
        $operator_login = $operator['E'];
        $operator_depass = $operator['F'];
        
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $operator_depass . $salt);
        $insert_users = $db->prepare("INSERT INTO users (username, password, salt, depass)
                                        VALUES (:login, :pass, :salt, :depass)");
        $insert_users->bindParam(':login', $operator_login, PDO::PARAM_STR);
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
} else {
    die('Произошла ошибка при загрузке файла с операторами на сервер');
}
