<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_load
 * @version 1.0.0
 * @author Sergey Lobanov
 * @copyright (c) Komus
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_langfile('komus_load');

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

///Массив полей
$FieldArray = array(
/*'kod'   => 'VARCHAR(255)',
'interes'   => 'VARCHAR(255)',
'name'      => 'VARCHAR(255)',
'email'     => 'VARCHAR(255)',
'inn'       => 'VARCHAR(255)',
'fio'       => 'VARCHAR(255)',
'city'      => 'VARCHAR(255)',
'street'    => 'VARCHAR(255)',
'dom'       => 'VARCHAR(255)',
'phone1'    => 'VARCHAR(255)',
'phone2'    => 'VARCHAR(255)',
'phone3'    => 'VARCHAR(255)',
'phone4'    => 'VARCHAR(255)',
'phone5'    => 'VARCHAR(255)',
'email1'    => 'VARCHAR(255)',
'segment'   => 'VARCHAR(255)',
'segment1'  => 'VARCHAR(255)',
'glavkod'   => 'VARCHAR(255)'*/
                   );
////////////////////////////////

switch ($mode) {
case 'load':
	foreach ($FieldArray as $field => $type) {		
        $sql_contacts     = "ALTER TABLE cot_komus_contacts ADD {$field} {$type}";  
        $sql_add_contacts = $db->query($sql_contacts);
	} 
         
    $url = 'e=komus_data&mode=loadok';
		
	header('Location: ' . cot_url('plug', $url, '', 'true'));
	exit;
break;

case 'loaderror':
		  $t->parse('MAIN.LOADERROR'); 
		break;
	
case 'loadok': 		      
        $t->parse('MAIN.LOADOK');  
break;


default:   
    if ($gr_operator_access) {
        $t->assign(array(
            'KOMUS_LOAD_URL'   => cot_url('plug', 'e=komus_data&mode=load')            
        ));
        $t->parse('MAIN.HOME.GRAND_OPERATOR');
    }

    if ($operator_access) {
        $t->assign(array(
        ));
        $t->parse('MAIN.HOME.OPERATOR');
    }    
}

$t->assign(array(
        'KOMUS_DATA_TITLE' => $L['komus_data_title']        
    ));
$t->parse('MAIN.HOME');
?>
