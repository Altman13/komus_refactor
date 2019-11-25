<!-- BEGIN: MAIN -->
<h2>{KOMUS_DATA_TITLE}</h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
  <div id="load-base">
  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 
     <form action="{KOMUS_LOAD_URL}" method="post" enctype="multipart/form-data">
     <div><b>Создать поля</b></div>
     <p>&nbsp;</p>
     <div><button type="submit">Создать</button></div>     
     </form> 
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->

 <!-- BEGIN: LOADOK -->
  <p><b>Поля созданы</b></p>
 <!-- END: LOADOK -->
 
 <!-- BEGIN: LOADERROR -->
   <p><b>Поля не созданы</b></p>

 <!-- END: LOADERROR -->
 </div>    
<!-- END: MAIN -->
