<!-- BEGIN: MAIN -->

<h1>{KOMUS_TOP_PHONE}</h1>

  <!-- BEGIN: GUEST -->
  <div class="index_auth">
    <div class="block">
      <form name="login" action="{KOMUS_AUTH_SEND}" method="post">
        <table class="flat width100">
          <tr>
            <td class="width30">{PHP.L.komus_login}:</td>
            <td class="width70">{KOMUS_AUTH_USER}</td>
          </tr>
          <tr>
            <td>{PHP.L.Password}:</td>
            <td>{KOMUS_AUTH_PASSWORD}</td>
          </tr>
          <tr>
            <td colspan="2" class="valid"><button type="submit">{PHP.L.Login}</button></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <!-- END: GUEST -->

  <!-- BEGIN: OPERATOR -->
  <script>
  $(document).ready(function() {
  });
  </script>
  <div class="body textcenter">
    <form id="main_form" action="{KOMUS_SPLASH_ACTION}" method="post">
      <div>Ожидание...</div><br />
      <div>
        <button type="submit" name="action" value="1"><strong>Позвонить</strong></button>
        <button type="submit" name="action" value="-1">Перерыв</button>
      </div>
      
      <!-- IF {KOMUS_CF_TYPE_PROJECT} -->
      <!-- IF {KOMUS_FILTER_SHOW} -->
      <div>&nbsp;</div>
	  <div>{KOMUS_SPLASH_FILTER_REGION}&nbsp;&nbsp;&nbsp;{KOMUS_SPLASH_FILTER_SEGMENT}</div>  
      <!-- ENDIF -->
      <!-- ENDIF -->
    </form>    
    
    <!-- IF {KOMUS_CF_TYPE_PROJECT} -->
    <!-- IF {KOMUS_COUNT_SHOW} -->
    <div id="call_count">
    <table width="100%">
     <tr>
      <!-- BEGIN: COUNT_HEADER -->
      <th>{KOMUS_QUANTITY_HEADER}</th>
      <!-- END: COUNT_HEADER -->
     </tr>
     <tr>
      <!-- BEGIN: COUNT_STATUS -->
      <td>{KOMUS_QUANTITY_STATUS}</td>
      <!-- END: COUNT_STATUS -->      
     </tr>
    </table></div>
    <!-- ENDIF -->
    
    
    <!-- IF {KOMUS_CF_CALLS} --> 
    <div id="perezvon-info">
    
    <!-- IF {KOMUS_CF_CALLS_TYPE1} -->       
    <table width="100%">
    <tr>
    <!-- IF {KOMUS_CALLS_FLAG} -->
    <td stile="width: 50%;">
    <p><b>Перезвоны</b></p>
    <table width="100%">
    <tr>        
     <th>ФИО</th>
     <th>Город</th>
     <th>Когда перезвонить</th>
     <th>Комментарий</th>
     <th>Оператор</th>     
     <th>&nbsp;</th>
    </tr>
    <!-- BEGIN: CALLS -->    
    <tr>   
     <td>{KOMUS_CALLS_FIO}</td>
     <td>{KOMUS_CALLS_CITY}</td>
     <td>{KOMUS_CALLS_RECALL}</td>
     <td>{KOMUS_CALLS_COMMENT}</td>
     <td>{KOMUS_OPERATOR_NAME}</td>
     <td><a href="{KOMUS_CALLS_URL}">Перезвонить</a></td>
    </tr>
    <!-- END: CALLS -->
    </table>   
    </td>
    <!-- ENDIF -->
        
    <!-- IF {KOMUS_NOCALLS_FLAG} -->
    <td stile="width: 50%;">
    <p><b>Недозвоны</b></p>
    <table width="100%">
    <tr>        
     <th>ФИО</th>
     <th>Город</th>
     <th>Дата звонка</th>
     <th>Статус</th>
     <th>Комментарий</th>
     <th>Оператор</th>     
     <th>&nbsp;</th>
    </tr>
    <!-- BEGIN: NOCALLS -->    
    <tr>   
     <td>{KOMUS_NOCALLS_FIO}</td>
     <td>{KOMUS_NOCALLS_CITY}</td>
     <td>{KOMUS_NOCALLS_RECALL}</td>
     <td>{KOMUS_NOCALLS_STATUS} {KOMUS_NOCALLS_QANTITY}</td>
     <td>{KOMUS_NOCALLS_COMMENT}</td>
     <td>{KOMUS_NOOPERATOR_NAME}</td>
     <td><a href="{KOMUS_NOCALLS_URL}">Перезвонить</a></td>
    </tr>
    <!-- END: NOCALLS -->
    </table>
    </td>
    <!-- ENDIF -->
    
    </tr>
    </table> 
    <!-- ENDIF -->         
     
    <!-- IF {KOMUS_CF_CALLS_TYPE2} -->  
     <form action="/index.php" method="post">
     <table border="0">
     <tr>
      <td><b>Статус звонка:</b> {KOMUS_SPLASH_STATUS}</td>      
      <td><input type="submit" value="Установить" /></td>
     </tr>
     </table>
    </form>
    
    <p>&nbsp;</p>
    <table width="100%">
    <tr>        
     <th>Название</th>
     <th>Телефон</th>
     <th>Дата звонка</th>
     <th>Когда перезвонить</th>
     <th>Комментарий</th>
     <th>Оператор</th>     
     <th>&nbsp;</th>
    </tr>
    <!-- BEGIN: CALLS2 -->    
    <tr>   
     <td>{KOMUS_CALLS_COMPANY}</td>
     <td>{KOMUS_CALLS_PHONE}</td>
     <td>{KOMUS_CALLS_CALL}</td>
     <td>{KOMUS_CALLS_RECALL}</td>
     <td>{KOMUS_CALLS_COMMENT}</td>
     <td>{KOMUS_OPERATOR_NAME}</td>
     <td><a href="{KOMUS_CALLS_URL}">Перезвонить</a></td>
    </tr>
    <!-- END: CALLS2 -->
    </table>  
    <!-- ENDIF -->

    <!-- IF {KOMUS_CF_CALLS_TYPE3} -->  
     <form action="/index.php" method="post">
     <table border="0">
     <tr>
	  <td><b>Оператор:</b> {KOMUS_OPERATOR_FILTR}</td>
      <td><b>Статус звонка:</b> {KOMUS_SPLASH_STATUS}</td>      
      <td><input type="submit" value="Установить" /></td>
     </tr>
     </table>
    </form>
    
    <p>&nbsp;</p>
    <table width="100%">
    <tr>        
     <th>Ф.И.О.</th>
     <th>Телефон</th>
     <th>Дата звонка</th>
     <th>Когда перезвонить</th>
     <th>Комментарий</th>
     <th>Оператор</th>     
     <th>&nbsp;</th>
    </tr>
    <!-- BEGIN: CALLS3 -->    
    <tr style="color: {KOMUS_CALLS_STYLE_EXPIRED}">   
     <td>{KOMUS_CALLS_FIO}</td>
     <td>{KOMUS_CALLS_PHONE}</td>
     <td>{KOMUS_CALLS_CALL}</td>
     <td>{KOMUS_CALLS_RECALL}</td>
     <td>{KOMUS_CALLS_COMMENT}</td>
     <td>{KOMUS_OPERATOR_NAME}</td>
     <td><a href="{KOMUS_CALLS_URL}">Перезвонить</a></td>
    </tr>
    <!-- END: CALLS3 -->
    </table>  
    <!-- ENDIF -->

	
    </div>
    <!-- ENDIF -->
    <!-- ENDIF -->
  </div>
  <!-- END: OPERATOR -->

<!-- END: MAIN -->
