<!-- BEGIN: MAIN -->
<h2>{KOMUS_OPERTOR_TITLE}</h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
  <div id="load-base">
  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 
     <form action="{KOMUS_LOAD_URL}" method="post" enctype="multipart/form-data">
     <div>Файл с операторами: <input name="fileload" type="file"></div>
     <p>&nbsp;</p>
     <div><button type="submit">Загрузить</button></div>
     </form> 
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->

 <!-- BEGIN: LOADOK -->
  
  <p>&nbsp;</p>
  <table width="350">
  <tr>
   <td><b>Логин</b></td>
   <td><b>Загружен</b></td>
   <td><b>Пароль</b></td> 
  </tr>
  <!-- BEGIN: RESULT -->
   <tr>
    <td>{KOMUS_NAME_RESULT}</td>
    <td>{KOMUS_LOAD_RESULT}</td>
    <td>{KOMUS_LOAD_PASSWORD}</td>
   </tr>
  <!-- END: RESULT -->
  </table>
 <!-- END: LOADOK -->
 
 <!-- BEGIN: LOADERROR -->
   <p><b>Файл не удалось загрузить</b></p>

 <!-- END: LOADERROR -->
 </div>    
<!-- END: MAIN -->
