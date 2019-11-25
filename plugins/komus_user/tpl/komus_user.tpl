<!-- BEGIN: MAIN -->
<script>
    $(document).ready(function() {
    	$('#statistic').datepicker({
    		changeMonth: true,
    		changeYear: true,		
    		showButtonPanel: true
    	});
    	$('#statistic_to').datepicker({
    		changeMonth: true,
    		changeYear: true,		
    		showButtonPanel: true
    	});
    	$('#free').datepicker({
    		changeMonth: true,
    		changeYear: true,		
    		showButtonPanel: true
    	});
    	$('#free_to').datepicker({
    		changeMonth: true,
    		changeYear: true,		
    		showButtonPanel: true
    	});
    });    
</script>        
<h2>Операторы/Статистика </h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
<div id="load-base">
  <!-- BEGIN: HOME --> 
    <!-- BEGIN: GRAND_OPERATOR -->     
    <form method="post" action="{KOMUS_OPERATOR_RETURN}"> 
    Дата звонка: С <input type="text" id="statistic" name="statistic" value="{KOMUS_CALLS_FILTR}" /> 
    по <input type="text" id="statistic_to" name="statistic_to" value="{KOMUS_CALLS_FILTR_TO}" />
    <input name="callsfiltr" type="hidden" value="1" />
    <input type="submit" class="submit" value="Установить" />
    </form>
    <br />
   <b>Статистика по звонкам</b>
    <table>
     <tr>   
      <th>Оператор</th> 
      <!-- BEGIN: HEADER -->
      <th>{KOMUS_STAT_TITLE}</th>
      <!-- END: HEADER --> 
      <th>Общий итог</th>    
     </tr>
     
     <!-- BEGIN: ROW_OPERATOR -->
     <tr>
       <td>{KOMUS_USER_NAME}</td>
       <!-- BEGIN: STATISTIC -->
       <td>{KOMUS_USER_STATISTIC}</td> 
       <!-- END: STATISTIC -->
       <td>{KOMUS_USER_TOTAL_USER}</td>
     </tr>
     <!-- END: ROW_OPERATOR -->
     <tr>
      <td>Общий итог</td>
      <!-- BEGIN: FOOTER -->
      <td>{KOMUS_USER_TOTAL_STATUS}</td>
      <!-- END: FOOTER --> 
      <td>{KOMUS_USER_TOTAL_ALL}</td>
     </tr>
    </table>
    
    <br /><br />
    
    <b>Статистика по базе обзвона</b>
    <table>
     <tr>   
      <th>Оператор</th> 
      <!-- BEGIN: HEADER_CONTACTS -->
      <th>{KOMUS_STAT_TITLE_CONTACTS}</th>
      <!-- END: HEADER_CONTACTS --> 
      <th>Общий итог</th>    
     </tr>
     
     <!-- BEGIN: ROW_OPERATOR_CONTACTS -->
     <tr>
       <td>{KOMUS_USER_NAME_CONTACTS}</td>
       <!-- BEGIN: STATISTIC_CONTACTS -->
       <td>{KOMUS_USER_STATISTIC_CONTACTS}</td> 
       <!-- END: STATISTIC_CONTACTS -->
       <td>{KOMUS_USER_TOTAL_USER_CONTACTS}</td>
     </tr>
     <!-- END: ROW_OPERATOR_CONTACTS -->
     <tr>
      <td>Общий итог</td>
      <!-- BEGIN: FOOTER_CONTACTS -->
      <td>{KOMUS_USER_TOTAL_STATUS_CONTACTS}</td>
      <!-- END: FOOTER_CONTACTS --> 
      <td>{KOMUS_USER_TOTAL_ALL_CONTACTS}</td>
     </tr>
    </table>
    
    <br /><br />
    <b>Не обзвоненные записи: {KOMUS_FREE_CALLS}</b>
    
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->
<!-- END: MAIN -->
</div>    

