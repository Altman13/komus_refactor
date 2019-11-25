<!-- BEGIN: MAIN -->
<h2>{KOMUS_STAT_TITLE}</h2> 
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 

    <!-- IF {KOMUS_STAT_SHOW} -->
    <div id="call_count_stat">
    <table width="100%">
     <tr>
      <!-- BEGIN: STAT_HEADER -->
      <th>{KOMUS_STAT_QUANTITY_HEADER}</th>
      <!-- END: STAT_HEADER -->
     </tr>
	 <!-- BEGIN: STAT_ROW -->
     <tr>
      <!-- BEGIN: STATISTIC -->
      <td>{KOMUS_STAT_QUANTITY_STATUS}</td>
      <!-- END: STATISTIC -->      
     </tr>
	 <!-- END: STAT_ROW -->
     <tr>
       <td>Общий итог</td>
	   <!-- BEGIN: STAT_FOOTER -->
	   <td>{KOMUS_STAT_TOTAL_STATUS}</td>
	   <!-- END: STAT_FOOTER -->
     </tr>	 
    </table></div>
    <!-- ENDIF -->	
	
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->
 
<!-- END: MAIN -->
