<?php
function Calls3(){
global $db, $db_x, $t;	

//Фильтры
if ($_SERVER["REQUEST_METHOD"] == "POST") {		
	//$calls_data = cot_import('calls', 'P', 'ARR');	
    //$_SESSION['calls_data'] = $calls_data['year'] . '-' . $calls_data['month'] . '-' . $calls_data['day'];          
    
	$_SESSION['operator_select'] = cot_import('operator_select', 'P', 'TXT');
    $_SESSION['filtr_status'] = cot_import('filtr_status', 'P', 'TXT');
}

//Фильтр по дате звонка
/*if (!empty($_SESSION['calls_data']) && $_SESSION['calls_data'] != '--') {
	$calls_data_filtr = " AND creation_time >= '".$_SESSION['calls_data']."  00:00:00' AND creation_time <= '".$_SESSION['calls_data']."  23:59:59'";
	$tmp_date = explode('-', $_SESSION['calls_data']);
	$calls_data_ts = mktime(0,0,0,$tmp_date[1],$tmp_date[2],$tmp_date[0]);
} else {
	$calls_data_filtr = '';
	$calls_data_ts = 0;
}*/

//Фильтр по оператору
if ($_SESSION['operator_select']) {
	    	$operator_select = " AND contacts.user_id = " . $_SESSION['operator_select'];
	    }

		
// статусы		
if ($_SESSION['filtr_status']) {
	    if ($_SESSION['filtr_status'] == "1") {
	    	$filtr_status = " status1 in (111, 112, 113, 114, 115, 116) AND count_calls = 1 ";
	    } elseif ($_SESSION['filtr_status'] == "2"){
	    	$filtr_status = " status1 in (111, 112, 113, 114, 115, 116) AND count_calls = 2 ";
	    } elseif ($_SESSION['filtr_status'] == "4"){
	    	$filtr_status = " status2 = 120 ";
		} elseif ($_SESSION['filtr_status'] == "5"){
	    	$filtr_status = " status3 = 124 ";
	    } elseif ($_SESSION['filtr_status'] == "6"){
	    	$filtr_status = " status4 = 126 ";
		} else {
	    	$filtr_status = " status = " . $_SESSION['filtr_status'];
	    }	
}
//Операторы для фильтра
$sql_operators_string = "
			SELECT DISTINCT contacts.user_id, CONCAT(u.user_lastname, ' ', u.user_firstname) AS fio
            FROM {$db_x}komus_contacts AS contacts
            LEFT JOIN {$db_x}users AS u ON u.user_id = contacts.user_id            
            WHERE contacts.user_id>0
            ORDER BY fio
		";
$sql_operators = $db->query($sql_operators_string);

$operator_fio = "<select name=\"operator_select\">\n";
$operator_fio .= "<option value=\"0\"> </option>\n";

foreach ($sql_operators->fetchAll() as $oper) {
    $selected = ($_SESSION['operator_select'] == $oper['user_id']) ?
                     ' selected="true"' :
                    '';
    $operator_fio .= <<<HTML
    <option value="{$oper['user_id']}"{$selected}>{$oper['fio']}</option>\n
HTML;


}

$operator_fio .= "</select>\n"; 
   
/////////////////////////////

//Фильтр по статусу звонка
$statusArr = array();
$statusArr[1] = "Недозвон1";
$statusArr[2] = "Недозвон2";
$statusArr[4] = "Перезвон не  Клиент";
$statusArr[5] = "Перезвон Клиент( не удобно говорить)";
$statusArr[6] = "Думает";
//$statusArr[74] = "Секретарь";

$field_status = "<select name=\"filtr_status\">\n";
$field_status .= "<option value=\"0\"> </option>\n";
foreach ($statusArr as $key => $st){
    $selected = ($_SESSION['filtr_status'] == $key) ?
                     ' selected="true"' :
                    '';
                                $field_status .= <<<HTML
    <option value="{$key}"{$selected}>{$st}</option>\n
HTML;
                        
}
$field_status .= "</select>\n"; 
   
/////////////////////////////
	
    $t->assign(array(      
        'KOMUS_OPERATOR_FILTR'          => $operator_fio,
        'KOMUS_SPLASH_STATUS'           => $field_status       
    ));
   
   //Записи для перезвона
if (!empty($filtr_status) ) {  	
    $sql_base_string = "
            SELECT contacts.*, DATE_FORMAT(creation_time, '%d.%m.%Y %H:%i') data_call1, DATE_FORMAT(data_recall, '%d.%m.%Y %H:%i') data_recall1,
                    UNIX_TIMESTAMP(data_recall) data_recall2, u.user_lastname, u.user_firstname        
            FROM {$db_x}komus_contacts AS contacts
            LEFT JOIN {$db_x}users AS u ON u.user_id = contacts.user_id            
            WHERE {$filtr_status} {$operator_select}
            ORDER BY creation_time
        ";
    $sql_base        = $db->query($sql_base_string);
  // echo $sql_base_string; die;
     foreach ($sql_base->fetchAll() as $item) {
     	$status  = getReferenceItem($item['status']);
		$phones = $item['phone2'];
		if ($item['phone1'] <> '') $phones .= ', '.$item['phone1'];
     	$t->assign(array(
     	         'KOMUS_CALLS_NAME'                 =>  $item['name'],
				 'KOMUS_CALLS_FIO'                 =>  $item['fio'],
				 'KOMUS_CALLS_BISNESS'              =>  $item['bisness'],
     	         'KOMUS_CALLS_PHONE'                =>  $phones ,
     	         'KOMUS_CALLS_CALL'                 =>  $item['data_call1'],
     	         'KOMUS_CALLS_RECALL'               =>  $item['data_recall1'],
     	         'KOMUS_CALLS_COMMENT'              =>  $item['comment'],
     	         'KOMUS_CALLS_STATUS'               =>  "Перезвонить",
     	         'KOMUS_OPERATOR_NAME'              =>  $item['user_lastname'] . ' ' . $item['user_firstname'],
				 'KOMUS_CALLS_STYLE_EXPIRED'		=>	(!is_null($item['data_recall']) && ($item['data_recall2'] < mktime()) ? "red" : "black"),				 
     	         'KOMUS_CALLS_URL'                  =>  cot_url('plug', 'e=komus&mode=new_call&project=1&id='.$item['id'])     
             ));
              
        $t->parse('MAIN.OPERATOR.CALLS3');  
     }
}

}    
?>
