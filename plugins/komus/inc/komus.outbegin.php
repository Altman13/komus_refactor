<?php
 // ID записи перезвонов и недозвонов
 $base_id = cot_import('id', 'G', 'INT');
 $time_now =  date('H:i:s', $sys['now_offset'] + $cfg['defaulttimezone'] * 3600);
 //Выборка записи для обзвона
    //выбираем свободные записи is_block = 1
    //Фильтр
	if ($_SESSION['filtr']) {    	
		$filtrSql = " AND city = '" . $_SESSION['filtr'] . "'"; 
    } else {    	
		$filtrSql = ""; 
    }
    if ($_SESSION['filtr1']) {    	
		$filtrSql1 = " AND segment = '" . $_SESSION['filtr1'] . "'"; 
    } else {    	
		$filtrSql1 = ""; 
    }
    if ($_SESSION['filtr2']) {    	
		$filtrSql2 = " AND activity = '" . $_SESSION['filtr2'] . "'"; 
    } else {    	
		$filtrSql2 = ""; 
    }
	//Выбираем перезвоны по времени
    if ($base_id == null) {
            $sql_base_string = "SELECT * FROM {$db_x}komus_contacts            
                WHERE is_block = 1 AND status = 0{$filtrSql}{$filtrSql1}{$filtrSql2} LIMIT 1";            
        $sql_base  = $db->query($sql_base_string);
        $base_data = $sql_base->fetch();   
    } else {
    	//Перезвоны
    	$sql_base_string = "SELECT * FROM {$db_x}komus_contacts WHERE id = {$base_id}";
      $sql_base = $db->query($sql_base_string);
      $base_data = $sql_base->fetch();
    }
    //Запись использована
    if ($base_data['id'] != NULL) {    	
        $update_data['is_block'] = 0;
        $update_data['status'] = 0;
        $sql_data_update = $db->update($db_x . 'komus_contacts', $update_data, 'id = ' . $base_data['id']);
    }   
    $contact_id = $base_data['id'];
?>