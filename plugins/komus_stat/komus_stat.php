<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_stat
 * @version 1.0.0
 * @author Sergey Lobanov
 * @copyright (c) Komus
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_langfile('komus_stat');

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

// Статистика

$item_id = cot_import('item', 'G', 'INT');
$refArray = array();
$totalsArray = array('-2' => 0, '-1' => 0);

$t->assign(array(
	'KOMUS_STAT_QUANTITY_HEADER' => 'Вид деятельности'
));    	
$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_HEADER');
$t->assign(array(
	'KOMUS_STAT_QUANTITY_HEADER' => 'Всего записей'
));    	
$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_HEADER');
$t->assign(array(
	'KOMUS_STAT_QUANTITY_HEADER' => 'Не звонили'
));    	
$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_HEADER');

// Статусы звонка
$sql_stat_string = "
        SELECT *
        FROM {$db_x}komus_references_items
        WHERE reference_id = $item_id AND `value` = '1' ORDER BY sort
    ";
$sql_stat = $db->query($sql_stat_string);
    
foreach ($sql_stat as $key => $row) {
	$t->assign(array(
		'KOMUS_STAT_QUANTITY_HEADER' => $row['title']
	));    	
	$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_HEADER');

   	$refArray[] = $row['id'];
	$totalsArray[$row['id']] = 0;
}

$totalsArray['total'] = 0;

$t->assign(array(
	'KOMUS_STAT_QUANTITY_HEADER' => 'Всего результативных звонков'
)); 
$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_HEADER');

// Звонки по видам деятельности
$sql_filtr_items_string = "
            SELECT DISTINCT segment AS title     
            FROM {$db_x}komus_contacts
            ORDER BY segment
			";
$sql_filtr_items = $db->query($sql_filtr_items_string);
$sql_filtr_data = $sql_filtr_items->fetchAll();

foreach ($sql_filtr_data as $filtrName) {
	$filtrVal = $filtrName['title'];
	$t->assign(array(
           'KOMUS_STAT_QUANTITY_STATUS' =>  $filtrName['title']
	));    	
	$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_ROW.STATISTIC');
	
	$sql_count_by_filtr_string = "
			SELECT -2 AS pt,COUNT(*) AS cnt FROM {$db_x}komus_contacts WHERE segment = '{$filtrVal}'
			UNION
			SELECT -1 AS pt,COUNT(*) AS cnt FROM {$db_x}komus_contacts WHERE segment = '{$filtrVal}' AND creation_time IS NULL
			ORDER BY pt";
	
	$sql_count_by_filtr = $db->query($sql_count_by_filtr_string);
	foreach ($sql_count_by_filtr->fetchAll() as $filtr_count) {
		$t->assign(array(
           'KOMUS_STAT_QUANTITY_STATUS' =>  $filtr_count['cnt']
		));    	
		$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_ROW.STATISTIC');
		
		$totalsArray[$filtr_count['pt']] += $filtr_count['cnt'];
	}
	
	$rowSumm = 0;
	foreach ($refArray as $refStat) {
		$sql_count_string = "
			SELECT COUNT(*) AS cnt FROM {$db_x}komus_contacts WHERE segment = '{$filtrVal}' AND is_finish = 1 AND status = {$refStat}";
		$sql_count = $db->query($sql_count_string);
		$count_data = $sql_count->fetchColumn();
		$rowSumm += $count_data;
		
		$t->assign(array(
           'KOMUS_STAT_QUANTITY_STATUS' =>  $count_data
		));    	
		$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_ROW.STATISTIC');
		
		$totalsArray[$refStat] += $count_data;
	}
	
	$totalsArray['total'] += $rowSumm;
	
	$t->assign(array(
          'KOMUS_STAT_QUANTITY_STATUS' =>  $rowSumm
	));    	
	$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_ROW.STATISTIC');	
	
	
	$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_ROW');
}
    
foreach ($totalsArray as $total) {
	$t->assign(array(
          'KOMUS_STAT_TOTAL_STATUS' =>  $total
	));    	
	$t->parse('MAIN.HOME.GRAND_OPERATOR.STAT_FOOTER');
}
	
$t->assign(array(                
           'KOMUS_STAT_SHOW'       =>  true    
));
//////////////////////
 
if ($gr_operator_access) {
    $t->assign(array(
        'KOMUS_STAT_URL'   => cot_url('plug', 'e=komus_stat')            
    ));
    $t->parse('MAIN.HOME.GRAND_OPERATOR');
}

if ($operator_access) {
    $t->assign(array(
    ));
    $t->parse('MAIN.HOME.OPERATOR');
}    


$t->assign(array(
        'KOMUS_STAT_TITLE' => $L['komus_stat_title']        
    ));
$t->parse('MAIN.HOME');
?>
