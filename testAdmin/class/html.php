<?
class HTML { 
 //Постраничное разбиение
 public static function pages( $offset = 0, $count = 0, $pages = 0, $href ="") {
  $num=1;
  for($i=0; $i<$count; $i=$i+$offset) {
   if($pages==$i)
     $link.= $num."&nbsp;";
   else	 
     $link.= "<a href=\"".$href."pages=".($i)."\">".$num."</a>&nbsp;";
   $num++;
  }
  return $link;
  }
  
  public static function pages_ext( $offset = 0, $count = 0, $group = 0 , $pages = 0, $href ="") {
  $number_page=1;
  $num_group = 1;
  $num = 1;
  
  for($i=0; $i<$count; $i=$i+$offset) {
    
   if($pages==$i) {
     $link[$num_group]["link"].= $number_page."&nbsp;";
     $link[$num_group]["page"] =$i;
   } else {	 
     $link[$num_group]["link"].= "<a href=\"".$href."pages=".($i)."\">".$number_page."</a>&nbsp;";
     $link[$num_group]["page"] =$i;
   }
     
  $number_page++;
   
    if( ($number_page% $group) == 0  ) {
        $num_group++;
   }
    
  }
  
  if( !empty( $link ) ) {
   foreach( $link as $key =>$item ) {
    if( $pages <= $item["page"] ) break; 
   }
  }
  
  //Движение в правую сторону
  if( isset( $link[$key+1] ) ) {
   $link[$key]["link"] .= "<a href=\"".$href."pages=".($link[$key]["page"] + $offset)."\"> ... </a>&nbsp;";
  }
  
  if( ($pages +$offset) < $count ) {
   $link[$key]["link"] .= "<a href=\"".$href."pages=".($pages + $offset)."\"> >> </a>&nbsp;";
  }
  
  //Движение в левую сторону
  if( isset( $link[$key-1] ) ) {
   $link[$key]["link"] = "<a  href=\"".$href."pages=".($link[$key-1]["page"] )."\"> ... </a>&nbsp;".$link[$key]["link"] ;
  }
  
  if( $pages > 0) {
  $link[$key]["link"] = "<a  href=\"".$href."pages=".($pages - $offset )."\"> << </a>&nbsp;".$link[$key]["link"];
  }
  
  return $link[$key]["link"];
  }
  
  //----------------------------------------
public static function tree_list( $data = false, $id = "id_navigation"  ){
 $count = 0;
 $data_tree = array();
 $data_tmp = array();
 
 foreach( $data as $item) {
  if( $item["id_subs"] == 0 ) {
   $_tmp[$id] = $item[$id];
   $_tmp["name"] = $item["name"];
   $_tmp["id_subs"] = $item["id_subs"];
   $_tmp["separator"] = "";
   $data_tmp[]= $_tmp;
  } 
 }
  
 foreach(  $data_tmp as $item ) {
  $data_tree[] = $item;
  HTML :: tree_recur(  $data , $item, $data_tree, $id);
 } 
 return $data_tree;
}

 public static function tree_recur(  $data , $item,  &$data_tree, $id ) {
  
   foreach( $data as $item_all) {
    if( $item_all["id_subs"] == $item[$id] ) {
     $_tree[$id] = $item_all[$id];
     $_tree["name"] =  "--".$item["separator"].$item_all["name"];
     $_tree["id_subs"] = $item_all["id_subs"];
     $_tree["separator"] = "--".$item["separator"];
     $data_tree[] = $_tree;
     
     HTML :: tree_recur($data , $_tree, $data_tree, $id);
    }
   }
 }
//-------------------------------------------------- 
 //Хлебные крошки( админка)
  public static function _links( $parent_nav = false, $mapper = false, $href = false, $id = "id_navigation" ) {
   $id_subs = $parent_nav -> id_subs;
   $links = '<a href="index.php?menu='.$href.'&item_id=0">Главный</a>';
   while ( $id_subs != 0 ) {
    $parent = $mapper -> FindById( $id_subs );
    $id_subs = $parent -> id_subs;
    $link_arr[] = '<b> :: </b><a href="index.php?menu='.$href.'&item_id='.$parent -> $id.'">'.$parent ->name.'</a>'; 
   }
   
   if( count( $link_arr ) > 0) {
   $result = array_reverse( $link_arr );
   foreach( $result as $item )
    $links .= $item;
   }
   return $links;
  }
  
 //--------------Цепь ссылок
 public static function cep_navigation ( $nav, $param, $top_punkt ){
 
 $link='<ul id="breead_crumbs"><li class="first"><a  href="/">Главная</a></li>';
 $link .='<li class="next"><a href="/'.$top_punkt -> url.'/">'.$top_punkt -> name.'</a></li>';
 if( count( $nav) >0 && $nav != false){ 
  foreach( $nav[ Parce_uri :: get_url_bylevel( $param ) ] as $item ) {
   if( $item["select"] ) {
    $link .= '<li class="next"><a href="/'.$item["url"].'">'.$item["name"].'</a></li>';
    if( count( $nav[$item["this_url"]] ) >0 )  
     $link .= HTML :: recurs_cep_navigation ( $nav,$item["this_url"] );
   } 
  }
  } 
  $link .='</ul>';
  return $link; 
 } 
 
 public static function recurs_cep_navigation ( $nav, $url ){
  foreach( $nav[$url] as $item ) {
   if( $item["select"] ) {
    $link .= '<li class="next"><a href="/'.$item["url"].'">'.$item["name"].'</a></li>';
 
    if( count( $nav[$item["this_url"]] ) >0 )   
     $link .= HTML :: recurs_cep_navigation ( $nav,$item["this_url"] );
   }
  } 
  return $link;
 } 
 
 //-----------------------------------------------------------
 public static function metatags( $data = false, &$param ) {
  if( !empty( $data -> meta_title ) ) {
   $param["meta_title"]       .= ". ".$data -> meta_title;
  }
  if( !empty( $data -> meta_keywords ) ) {
   $param["mata_description"] .= ". ".$data ->  meta_description;
  }
  if( !empty( $data -> meta_description ) ) {
   $param["mata_keyword"]     .= " ".$data -> meta_keywords;
  }
 }
}  