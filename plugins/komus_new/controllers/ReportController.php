<?php

use Komus\report;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class ReportController
{
    private $report;
    private $obj_php_excel;
    private $obj_writer;
    public function __construct(Container $container)
    {
        $this->obj_php_excel=new PHPExcel();
        $this->obj_writer=new PHPExcel_Writer_Excel2007($this->obj_php_excel);
        $this->report=$container['report'];
    }
    public function show()
    {
        //set_time_limit(1800);
        //TODO: сформировать рамку у отчета и шапку отчета
        $this->obj_php_excel->setActiveSheetIndex(0);
        $data_for_xls = $this->report->read();
        $row_num = 1;
        
        foreach ($data_for_xls as $key => $data_row) {
            $clm_num = 0;
            foreach ($data_row as $key => $column_val) {
                if ($row_num == 1) {
                    $this->obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $key);
                    $string_value_column = PHPExcel_Cell::stringFromColumnIndex($clm_num);
                    echo $string_value_column.PHP_EOL;
                    $this->obj_php_excel->getActiveSheet()->getStyle("A1:$string_value_column"."1")->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'F28A8C'
                        )
                        ));
                    $clm_num++;
                } else {
                    $this->obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $column_val);
                    $clm_num++;
                }
            }
            $row_num++;
        }
        $this->obj_writer->save('report.xlsx');
    }
}
