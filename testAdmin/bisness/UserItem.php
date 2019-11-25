<?
class User {
  public $user_id;
  public $user_name;
  public $user_password;
  public $user_maingrp;
  
  function __construct( $user_id = false, $user_name = false, $user_password = false, $user_maingrp = false )
  {
   $this -> user_id          = $user_id;
   $this -> user_name        = $user_name;
   $this -> user_password    = $user_password;
   $this -> user_maingrp     = $user_maingrp;
  }
}

class UserMapper {
 
  public static  function FindByLogin( $obj ) {
   $query = "SELECT * FROM cot_users  WHERE login = ':1'";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $obj -> login ) -> fetch_assoc();
   
   return new User ( $data["user_id"], $data["user_name"] , $data["user_password"] );
  }
  
  public static  function UserLogin( $login, $password) {
   $query = "SELECT user_id,user_name,user_password, user_maingrp FROM cot_users WHERE user_name = ':1' AND user_password = ':2'";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $login, $password ) -> fetch_assoc();
   
   return new User ( $data["user_id"], $data["user_name"] , $data["user_password"], $data["user_maingrp"] );    
  }
}
?>