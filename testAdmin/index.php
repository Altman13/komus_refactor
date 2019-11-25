<?
//error_reporting(2048);

 include_once("config.php");
 include_once("class/util.php");
 include_once("class/DB_Mysql.php");
 include_once("class/login_user.php");
 include_once("class/template.php");
 include_once("class/change_record.php");
 include_once("class/html.php");
 include_once("main.admin.php");
 
 include_once("bisness/UserItem.php");
 include_once("bisness/ProjectItem.php");
 include_once("bisness/TypeField.php");
 include_once("bisness/NodeItem.php");
 include_once("bisness/FormItem.php");
 include_once("bisness/FieldItem.php");
 include_once("bisness/ReferencesItem.php");
 include_once("bisness/RefItemItem.php");
 include_once("bisness/ConditionItem.php");
 
 include_once("project.admin.php");
 include_once("typefield.admin.php");
 include_once("node.admin.php");
 include_once("form.admin.php");
 include_once("field.admin.php");
 include_once("references.admin.php");
 include_once("refitem.admin.php");
 include_once("condition.admin.php");
    
 $param["menu"]        = Util :: s_param('menu'); 
 $param["cmd"]         = Util :: s_param("cmd");
 $param["action"]      = Util :: s_param("action");
 $param["limit"]       = 30;
 $param["group_limit"] = 10;
 $param["id"]          = Util :: s_param( "id" )   ? Util :: s_param( "id" ) : true;
 $param["item_id"]     = Util :: s_param( "item_id" )   ? Util :: s_param( "item_id" ) : 0;
 $param["pages"]       = ( Util :: s_param( "pages" ) ? Util :: s_param( "pages" ) : 0 ) ;
 $param["filter"]      = ( Util :: s_param( "filter" ) ? trim( Util :: s_param( "filter" ) ) : false );
 $param["date"]        = @strftime( '%d.%m.%Y' , time( ) );  

$user = UserMapper :: UserLogin( Util::s_param('login'), MD5(Util :: s_param('password')) );
$serg=new login_user(Util::s_param('login'), Util :: s_param('password') , $user);

$template = new Template( $config["template_admin"], "main/main_1.phtml");
$template -> assign( "main_menu", "main/main_menu.phtml" );

if( !isset($_SESSION['valid_user']) && !isset($_SESSION['id_user']) ) {
 
 if(!$serg->login( "valid_user", "id_user" ))
 {  	
  $template -> assign( "admin", "main/login.phtml" );
  $template -> show_main( );
 } else { 	
  $handler = Factory :: Site( $param["menu"], $template );
 }
 
} else {
 	
 $handler = Factory :: Site( $param["menu"], $template );
 if( $handler ) 
  $handler -> display( ); 
}
?>
