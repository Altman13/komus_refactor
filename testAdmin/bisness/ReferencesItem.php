<?
class References {
  public $id;
  public $title;
  public $description;
  
 function __construct( $id = false, $title = false, $description = false ) { 
    $this -> id             = $id;
    $this -> title          = $title;
	$this -> description    = $description;
  }
}

class ReferencesMapper {
 protected static function _where( $param = array() ){
   $query = "";
   !empty( $param["filter"] ) ? $query = " WHERE title LIKE '%:1%' " : "";
   
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY id ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT * FROM cot_komus_references ";
   $query .= ReferencesMapper :: _where( $param );
   $query .= ReferencesMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_references ";
   $query .= ReferencesMapper :: _where( $param );
   $query .= ReferencesMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_references  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new References( $data["id"], $data["title"], $data["description"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_references 
                      ( title, description ) VALUES ( ':1', ':2' )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> title, $obj -> description );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     
     $query = "UPDATE cot_komus_references SET
                      title = ':1', description = ':2'  WHERE id = :3";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> title, $obj -> description, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_references WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>