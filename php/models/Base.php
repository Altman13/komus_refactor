<?php

namespace Komus;

use Slim\Http\UploadedFile;

class Base
{
    private $db;
    private $obj_php_excel;
    private $obj_reader;
    private $input_file_type;
    public function __construct($db)
    {
        $this->db = $db;
        $this->obj_php_excel = new \PHPExcel();
        $this->obj_writer = new \PHPExcel_Writer_Excel2007($this->obj_php_excel);
        $this->input_file_type = new \PHPExcel_IOFactory();
    }
    public function create($files)
    {
        try {
            $uploadfile = $this->uploadFile($files);
            $total_rows = $this->setSettingsXls($uploadfile);
            //TODO : убедиться в том, что не может быть пропущенных пустых столбцов в файле для импорта базы,
            //!иначе загрузка произойдет до первого пустого столбца заголовка
            $columns_name = array();
            $query_insert_columns_name = "INSERT INTO contacts (";
            $data = array();
            for ($i = 0;; $i++) {
                $column_name_rus = $this->obj_php_excel->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue();
                if ($column_name_rus != NULL) {
                    $column_name_temp = $this->translitColumn($column_name_rus);
                    $column_name_translit = explode('-', $column_name_temp, 2);
                    $column_name_translit = preg_replace("/[^a-zA-ZА\s]/", '', $column_name_translit[0]);
                    array_push($columns_name, $column_name_translit);
                    $query_insert_columns_name .= '`' . $column_name_translit . '`, ';
                    $data[$column_name_translit] = strval($column_name_rus);
                    $alter_table_contacts = $this->db->prepare("ALTER TABLE contacts ADD IF NOT EXISTS $column_name_translit VARCHAR(255)");
                    $alter_table_contacts->execute();
                }
            }
            $this->saveArrayToFile($data);
            $this->insertDb($query_insert_columns_name, $total_rows, $columns_name);
        } catch (\Throwable $th) {
            echo 'Произошла ошибка при добавлении поля в таблицу contacts ' . $th->getMessage() . PHP_EOL;
        }
    }
    public function uploadFile($files)
    {
        $directory = __DIR__ . '/../files/';
        //TODO: дописать загрузку нескольких файлов
        $i = 1;
        foreach ($files as $f) {
            move_uploaded_file($f, $directory . "$i.xlsx");
            $i++;
        }
        $uploadfile = $directory . '1.xlsx';
        return $uploadfile;
    }
    public function setSettingsXls($uploadfile)
    {
        $this->input_file_type::identify($uploadfile);
        $this->obj_reader::createReader($this->input_file_type);

        if ($this->input_file_type == 'OOCalc') {
            $this->obj_reader->setLoadSheetsOnly('Лист1');
        }
        $this->obj_php_excel = $this->obj_reader->load($uploadfile);
        $worksheetData = $this->obj_reader->listWorksheetInfo($uploadfile);
        $total_rows = $worksheetData[0]['total_rows'];
        return $total_rows;
    }
    public function saveArrayToFile($data)
    {
            $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
            $fn = "columns_name.json";
            file_put_contents($fn, $data_json);    
    }
    public function translitColumn($column_name_rus)
    {
        $column_name_rus = (string) $column_name_rus; 
        $column_name_rus = strip_tags($column_name_rus); 
        $column_name_rus = str_replace(array("\n", "\r"), " ", $column_name_rus); 
        $column_name_rus = preg_replace("/\s+/", ' ', $column_name_rus);
        $column_name_rus = trim($column_name_rus); 
        $column_name_rus = function_exists('mb_strtolower') ? mb_strtolower($column_name_rus) : strtolower($column_name_rus); 
        $column_name_rus = strtr($column_name_rus, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 
        'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 
        'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        // очищаем строку от недопустимых символов
        $column_name_rus = preg_replace("/[^0-9a-z-_ ]/i", "", $column_name_rus); 
        $column_name_translit = str_replace(" ", "-", $column_name_rus);
        return $column_name_translit;
    }
    public function insertDb($query_insert_columns_name, $total_rows, $columns_name)
    {
        $query_insert_columns_name = substr_replace($query_insert_columns_name, ',`regions_id`, `users_id`)', -2, -1);
        for ($i = 1; $i < $total_rows; $i++) {
            $str_q_values = 'VALUES (';
            for ($column_num = 0; $column_num < count($columns_name); $column_num++) {
                $columns_value = $this->obj_php_excel->getActiveSheet()->getCellByColumnAndRow($column_num, $i)->getValue();
                $str_q_values .= '\'' . $columns_value . '\', ';
            }
            $str_q_values = substr_replace($str_q_values, ',\'1\',\'1\')', -2, -1);
            $insert_row = $this->db->prepare($query_insert_columns_name . $str_q_values);
            try {
                $insert_row->execute();
            } catch (\Throwable $th) {
                echo 'Произошла ошибка при добавлении записи в таблицу contacts ' . $th->getMessage() . PHP_EOL;
            }
        }
    }
    /**
     * Read
     *
     * @return void
     */
    public function read()
    {
    }
    /**
     * Update
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function update($id)
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
    public function delete($id)
    {
        # code...
    }
}
