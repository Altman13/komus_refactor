<?php

namespace Komus;
//header("Access-Control-Allow-Origin: *");
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
        $sheetData = $obj_php_excel->getActiveSheet()->toArray(null, true, true, true);

        //всего строк в файле
        $worksheetData = $obj_reader->listWorksheetInfo($uploadfile);
        global $totalRows;
        $totalRows = $worksheetData[0]['totalRows'];
        //TODO: удалить пробелы, обрезать строки, сделать проверку на пустоту и перебор ячеек в цикле

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
        $for_sortable = array();
        //TODO : убедиться в том, что не может быть пропущенных пустых столбцов в файле для импорта базы,
        //иначе загрузка произойдет до первого пустого столбца заголовка
        //номер строки в excel файле 
        for ($i = 0;; $i++) {
            $column_name = $obj_php_excel->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue();
            if ($column_name != NULL) {
                $column_name_translit = translit($column_name);
                $one_word_column_name = explode('-', $column_name_translit, 2);
                $one_word_column_name = preg_replace("/[^a-zA-ZА\s]/", '', $one_word_column_name[0]);
            } else {
                break;
            }
            // ALTER TABLE `contacts` ADD COLUMN 
            // test VARCHAR(255) NULL DEFAULT NULL AFTER `id`  
            $alter_table_contacts = $this->db->prepare("ALTER TABLE contacts ADD $one_word_column_name VARCHAR(255)");
            try {
                $alter_table_contacts->execute();
            } catch (\Throwable $th) {
                //TODO :убрать в отдельную функцию  errorReporter
                die('Произошла ошибка при добавлении поля в таблицу contacts '
                    . $th->getMessage() . ' в строке № ' . $th->getLine() .
                    ' по адресу: ' . $_SERVER['SCRIPT_NAME']);
            }
        }
        array_push($for_sortable, $one_word_column_name);
        //}
        // global $columns_for_insert;
        // foreach ($for_sortable as $item) {
        //     $columns_for_insert .= $item;
        //     $columns_for_insert .= ', ';
        // }
        // echo $columns_for_insert;






        $length = count($for_sortable);
        echo '<br>';
        global $i;
        for ($i = 2; $i < $totalRows; $i++) {
            for ($column_num = 0; $column_num < $length; $column_num++) {
                $columns_value = $obj_php_excel->getActiveSheet()->getCellByColumnAndRow($column_num, $i)->getValue();
                echo $columns_value . ' ';
            }
            echo '<br>';
        }
        //$insert_contacts = $this->db->prepare("INSERT INTO `komus_new`.`contacts` ($columns_for_insert) VALUES ('2020-02-12 13:17:35', '21', '29', :col_val)");
        // $insert_contacts->bindParam(':col_val', $column_value, \PDO::PARAM_STR);
        //     $alter_table_contacts = $this->db->prepare("ALTER TABLE `contacts` ADD COLUMN 
        //                         $one_word_column_name VARCHAR(255) NULL DEFAULT NULL AFTER `id`");
        //     try {
        //         $alter_table_contacts->execute();
        //     } catch (\Throwable $th) {
        //         //TODO :убрать в отдельную функцию  errorReporter
        //         die('Произошла ошибка при добавлении поля в таблицу contacts '
        //             . $th->getMessage() . ' в строке № ' . $th->getLine() .
        //             ' по адресу: ' . $_SERVER['SCRIPT_NAME']);
        //     }
        // }
        // //добавление данных в базу после динамического создания полей
        // global $column_num;
        // for ($column_num = 0;; $column_num++) {
        //     for ($row_num = 1;; $row_num++) {
        //         $column_value = $obj_php_excel->getActiveSheet()->getCellByColumnAndRow($column_num, $row_num)->getValue();
        //         if ($column_value != NULL) {
        //             echo $column_value . '<br>';
        //         } else {
        //             break;
        //         }
        // $insert_contacts = $db->prepare("INSERT INTO `komus_new`.`contacts` (`creation_time`,`regions_id`, `users_id`, $col_name) VALUES ('2020-02-12 13:17:35', '21', '29', :col_val)");
        // $insert_contacts->bindParam(':col_val', $column_value, PDO::PARAM_STR);
        // try {
        //     $insert_contacts->execute();
        // } catch (\Throwable $th) {
        //     die('Произошла ошибка при добавлении значения ' . $column_value . ' в таблицу contacts '
        //         . $th->getMessage() . ' в строке №' . $th->getLine() .
        //         ' по адресу: ' . $_SERVER['SCRIPT_NAME']);
        // }
        //     }
        // }
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
