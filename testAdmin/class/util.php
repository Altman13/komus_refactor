<?
class Util {
 public static function s_param ($name , $html = true ) {
  global $HTTP_GET_VARS, $HTTP_POST_VARS, $_GET, $_POST;

	unset ($val);
	if (isset ($_GET[$name]))
		$val = $_GET[$name];
	else if (isset ($_POST[$name]))
		$val = $_POST[$name];
	else if (isset ($HTTP_GET_VARS[$name]))
		$val = $HTTP_GET_VARS[$name];
	else if (isset ($HTTP_POST_VARS[$name]))
		$val = $HTTP_POST_VARS[$name];

        if( $html ) {
	 return (@  htmlspecialchars( $val , ENT_QUOTES ) );
       } else {
       	 return (@ $val );
       }	 
 }
  
  //--- Перенаправление на другой URL
  public static function header_redirect( $url = false) {
   global $config;
   header( "Location: http://".$config["http_host"] ."/".$url);
   exit;
  }
  
 public static function header_error( ) {
   header('HTTP/1.1 301 Moved Permanently');
   header( "Location: http://".$_SERVER["HTTP_HOST"] ."/error_404");
   exit;
  }
  
  public static function no_cache( ) {
   header("Expires: Mon, 28 Jul 1995 08:00:00 GMT");
   header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
   header("Cache-Control: no-cache, must-revalidate");
   header("Pragma: no-cache");
  }
  
  //---Работа с куками
  public static function set_cookie( $name = false, $value = false, $extras = array() ) {
        
   setcookie( $name, $value ,$extras["expire"], $extras["path"], $extras["domain"], $extras["secure"] );
  }
  
  public static function get_cookie( $name, $kill_cookie = true ) {
   global $_COOKIE;
   $cookie = true;
   
   if ( isset( $_COOKIE[$name] ) ) {
    $cookie = $_COOKIE[$name];
    $kill_cookie ? setcookie( $name ) : '';
   } else {
   $cookie =  false;
  }
  
  return $cookie;
 }
 
  //----------------------------------
 
  public static function format_date ( $date ) {
   $date_arr = explode( "." ,$date );
   $gmmktime = gmmktime(0,0,0, $date_arr[1], $date_arr[0], $date_arr[2] );
   
   return $gmmktime;
  }
  
  //-------------------------------------------------
  public static function filtr ( $param = array() ) {
  global $_SERVER;
  
  if( $_SERVER["REQUEST_METHOD"] == "POST" &&  !$param["filter"] ){
       Util :: set_cookie( $param["name"] , "" );
       $param["filter"] = false;
     }
    
    if( $param["filter"]  ) {
     Util :: set_cookie( $param["name"], $param["filter"] );
    } else  if( !$param["filter"] && $_SERVER["REQUEST_METHOD"] != "POST") {
      $param["filter"] = Util :: get_cookie( $param["name"] , false );
    }
   
   return $param["filter"];
  }
  
 //---------------------------------------------------

  public static function send_mail( $param = false) {
    $mail_ok = true;
    $mail_heders.="Content-Type: text/html; charset=\"windows-1251\"\r\n";
    $mail_heders.="Content-Transfer-Encoding: 8bit\r\n";
    $mail_heders.=$param["headers"];
    
     if( mail( $param["mail_to"], $param["mail_subject"], ob_get_contents( ), $mail_heders ) ) {  
       ob_end_clean( );
       $mail_ok = true;
     } else {
       ob_end_clean( );
       $mail_ok = false;
     }
   return $mail_ok; 
  }
  
 //--------------------------
 public static function drow_code( $code = false ) {
  $image = ImageCreateFromPng( 'images/kod/kod.png' );
  $color_bg = ImageColorAllocate( $image, 140, 140, 140 );
  $color = ImageColorAllocate( $image, 150, 150, 150 );

  ImageString( $image,4, 5,10, $code, $color );
  ImagePNG( $image ,'images/kod/kod1.png');
  ImageDestroy( $image );
 } 
 
 public static function generate_kod( ){
  session_start( );
  $kod = rand( 100000,900000);
  $_SESSION["validate_kod"] = $kod;
  return $kod;
 }
 
 //----Загрузка файлов  
 public static function read_file($name_file) {
  if(file_exists($name_file)) {
   $txt_all_arr = file($name_file);          
    return $txt_all_arr;                                                                                                                                                                 
  } else {
   die("Файл не найден.");
  }
 }
 
 public static function copy_file( $source , $dist ) {
   if(copy("$source","$dist")){
    chmod( $dist, 0777); 
    return TRUE;
   } else {
    return FALSE;
   }
 }
 
 public static function up_file( $dir = false, $file = false) {
   if( !empty( $file["name"] ) ) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".$dir."/";
    $source = $file["tmp_name"];

   	$fname_arr = explode('.',$file["name"]); 	
	$iduser = login :: get_id_user ( );
	$file_name = $iduser.time().'.jpg';
    list($width, $height) = getimagesize($source);
    
	if( $width > $height ) {
	 $img_x = 600;
	 $img_y = 450;
	 $rotate = false;
	} else {
	 $img_x = 450;
	 $img_y = 600;
	 $rotate = true;
	}
	
	//Основное фото	
    $dist = $dir.$file_name;
	
	$new = imagecreatetruecolor($img_x, $img_y);
    $img = ImageCreateFromJpeg( $source );   
	imagecopyresized($new, $img, 0, 0, 0, 0,  $img_x, $img_y, $width, $height);
    if($rotate){
     $img = imagerotate($img, 270, 0);
    }		
	imagejpeg($new, $dist);
	
	//Превьюшка
	$dir = $_SERVER["DOCUMENT_ROOT"]."/pict/";
    $dist_pr = $dir.$file_name;

	$new_pr = imagecreatetruecolor(120, 90);
    $img_pr=ImageCreateFromJpeg( $source );   
	imagecopyresized($new_pr, $img_pr, 0, 0, 0, 0, 120, 90, $width, $height);
	imagejpeg($new_pr, $dist_pr);

	return $file_name;
   }
  }
  
  public static function del_file( $file_name = false  ) {
    $file = $_SERVER["DOCUMENT_ROOT"]."/".$file_name;
    if( file_exists( $file ) ) {
     unlink( $file );
    }
  }
  
  public static function show_image( $big_image = false ) {
  $size = getimagesize( $_SERVER["DOCUMENT_ROOT"].$big_image );
   ?>
    javascript:show('<?= $big_image ?>', '<?= $size[0]+20 ?>', '<?= $size[1]+20 ?>');   
   <?
  }
  
  //------------
  public static function number_format( $number ) {
   return  number_format($number, 2,".", " ");
  }
  
  public static function first_char( $str ) {
   $first_char = substr( $str,0,1 );
   $str_next = substr( $str,1 );
   $finish = '<span class="red_char">'.$first_char.'</span>'.$str_next;
   return $finish;
 } 
}
?>