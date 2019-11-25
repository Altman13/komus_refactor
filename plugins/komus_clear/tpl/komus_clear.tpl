<!-- BEGIN: MAIN -->
<h2>{KOMUS_LOAD_TITLE}</h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
  <div id="load-base">
  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 
     <script>
     $(document).ready(function(){
      
      $('#load-base form').submit(function() { 
    	  if (confirm("Удалить записи?")) return true;
		  return false;
      });
  }); 
  </script>
     <form action="{KOMUS_LOAD_URL}" method="post">
     <p><b>Удалить записи из базы</b></p>
     <p>&nbsp;</p>
     <table style="margin:0 auto;">
     <tr>
      <td><label for="id_begin">c:</label></td>
      <td><input class="text" type="text" name="id_begin" id="id_begin" /></td>
     </tr>
     <tr>
     <td><label for="id_end">по:</label></td>
     <td><input class="text" type="text" name="id_end" id="id_end" /></td>
     </tr>
     </table>
     <p>&nbsp;</p>
     <div><button type="submit">Удалить</button></div>
     </form> 
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->

 <!-- BEGIN: LOADOK -->
  <p><b>Записи удалены</b></p>
 <!-- END: LOADOK -->
 
 <!-- BEGIN: LOADERROR -->
   <p><b>Удалить не удалось</b></p>

 <!-- END: LOADERROR -->
 </div>    
<!-- END: MAIN -->
