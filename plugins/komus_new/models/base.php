<?php
//header("Access-Control-Allow-Origin: *");
require 'vendor/autoload.php';
require '/config/config.php';

class Base
{
    private $db;
    public function __construct($db, PHPExcel $objPHPExcel, $file_import_base)
    {
        $this->db = $db;
    }
    public function Create()
    {
        //TODO : реализовать динамическое добавление полей в таблицу контакты без ручного вмешательства в базу
        //$file_import_base = 'datas/users/load.xls';
        //set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
        //$objPHPExcel = new PHPExcel();

        $translit = array(

            'а' => 'a',   'б' => 'b',   'в' => 'v',
        
            'г' => 'g',   'д' => 'd',   'е' => 'e',
        
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
        
            'и' => 'i',   'й' => 'j',   'к' => 'k',
        
            'л' => 'l',   'м' => 'm',   'н' => 'n',
        
            'о' => 'o',   'п' => 'p',   'р' => 'r',
        
            'с' => 's',   'т' => 't',   'у' => 'u',
        
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
        
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
        
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'\'',
        
            'э' => 'e\'',   'ю' => 'yu',  'я' => 'ya',
        
        
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
        
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        
            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
        
            'И' => 'I',   'Й' => 'J',   'К' => 'K',
        
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
        
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
        
            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
        
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
        
            'Ь' => '\'',  'Ы' => 'Y\'',   'Ъ' => '\'\'',
        
            'Э' => 'E\'',   'Ю' => 'YU',  'Я' => 'YA',
        
        );
        $uploaddir = './files/';
        $uploadfile = $uploaddir . basename($_FILES['uploadfile']['name']);
        $objPHPExcel = new PHPExcel();
        //if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $file_import_base)) {
        $inputFileType = PHPExcel_IOFactory::identify($uploadfile);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        if ($inputFileType == 'OOCalc') {
            $objReader->setLoadSheetsOnly('Лист1');
        }
        $objPHPExcel = $objReader->load($uploadfile);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        //TODO: удалить пробелы, обрезать строки, сделать проверку на пустоту и перебор ячеек в цикле
        $for_sortable = array();
        for ($i = 0; $i < 100; $i++) {
            $column_name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, 1)->getValue();
            if ($column_name != NULL) {
                $column_name_translit = strtr($column_name, $translit);
                echo $column_name_translit . '<br>';
                array_push($for_sortable, $column_name_translit);
            }
        }
        return $for_sortable;

        // if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $this->file_import_base)) {
        //     $inputFileType = PHPExcel_IOFactory::identify($this->file_import_base);
        //     $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        //     if ($inputFileType == 'OOCalc') {
        //         $objReader->setLoadSheetsOnly('Лист1');
        //     }
        //     $objPHPExcel = $objReader->load($this->file_import_base);
        //     $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        //     foreach ($sheetData as $row) {
        //         $insert_base['fio']           = $row['B'];
        //         $insert_base['policenumber']  = $row['C'];
        //         $insert_base['productnumber'] = $row['D'];
        //         $insert_base['productname']   = $row['E'];
        //         $insert_base['currency']      = $row['F'];
        //         $insert_base['contractdate']  = $row['G'];
        //         $insert_base['dateend']       = $row['I'];
        //         $insert_base['period']        = $row['L'];
        //         $insert_base['premium']       = $row['O'];
        //         $insert_base['summ']          = $row['P'];
        //         $insert_base['profit']        = $row['T'];
        //         $insert_base['profityear']    = $row['V'];
        //         $insert_base['bank']          = $row['AA'];
        //         $insert_base['segment']       = $row['AC'];
        //         $insert_base['strategy']      = $row['AD'];
        //         $insert_base['marketname']    = $row['AE'];
        //         $insert_base['region']        = $row['AF'];
        //         $insert_base['city']          = $row['AG'];
        //         $insert_base['birthdate']     = $row['AH'];
        //         $insert_base['address']       = $row['AJ'];
        //         $insert_base['phone1']        = $row['AK'];
        //         $insert_base['phone2']        = $row['AL'];
        //         $insert_base['email']         = $row['AN'];
        //         $insert_base['office']        = $row['AM'];
        //     }
        // }
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
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
