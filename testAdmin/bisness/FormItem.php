<?
class Form {
  public $id;
  public $project_id;
  public $node_id;
  public $title;
  public $save;
  public $description;
  
 function __construct( $id = false, $project_id = false, $node_id = false, $title = false, $save = false, $description = false  ) { 
    $this -> id            = $id;
    $this -> project_id    = $project_id;
    $this -> node_id       = $node_id;
    $this -> title         = $title;
    $this -> save          = $save;
    $this -> description   = $description;
  }
}

class FormMapper {
 protected static function _where( $param = array() ){
   $query = "";
   //!empty( $param["filter"] ) ? $query = " WHERE cot_komus_nodes.node_text LIKE '%:1%' " : "";
   ( !empty( $param["item_id"] ) ) ? $query =" WHERE node_id =".$param["item_id"] : "";
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY id ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT cot_komus_forms.*, cot_komus_projects.title AS project_title  FROM cot_komus_forms 
             LEFT JOIN cot_komus_projects ON cot_komus_forms.project_id = cot_komus_projects.id ";
   $query .= FormMapper :: _where( $param );
   $query .= FormMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_forms ";
   $query .= FormMapper :: _where( $param );
   $query .= FormMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_forms  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new Form( $data["id"], $data["project_id"], $data["node_id"], $data["title"], $data["save"], $data["description"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_forms 
                      ( project_id, node_id, title, save, description ) VALUES ( :1, :2, ':3', :4, ':5' )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> project_id, $obj -> node_id, $obj -> title, $obj -> save, $obj -> description  );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     
     $query = "UPDATE cot_komus_forms SET
                      project_id = :1, node_id = :2, title = ':3', save = :4, description =':5'  WHERE id = :6";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> project_id, $obj -> node_id, $obj -> title, 
                                        $obj -> save, $obj -> description, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_forms WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>