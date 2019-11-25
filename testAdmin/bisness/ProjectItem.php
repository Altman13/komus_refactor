<?
class Project {
  public $id;
  public $title;
  public $first_node_id;
  
 function __construct( $id = false, $title = false, $first_node_id = false ) { 
    $this -> id             = $id;
    $this -> title          = $title;
	$this -> first_node_id  = $first_node_id;
  }
}

class ProjectMapper {
 protected static function _where( $param = array() ){
   $query = "";
   
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY id ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT * FROM cot_komus_projects ";
   $query .= ProjectMapper :: _where( $param );
   $query .= ProjectMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_projects ";
   $query .= ProjectMapper :: _where( $param );
   $query .= ProjectMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_projects  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new Project( $data["id"], $data["title"], $data["first_node_id"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_projects 
                      ( title, first_node_id ) VALUES ( ':1', :2 )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> title, $obj -> first_node_id );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     
     $query = "UPDATE cot_komus_projects SET
                      title = ':1', first_node_id = :2  WHERE id = :3";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> title, $obj -> first_node_id, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_projects WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>