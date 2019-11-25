<?
class Field {
  public $id;
  public $type;
  public $title;
  public $name;
  public $form_id;
  public $reference_id;
  public $required;
  public $empty_string;
  public $sort;
  public $save;
  public $description;
    
 function __construct( $id = false, $type = false, $title = false, $name = false, $form_id = false, $reference_id = false,
                       $required = false, $empty_string = false, $sort = false, $save = false, $description = false  ) { 
    $this -> id           = $id;
    $this -> type         = $type;
    $this -> title        = $title;
    $this -> name         = $name;
    $this -> form_id      = $form_id;
    $this -> reference_id = $reference_id;
    $this -> required     = $required;
    $this -> empty_string = $empty_string;
    $this -> sort         = $sort;
    $this -> save         = $save;
    $this -> description  = $description;
    
  }
}

class FieldMapper {
 protected static function _where( $param = array() ){
   $query = "";
   //!empty( $param["filter"] ) ? $query = " WHERE cot_komus_nodes.node_text LIKE '%:1%' " : "";
   ( !empty( $param["item_id"] ) ) ? $query =" WHERE form_id =".$param["item_id"] : "";
   return $query;
  }
   
 protected static function _order ( $param = array() ){
   $query = "";
   $query = " ORDER BY sort ";
   return $query;
  }
  
 public static  function SelectAll( $param = array() )  {
   $query = "SELECT cot_komus_forms_fields.*, cot_komus_references.title AS reference, 
             cot_komus_forms_types.title AS typefield FROM cot_komus_forms_fields 
             LEFT JOIN cot_komus_references ON cot_komus_forms_fields.reference_id = cot_komus_references.id 
             LEFT JOIN cot_komus_forms_types ON cot_komus_forms_fields.type = cot_komus_forms_types.id ";
   $query .= FieldMapper :: _where( $param );
   $query .= FieldMapper :: _order( $param );
    
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetchall_assoc();
   
   return $data;   
  }

 public static function CountAll( $param = array() )  {
   $query = "SELECT count(id) AS count FROM cot_komus_forms_fields ";
   $query .= FieldMapper :: _where( $param );
   $query .= FieldMapper :: _order( $param );
   
   (!empty($param["limit"]) && empty($param["offset"])) ? $query.= " LIMIT ".$param["limit"] : '';
   (!empty($param["limit"]) && !empty($param["offset"])) ? $query.= " LIMIT ".$param["offset"]." ,".$param["limit"] : '';
 
   $dbh = new DB();
   $data = $dbh -> prepare( $query ) -> execute( $param["filter"] ) -> fetch_assoc();
   
   return $data["count"];   
  }

 public static function FindById( $id ) {
   $query = "SELECT * FROM cot_komus_forms_fields  WHERE id = :1";
   
   $dbh = new DB();
   $data = $dbh -> prepare($query) -> execute( $id ) -> fetch_assoc();
   
   return new Field( $data["id"], $data["type"], $data["title"], $data["name"], $data["form_id"], $data["reference_id"],
                     $data["required"], $data["empty_string"], $data["sort"], $data["save"], $data["description"] );
 }
   
 public static function insert( $obj ) {
    if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "INSERT INTO cot_komus_forms_fields 
                      ( type, title, name, form_id, reference_id, required, empty_string, sort, save, description ) 
                      VALUES ( :1, ':2', ':3', :4, :5, ':6', ':7', :8, ':9', ':10' )";
                     
    $dbh = new DB();
    $dbh -> prepare( $query ) -> execute( $obj -> type, $obj -> title, $obj -> name, $obj -> form_id, $obj -> reference_id, 
                                          $obj -> required, $obj -> empty_string, $obj -> sort, $obj -> save, $obj -> description  );                 
  }

 public static function update( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
     // var_dump($obj); die;
     $query = "UPDATE cot_komus_forms_fields SET
                      type = :1, title =':2', name = ':3', form_id = :4, reference_id = :5, required = ':6', empty_string = ':7', 
                      sort =:8, save = ':9', description = ':10'  WHERE id = :11";
                      
    $dbh = new DB();
    $dbh -> prepare($query) -> execute( $obj -> type, $obj -> title, $obj -> name, $obj -> form_id, $obj -> reference_id, 
                                        $obj -> required, $obj -> empty_string, $obj -> sort, $obj -> save, $obj -> description, $obj -> id );
  }
  
 public static function delete( $obj ) {
     if( !$obj -> id ){
     die("Объект не создан");
    }
    
    $query = "DELETE FROM cot_komus_forms_fields WHERE id = :1";
      
    $dbh = new DB();  
    $dbh -> prepare( $query ) -> execute( $obj -> id );  
  } 
}
?>