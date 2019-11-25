<?
class Template {
 private $main_path = false;
 private $main_template = false;
 private $inc_template = array();
 private $data = array();
 private $template = false;  
 
 function __construct( $main_path = false, $main_template = false ) {
   $this -> main_path = $main_path;
   $this -> main_template = $this -> main_path . $main_template;  
 }
 
 public function assign_main( $main_template = false ) {
   $this -> main_template = $this -> main_path . $main_template;
 }
 
 public function assign( $inc = false, $inc_template = false , $data = false) {
   $this -> inc_template[ $inc ] = $this -> main_path . $inc_template;
   
   if ( $data ) {
    $this -> data[$inc] =  $data;
   }
 }
 
 public function assign_data ( $inc = false, $data = false ) {
  if ( $data ) {
   $this -> data[$inc] =  $data;
   }
 }
 
 public function get_data( $inc = false ) {
  if( $inc ) {
   return $this -> data[$inc];
  } else {
   return false;
  } 
 }
 
 public function show_inc( $inc = false ) { 
  if( $this -> inc_template[ $inc ] ) {
      $this -> template = $inc; 
      
      include( $this -> inc_template[ $inc ] );
  }   
 }
 public function is_inc(  $inc = false ) {
  if( $this -> inc_template[ $inc ] ) {
    return true;
  } else {
   return false;
  }
 }
 
 public function show_main( ) {
 	
    include( $this -> main_template );
  }
}
?>