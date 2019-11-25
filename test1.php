 <?php

$db = new PDO("mysql:host=10.0.17.250;dbname=vektor2017_dev; charset=utf8", "usr_web" , "USR_PassworD" );

 $sql = "   SELECT contact.* , DATE_FORMAT(contact.creation_time, '%d.%m.%Y')  dd                                           
                FROM vektor2017_dev.cot_komus_contacts AS contact                
                LEFT JOIN vektor2017_dev.cot_users AS u ON u.user_id = contact.user_id                               
                ORDER BY contact.id";
        
		   $sql_report = $db->query($sql);
 			
			 foreach ($sql_report as $key => $row) { 
			   if (!is_null($row['creation_time'])) {
			    echo $row['dd'].'<br>';
			   }
			 }
			
?>			 