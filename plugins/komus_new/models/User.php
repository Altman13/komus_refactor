<?php

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use Firebase\JWT\JWT;

namespace Komus;

use DateTime;

require "config/config.php";
require "vendor/autoload.php";

//$spreadsheet = new Spreadsheet();
//$sheet = $spreadsheet->getActiveSheet();
// $uploaddir = './files/';
// $uploadfile = $uploaddir . basename($_FILES['uploadfile']['name']);

class User
{
    private $db;
    private $operators_file;
    public function __construct($db)
    {
        $this->db = $db;
        //$this->operators_file = $uploadfile;
    }
    /**
     * Create
     *
     * @param  mixed $users
     *
     * @return void
     */
    public function create($files)
    {
        //TODO: Реализовать назначение в группы пользователей
        /** Реализовать панель управления для админа и старшего оператора
         * в которой будет реализация раздачи прав и назначения групп пользователям
         */
        //TODO: Реализовать подгрузку пользователей сразу из центрального проекта
        $directory = __DIR__ . '/../files/';
        foreach ($files as $f) {
            move_uploaded_file($f, $directory . "operators.xlsx");
        }
        //TODO: удалить файл
        $uploadfile = $directory . 'operators.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($uploadfile);
        $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        if ($inputFileType == 'OOCalc') {
            $objReader->setLoadSheetsOnly('Операторы');
        }
        try {
            $objPHPExcel = $objReader->load($uploadfile);
        } catch (\Throwable $th) {
            die('Произошла ошибка при попытке чтения файла с операторами ' . $th->getMessage() . PHP_EOL);
        }
        $operators = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $unicode = $this->db->prepare("SET NAMES utf8 COLLATE utf8_unicode_ci");
        $unicode->execute();
        foreach ($operators as $operator) {
            $operator_fist_name = $operator['C'];
            $operator_last_name = $operator['B'];
            $operator_login = $operator['E'];
            $operator_depass = $operator['F'];
            // echo $operator_login .PHP_EOL;
            // echo $operator_depass .PHP_EOL;
            //$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            //$password_hash = hash('sha256', $operator_depass . $salt);
            //генерируем  JWT токен            
            $payload = [
                "user" => $operator_login,
                "passwords" => $operator_depass,
            ];
            var_dump($payload);
            die();

            $token =\Firebase\JWT\JWT::encode($payload, "thisissecret", "HS256");
            $insert_users = $this->db->prepare("INSERT IGNORE INTO users (login, firstname, lastname, depass, token,
                                                            timezone_id, groups_id)
                                                                VALUES (:operator_login, :operator_fist_name, :operator_last_name, :depass, :token,
                                                            1, 1)");
            $insert_users->bindParam(':operator_login', $operator_login, \PDO::PARAM_STR);
            $insert_users->bindParam(':operator_fist_name', $operator_fist_name, \PDO::PARAM_STR);
            $insert_users->bindParam(':operator_last_name', $operator_last_name, \PDO::PARAM_STR);
            //$insert_users->bindParam(':salt', $salt, \PDO::PARAM_STR);
            //$insert_users->bindParam(':pass', $password_hash, \PDO::PARAM_STR);
            $insert_users->bindParam(':token', $token, \PDO::PARAM_STR);
            // //TODO : убрать после отладки depass из базы
            $insert_users->bindParam(':depass', $operator_depass, \PDO::PARAM_STR);
            try {
                $insert_users->execute();
            } catch (\Throwable $th) {
                die('Произошла ошибка при добавлении оператора в базу ' . $th->getMessage());
            }
        }
        echo 'Операторы добавлены. ' . PHP_EOL;
    }
    /**
     * Read
     *
     * @return void
     */
    public function read()
    {
        $all_users = $this->db->prepare("SELECT CONCAT(users.firstname,' ', users.lastname) as operators FROM users");
        try {
            $all_users->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке контактов ' . $th->getMessage());
        }
        $users = $all_users->fetchAll();
        return json_encode($users);
    }
    /**
     * Update
     *
     * @param  mixed $name
     *
     * @return void
     */
    public function update($user_name)
    {
        if ($user_name) {
            $update_role_user = $this->db->prepare("UPDATE `komus_new`.`users` SET `groups_id`='2' WHERE users.firstname =:user_name");
            $update_role_user->bindParam(':user_name', $user_name, \PDO::PARAM_STR);
            try {
                $update_role_user->execute();
            } catch (\Throwable $th) {
                echo ('Произошла ошибка при назначении прав оператору' . $th->getMessage() . PHP_EOL);
            }
            echo ('Произошла ошибка при назначении прав оператору' . $th->getMessage() . PHP_EOL);
        }
    }
    /**
     * Delete
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function delete($id)
    {
        # code...
    }
}
