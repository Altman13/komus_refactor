<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_user
 * @version 1.0.0
 * @author Sergey Lobanov
 * @copyright (c) Komus
 * @license BSD
 */
set_time_limit(1800);
defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_langfile('komus_load');
require_once cot_incfile('forms');

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

if ($gr_operator_access) {
  // Статистика
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $calls_flag = cot_import('callsfiltr', 'P', 'TXT');
        if ($calls_flag) {
            $_SESSION['statistic_data'] = cot_import('statistic', 'P', 'TXT');
            ;
            $_SESSION['statistic_data_to'] = cot_import('statistic_to', 'P', 'TXT');
        }
    }

  //Фильтр по дате
    if (!empty($_SESSION['statistic_data']) && !empty($_SESSION['statistic_data_to'])) {
        $tmp_date = explode('.', $_SESSION['statistic_data']);
        $tmp_date_to = explode('.', $_SESSION['statistic_data_to']);
        $from = $tmp_date[2] . "-" . $tmp_date[1] . "-" . $tmp_date[0];
        $to = $tmp_date_to[2] . "-" . $tmp_date_to[1] . "-" . $tmp_date_to[0];
        if (!empty($tmp_date[0]) && !empty($tmp_date[1]) && !empty($tmp_date[2]) && !empty($tmp_date_to[0]) && !empty($tmp_date_to[1]) && !empty($tmp_date_to[2])) {
            $calls_data_filtr = " AND begin_time >= '" . $from . "  00:00:00' AND begin_time <= '" . $to . "  23:59:59'";
            $calls_data_filtr_contacts = " AND creation_time >= '" . $from . "  00:00:00' AND creation_time <= '" . $to . "  23:59:59'";
        } else {
            $calls_data_filtr = '';
            $calls_data_filtr_contacts = '';
        }
    }

    $t->assign(array(
    'KOMUS_CALLS_FILTR'             => $_SESSION['statistic_data'],
    'KOMUS_CALLS_FILTR_TO'          => $_SESSION['statistic_data_to'],
    'KOMUS_OPERATOR_RETURN'         => cot_url('plug', 'e=komus_user')
    ));

  // Статусы звонка
    $sql_ref_string = "
            SELECT *
            FROM {$db_x}komus_references_items
            WHERE reference_id = 1
            ORDER BY sort
    ";
    $sql_ref = $db->query($sql_ref_string);

  // Операторы работавшие за период
    $sql_operator_string = "SELECT calls.*, u.user_lastname, u.user_firstname                                            
                FROM {$db_x}komus_calls AS calls  
                LEFT JOIN {$db_x}users AS u ON u.user_id = calls.user_id                                               
                WHERE calls.user_id > 0 {$calls_data_filtr}
                GROUP BY calls.user_id";
    $sql_operator = $db->query($sql_operator_string);

  // Шапка
    foreach ($sql_ref as $reference) {
        $t->assign(array(
        'KOMUS_STAT_TITLE'     => $reference["title"]
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.HEADER');
    }

    $statistic = array();
    $total = 0;
    $totalStatus = array();

    foreach ($sql_operator as $operator) {
        $sql_ref = $db->query($sql_ref_string);
        foreach ($sql_ref as $reference) {
            $sql_report_string = "SELECT count(*) AS count                                            
                FROM {$db_x}komus_calls AS calls                                                
                WHERE calls.status = {$reference["id"]} {$calls_data_filtr}  
                      AND user_id = {$operator["user_id"]}";

            $sql_report = $db->query($sql_report_string);
            $count = $sql_report->fetchColumn();

            $total += $count;
            $totalStatus[$reference["id"]] += $count;

            $t->assign(array(
            'KOMUS_USER_STATISTIC'           => $count,
            ));
            $t->parse('MAIN.HOME.GRAND_OPERATOR.ROW_OPERATOR.STATISTIC');
        }

        $t->assign(array(
        'KOMUS_USER_NAME'           => $operator['user_firstname'] . ' ' . $operator['user_lastname'],
        'KOMUS_USER_TOTAL_USER'     => $total
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.ROW_OPERATOR');
        $total = 0;
    }

  // обший итог по статусам
    $totalAll = 0;
    foreach ($totalStatus as $item) {
        $totalAll += $item;
        $t->assign(array(
        'KOMUS_USER_TOTAL_STATUS'           => $item

        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.FOOTER');
    }

    $t->assign(array(
    'KOMUS_USER_TOTAL_ALL'           => $totalAll

    ));

  //  $t->parse('MAIN.HOME.GRAND_OPERATOR');



  // Статистика
  // Статусы звонка по базе
    $sql_ref_string = "
            SELECT *
            FROM {$db_x}komus_references_items
            WHERE reference_id = 1
            ORDER BY sort
    ";
    $sql_ref = $db->query($sql_ref_string);

  // Операторы работавшие за период
    $sql_operator_string = " SELECT contacts.*, u.user_lastname, u.user_firstname                                            
                FROM {$db_x}komus_contacts AS contacts  
                LEFT JOIN {$db_x}users AS u ON u.user_id = contacts.user_id                                               
                WHERE contacts.user_id > 0 {$calls_data_filtr_contacts}
                GROUP BY contacts.user_id";
    $sql_operator = $db->query($sql_operator_string);

  // Шапка
    foreach ($sql_ref as $reference) {
        $t->assign(array(
        'KOMUS_STAT_TITLE_CONTACTS'     => $reference["title"]
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.HEADER_CONTACTS');
    }

    $statistic = array();
    $total = 0;
    $totalStatus = array();

    foreach ($sql_operator as $operator) {
        $sql_ref = $db->query($sql_ref_string);
        foreach ($sql_ref as $reference) {
            $sql_report_string = "SELECT count(*) AS count                                            
                FROM {$db_x}komus_contacts AS contacts                                                
                WHERE contacts.status = {$reference["id"]} {$calls_data_filtr_contacts}  
                      AND user_id = {$operator["user_id"]}";

            $sql_report = $db->query($sql_report_string);
            $count = $sql_report->fetchColumn();

            $total += $count;
            $totalStatus[$reference["id"]] += $count;

            $t->assign(array(
            'KOMUS_USER_STATISTIC_CONTACTS'           => $count,
            ));
            $t->parse('MAIN.HOME.GRAND_OPERATOR.ROW_OPERATOR_CONTACTS.STATISTIC_CONTACTS');
        }

        $t->assign(array(
        'KOMUS_USER_NAME_CONTACTS'           => $operator['user_firstname'] . ' ' . $operator['user_lastname'],
        'KOMUS_USER_TOTAL_USER_CONTACTS'     => $total
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.ROW_OPERATOR_CONTACTS');
        $total = 0;
    }

  // обший итог по статусам
    $totalAll = 0;
    foreach ($totalStatus as $item) {
        $totalAll += $item;
        $t->assign(array(
        'KOMUS_USER_TOTAL_STATUS_CONTACTS'           => $item

        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR.FOOTER_CONTACTS');
    }

    $t->assign(array(
    'KOMUS_USER_TOTAL_ALL_CONTACTS'           => $totalAll

    ));

  //  $t->parse('MAIN.HOME.GRAND_OPERATOR');


  // Не обзвонненые записи
    $sql_count_string = "
        SELECT COUNT(*) AS count FROM cot_komus_contacts
        WHERE status = 0 AND is_block = 1        
    ";

    $sql_count = $db->query($sql_count_string);
    $count_free      = $sql_count->fetchColumn();

    $t->assign(array(
    'KOMUS_FREE_CALLS' =>  $count_free
    ));


    $t->parse('MAIN.HOME.GRAND_OPERATOR');
}

if ($operator_access) {
    $t->assign(array());
    $t->parse('MAIN.HOME.OPERATOR');
}

$t->parse('MAIN.HOME');
