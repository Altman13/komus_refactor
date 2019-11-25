<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_search
 * @version 1.0.0
 * @author Sergey Lobanov
 * @copyright (c) Komus
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_langfile('komus_search');

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
case 'search':
		$where = '';
		$zapros = '';
		$id_base = cot_import('id_base', 'P', 'TXT');
		$id_base = abs($id_base);
		
		$id         = cot_import('id', 'G', 'INT');

		$redirect = false;
		
        if (!empty($id_base)) {
			(!empty($where)) ?  "" : $where = " WHERE (id = ".$id_base;
			$zapros .= "№ id: ".$id_base." ";
			$where .= " ) ";
		} else {
			$now = time();			
			$time = getdate($now);
			$str_time = $time['year'].'-'.$time['mon'].'-'.$time['mday'].' 00:00:00';
			$where = " WHERE is_block = 0 AND (status = 0 OR status = 1) AND creation_time < '".$str_time."'";
			$redirect = true;
			$zapros .= "Список";
		}

		//empty($id_base) ? $where = " WHERE id = -1" : ""; 
				
		$sql_search_string = "
                SELECT contacts.*, DATE_FORMAT(contacts.creation_time, '%d.%m.%Y') begin_dates, DATE_FORMAT(contacts.creation_time, '%H:%i') begin_times
                FROM {$db_x}komus_contacts AS contacts
                {$where}        
                ORDER BY contacts.creation_time                        
        ";
		$sql_search = $db->query($sql_search_string);
		
		$sql_search_count_string = "
                                SELECT count(*) AS count 
                                FROM {$db_x}komus_contacts
                                {$where}                                
                            ";
        $sql_search_count = $db->query($sql_search_count_string);                                	
        $count_search = $sql_search_count->fetchColumn();
        
        if ($count_search  > 0) {
           foreach ($sql_search->fetchAll() as $item) {    
           	  if ($item['is_block'] == 1 && $item['status'] == 0) {
           	  	$is_block = "В обзвоне";
           	  } elseif ($item['is_block'] == 0 && ($item['status'] == 0 || $item['status'] == 1)) {
           	  	$is_block = "Висит";
           	  } else { 
           	    $is_block = "Отработана";
           	  }       	  
              $t->assign(array(               
                 'KOMUS_SEARCH_ID_ROW'              => $item['id'],
                 'KOMUS_SEARCH_STATUS_ROW'          => getReferenceItem($item['status']),
                 'KOMUS_SEARCH_STATUS_INT_ROW'      => $item['status_text'],                
                 'KOMUS_SEARCH_DATE_ROW'            => $item['begin_dates'],
                 'KOMUS_SEARCH_TIME_ROW'            => $item['begin_times'],
                 'KOMUS_SEARCH_IS_BLOCK_ROW'        => $is_block            
               ));
               
               if ($gr_operator_access) {
                if ($redirect) {
               	 	$url = 'e=komus_search&mode=edit&id='.$item['id'].'&red=1'; 
               	 	$url_change = 'e=komus_search&mode=change&id='.$item['id'].'&red=1';              	 	
               	 } else {
               	 	$url = 'e=komus_search&mode=edit&id='.$item['id'];
               	 	$url_change = 'e=komus_search&mode=change&id='.$item['id'];
               	 }
               	 
               	 $t->assign(array(
               	      'KOMUS_SEARCH_URL_EDIT' => cot_url('plug', $url),
               	      'KOMUS_SEARCH_URL_CHANGE' => cot_url('plug', $url_change)               	        
               	 ));              	
               }               
                 $t->parse('MAIN.SEARCH_RESULT.ROW_SEARCH');
           }       
        }        
        
		$t->assign(array(
           'KOMUS_SEARCH_ZAPROS'       => $zapros,
		   'KOMUS_SEARCH_URL_RETURN'   => cot_url('plug', 'e=komus_search')              
         ));
         
      	$t->parse('MAIN.SEARCH_RESULT');
	    	
	break;
	
    case 'edit':
    	if ($gr_operator_access) {
    		$id         = cot_import('id', 'G', 'INT');	
    		$redirect   = cot_import('red', 'G', 'INT');
    		
		    $update_contact['is_block'] = 1;		    
		    //$update_contact['status'] = 0;
		   // $update_contact['status_int'] = 0;
		   // $update_contact['kolvo_call'] = 0;
		    $sql_status_update = $db->update($db_x . 'komus_contacts', $update_contact, 'id = ' . $id);
    	}
    	if ($redirect) {
    		header('Location: ' . cot_url('plug', 'e=komus_search&mode=search', '', 'true'));
    	} else {
    		header('Location: ' . cot_url('plug', 'e=komus_search&mode=ok', '', 'true'));    		
    	}
    	
		exit;
    break;
    
    case 'ok':
    	$t->assign(array(
           'KOMUS_SEARCH_URL_RETURN'   => cot_url('plug', 'e=komus_search')              
         ));
    	$t->parse('MAIN.SEARCH_OK');
    break;	
    
    case 'change':
     	$id         = cot_import('id', 'G', 'INT');	
    	$where =" WHERE id = ".$id;
    	
    	$sql_search_string = "
                SELECT contacts.*, DATE_FORMAT(contacts.creation_time, '%d.%m.%Y') begin_dates, DATE_FORMAT(contacts.creation_time, '%H:%i') begin_times
                FROM {$db_x}komus_contacts AS contacts
                {$where}        
                ORDER BY contacts.creation_time                        
        ";
		$sql_search = $db->query($sql_search_string);
     	
     	$sql_search_count_string = "
                                SELECT count(*) AS count 
                                FROM {$db_x}komus_contacts
                                {$where}                                
                            ";
        $sql_search_count = $db->query($sql_search_count_string);                                	
        $count_search = $sql_search_count->fetchColumn();
        
         if ($count_search  > 0) {
           foreach ($sql_search->fetchAll() as $item) { 
           	  $status         = getSelect($item['status'], 1);
           	  $t->assign(array(               
                 'KOMUS_SEARCH_ID_ROW'          => $item['id'],                 
           	     'KOMUS_SEARCH_STATUS_ROW'      => $status,                             
				 'KOMUS_SEARCH_COMMENT_ROW'     => $item['comment']
               ));                             
           }
         }
           
    	$t->assign(array(
           'KOMUS_SEARCH_URL_RETURN'   => cot_url('plug', 'e=komus_search'),
    	   'KOMUS_SAVE_URL'            => cot_url('plug', 'e=komus_search&mode=save')
         ));
    	$t->parse('MAIN.CHANGE');
    break;	
    
    case 'save':
        if ($gr_operator_access) {
    		$id         = cot_import('id', 'P', 'INT');	    				       		   
		    $update_contact['status']     = cot_import('status', 'P', 'INT');
			$update_contact['comment']    = cot_import('comment', 'P', 'TXT');
		    
		    $sql_status_update = $db->update($db_x . 'komus_contacts', $update_contact, 'id = ' . $id);
		    header('Location: ' . cot_url('plug', 'e=komus_search&mode=change&id='.$id, '', 'true'));
		    exit;
    	}
    break;	
    			    			
default:   
    if ($gr_operator_access) {
        $t->assign(array(
            'KOMUS_SEARCH_URL'        => cot_url('plug', 'e=komus_search&mode=search')              
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
        'KOMUS_SEARCH_TITLE' => $L['komus_search_title']
    ));
$t->parse('MAIN.HOME');
?>
