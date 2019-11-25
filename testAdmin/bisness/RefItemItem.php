<?
class RefItem {
  public $id;
  public $title;
  public $value;
  public $reference_id;
  public $sort;
  
 function __construct( $id = false, $title = false, $value = false, $reference_id = false,  $sort = false ) { 
    $this -> id            = $id;
    $this -> title         = $title;
    $this -> value         = $value;
    $this -> reference_id  = $reference_id;
    $this -> sort          = $sort;
  }
}

class RefItemMapper {
 protected static function _where( $param = array() ){
   $query = "";
   //!empty( $param["filter"] ) ? $query = " WHERE cot_komus_nodes.node_text LIKE '%:1%' " : "";
    ( !empty( $param["item_id"] ) ) ? $query =" WHERE reference_id =".$param["item_id"] : "";
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY sort ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT * FROM cot_komus_references_items ";
   $query .= RefItemMapper :: _where( $param );
   $query .= RefItemMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_references_items ";
   $query .= RefItemMapper :: _where( $param );
   $query .= RefItemMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_references_items  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new RefItem( $data["id"], $data["title"], $data["value"], $data["reference_id"], $data["sort"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }

    $query = "INSERT INTO cot_komus_references_items 
                      ( title, value, reference_id, sort ) VALUES ( ':1', ':2', :3, :4 )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> title, $obj -> value, $obj -> reference_id, $obj -> sort );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
   
     $query = "UPDATE cot_komus_references_items SET
                      title = ':1', value = ':2', reference_id = :3, sort = :4 WHERE id = :5";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> title, $obj -> value, $obj -> reference_id, $obj -> sort, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_references_items WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>