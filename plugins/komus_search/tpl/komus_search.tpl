<!-- BEGIN: MAIN -->
<h2>{KOMUS_SEARCH_TITLE}&nbsp;&nbsp;&nbsp;<a href="plug.php?e=komus_search&mode=search">Список</a></a></h2>    
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
   <div id="search"> 
  <!-- BEGIN: HOME -->

    <!-- BEGIN: GRAND_OPERATOR --> 
  
    <div id="search-form">
    <form method="post" action="{KOMUS_SEARCH_URL}">    
     <p><label for="id_contact">№ id:</label><input class="text" type="text" name="id_base" id="id_base" /></p>    	 
	 <p class="center"><input type="submit" class="submit" value="Найти" /></p>  
    </form>
   </div>
 
    <!-- END: GRAND_OPERATOR -->
  
    <!-- BEGIN: OPERATOR -->
    <!-- END: OPERATOR -->

 <!-- END: HOME -->
 
 <!-- BEGIN: SEARCH_RESULT --> 
  <p class="content"><b>Результаты поиска по запросу: {KOMUS_SEARCH_ZAPROS}</b></p>
  <!-- IF {PHP.count_search} == 0 -->
  <p class="content"><b>Ничего не найдено</b></p>
  <p>&nbsp;</p>
  <!-- ENDIF -->
  
  <!-- IF {PHP.count_search} >= 1 -->  
   <!-- BEGIN: ROW_SEARCH -->
  <table class="search">
   <tr>
    <th>№ id</th>
    <th>Статус звонка</th>
    <th>Дата звонка</th>
    <th>Время звонка</th>
    <th>Статус записи</th>
    <th>&nbsp;</th>   
    <th>&nbsp;</th>
   </tr>
    <tr>
    <td>{KOMUS_SEARCH_ID_ROW}</td>
    <td>{KOMUS_SEARCH_STATUS_ROW}</td>
    <td>{KOMUS_SEARCH_DATE_ROW}</td>
    <td>{KOMUS_SEARCH_TIME_ROW}</td>
    <td>{KOMUS_SEARCH_IS_BLOCK_ROW}</td>
              
   <!-- IF {PHP.gr_operator_access} -->
    <td><a href="{KOMUS_SEARCH_URL_EDIT}"><b>Вернуть в обзвон</b></a></td>
    <td><a href="{KOMUS_SEARCH_URL_CHANGE}"><b>Редактировать</b></a></td>  
    <!-- ENDIF -->
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <!-- END: ROW_SEARCH -->
  <!-- ENDIF -->
  <h2><a href="{KOMUS_SEARCH_URL_RETURN}">Продолжить поиск</a></h2>  
  <!-- END: SEARCH_RESULT -->
 
  <!-- BEGIN: SEARCH_OK --> 
  <div id="search-form">
  <p>&nbsp;</p>
  <p class="content"><b>Запись возвращена</b></p>
  <p>&nbsp;</p>
  </div>
  <h2><a href="{KOMUS_SEARCH_URL_RETURN}">Продолжить поиск</a></h2>  
  <!-- END: SEARCH_OK -->
  
  <!-- BEGIN: CHANGE -->
  
    <div id="search-form">
    <p class="content"><b>Результаты поиска по запросу: Id {KOMUS_SEARCH_ID_ROW}</b></p>
    <p>&nbsp;</p>
    <form method="post" action="{KOMUS_SAVE_URL}" class="width700"> 
     <input type="hidden" name="id" value="{KOMUS_SEARCH_ID_ROW}" />        
     
     <p><label for="status" class="width200">Статус звонка</label>
     <select name="status" id="status" class="width200">{KOMUS_SEARCH_STATUS_ROW}</select></p>
     
	 <p><label for="comment" class="width200">Комментарий</label>
	 <textarea rows="5" cols="70" name="comment">{KOMUS_SEARCH_COMMENT_ROW}</textarea></p>
	 
     <p class="center"><input type="submit" class="submit" value="Сохранить" /></p>  
    </form>
   </div>
    <h2><a href="{KOMUS_SEARCH_URL_RETURN}">Продолжить поиск</a></h2>
 
 <!-- END: CHANGE -->
  
 </div>
 <!-- END: MAIN -->