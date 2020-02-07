<?php
//header("Access-Control-Allow-Origin: *");
class Calls
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function Create()
    {
        //TODO : реализовать динамическое добавление полей в таблицу контакты без ручного вмешательства в базу
        $file_import_base = 'datas/users/load.xls';
        set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
        include_once 'PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $file_import_base)) {
            $inputFileType = PHPExcel_IOFactory::identify($file_import_base);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            if ($inputFileType == 'OOCalc') {
                $objReader->setLoadSheetsOnly('Лист1');
            }
            $objPHPExcel = $objReader->load($file_import_base);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheetData as $row) {
                $insert_base['fio']           = $row['B'];
                $insert_base['policenumber']  = $row['C'];
                $insert_base['productnumber'] = $row['D'];
                $insert_base['productname']   = $row['E'];
                $insert_base['currency']      = $row['F'];
                $insert_base['contractdate']  = $row['G'];
                $insert_base['dateend']       = $row['I'];
                $insert_base['period']        = $row['L'];
                $insert_base['premium']       = $row['O'];
                $insert_base['summ']          = $row['P'];
                $insert_base['profit']        = $row['T'];
                $insert_base['profityear']    = $row['V'];
                $insert_base['bank']          = $row['AA'];
                $insert_base['segment']       = $row['AC'];
                $insert_base['strategy']      = $row['AD'];
                $insert_base['marketname']    = $row['AE'];
                $insert_base['region']        = $row['AF'];
                $insert_base['city']          = $row['AG'];
                $insert_base['birthdate']     = $row['AH'];
                $insert_base['address']       = $row['AJ'];
                $insert_base['phone1']        = $row['AK'];
                $insert_base['phone2']        = $row['AL'];
                $insert_base['email']         = $row['AN'];
                $insert_base['office']        = $row['AM'];
            }
        }
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
