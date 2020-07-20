<?php

namespace Komus;

use Slim\Http\UploadedFile;

class Base
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function create($files)
    {
        $directory = __DIR__ . '/../files/';
        //TODO: дописать загрузку нескольких файлов
        $i = 1;
        foreach ($files as $f) {
            move_uploaded_file($f, $directory . "$i.xlsx");
            $i++;
        }
        $uploadfile = $directory . '1.xlsx';
        $obj_php_excel = new \PHPExcel();
        $input_file_type = \PHPExcel_IOFactory::identify($uploadfile);
        $obj_reader = \PHPExcel_IOFactory::createReader($input_file_type);
        if ($input_file_type == 'OOCalc') {
            $obj_reader->setLoadSheetsOnly('Лист1');
        }
        $obj_php_excel = $obj_reader->load($uploadfile);
        $worksheetData = $obj_reader->listWorksheetInfo($uploadfile);
        $totalRows = $worksheetData[0]['totalRows'];
        function translit($s)
        {
            $s = (string) $s; // преобразуем в строковое значение
            $s = strip_tags($s); // убираем HTML-теги
            $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
            $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
            $s = trim($s); // убираем пробелы в начале и конце строки
            $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
            $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
            $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
            $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
            return $s; // возвращаем результат
        }
        //TODO : убедиться в том, что не может быть пропущенных пустых столбцов в файле для импорта базы,
        //иначе загрузка произойдет до первого пустого столбца заголовка
        //номер строки в excel файле 
        $for_sortable = array();
        $str_q_tables_n = "INSERT INTO contacts (";
        $data = array();
        for ($i = 0;; $i++) {
            $column_name = $obj_php_excel->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue();
            if ($column_name != NULL) {
                $column_name_translit = translit($column_name);
                $one_word_column_name = explode('-', $column_name_translit, 2);
                $one_word_column_name = preg_replace("/[^a-zA-ZА\s]/", '', $one_word_column_name[0]);
                array_push($for_sortable, $one_word_column_name);
                $str_q_tables_n .= '`' . $one_word_column_name . '`, ';
                $data[$one_word_column_name] = strval($column_name);
            } else {
                break;
            }
            $alter_table_contacts = $this->db->prepare("ALTER TABLE contacts ADD IF NOT EXISTS $one_word_column_name VARCHAR(255)");
            try {
                $alter_table_contacts->execute();
            } catch (\Throwable $th) {
                echo 'Произошла ошибка при добавлении поля в таблицу contacts ' . $th->getMessage() . PHP_EOL;
            }
        }

        $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $fn = "columns_name.json";
        file_put_contents($fn, $data_json);

        $str_q_tables_n = substr_replace($str_q_tables_n, ',`regions_id`, `users_id`)', -2, -1);
        for ($i = 1; $i < $totalRows; $i++) {
            $str_q_values = 'VALUES (';
            for ($column_num = 0; $column_num < count($for_sortable); $column_num++) {
                $columns_value = $obj_php_excel->getActiveSheet()->getCellByColumnAndRow($column_num, $i)->getValue();
                $str_q_values .= '\'' . $columns_value . '\', ';
            }
            $str_q_values = substr_replace($str_q_values, ',\'1\',\'1\')', -2, -1);
            $insert_row = $this->db->prepare($str_q_tables_n . $str_q_values);
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
