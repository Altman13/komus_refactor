<?
  class ConditionAdmin extends Change_record{  
    private  $template;   
    function __construct ( Template $template ){
      $this -> template = $template;
     
      if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
       die("Нет сессии");     
   }    
    
    public function display() {
      global $param;     
      $url_redirect = "testAdmin/index.php?menu=condition&pages=".$param["pages"];
      
      //Модификация записи
     $this -> change( new ConditionMapper(), $url_redirect, $this -> from_form() ); 
             
     $param["message"] = Util :: get_cookie( "admin" );                           

     $this -> list_data( );
     
	 $data_node     = NodeMapper :: SelectAll();  
	 $field         = FieldMapper :: SelectAll();     
	 
 	 $this -> template -> assign_data( "data_node", $data_node );
 	 $this -> template -> assign_data( "field", $field );
     $this -> template -> assign_data( "param", $param );
     $this -> template -> show_main();
   }
   
  protected function list_data(  ) {
   global $param;
      
   $param["filter"] = Util :: filtr( array("filter" => $param["filter"] , "name" => "filtr_condition") );
   $param["record_count"] = ConditionMapper :: CountAll ( array( "filter" => $param["filter"] ) );
   $data = ConditionMapper :: SelectAll( array( "offset" => $param["pages"] , "limit" => $param["limit"] ,  "filter" => $param["filter"] ) );
    
   $this -> template -> assign( "admin", "condition/list.phtml", $data );    
  }
  
  //  Данные с формы
  protected function from_form(){
    
    $record = new Condition( true );

    if( $_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET" ) {
     $record -> node_id           = Util :: s_param( "node_id" ) ? Util :: s_param( "node_id" ) : 0;
	 $record -> if_visited_node   = Util :: s_param( "if_visited_node" ) ? Util :: s_param( "if_visited_node" ) : 0;
	 $record -> if_field          = Util :: s_param( "if_field" ) ? Util :: s_param( "if_field" ) : 0;
     $record -> if_field_value    = Util :: s_param( "if_field_value" ) ? Util :: s_param( "if_field_value" ) : 0;
     $record -> to_node           = Util :: s_param( "to_node" ) ? Util :: s_param( "to_node" ) : 0;
    }
   return $record;
  } 
 } 
?>