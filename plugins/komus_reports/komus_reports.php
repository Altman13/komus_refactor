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
set_time_limit(1800);
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
                ' AND d.user_id = ' . $usr['id'] : '';

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
                    $sql_report_string = "SELECT contact.*, DATE_FORMAT(contact.creation_time, '%d.%m.%Y') begin_date, 
                                            u.user_lastname, u.user_firstname,
                                            DATE_FORMAT(contact.creation_time, '%H:%i') begin_time,
                                            DATE_FORMAT(contact.date_meat, '%d.%m.%Y %H:%i') date_meat                                              
                                        FROM {$db_x}komus_contacts AS contact                
                                        LEFT JOIN {$db_x}users AS u ON u.user_id = contact.user_id                               
                                        ORDER BY contact.id";
                    $sql_report = $db->query($sql_report_string);
                    $xls_filename = 'report_' . $rep_name . '.xls';
                    $xls = new Spreadsheet_Excel_Writer('reports/' . $xls_filename);
                    $xls->setVersion(8);
                    $sheet = &$xls->addWorksheet(iconv('utf-8', 'windows-1251', 'Base'));
                    $sheet->setInputEncoding('windows-1251');
                    $xls->setCustomColor(10, 153, 204, 0);
                    $formatHeader = &$xls->addFormat();
                    $formatHeader->setBorder(1);
                    $formatHeader->setHAlign('center');
                    $formatHeader->setVAlign('vcenter');
                    $formatHeader->setBold();
                    $formatHeader->setTextWrap();
                    $formatHeader->setFgColor(10);
                    $formatCell = &$xls->addFormat();
                    $formatCell->setHAlign('center');
                    $formatCell->setVAlign('top');
                    $formatCell->setBorder(1);
                    $formatCell->setTextWrap();
                    $sheet->setColumn(0, 40, 20);
                    $sheet->write(0, 0, iconv('utf-8', 'windows-1251', 'Клиент ФИО'), $formatHeader);
                    $sheet->write(0, 1, iconv('utf-8', 'windows-1251', 'Полис Номер'), $formatHeader);
                    $sheet->write(0, 2, iconv('utf-8', 'windows-1251', 'Продукт Номер'), $formatHeader);
                    $sheet->write(0, 3, iconv('utf-8', 'windows-1251', 'Продукт Наименование'), $formatHeader);
                    $sheet->write(0, 4, iconv('utf-8', 'windows-1251', 'Валюта'), $formatHeader);
                    $sheet->write(0, 5, iconv('utf-8', 'windows-1251', 'Договор Дата Заключения'), $formatHeader);
                    $sheet->write(0, 6, iconv('utf-8', 'windows-1251', 'Покрытие Дата Окончания'), $formatHeader);
                    $sheet->write(0, 7, iconv('utf-8', 'windows-1251', 'Срок действия программы'), $formatHeader);
                    $sheet->write(0, 8, iconv('utf-8', 'windows-1251', 'Покрытие Премия'), $formatHeader);
                    $sheet->write(0, 9, iconv('utf-8', 'windows-1251', 'Сумма выплат по дожитиям '), $formatHeader);
                    $sheet->write(0, 10, iconv('utf-8', 'windows-1251', 'Доходность текущая'), $formatHeader);
                    $sheet->write(0, 11, iconv('utf-8', 'windows-1251', 'Доходность в год %'), $formatHeader);
                    $sheet->write(0, 12, iconv('utf-8', 'windows-1251', 'Банк'), $formatHeader);
                    $sheet->write(0, 13, iconv('utf-8', 'windows-1251', 'Сегмент'), $formatHeader);
                    $sheet->write(0, 14, iconv('utf-8', 'windows-1251', 'Стратегия'), $formatHeader);
                    $sheet->write(0, 15, iconv('utf-8', 'windows-1251', 'Маркетинговое наименование'), $formatHeader);
                    $sheet->write(0, 16, iconv('utf-8', 'windows-1251', 'Регион выдачи полиса'), $formatHeader);
                    $sheet->write(0, 17, iconv('utf-8', 'windows-1251', 'Город выдачи полиса'), $formatHeader);
                    $sheet->write(0, 18, iconv('utf-8', 'windows-1251', 'Клиент Дата Рождения'), $formatHeader);
                    $sheet->write(0, 19, iconv('utf-8', 'windows-1251', 'Клиент Адрес Регистрации'), $formatHeader);
                    $sheet->write(0, 20, iconv('utf-8', 'windows-1251', 'Клиент Телефон Домашний'), $formatHeader);
                    $sheet->write(0, 21, iconv('utf-8', 'windows-1251', 'Клиент Телефон Мобильный'), $formatHeader);
                    $sheet->write(0, 22, iconv('utf-8', 'windows-1251', 'Клиент Email'), $formatHeader);
                    $sheet->write(0, 23, iconv('utf-8', 'windows-1251', 'Офис Выдачи Наименование'), $formatHeader);
                    $sheet->write(0, 24, iconv('utf-8', 'windows-1251', 'Результат звонка'), $formatHeader);
                    $sheet->write(0, 25, iconv('utf-8', 'windows-1251', 'Результат звонка'), $formatHeader);
                    $sheet->write(0, 26, iconv('utf-8', 'windows-1251', 'Результат звонка'), $formatHeader);
                    $sheet->write(0, 27, iconv('utf-8', 'windows-1251', 'Результат звонка'), $formatHeader);
                    $sheet->write(0, 28, iconv('utf-8', 'windows-1251', 'дата и время встречи (при согласии на встречу)'), $formatHeader);
                    $sheet->write(0, 29, iconv('utf-8', 'windows-1251', 'Техника 1'), $formatHeader);
                    $sheet->write(0, 30, iconv('utf-8', 'windows-1251', 'Техника 2'), $formatHeader);
                    $sheet->write(0, 31, iconv('utf-8', 'windows-1251', 'Техника 3'), $formatHeader);
                    $sheet->write(0, 32, iconv('utf-8', 'windows-1251', 'Комментарий '), $formatHeader);
                    $sheet->write(0, 33, iconv('utf-8', 'windows-1251', 'Дата звонка'), $formatHeader);
                    $sheet->write(0, 34, iconv('utf-8', 'windows-1251', 'Время звонка'), $formatHeader);
                    $sheet->write(0, 35, iconv('utf-8', 'windows-1251', 'Оператор'), $formatHeader);
                    $sheet->write(0, 36, iconv('utf-8', 'windows-1251', 'ID контакта'), $formatHeader);

                    $count = 1;
                    foreach ($sql_report as $key => $row) {
                        $sheet->write(1 + $key, 0, iconv('utf-8', 'windows-1251', clear_simbol($row['fio'])), $formatCell);
                        $sheet->write(1 + $key, 1, iconv('utf-8', 'windows-1251', clear_simbol($row['policenumber'])), $formatCell);
                        $sheet->write(1 + $key, 2, iconv('utf-8', 'windows-1251', clear_simbol($row['productnumber'])), $formatCell);
                        $sheet->write(1 + $key, 3, iconv('utf-8', 'windows-1251', clear_simbol($row['productname'])), $formatCell);
                        $sheet->write(1 + $key, 4, iconv('utf-8', 'windows-1251', clear_simbol($row['currency'])), $formatCell);
                        $sheet->write(1 + $key, 5, iconv('utf-8', 'windows-1251', clear_simbol($row['contractdate'])), $formatCell);
                        $sheet->write(1 + $key, 6, iconv('utf-8', 'windows-1251', clear_simbol($row['dateend'])), $formatCell);
                        $sheet->write(1 + $key, 7, iconv('utf-8', 'windows-1251', clear_simbol($row['period'])), $formatCell);
                        $sheet->write(1 + $key, 8, iconv('utf-8', 'windows-1251', clear_simbol($row['premium'])), $formatCell);
                        $sheet->write(1 + $key, 9, iconv('utf-8', 'windows-1251', clear_simbol($row['summ'])), $formatCell);
                        $sheet->write(1 + $key, 10, iconv('utf-8', 'windows-1251', clear_simbol($row['profit'])), $formatCell);
                        $sheet->write(1 + $key, 11, iconv('utf-8', 'windows-1251', clear_simbol($row['profityear'])), $formatCell);
                        $sheet->write(1 + $key, 12, iconv('utf-8', 'windows-1251', clear_simbol($row['bank'])), $formatCell);
                        $sheet->write(1 + $key, 13, iconv('utf-8', 'windows-1251', clear_simbol($row['segment'])), $formatCell);
                        $sheet->write(1 + $key, 14, iconv('utf-8', 'windows-1251', clear_simbol($row['strategy'])), $formatCell);
                        $sheet->write(1 + $key, 15, iconv('utf-8', 'windows-1251', clear_simbol($row['marketname'])), $formatCell);
                        $sheet->write(1 + $key, 16, iconv('utf-8', 'windows-1251', clear_simbol($row['region'])), $formatCell);
                        $sheet->write(1 + $key, 17, iconv('utf-8', 'windows-1251', clear_simbol($row['city'])), $formatCell);
                        $sheet->write(1 + $key, 18, iconv('utf-8', 'windows-1251', clear_simbol($row['birthdate'])), $formatCell);
                        $sheet->write(1 + $key, 19, iconv('utf-8', 'windows-1251', clear_simbol($row['address'])), $formatCell);
                        $sheet->write(1 + $key, 20, iconv('utf-8', 'windows-1251', clear_simbol($row['phone1'])), $formatCell);
                        $sheet->write(1 + $key, 21, iconv('utf-8', 'windows-1251', clear_simbol($row['phone2'])), $formatCell);
                        $sheet->write(1 + $key, 22, iconv('utf-8', 'windows-1251', clear_simbol($row['email'])), $formatCell);
                        $sheet->write(1 + $key, 23, iconv('utf-8', 'windows-1251', clear_simbol($row['office'])), $formatCell);
                        $sheet->write(1 + $key, 24, iconv('utf-8', 'windows-1251', getReferenceItem($row['status1'])), $formatCell);
                        $sheet->write(1 + $key, 25, iconv('utf-8', 'windows-1251', getReferenceItem($row['status2'])), $formatCell);
                        $sheet->write(1 + $key, 26, iconv('utf-8', 'windows-1251', getReferenceItem($row['status3'])), $formatCell);
                        $sheet->write(1 + $key, 27, iconv('utf-8', 'windows-1251', getReferenceItem($row['status4'])), $formatCell);
                        $sheet->write(1 + $key, 28, iconv('utf-8', 'windows-1251', clear_simbol($row['date_meat'])), $formatCell);
                        $sheet->write(1 + $key, 29, iconv('utf-8', 'windows-1251', getReferenceItem($row['tech1'])), $formatCell);
                        $sheet->write(1 + $key, 30, iconv('utf-8', 'windows-1251', getReferenceItem($row['tech2'])), $formatCell);
                        $sheet->write(1 + $key, 31, iconv('utf-8', 'windows-1251', getReferenceItem($row['tech3'])), $formatCell);
                        $sheet->write(1 + $key, 32, iconv('utf-8', 'windows-1251', $row['comment']), $formatCell);
                        $sheet->write(1 + $key, 33, iconv('utf-8', 'windows-1251', $row['begin_date']), $formatCell);  // дата звонка
                        $sheet->write(1 + $key, 34, iconv('utf-8', 'windows-1251', $row['begin_time']), $formatCell);  // время звонка
                        $sheet->write(1 + $key, 35, iconv('utf-8', 'windows-1251', $row['user_lastname'] . ' ' . $row['user_firstname']), $formatCell);
                        $sheet->write(1 + $key, 36, iconv('utf-8', 'windows-1251', $row['id']), $formatCell);
                        $count++;
                    }
                    $xls->close();
                    break;
                case 3:
                    $rep_name = 'work';
                    $data_begin_mktime = mktime(0, 0, 0, $from['month'], $from['day'], $from['year']);
                    $date_end_mktime   = mktime(0, 0, 0, $to['month'], $to['day'], $to['year']);
                    $count = 0;
                    for ($i = $data_begin_mktime; $i <= $date_end_mktime; $i += 3600 * 24, $count++) {
                        $interval[$count]['mysql'] = strftime('%Y-%m-%d', $i);
                        $interval[$count]['data'] = strftime('%d.%m.%Y', $i);
                    }

                    $xls_filename = 'report_' . $rep_name . '.xls';

                    $xls = new Spreadsheet_Excel_Writer('reports/' . $xls_filename);
                    $sheet = &$xls->addWorksheet(iconv('utf-8', 'windows-1251', 'Время работы'));

                    //$sheet->setRow(0, 18.75);

                    $formatHeader = &$xls->addFormat();
                    $formatHeader->setBorder(1);
                    $formatHeader->setHAlign('center');
                    $formatHeader->setVAlign('vcenter');
                    $formatHeader->setBold();
                    $formatHeader->setTextWrap();
                    $formatHeader->setFgColor(22);

                    $formatDay = &$xls->addFormat();
                    $formatDay->setBorder(1);
                    $formatDay->setVAlign('vcenter');
                    $formatDay->setBold();
                    $formatDay->setTextWrap();
                    $formatDay->setFgColor(26);

                    $formatCell = &$xls->addFormat();
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
                        $sql_report_string = "SELECT id, UNIX_TIMESTAMP(MIN(begin_time)) AS mintime, 
                                                        UNIX_TIMESTAMP(MAX(begin_time)) AS maxtime, 
                                                users.user_lastname, users.user_firstname                                              
                                                FROM {$db_x}komus_calls AS calls
                                                LEFT JOIN {$db_x}users AS users ON calls.user_id = users.user_id
                                                WHERE calls.user_id > 0 
                                                AND calls.begin_time >= '{$day["mysql"]} 00:00:00' 
                                                    AND calls.begin_time <= '{$day["mysql"]} 23:59:59'
                                                GROUP BY calls.user_id
                                                ORDER BY users.user_lastname";
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
                                $worktimeminut = round(60 * $minut);
                            } else {
                                $worktimeminut = '00';
                            }
                            $time = $worktimehours . ':' . $worktimeminut;
                            $sheet->write($row_num, 0, iconv('utf-8', 'windows-1251', $row['user_lastname'] . ' ' . $row['user_firstname']), $formatCell);
                            $sheet->write($row_num, 1, iconv('utf-8', 'windows-1251', round($worktime / 3600, 2)), $formatCell);
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
                'KOMUS_REPORTS_BASE1_URL'               => cot_url('plug', 'e=komus_reports&mode=report&rep=2'),
                'KOMUS_REPORTS_BASE2_URL'               => cot_url('plug', 'e=komus_reports&mode=report&rep=4'),
                'KOMUS_REPORTS_OPERATOR_URL'            => cot_url('plug', 'e=komus_reports&mode=report&rep=3')
            ));
            $t->parse('MAIN.HOME.GRAND_OPERATOR');
        }
        if ($operator_access) {
            $t->assign(array());
            $t->parse('MAIN.HOME.OPERATOR');
        }
        $t->assign(array(
            'KOMUS_REPORTS_TITLE' => $L['komus_reports_title']
        ));
        $t->parse('MAIN.HOME');
}
