<?php
require "config/config.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Firebase\JWT\JWT;

namespace Komus;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$uploaddir = './files/';
$uploadfile = $uploaddir . basename($_FILES['uploadfile']['name']);
class User
{
    private $db;
    private $operators_file;
    public function __construct($db, $uploadfile)
    {
        $this->db = $db;
        $this->operators_file = $uploadfile;
    }
    /**
     * Create
     *
     * @param  mixed $users
     *
     * @return void
     */
    public function Create()
    {
        //TODO: Реализовать назначение в группы пользователей
        /** Реализовать панель управления для админа и старшего оператора
         * в которой будет реализация раздачи прав и назначения групп пользователям
         */
        //TODO: Реализовать подгрузку пользователей сразу из центрального проекта
        $inputFileType = PhpOffice\PhpSpreadsheet\IOFactory::identify($this->operators_file);
        $objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        if ($inputFileType == 'OOCalc') {
            $objReader->setLoadSheetsOnly('Операторы');
        }
        try {
            $objPHPExcel = $objReader->load($this->operators_file);
        } catch (\Throwable $th) {
            die('Произошла ошибка при попытке чтения файла с операторами ' . $th->getMessage() . PHP_EOL);
        }
        $operators = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        foreach ($operators as $operator) {
            $operator_fist_name = $operator['C'];
            $operator_last_name = $operator['B'];
            $operator_login = $operator['E'];
            $operator_depass = $operator['F'];
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password_hash = hash('sha256', $operator_depass . $salt);
            //генерируем  JWT токен            
            $payload = [
                "user" => $operator_login,
                "passwords" =>$operator_depass
            ];
            $token = JWT::encode($payload, "thisissecret", "HS256");
            $insert_users = $this->db->prepare("INSERT IGNORE INTO users (login, firstname, lastname, password, token, salt, depass, 
                                                            timezone_id, groups_id)
                                            VALUES (:operator_login, :operator_fist_name, :operator_last_name, :pass, :token, :salt, :depass, 1, 1)");
            $insert_users->bindParam(':operator_login', $operator_login, PDO::PARAM_STR);
            $insert_users->bindParam(':operator_fist_name', $operator_fist_name, PDO::PARAM_STR);
            $insert_users->bindParam(':operator_last_name', $operator_last_name, PDO::PARAM_STR);
            $insert_users->bindParam(':salt', $salt, PDO::PARAM_STR);
            $insert_users->bindParam(':pass', $password_hash, PDO::PARAM_STR);
            $insert_users->bindParam(':token', $token, PDO::PARAM_STR);
            // //TODO : убрать после отладки depass из базы
            $insert_users->bindParam(':depass', $operator_depass, PDO::PARAM_STR);
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
    public function Read()
    {
        $all_users = $this->db->prepare("SELECT * FROM users");
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
     * @param  mixed $id
     *
     * @return void
     */
    public function Update($id)
    {
        # code...
    }
    /**
     * Delete
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function Delete($id)
    {
        # code...
    }
}
