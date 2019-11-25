<?
  class RefItemAdmin extends Change_record{  
    private  $template;   
    function __construct ( Template $template ){
      $this -> template = $template;
     
      if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
       die("Нет сессии");     
   }    
    
    public function display() {
      global $param;     
      
      $url_redirect = "testAdmin/index.php?menu=refitem&pages=".$param["pages"]."&item_id=".$param["item_id"];
      //Модификация записи
      $this -> change( new RefItemMapper(), $url_redirect, $this -> from_form() );     
      
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
     $references = ReferencesMapper :: FindById( $param["item_id"] );
     $references_all = ReferencesMapper :: SelectAll();

     $this -> template -> assign_data( "references", $references );
     $this -> template -> assign_data( "references_all", $references_all );
 	 $this -> template -> assign_data( "param", $param );
     $this -> template -> show_main();
   }
   
  protected function list_data(  ) {
   global $param;
      
   $param["filter"] = Util :: filtr( array("filter" => $param["filter"] , "name" => "filtr_refitem") );
   $param["record_count"] = RefItemMapper :: CountAll ( array( "filter" => $param["filter"], "item_id" => $param["item_id"] ) );
   $data = RefItemMapper :: SelectAll( array( "item_id" => $param["item_id"], "offset" => $param["pages"] , "limit" => $param["limit"] ,  "filter" => $param["filter"] ) );
    
   $this -> template -> assign( "admin", "refitem/list.phtml", $data );    
  }
  
  protected function edit_data( ) {
   global $param;
     
   $data = RefItemMapper :: FindById( $param["id"] ); 
   $this -> template -> assign( "admin", "refitem/form.phtml" , $data);
  }
  
  protected function add_data( ) {
   $this -> template -> assign( "admin", "refitem/form.phtml" );
  }
  
   protected function update_data( $url_redirect = false ) {
    global  $param; 
     
    $form_data = $this -> from_form();
   
    if( count( $form_data -> all_id ) > 0 ) {
     foreach( $form_data -> all_id as $key => $item ){
      $update = RefItemMapper :: FindById($key);	
      $update -> sort = abs($form_data -> all_sort[$key]);
      if ( !empty( $update -> sort ) ) {
       RefItemMapper :: update( $update );
      }
     }
    }
     
    Util :: header_redirect( $url_redirect );
  }
  
  //  Данные с формы
  protected function from_form(){
    
    $record = new RefItem( true );

    if( $_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET" ) {
     $record -> id            = Util :: s_param( "id" )   ? Util :: s_param( "id" ) : true;
     $record -> title         = Util :: s_param( "title" );
	 $record -> value         = Util :: s_param( "value" );
	 $record -> reference_id  = Util :: s_param( "reference_id" );
     $record -> sort          = Util :: s_param( "sort" );   
     //Записи на странице
     $record -> all_sort = Util :: s_param( "all_sort", false );   
     $record -> all_id   = Util :: s_param( "all_id", false ); 
    }
 
   return $record;
  } 
 } 
?>