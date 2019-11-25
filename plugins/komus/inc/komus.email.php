<?php
function SendMail($contact_id) {
	global $db, $db_x, $cfg;
	
	    $EOL = "\r\n";
     $boundary     = "-------".md5(uniqid(time()));
	$path       = 'datas/users/'; 
	$fileArr = array("Акция ИБП. Наличие на складе.pdf", "Акция ДГУ. Наличие на складе.pdf");		
	
	// $imagesArr = array("img1.jpg","img2.jpg","img3.jpg");
	 
	$subject    = 'Предложение от компании «НОЙХАУС»';
	$subject    = '=?utf-8?B?'.base64_encode($subject).'?=';
	
	$sql_email_string = "
        SELECT contacts.*                      
        FROM {$db_x}komus_contacts contacts                               
        WHERE 
            id = {$contact_id}
            AND contacts.is_finish = 1
           
    ";
	$sql_email = $db->query($sql_email_string);

	foreach ($sql_email as $key => $row) {
	 if ($row['is_kp'] == 10) {
	 	$html = '
	 	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Title</title>
</head>

<body style = "font: 11pt Arial; line-height: 1.5; font-style: italic;">
 Добрый день!<br><br>


В продолжение нашего разговора по телефону, направляю Вам информацию о компании<br>

&nbsp;&nbsp;&nbsp;&nbsp;1. В виде каталогов ИБП и ДГУ. 2 файла в приложении<br>

&nbsp;&nbsp;&nbsp;&nbsp;2. Ссылка на наш сайт: <a href="http://neuhaus.ru/"> http://neuhaus.ru/ </a><br>
 <br>

&nbsp;&nbsp;&nbsp;&nbsp;В приложении находятся складские остатки по оборудованию ДГУ и ИБП. Стоимость можно уточнить у менеджеров отдела продаж.<br> 
<br>
На текущий момент Группа компаний Нойхаус является инжиниринговой компанией, которая предлагает своим Заказчикам решения по реализации инженерных проектов в области энергетики любой сложности. В состав этих решений входят проектные, монтажные и сервисные работы, а также поставка ДГУ, ИБП и ГПУ.
<br>
 <br>

Хорошего дня!
   </body>
</html>
	 	';
		 $to = $row['email_lpr'];
		
		 $headers = "Mime-Version: 1.0$EOL"; 
	 	$headers = "From: info@neuhaus.ru$EOL";
      //  $headers .= "To: $to$EOL";
      //  $headers .= "Bcc: dmitriy@stakhanovets.ru,konstantin.shishlov@stakhanovets.ru$EOL";
        $headers .= "X-Mailer: PHPMail Tool$EOL";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
             
        $multipart = $EOL;
        $multipart .= "--$boundary\n";      
        $multipart .= "Content-Type: text/html; charset=\"utf-8\"\n";
        $multipart .= "Content-Transfer-Encoding: 8bit";
        $multipart .= "\n\n"; // раздел между заголовками и телом html-части 
        $multipart .= $html;
       
	   foreach ($fileArr as $file) {             
                $multipart .= "\n\n";
                $multipart .= "--$boundary\n";                     
				$multipart .= "Content-Type: application/octet-stream;\n name=\"" . $file . "\"\n";   
                $multipart .= "Content-Transfer-Encoding: base64\n";                   
				$multipart .= "Content-Disposition: attachment;\n filename=\"" . $file . "\"\n";                
                $multipart .= "\n\n"; 
                $multipart .= chunk_split(base64_encode( readFileForEmail($path.$file) ));  			
             }      
                   
             $multipart .= "--$boundary--";
	   
		if (mail($to, $subject, $multipart, $headers)) {
			echo '<div style=\"padding: 10px\">Письмо отправлено</div>';
		} else {
			echo '<div style=\"padding: 10px\"><strong>Ошибка при отправке анкеты по электронной почты!</strong></div>';
		} 			 		
         
	 }
  }

// Отправка лида
/*
$sql_email_string = "
                SELECT contacts.*, DATE_FORMAT(contacts.creation_time, '%d.%m.%Y') begin_dates                       
                FROM {$db_x}komus_contacts contacts                               
                WHERE 
                    id = {$contact_id}
                    AND contacts.is_finish = 1
                ";
	$sql_email = $db->query($sql_email_string);
	
	
    foreach ($sql_email as $key => $row) {        	
		if ($row['status'] == 87 || $row['status'] == 98) {    
			$subject    = getReferenceItem($row['status']);
				
				$text = '<table width="70%" border="1" cellpadding="0" cellspacing="0">';
				
				$text .= '<tr>';
				$text .= '<td>Название организации</td>';
				$text .= '<td>' . $row['name'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Разделы</td>';
				$text .= '<td>' . $row['segment'] . '</td>';
				$text .= '</tr>';
								
				$text .= '<tr>';
				$text .= '<td>Подразделы</td>';
				$text .= '<td>' . $row['segment2'] . '</td>';
				$text .= '</tr>';
								
				$text .= '<tr>';
				$text .= '<td>Рубрики</td>';
				$text .= '<td>' . $row['segment1'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Населенные пункты</td>';
				$text .= '<td>' . $row['city'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Адреса</td>';
				$text .= '<td>' . $row['street'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Сайты</td>';
				$text .= '<td>' . $row['site'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Телефоны</td>';
				$text .= '<td>' . $row['phone1'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Телефоны</td>';
				$text .= '<td>' . $row['phone2'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>ФИО ЛПР</td>';
				$text .= '<td>' . $row['fio_lpr'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Должность ЛПР</td>';
				$text .= '<td>' . $row['dolgnost_lpr'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';				
				$text .= '<td>Телефон ЛПР</td>';
				$text .= '<td>' . $row['phone_lpr'] . '</td>';
				$text .= '</tr>';				
				
				$text .= '<tr>';				
				$text .= '<td>e-mail ЛПР</td>';
				$text .= '<td>' . $row['email_lpr'] . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>КП отправить?</td>';
				$text .= '<td>' . getReferenceItem($row['is_kp']) . '</td>';
				$text .= '</tr>';
				
				$text .= '<tr>';
				$text .= '<td>Статус звонка</td>';
				$text .= '<td>' . getReferenceItem($row['status']) . '</td>';
				$text .= '</tr>';

				$text .= '<tr>';
				$text .= '<td>Комментарий оператора</td>';
				$text .= '<td>' . $row['comment'] . '</td>';
				$text .= '</tr>';
				
				$text .= '</table>';
               
                $subject    = '=?utf-8?B?'.base64_encode($subject).'?=';
        		
        		$head = "From: tver-crm@komus.net\n";
        		//$head .= "Reply-to: info@komus.net\n";
                $head .= "X-Mailer: PHPMail Tool\n";                          
                $head .= "Content-Type: text/html; charset=\"utf-8\"\n";
                $head .= "Content-Transfer-Encoding: 8bit\n";
               			 
			    $to = $cfg['plugin']['komus']['email'];
				//$to = $row['email'];
               // var_dump($to);die;
        		if (mail($to, $subject, $text, $head)) {
        		    echo '<div style=\"padding: 10px\">Письмо отправлено</div>';
        		} else {
        		    echo '<div style=\"padding: 10px\"><strong>Ошибка при отправке анкеты по электронной почты!</strong></div>';
        		} 	 
        		
		} 
	}
  */
  
}       
?>