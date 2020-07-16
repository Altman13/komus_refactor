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
        $this->obj_php_excel = new PHPExcel();
        $this->obj_writer = new PHPExcel_Writer_Excel2007($this->obj_php_excel);
        $this->report = $container['report'];
    }
    public function show()
    {
        //set_time_limit(1800);
        // $ret =array('data' =>'', 'error' => '', 'error_text'=> '');
        // $ret['error'] = 'error_ocurred';
        // $return=json_encode($ret, JSON_UNESCAPED_UNICODE);

        $this->obj_php_excel->setActiveSheetIndex(0);
        $data_for_xls = $this->report->read();
        $row_num = 1;

        foreach ($data_for_xls as $key => $data_row) {
            $clm_num = 0;
            foreach ($data_row as $key => $column_val) {
                if ($row_num == 1) {
                    $this->headerReportFormat($clm_num, $row_num, $key);
                    $clm_num++;
                } else {
                    $even_row = is_float($row_num / 2);
                    if ($even_row) {
                        $this->bodyReportFormat($rgb = 'FAEBD7', $clm_num, $row_num, $column_val);
                    } else {
                        $this->bodyReportFormat($rgb = 'F5F5F5', $clm_num, $row_num, $column_val);
                    }
                    $clm_num++;
                }
            }
            $row_num++;
        }
        $this->obj_writer->save('report.xlsx');
    }
    public function headerReportFormat($clm_num, $row_num, $key)
    {
        $string_value_column = PHPExcel_Cell::stringFromColumnIndex($clm_num);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '2F4F4F')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'DDDDDD')
                )
            )
        );
        $this->obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $key);
        $this->obj_php_excel->getActiveSheet()->getColumnDimension($string_value_column)->setWidth("30");
        $this->obj_php_excel->getActiveSheet()->getRowDimension("1")->setRowHeight(50);
        $this->obj_php_excel->getActiveSheet()->getStyle("A1:$string_value_column" . "1")->applyFromArray($styleArray);
        $this->obj_php_excel->getActiveSheet()->getStyle("A1:$string_value_column" . "1")->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'ebffdd'
            )
        ));
    }
    public function bodyReportFormat($rgb, $clm_num, $row_num, $column_val)
    {
        $string_value_column = PHPExcel_Cell::stringFromColumnIndex($clm_num);
        $border = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'DDDDDD')
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $this->obj_php_excel->getActiveSheet()->setCellValueByColumnAndRow($clm_num, $row_num, $column_val);
        $this->obj_php_excel->getActiveSheet()->getStyle("A" . $row_num . ":$string_value_column" . $row_num)->applyFromArray($border);
        $this->obj_php_excel->getActiveSheet()->getStyle("A" . $row_num . ":$string_value_column" . $row_num)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $rgb
            )
        ));
    }
}
