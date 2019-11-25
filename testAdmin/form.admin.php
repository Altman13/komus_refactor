<?
  class FormAdmin extends Change_record{  
    private  $template;   
    function __construct ( Template $template ){
      $this -> template = $template;
     
      if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
       die("Нет сессии");     
   }    
    
    public function display() {
      global $param;     
      $url_redirect = "testAdmin/index.php?menu=form&pages=".$param["pages"]."&item_id=".$param["item_id"];
      
      //Модификация записи
      $this -> change( new FormMapper(), $url_redirect, $this -> from_form() ); 
              
      $param["message"] = Util :: get_cookie( "admin" );       
              
      switch ( $param["action"] ) {
      case 'add':
       $this -> add_data( ); 
      break;
      
      case 'edit':
      $this -> edit_data( ); 
      break;
           
      default: 
       $this -> list_data( );
      break;      
     }
     
	 $data_node     = NodeMapper :: SelectAll();  
 	 $data_project  = ProjectMapper :: SelectAll();
	 
 	 $this -> template -> assign_data( "data_node", $data_node );
 	 $this -> template -> assign_data( "data_project", $data_project );
     $this -> template -> assign_data( "param", $param );
     $this -> template -> show_main();
   }
   
  protected function list_data(  ) {
   global $param;
      
   $param["filter"] = Util :: filtr( array("filter" => $param["filter"] , "name" => "filtr_form") );
   $param["record_count"] = FormMapper :: CountAll ( array( "item_id" => $param["item_id"], "filter" => $param["filter"] ) );
   $data = FormMapper :: SelectAll( array( "item_id" => $param["item_id"], "offset" => $param["pages"] , "limit" => $param["limit"] ,  "filter" => $param["filter"] ) );
    
   $this -> template -> assign( "admin", "form/list.phtml", $data );    
  }
  
  protected function edit_data( ) {
   global $param;
     
   $data = FormMapper :: FindById( $param["id"] ); 
   $this -> template -> assign( "admin", "form/form.phtml" , $data);
  }
  
  protected function add_data( ) {
   $this -> template -> assign( "admin", "form/form.phtml" );
  }
  
  //  Данные с формы
  protected function from_form(){
    
    $record = new Form( true );

    if( $_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET" ) {
     $record -> id           = Util :: s_param( "id" )   ? Util :: s_param( "id" ) : true;
	 $record -> project_id   = Util :: s_param( "project_id" );
	 $record -> node_id      = Util :: s_param( "node_id" );
     $record -> title        = Util :: s_param( "title" );
     $record -> save         = Util :: s_param( "save" ) ? Util :: s_param( "save" ) : 0;
     $record -> description  = Util :: s_param( "description" );
    }
   return $record;
  } 
 } 
?>