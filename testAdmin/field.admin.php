<?
  class FieldAdmin extends Change_record{  
    private  $template;   
    function __construct ( Template $template ){
      $this -> template = $template;
     
      if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
       die("Нет сессии");     
   }    
    
    public function display() {
      global $param;     
      $url_redirect = "testAdmin/index.php?menu=field&pages=".$param["pages"]."&item_id=".$param["item_id"];
      
      //Модификация записи
      $this -> change( new FieldMapper(), $url_redirect, $this -> from_form() ); 
              
      $param["message"] = Util :: get_cookie( "admin" );       
              
      switch ( $param["action"] ) {
      case 'add':
       $this -> add_data( ); 
      break;
      
      case 'edit':
      $this -> edit_data( ); 
      break;

      case 'update':
       $this -> update_data( $url_redirect ); 
      break;
      
      
      default: 
       $this -> list_data( );
      break;      
     }
     
	 $data_references = ReferencesMapper :: SelectAll();  
 	 $data_forms      = FormMapper :: SelectAll();
 	 $type            = TypeFieldMapper :: SelectAll();
	 
 	 $this -> template -> assign_data( "data_references", $data_references );
 	 $this -> template -> assign_data( "data_forms", $data_forms );
 	 $this -> template -> assign_data( "type", $type );
     $this -> template -> assign_data( "param", $param );
     $this -> template -> show_main();
   }
   
  protected function list_data(  ) {
   global $param;
      
   $param["filter"] = Util :: filtr( array("filter" => $param["filter"] , "name" => "filtr_form") );
   $param["record_count"] = FieldMapper :: CountAll ( array( "filter" => $param["filter"] ) );
   $data = FieldMapper :: SelectAll( array( "item_id" => $param["item_id"], "offset" => $param["pages"] , "limit" => $param["limit"] ,  "filter" => $param["filter"] ) );
    
   $this -> template -> assign( "admin", "field/list.phtml", $data );    
  }
  
  protected function edit_data( ) {
   global $param;
     
   $data = FieldMapper :: FindById( $param["id"] ); 
   $this -> template -> assign( "admin", "field/form.phtml" , $data);
  }
  
  protected function add_data( ) {
   $this -> template -> assign( "admin", "field/form.phtml" );
  }
  
  protected function update_data( $url_redirect = false ) {
    global  $param; 
     
    $form_data = $this -> from_form();
   
    if( count( $form_data -> all_id ) > 0 ) {
     foreach( $form_data -> all_id as $key => $item ){
      $update = FieldMapper :: FindById($key);	
      $update -> sort = abs($form_data -> all_sort[$key]);
      if ( !empty( $update -> sort ) ) {
       FieldMapper :: update( $update );
      }
     }
    }
     
    Util :: header_redirect( $url_redirect );
  }
  
  //  Данные с формы
  protected function from_form(){
    
    $record = new Field( true );

    if( $_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET" ) {
     $record -> id           = Util :: s_param( "id" )   ? Util :: s_param( "id" ) : true;
	 $record -> type         = Util :: s_param( "type" );
	 $record -> title        = Util :: s_param( "title", false );
	 $record -> name         = Util :: s_param( "name" );
     $record -> form_id      = Util :: s_param( "form_id" );
     $record -> reference_id = Util :: s_param( "reference_id" ) ? Util :: s_param( "reference_id" ) : 0;
     $record -> required     = Util :: s_param( "required" );
     $record -> empty_string = Util :: s_param( "empty_string" ) ? Util :: s_param( "empty_string" ) : 0;
     $record -> sort         = Util :: s_param( "sort" );
     $record -> save         = Util :: s_param( "save" ) ? Util :: s_param( "save" ) : 0;
     $record -> description  = Util :: s_param( "description" );
      //Записи на странице
     $record -> all_sort = Util :: s_param( "all_sort", false );   
     $record -> all_id   = Util :: s_param( "all_id", false ); 
    }
   
   return $record;
  } 
 } 
?>
