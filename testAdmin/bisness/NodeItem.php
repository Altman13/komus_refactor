<?
class Node {
  public $id;
  public $node_text;
  public $project_id;
  
 function __construct( $id = false, $node_text = false, $project_id = false ) { 
    $this -> id            = $id;
    $this -> node_text     = $node_text;
	$this -> project_id    = $project_id;
  }
}

class NodeMapper {
 protected static function _where( $param = array() ){
   $query = "";
   !empty( $param["filter"] ) ? $query = " WHERE cot_komus_nodes.node_text LIKE '%:1%' " : "";
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY id ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT cot_komus_nodes.*, cot_komus_forms.id AS form_id, cot_komus_forms.title AS form_title  FROM cot_komus_nodes 
             LEFT JOIN cot_komus_forms ON cot_komus_nodes.id = cot_komus_forms.node_id ";
   $query .= NodeMapper :: _where( $param );
   $query .= NodeMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_nodes ";
   $query .= NodeMapper :: _where( $param );
   $query .= NodeMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_nodes  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new Node( $data["id"], $data["node_text"], $data["project_id"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_nodes 
                      ( node_text, project_id ) VALUES ( ':1', :2 )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> node_text, $obj -> project_id );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     
     $query = "UPDATE cot_komus_nodes SET
                      node_text = ':1', project_id = :2  WHERE id = :3";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> node_text, $obj -> project_id, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_nodes WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>