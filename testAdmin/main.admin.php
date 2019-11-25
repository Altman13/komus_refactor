<?php
class Factory {
 function __consrtuct( ) {
 if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
  die("Нет сессии");
 }
 
 public static function Site( $url = false, Template $template ) {

 switch( $url )
 { 
  
  case 'projects':
     $handler = new ProjectAdmin( $template );
  break;   
 
  case 'typefields':  	
     $handler = new TypeFieldAdmin( $template );
  break; 
  
  case 'node':  	
     $handler = new NodeAdmin( $template );
  break;
  
  case 'form':  	
     $handler = new FormAdmin( $template );
  break;
  
  case 'field':  	
     $handler = new FieldAdmin( $template );
  break;
  
  case 'references':  	
  	$handler = new ReferencesAdmin( $template );
  break;
  
  case 'refitem':  	  
  	$handler = new RefItemAdmin( $template );
  break;
  
  case 'condition':  	  
  	$handler = new ConditionAdmin( $template );
  break;
  
  case 'exit':
   session_destroy();
   $template -> show_main();
  break;
  
  default:
    $template -> show_main();
 }
  return $handler;
 }
 
} 
?>
