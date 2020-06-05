<?php

use Komus\report;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class ReportController
{
    private $report;
    public function __construct(Container $container)
    {
        $this->report = $container['report'];
    }
    public function show()
    {
        //set_time_limit(1800);
        //TODO: сформировать рамку у отчета и шапку отчета
        $obj_php_excel = new PHPExcel();
        $obj_writer = new PHPExcel_Writer_Excel2007($obj_php_excel);
        $obj_php_excel->setActiveSheetIndex(0);
        $data_for_xls = $this->report->read();
        $row_num = 1;
        foreach ($data_for_xls as $key => $data_row) {
            $clm_num = 0;
            foreach ($data_row as $key => $column_val) {
                if ($row_num == 1) {
                    $obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $key);
                    $clm_num++;
                } else {
                    $obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $column_val);
                    $clm_num++;
                }
            }
            $row_num++;
        }
        $obj_writer->save('report.xlsx');
    }
}
