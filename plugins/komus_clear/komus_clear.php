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

switch ($mode) {
case 'load':
	    $id_begin = cot_import('id_begin', 'P', 'INT');
	    $id_end = cot_import('id_end', 'P', 'INT');
	    
		if (!empty($id_begin) && !empty($id_end)) {
			$sql = "DELETE contacts.* FROM {$db_x}komus_contacts AS contacts LEFT JOIN {$db_x}komus_calls AS calls ON contacts.id=calls.contact_id 
					WHERE contacts.id >= {$id_begin} AND contacts.id <= {$id_end} AND calls.contact_id IS NULL";
			
			$result = $db -> query($sql);			
            $url = 'e=komus_clear&mode=loadok';
		} else {
			$url = 'e=komus_clear&mode=loaderror';
		}
		
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
	$_SESSION['count_dell'] = '';
    if ($gr_operator_access) {
        $t->assign(array(
            'KOMUS_LOAD_URL'   => cot_url('plug', 'e=komus_clear&mode=load')            
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
        'KOMUS_LOAD_TITLE' => $L['komus_clear_title']        
    ));
$t->parse('MAIN.HOME');
?>
