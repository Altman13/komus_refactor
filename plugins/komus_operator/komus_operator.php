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
        include_once 'Spreadsheet/Excel/reader.php';
		$target = 'datas/users/import.xls';
	
		if (move_uploaded_file( $_FILES["fileload"]["tmp_name"], $target )) {
			$data = new Spreadsheet_Excel_Reader();
            $data -> setOutputEncoding('CP1251');
            $data -> read($target);  
            $groupId = 4;
            $resultArr = array();
            unset($_SESSION["load_operator"]);
            if ( count( $data -> sheets[0]['cells'] ) > 0 ) {
            	foreach ($data -> sheets[0]['cells'] as $key => $itemrow ) {
            			                 	
            	 $user_name = trim($itemrow[5]); 
            	 $user_password = trim($itemrow[6]);            			               	 	
            	 if (!empty($user_name) && !empty($user_password)) {			           		
            	    $insert_base['user_name']      = iconv("windows-1251", "UTF-8", $user_name);
            	    $insert_base['user_password']  = iconv("windows-1251", "UTF-8", md5($user_password));
            	    $insert_base['user_maingrp']   = iconv("windows-1251", "UTF-8", $groupId);
            	    $insert_base['user_email']     = iconv("windows-1251", "UTF-8", $itemrow[5].'@c.ru');            	    
            	    $insert_base['user_firstname'] = iconv("windows-1251", "UTF-8", $itemrow[3]);
            	    $insert_base['user_lastname']  = iconv("windows-1251", "UTF-8", $itemrow[2]);
            	    
            	    $insert_base['user_theme']     = iconv("windows-1251", "UTF-8", "nemesis");
            	    $insert_base['user_scheme']    = iconv("windows-1251", "UTF-8", "default");
            	    $insert_base['user_lang']      = iconv("windows-1251", "UTF-8", "ru");
            	    $insert_base['user_regdate']   = iconv("windows-1251", "UTF-8", (int)$sys['now']);            	    
            	    $insert_base['user_lostpass']  = iconv("windows-1251", "UTF-8", md5(microtime()));
            	    
            	    //Проверка есть ли такой пользователь(по логину)
            	    $sql_oper_string = "SELECT count(*) AS count FROM {$db_x}users WHERE user_name = '{$user_name}'";
            	    $sql_user = $db->query($sql_oper_string);
            	    $count_user = $sql_user->fetchColumn();
            	    
            	    if ($count_user == 0) {
            	    	$sql_insert = $db->insert($db_x . 'users', $insert_base);
            	    	//Добавление в групы
            	        $userid = $db->lastInsertId();
                        $db->insert($db_x . 'groups_users', array('gru_userid' => (int)$userid, 'gru_groupid' => $groupId)); 
                        $resultArr[$itemrow[5]]["insert"] = true;
                        
            	    } else {
            	    	// Уже есть
            	    	$resultArr[$itemrow[5]]["insert"] = false;
            	    	$sql_oper_string = "SELECT user_password FROM {$db_x}users WHERE user_name = '{$user_name}'";
            	        $sql_user = $db->query($sql_oper_string);
            	        $pass = $sql_user->fetchColumn();            	       

            	        // Совпадает пароль
            	    	if (md5($user_password) == $pass ) {
            	    		$resultArr[$itemrow[5]]["password"] = true;
            	    	} else {
            	    		$resultArr[$itemrow[5]]["password"] = false;
            	    	}
            	    }
            	 }  
              	}
            }
            $_SESSION["load_operator"] = $resultArr;
			$url = 'e=komus_operator&mode=loadok';
		} else {
			$url = 'e=komus_operator&mode=loaderror';
		}
		
		header('Location: ' . cot_url('plug', $url, '', 'true'));
		exit;
break;

case 'loaderror':
		  $t->parse('MAIN.LOADERROR'); 
		break;
	
case 'loadok': 
	    $result = $_SESSION["load_operator"];
	    foreach ($result as $key => $item) {
	    	
	    	$t->assign(array(
                 'KOMUS_NAME_RESULT'   => $key,
                 'KOMUS_LOAD_RESULT'   => $item["insert"] ? "Загружен" : "<b>Уже есть</b>"	    		    	            
            ));
            
            if (!$item["insert"]) {
            	$t->assign(array(
            	    'KOMUS_LOAD_PASSWORD' => $item["password"] ? "Совпадает" : "<b>Не совпадает</b>"   	            
                ));
            } else {
            	$t->assign(array(
            	    'KOMUS_LOAD_PASSWORD' => ""   	            
                ));
            }
	        $t->parse('MAIN.LOADOK.RESULT');	
	    }
	    		      
        $t->parse('MAIN.LOADOK');  
break;


default:   
    if ($gr_operator_access) {
        $t->assign(array(
            'KOMUS_LOAD_URL'   => cot_url('plug', 'e=komus_operator&mode=load')            
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
        'KOMUS_OPERTOR_TITLE' => $L['komus_operator_title']        
    ));
$t->parse('MAIN.HOME');
?>
