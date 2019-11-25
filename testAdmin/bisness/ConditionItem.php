<?
class Condition {
  public $node_id;
  public $if_visited_node;
  public $if_field;
  public $if_field_value;
  public $to_node; 
  
 function __construct( $node_id = false, $if_visited_node = false, $if_field = false, $if_field_value = false, $to_node = false ) { 
    $this -> node_id          = $node_id;
    $this -> if_visited_node  = $if_visited_node;
    $this -> if_field         = $if_field;
    $this -> if_field_value   = $if_field_value;
    $this -> to_node          = $to_node; 
  }
}

class ConditionMapper {
 protected static function _where( $param = array() ){
   $query = "";
   //!empty( $param["filter"] ) ? $query = " WHERE cot_komus_nodes.node_text LIKE '%:1%' " : "";
   //( !empty( $param["item_id"] ) ) ? $query =" WHERE node_id =".$param["item_id"] : "";
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY node_id ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT * FROM cot_komus_conditions "; 
             
   $query .= ConditionMapper :: _where( $param );
   $query .= ConditionMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(node_id) AS count FROM cot_komus_conditions ";
   $query .= ConditionMapper :: _where( $param );
   $query .= ConditionMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }
   
 public static function insert( $obj ) {
    if( !$obj -> node_id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_conditions 
                      ( node_id, if_visited_node, if_field, if_field_value, to_node ) VALUES ( :1, :2, :3, :4, :5 )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> node_id, $obj -> if_visited_node, $obj -> if_field, $obj -> if_field_value, $obj -> to_node  );                 
  }
}
?>