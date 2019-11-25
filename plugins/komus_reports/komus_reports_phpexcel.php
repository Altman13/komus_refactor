<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_reports
 * @version 1.0.0
 * @author Larion Lushnikov
 * @copyright (c) Komus
 * @license BSD
 */

set_time_limit(180);
defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_incfile('forms');
require_once cot_langfile('komus');
require_once cot_langfile('komus_reports');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'w');

$gr_operator_groups = array(5, 6);
$operator_groups = array();

$gr_operator_access = false;
$operator_access = false;

$sql_user_string = "SELECT gru_groupid FROM {$db_x}groups_users WHERE gru_userid = {$usr['id']}";
$sql_user = $db->query($sql_user_string);

foreach ($sql_user->fetchAll() as $group) {
    if (in_array($group['gru_groupid'], $gr_operator_groups)) {
        $gr_operator_access = true;
    }
    if (in_array($group['gru_groupid'], $operator_groups)) {
        $operator_access = true;
    }
}

$plugin_title = $L['komus_reports_title'];

$mode = cot_import('mode', 'G', 'ALP');

switch ($mode) {
case 'report':
    $rep = cot_import('rep', 'G', 'INT');
    require_once('plugins/komus_reports/inc/komus_reports.xls_tpl.php');
    
    if (empty($_POST)) {
        $t->assign(array(
            'KOMUS_CREATE_ACTION'     => cot_url('plug', 'e=komus_reports&mode=report&rep=' . $rep),
            'KOMUS_CREATE_FROM_DATE'  => cot_selectbox_date($sys['now_offset'], 'short', 'from'),
            'KOMUS_CREATE_TO_DATE'    => cot_selectbox_date($sys['now_offset'], 'short', 'to')
        ));
        $t->parse('MAIN.REPORT');
    } else {
        $from = cot_import('from', 'P', 'ARR');
        $from_sql = $from['year'] . '-' . $from['month'] . '-' . $from['day'] . ' 00:00:00';
        $to = cot_import('to', 'P', 'ARR');
        $to_sql = $to['year'] . '-' . $to['month'] . '-' . $to['day'] . ' 23:59:59';
        $current_user_sql = ($operator_access) ?
            ' AND d.user_id = ' . $usr['id'] : 
            '';
        
        $sql_references_string = "SELECT id, title, value FROM {$db_x}komus_references_items";
        $sql_references = $db->query($sql_references_string);
        $references = array();
        foreach ($sql_references as $row) {
            $tmp = array();
            $tmp['title'] = $row['title'];
            $tmp['value'] = $row['value'];
            $references[$row['id']] = $tmp;
        }
            
        require_once 'Spreadsheet/Excel/Writer.php';

/*===========================================================*/
/*=============== Отчеты ====================================*/
/*===========================================================*/
        
        switch ($rep) {
/*---------------------------------------------*/
/*---------- Основной отчет -------------------*/
/*---------------------------------------------*/         	
            case 1:
            $rep_name = 'base';
            
            $sql_report_string = "
                SELECT contact.*, DATE_FORMAT(contact.creation_time, '%d.%m.%Y %H:%i') begin_time, u.user_lastname, u.user_firstname,
                       DATE_FORMAT(contact.creation_time, '%d.%m.%Y') begin_dates, DATE_FORMAT(contact.creation_time, '%H:%i') begin_times                                              
                FROM {$db_x}komus_contacts AS contact                
                LEFT JOIN {$db_x}users AS u ON u.user_id = contact.user_id                               
                ORDER BY contact.id
            ";
            $sql_report = $db->query($sql_report_string);

            $xls_filename = 'reports/report_' . $rep_name . '.xls';
            
            //подключаем и создаем класс PHPExcel
            set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');        
	        include_once 'PHPExcel.php';   
	      
	        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
            $cacheSettings = array( 'dir'  => '/var/www/_dev/develop-dev/tmp' );
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
	        
	        
	        
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $aSheet = $objPHPExcel->getActiveSheet();
            $aSheet->setTitle('Первый лист');           
            
            // Ширина столбца
            $aSheet->getColumnDimension('A')->setWidth(25);
            $aSheet->getColumnDimension('B')->setWidth(25);
            $aSheet->getColumnDimension('C')->setWidth(25);
            $aSheet->getColumnDimension('D')->setWidth(15);
            $aSheet->getColumnDimension('E')->setWidth(15);
            $aSheet->getColumnDimension('F')->setWidth(15);
            $aSheet->getColumnDimension('G')->setWidth(15);
            $aSheet->getColumnDimension('H')->setWidth(15);
            $aSheet->getColumnDimension('I')->setWidth(15);
            $aSheet->getColumnDimension('J')->setWidth(25);
            $aSheet->getColumnDimension('K')->setWidth(15);
            $aSheet->getColumnDimension('L')->setWidth(10);
            
            // Стили по умолчанию для всего документа
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);             

            // Массив стилей
            $styleArray = array(
	             'font' => array(
		                'bold' => true,
                        'name' => 'Calibri'
	             ),	             	             

	             'alignment' => array(
		                 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
	                     'wrap'       => true,
	                     'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER 
	             ),	             	             
	             
	              'fill' => array(
		               'type' => PHPExcel_Style_Fill::FILL_SOLID,		               
		               'startcolor' => array(
			                'argb' => 'FFA0A0A0',
		               ),
	               ),
	               
	               'borders' => array(
		               'allborders' => array(
			                 'style' => PHPExcel_Style_Border::BORDER_THIN,
			                 'color' => array('argb' => '00000000'),
		               ),
	               ),	               
               );
               
               $styleArray1 = array(                     	             

	             'alignment' => array(
		                 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
	                     'wrap'       => true	                     
	             ),	             	             
	             	              	               
	              'borders' => array(
		               'allborders' => array(
			                 'style' => PHPExcel_Style_Border::BORDER_THIN,
			                 'color' => array('argb' => '00000000'),
		               ),
	               ),	               
               );

               $aSheet->getStyle('A1:L1')->applyFromArray($styleArray);
                       
            
            $aSheet -> setCellValue('A1', 'Имя');
            $aSheet -> setCellValue('B1', 'Отчество');
            $aSheet -> setCellValue('C1', 'Фамилия');
            $aSheet -> setCellValue('D1', 'Телефон');
            $aSheet -> setCellValue('E1', 'Город');
            $aSheet -> setCellValue('F1', 'Статус звонка');
            $aSheet -> setCellValue('G1', 'Дата звонка');
            $aSheet -> setCellValue('H1', 'Время звонка');
            $aSheet -> setCellValue('I1', 'Оператор');
            $aSheet -> setCellValue('J1', 'Коментарий');
            $aSheet -> setCellValue('K1', 'Кол-во  наборов');
            $aSheet -> setCellValue('L1', 'ID');
            
            $count = 1; 
            foreach ($sql_report as $key => $row) {               	         	
            	$row_num = $key + 2;
            	$aSheet->getStyle('A'.$row_num.':L'.$row_num)->applyFromArray($styleArray1);
            	
            	$status            = getReferenceItem($row['status']);            	
            	            	
            	if ($row['status'] == 1) {
            		$status = $status.' '.$row['count_calls'];
            	}
            	
            	$aSheet->setCellValueByColumnAndRow(0, $row_num, $row['First_Name']);
            	$aSheet->setCellValueByColumnAndRow(1, $row_num, $row['Patronymic']);
            	$aSheet->setCellValueByColumnAndRow(2, $row_num, $row['Last_Name']);
                $aSheet->setCellValueByColumnAndRow(3, $row_num, $row['phone']);
                $aSheet->setCellValueByColumnAndRow(4, $row_num, $row['City']);
                
                $aSheet->setCellValueByColumnAndRow(5, $row_num, $status);
                $aSheet->setCellValueByColumnAndRow(6, $row_num, $row['begin_dates']);
                $aSheet->setCellValueByColumnAndRow(7, $row_num, $row['begin_times']);
                $aSheet->setCellValueByColumnAndRow(8, $row_num, $row['user_lastname'] . ' ' . $row['user_firstname']);
                $aSheet->setCellValueByColumnAndRow(9, $row_num, $row['comment']);
                $aSheet->setCellValueByColumnAndRow(10, $row_num, $row['count_calls']);
                $aSheet->setCellValueByColumnAndRow(11, $row_num, $row['id']);            
           }
           
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
          //  $objWriter->setOffice2003Compatibility(true);
            $objWriter->save($xls_filename);
 
            break; 

            case 2:
            $rep_name = 'work';
            
            $data_begin_mktime = mktime(0,0,0, $from['month'], $from['day'], $from['year']);	        
	        $date_end_mktime   = mktime(0,0,0, $to['month'], $to['day'], $to['year']);	        
	        $count = 0;
            for ( $i = $data_begin_mktime; $i <= $date_end_mktime; $i += 3600 * 24, $count++ ) {
			    $interval[$count]['mysql'] = strftime( '%Y-%m-%d', $i );			
			    $interval[$count]['data'] = strftime( '%d.%m.%Y', $i );
		    }		                
            
            $xls_filename = 'report_' . $rep_name . '.xls';

            $xls = new Spreadsheet_Excel_Writer('reports/' . $xls_filename);
            $sheet =& $xls->addWorksheet(iconv('utf-8', 'windows-1251', 'Время работы'));
          
            //$sheet->setRow(0, 18.75);

            $formatHeader =& $xls->addFormat();
            $formatHeader->setBorder(1);
            $formatHeader->setHAlign('center');
            $formatHeader->setVAlign('vcenter');
            $formatHeader->setBold();
            $formatHeader->setTextWrap();
            $formatHeader->setFgColor(22);
            
            $formatDay =& $xls->addFormat();
            $formatDay->setBorder(1);            
            $formatDay->setVAlign('vcenter');
            $formatDay->setBold();
            $formatDay->setTextWrap();
            $formatDay->setFgColor(26);
            
            $formatCell =& $xls->addFormat();          
            $formatCell->setHAlign('center');
            $formatCell->setVAlign('top');
            $formatCell->setBorder(1);
            $formatCell->setTextWrap();
            
            $sheet->setColumn(0, 0, 25);
            $sheet->setColumn(0, 1, 20);
            
            $row_num = 0;
            $summa_day = 0;
            $summa_all = 0;
            foreach ($interval as $key => $day) {
            	$sql_report_string = "
                    SELECT id, UNIX_TIMESTAMP(MIN(begin_time)) AS mintime, UNIX_TIMESTAMP(MAX(begin_time)) AS maxtime, users.user_lastname, users.user_firstname                                              
                    FROM {$db_x}komus_calls AS calls
                    LEFT JOIN {$db_x}users AS users ON calls.user_id = users.user_id
                    WHERE calls.user_id > 0 AND
                          calls.begin_time >= '{$day["mysql"]} 00:00:00' AND calls.begin_time <= '{$day["mysql"]} 23:59:59'
                    GROUP BY calls.user_id
                    ORDER BY users.user_lastname
                ";
                $sql_report = $db->query($sql_report_string);
               
                $sheet->write($row_num, 0, iconv('utf-8', 'windows-1251', $day["data"]), $formatDay);
                $sheet->write($row_num++, 1, iconv('utf-8', 'windows-1251', ''), $formatDay);
                $sheet->write($row_num, 0, iconv('utf-8', 'windows-1251', 'Оператор'), $formatHeader);
                $sheet->write($row_num, 1, iconv('utf-8', 'windows-1251', 'Время работы'), $formatHeader);
                foreach ($sql_report->fetchAll() as $keyrow => $row) {            	            	            	
                    $row_num++;
                    $worktime = $row['maxtime'] - $row['mintime'];
                    $summa_day += $worktime;
                    
                    $worktimehours = round($worktime / 3600, 2);
                    $minut = $worktimehours - floor($worktimehours);
                    if ($minut > 0) {
                    	$worktimeminut = round(60*$minut);
                    } else {
                    	$worktimeminut = '00';
                    }
                    $time = $worktimehours.':'.$worktimeminut;
                    
                    $sheet->write( $row_num, 0, iconv('utf-8', 'windows-1251', $row['user_lastname'].' '.$row['user_firstname']), $formatCell);
                    $sheet->write( $row_num, 1, iconv('utf-8', 'windows-1251', round($worktime / 3600, 2)), $formatCell);                                        
               }
               $row_num++;
               $sheet->write($row_num, 0, iconv('utf-8', 'windows-1251', 'Итого:'), $formatHeader);
               $sheet->write($row_num, 1, iconv('utf-8', 'windows-1251', round($summa_day / 3600, 2)), $formatHeader);
               $summa_all += $summa_day;
               $summa_day = 0;
               $row_num += 2;               
            }    
            $sheet->write($row_num, 0, iconv('utf-8', 'windows-1251', 'Общий итого:'), $formatHeader);
            $sheet->write($row_num, 1, iconv('utf-8', 'windows-1251', round($summa_all / 3600, 2)), $formatHeader); 
            $xls->close(); 
            break;            
        }
        
        if ($gr_operator_access) {
            $t->assign(array(
                'KOMUS_REPORTS_XLS_FILENAME' => $xls_filename
            ));
        }
        
        $t->assign(array(
            'KOMUS_REPORTS_SELECT_DATE' => $select_date,
            'KOMUS_REPORTS_XLS_OUT'     => $xls_out,
            'KOMUS_REPORTS_TITLE'       => $L['komus_reports_title']
        ));
        $t->parse('MAIN.XLS_OUT');
    }
    break;
        
default:
    if ($gr_operator_access) {
        $t->assign(array(
            'KOMUS_REPORTS_BASE_URL'                => cot_url('plug', 'e=komus_reports&mode=report&rep=1'),
            'KOMUS_REPORTS_OPERATOR_URL'            => cot_url('plug', 'e=komus_reports&mode=report&rep=2')           
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR');
    }

    if ($operator_access) {
        $t->assign(array(
        ));
        $t->parse('MAIN.HOME.OPERATOR');
    }
    $t->assign(array(
        'KOMUS_REPORTS_TITLE' => $L['komus_reports_title']
    ));
    $t->parse('MAIN.HOME');
}


?>
