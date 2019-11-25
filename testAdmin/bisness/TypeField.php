<?
class TypeField {
  public $id;
  public $title;
  public $sort;
  
 function __construct( $id = false, $title = false, $sort = false ) { 
    $this -> id             = $id;
    $this -> title          = $title;
	$this -> sort           = $sort;
  }
}

class TypeFieldMapper {
 protected static function _where( $param = array() ){
   $query = "";
   !empty( $param["filter"] ) ? $query = " WHERE title LIKE '%:1%' " : "";
   
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY sort ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT * FROM cot_komus_forms_types ";
   $query .= TypeFieldMapper :: _where( $param );
   $query .= TypeFieldMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_forms_types ";
   $query .= TypeFieldMapper :: _where( $param );
   $query .= TypeFieldMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_forms_types  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new Project( $data["id"], $data["title"], $data["sort"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_forms_types 
                      ( title, sort ) VALUES ( ':1', :2 )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> title, $obj -> sort );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     
     $query = "UPDATE cot_komus_forms_types SET
                      title = ':1', sort = :2  WHERE id = :3";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> title, $obj -> sort, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_forms_types WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>