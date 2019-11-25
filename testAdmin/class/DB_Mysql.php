<?
class DB_Mysql{
 protected $user;
 protected $pass;
 protected $dbhost;
 protected $dbname;
 static $dbhandler;
 
 function __construct( $user, $pass, $dbhost, $dbname ){
  $this -> user = $user;
  $this -> pass = $pass;
  $this -> dbhost = $dbhost;
  $this -> dbname = $dbname;
 }
  
 protected function connect(){
// echo("����������� ����������<br>");
 if( ! is_resource( self :: $dbhandler) ) {
   self :: $dbhandler = mysql_connect( $this->dbhost, $this->user, $this->pass);
   mysql_query ('SET NAMES utf8');
 }
  
  if(! is_resource( self :: $dbhandler ) ) {
   die("���������� ���������� ����������".mysql_error());
  } 
  
  if( !mysql_select_db( $this->dbname, self :: $dbhandler ) ) {
   die("���������� ������������ � ����".mysql_error());
  }
 }
 
 protected function execute( $query ) {
  if( !self :: $dbhandler)  {
   $this->connect();
  }
  $ret = mysql_query( $query, self :: $dbhandler );
  if( !$ret ) {
   die("������ �� �������� ");
  } else if( !is_resource( $ret ) ) {
   return TRUE;
  } else {
   $stmt = new DB_MysqlState( self :: $dbhandler, $query );
   $stmt->result = $ret;
   return $stmt;
  }
 }
 
 public function prepare( $query ) {
  if( !self :: $dbhandler ) {
   $this->connect();
  }
  
  return new DB_MysqlState( self :: $dbhandler, $query );
 }
}

class DB_MysqlState  {
 protected $result;
 protected $binds;
 protected $query;
 protected $dbhandler;
 
 function __construct( $dbhandler, $query ) {
  $this->query = $query;
  $this->dbhandler = $dbhandler;
  if( !is_resource( $dbhandler ) ) {
   die("����������� ���������� � ����� ������");
  }
 }
 
 public function fetch_row() {
  if( !$this->result ) {
   die("������ �� ��������");
  }
  return mysql_fetch_row( $this->result );
 }
 
 public function fetch_assoc() {
  if( !$this->result ) {
   die("������ �� ��������");
  }
  return mysql_fetch_assoc( $this->result );
 }
 
 public function fetchall_assoc() {
  $retval = array();
  while( $row = $this->fetch_assoc() ) {
   $retval[] = $row;
  }
  return $retval;
 }
 
 public function execute() {
  $binds = func_get_args();
  foreach( $binds as $index => $name ) {
   $this->binds[$index + 1] = $name;
  }
  
  $cnt = count( $binds );
  $query = $this->query;
  
  if( $cnt > 0 ) { //���� ���������
   foreach( $this->binds as $ph => $pv) {
     $query = preg_replace( "/:".$ph."/",  mysql_escape_string( $pv ), $query , 1); 
   }
  }
//echo($query);
  $this->result = mysql_query( $query, $this->dbhandler );
  if( !$this->result ) {
   if( DB_SHOW_ERROR ) {    
    die( "������ �� ��������: ".mysql_error()."<br>".$query ); 
   } 
  }
  
  return $this;
 }
 
}

class DB extends DB_Mysql {
 function __construct() {
  parent :: __construct( DB_USER, DB_PASSWORD, DB_HOST, DB_NAME ); 
 }
}
