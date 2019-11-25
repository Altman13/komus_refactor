<?
class Change_record  {
public function change( $mapper = false ,$url_redirect = false , $record = false ) {
 $cmd = Util :: s_param("cmd");
 
 if( $cmd ) {            //���������, ������� � �����������
   switch( $cmd ) {
    case "edit":  //��������� ������     
      $this -> do_befor_edit();
      $this -> update( $mapper, $record );      
      $this -> do_after_edit( $url_redirect );
    break;

   case "add": //�������� ������          
       $this -> do_befor_add();     
       $this -> insert( $mapper, $record );
       $this -> do_after_add( $url_redirect );
   break;
   
   case "del":  //������� ������
      $this -> do_befor_del(); 
      $this -> delete( $mapper, $record );
      $this -> do_after_del( $url_redirect );           
   break;
  }

 }
}

 protected function delete( $mapper, $record ) {
  $mapper -> delete( $record );
}
 
 protected function insert( $mapper, $record ) {
  $mapper -> insert( $record );
}
 
 protected function update( $mapper, $record ) {
  $mapper -> update( $record );
}

 protected function do_after_del( $url_redirect = false ) {
  Util :: set_cookie( "admin", "Запись удалена" );
  Util :: header_redirect( $url_redirect );
 }
 
 protected function do_after_add( $url_redirect = false ) {
   Util :: set_cookie( "admin", "Запись добавлена" );
   Util :: header_redirect( $url_redirect ); 
 }

protected function do_after_edit( $url_redirect = false ) {
   Util :: set_cookie( "admin", "Запись изменена" );
   Util :: header_redirect( $url_redirect );   
 }

protected function do_befor_del() {
  
 }
 
protected function do_befor_add() {
 
 }

protected function do_befor_edit() {
 
 }
}
?>