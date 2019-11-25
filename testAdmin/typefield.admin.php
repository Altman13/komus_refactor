<?
  class TypeFieldAdmin extends Change_record{
     private  $template; 
   function __construct ( Template $template ){
      $this -> template = $template;

      if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) )
       die("Нет сессии");     
   }    
   
   public function display( ) {
      global $param;     
      $url_redirect = "testAdmin/index.php?menu=typefields&pages=".$param["pages"];
      
      $param["message"] = Util :: get_cookie( "admin" );    
      
    //Модификация записи
      $this -> change( new TypeFieldMapper(), $url_redirect, $this -> from_form() );                    
           
      switch ( $param["action"] ) {
      case 'edit':
       $this -> update_data( $url_redirect ); 
      break;
      
               
      default: 
       $this -> list_data( );
      break;      
     }
     
      $this -> template -> assign_data( "param", $param );
      $this -> template -> show_main( );
   }
   
  protected function list_data(  ) {
      global $param;
      
      $param["filter"] = Util :: filtr( array("filter" => $param["filter"] , "name" => "filtr_typefield") );
      $param["record_count"] = TypeFieldMapper :: CountAll ( array( "filter" => $param["filter"] ) );
      $data = TypeFieldMapper :: SelectAll( array( "offset" => $param["pages"] , "limit" => $param["limit"] ,  "filter" => $param["filter"] ) );
      
	  $this -> template -> assign( "admin", "typefield/list.phtml", $data );    
  }
  
 protected function update_data( $url_redirect = false ) {
    global  $param; 
     
    $form_data = $this -> from_form();
   
    if( count( $form_data -> all_spr ) > 0 ) {
     foreach( $form_data -> all_spr as $key => $item ){
      $update = new TypeField ( $key, @htmlspecialchars( $item , ENT_QUOTES ), $form_data -> all_sort[$key] );
      if ( !empty( $item ) ) {
       TypeFieldMapper :: update( $update );
      }
     }
    }
     
    Util :: header_redirect( $url_redirect );
  }
  
  
 protected function insert( $mapper, $record ) {
  if ( !empty( $record -> title ) ) {
    $mapper -> insert( $record );    
  }  
 }  
 
 protected function do_after_add( $url_redirect ) {   
   Util :: set_cookie( "admin", "Изменения сделаны" );
 }
  
  //  Данные с формы
  protected function from_form(){
    global $param;
    
    $record = new TypeField( true );

    if( $_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET" ) {
     $record -> id            =  Util :: s_param( "id" )   ? Util :: s_param( "id" ) : true;
     $record -> title         =  Util :: s_param( "title" ) ;
	 $record -> sort          =  Util :: s_param( "sort" ) ;
     
     //Записи на странице
     $record -> all_spr  = Util :: s_param( "all_spr", false );
	 $record -> all_sort = Util :: s_param( "all_sort", false );
   }
   
   return $record;
  } 
 
 } 
?>