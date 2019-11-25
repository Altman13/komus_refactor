<?php

class login_user
{
 private $login;
 private $password;
 private $user;

function __construct($login, $password, $user )
{
  $this->login=trim($login);
  $this->password=md5(trim($password));
     
  $this -> user = $user;
  
  session_start();
}

public function login( $name = false, $id = false )
{
 	
 if(isset($this->login) && isset($this->password)) {
     
    //���� ����� ������������
  if( !empty( $this -> user -> user_id ) )  {
   
   if( trim( $this -> user -> user_password ) == $this->password && trim( $this -> user -> user_name ) == $this->login && $this -> user -> user_maingrp == 5 ) {
	  //����������� ������������ � ������
	  $_SESSION[$name] = $this -> user -> user_name;
	  $_SESSION[$id]      = $this -> user -> user_id;
	  
     return TRUE;
    }
  }  else  {
   return FALSE;
  }
 } else {
 	
   //������ ������ ��� �����
   return FALSE;
  }
}

 public function valid_user()
 {
  if(!isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']))
   die("��� ������!");
  else
   return TRUE;
 }
}
?>
