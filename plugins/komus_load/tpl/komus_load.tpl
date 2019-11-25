<!-- BEGIN: MAIN -->
<h2>{KOMUS_LOAD_TITLE}</h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
  <div id="load-base">
  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 
     <form action="{KOMUS_LOAD_URL}" method="post" enctype="multipart/form-data">
     <div>Файл базы: <input name="fileload" type="file"></div>
     <p>&nbsp;</p>
     <div><button type="submit">Загрузить</button></div>
     <div>&nbsp;</div>
     <div><a href="datas/users/example.xls">Формат файла загрузки</a></div>
     </form> 
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->

 <!-- BEGIN: LOADOK -->
  <p><b>База загружена</b></p>
 <!-- END: LOADOK -->
 
 <!-- BEGIN: LOADERROR -->
   <p><b>Файл не удалось загрузить</b></p>

 <!-- END: LOADERROR -->
 </div>    
<!-- END: MAIN -->
