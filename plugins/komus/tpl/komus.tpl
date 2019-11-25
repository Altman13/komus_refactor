<!-- BEGIN: MAIN -->

<h2>{KOMUS_TITLE}</h2>
{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

  <!-- BEGIN: CONTINUE_CALLS -->
    <form action="{KOMUS_NEXT_CALL_ACTION}" method="post">
      <div class="body textcenter">{KOMUS_CONTINUE_MSG}</div>
      <div class="textcenter"><button type="submit" name="submit" value="2">Продолжить</button> <button type="submit" name="submit" value="1">Выйти</button></div>
    </form>
  <!-- END: CONTINUE_CALLS -->
  
  <!-- BEGIN: NEXT_CALL -->
  <script>
    $(document).ready(function() {
        var timetogo = 1;
        var timer = window.setInterval(function() {
            var str = timetogo;
            if (str == 1) {
                var secStr = 'секунда';
            } else if (str == 2 || str == 3 || str == 4) {
                var secStr = 'секунды';
            } else {
                var secStr = 'секунд';
            }
            $('.new_call_timer .sec_dig').text(str);
            $('.new_call_timer .sec_str').text(secStr);
            if (timetogo <= 0) {
                 document.location.href = '/index.php';
                 window.clearInterval(timer);
            }
            timetogo--;
        }, 1000);
        
    });
  </script>
  
  <div class="next_call">
    <form id="next_call" action="{KOMUS_NEXT_CALL_ACTION}" method="post">
      <div>{KOMUS_HAVE_NEXT_CALL}</div>
      <div><button type="submit" name="submit" value="1">Да</button> <button type="submit" name="submit" value="0">Нет</button></div>
      <div class="new_call_timer">До нового звонка осталось&nbsp;<span class="sec_dig">1</span> <span class="sec_str">секунд</span></div>
    </form>
  </div>
  <!-- END: NEXT_CALL -->

  <!-- BEGIN: STEP_ERROR -->
  <div class="error">{KOMUS_STEP_ERROR_NO_SESSION}</div>
  <!-- END: STEP_ERROR -->

  <!-- BEGIN: STEP -->
  
  <!-- IF {KOMUS_STEP_RUBRICATOR} -->
  <script src="plugins/komus/js/komus.rubricat.js" type="text/javascript"></script>
  <!-- ENDIF -->
   
   <!--Календарик: -->
   <link type="text/css" rel="stylesheet" href="jscal/jscal2.css" />
    <link type="text/css" rel="stylesheet" href="/jscal/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="/jscal/gold.css" />
    <script src="jscal/jscal2.js"></script>
    <script src="jscal/ru.js"></script>
	<script src="jscal/date.format.js"></script>
	
			   
			   
    <script>
  var requiredNames = Array();
  var requiredTitles = Array();
  {KOMUS_STEP_REQUIRED_NAMES_JS}
  {KOMUS_STEP_REQUIRED_TITLES_JS}
  
  
  
  
  $(document).ready(function(){
	  <!-- IF {KOMUS_STEP_RUBRICATOR} -->
	  rubricatorRun('{KOMUS_STEP_SEARCH_URL}');
	  <!-- ENDIF -->    
      $('form').submit(function() {
           var comment = $('#comment_text').val();
           $('input[name="comment"]').val(comment);
      });

      $('.answer_block form').submit(function() { 
          var errorsList = $.requiredFields(requiredNames, requiredTitles);

          if (errorsList != '') {
              alert(errorsList);
              return false;
          }

      });
	 
	$('select[name="status1"]').change(function() {
	 if ($(this).val() == 110 /* дозвон */) {
	   $('select[name="status2"]').parent().show(200);
	 }
	 else { $('select[name="status2"]').parent().hide(); }
	$('select[name="status2"]').change();
	$('select[name="status3"]').change();
	$('select[name="status4"]').change();
	});
	$('select[name="status1"]').change();
	
	$('select[name="status2"]').change(function() {
	 if ($(this).val() == 117 /* Контакт установлен с клиентом */) {
	   $('select[name="status3"]').parent().show(200);
	   $('select[name="tech1"]').parent().show(200);
	   $('select[name="tech2"]').parent().show(200);
	   $('select[name="tech3"]').parent().show(200);
	 }
	 else { $('select[name="status3"]').parent().hide();
		$('select[name="tech1"]').parent().hide();
	   $('select[name="tech2"]').parent().hide();
	   $('select[name="tech3"]').parent().hide();

	 }
	$('select[name="status3"]').change();
	$('select[name="status4"]').change();
	});
	$('select[name="status2"]').change();
	 	
	 $('select[name="status3"]').change(function() {
	 if ($(this).val() == 121 /* Презентация состоялась */) {
	   $('select[name="status4"]').parent().show(200);
	 }
	 else { $('select[name="status4"]').parent().hide(); }
	});
	$('select[name="status3"]').change();
	 
 $('select[name="status4"]').change(function() {
	 if ($(this).val() == 138 /* Другое */) {
	   $('input[name="status4txt"]').parent().parent().show(200);
	 }
	 else { $('input[name="status4txt"]').parent().parent().hide(); }
	 
	 if ($(this).val() == 125 /* Согласие на встречу */) {
	   $('input[name="date_meat"]').parent().show(200);
	 }
	 else {  $('input[name="date_meat"]').parent().hide(); 
	 }
	 
	});
	$('select[name="status4"]').change();
	 		 
	 
  }); 
  </script>
  
  <!-- IF {KOMUS_INTERRUP_CALL} -->
  <div id="top_buttons">
    <table>
      <tr>
        <td>
          <form id="f_break" action="{KOMUS_TOP_BUTTON_ACTION}" method="post">
            <fieldset><legend>Выход из разговора</legend>
            <select name="status">             
              <!-- BEGIN: TOP_FINISH_OPTION_ROW -->
              <option value="{KOMUS_TOP_FINISH_VALUE}"{KOMUS_TOP_FINISH_SELECTED}>{KOMUS_TOP_FINISH_OPTION_TITLE}</option>
              <!-- END: TOP_FINISH_OPTION_ROW -->
            </select>
            <input type="submit" value="OK" />
            <input type="hidden" name="id" value="{KOMUS_TOP_FINISH_ID}" />
            <input type="hidden" name="comment" value="" />
          </fieldset>
          </form>
        </td>
      </tr>
    </table>
  </div>
  <!-- ENDIF -->
  
  <table id="content_wrap">
    <tr>
      <td id="content">
        
        <!-- IF {KOMUS_CF_TABS_INFO} -->
        <div id="call_info" class="body">
          <div id="additional_buttons">
             <a href="{KOMUS_PAGE1_URL}" rel="shadowbox">АКЦИИ</a> |&nbsp;                        
             <a href="{KOMUS_PAGE2_URL}" rel="shadowbox">Адреса магазинов</a>
          </div>
        </div>
        <!-- ENDIF -->
        
        <div id="wrapper" >
        <div id="left_call">
       
        <!-- IF {KOMUS_CF_TYPE_PROJECT} -->
        <div id="left-info">  
        Клиент ФИО: <b>{KOMUS_STEP_FIO}</b><br />               
        Полис Номер:  <b>{KOMUS_STEP_POLICENUMBER}</b><br />
        Продукт Номер:  <b>{KOMUS_STEP_PRODUCTNUMBER}</b><br />
		Продукт Наименование:  <b>{KOMUS_STEP_PRODUCTNAME}</b><br />
		Валюта:  <b>{KOMUS_STEP_CURRENCY}</b><br />
		Договор Дата Заключения:  <b>{KOMUS_STEP_CONTRACTDATE}</b><br />
		Покрытие Дата Окончания:  <b>{KOMUS_STEP_DATEEND}</b><br />
		Срок действия программы:  <b>{KOMUS_STEP_PERIOD}</b><br /><br />
		Покрытие Премия :  <b>{KOMUS_STEP_PREMIUM}</b><br /><br />
		Сумма выплат по дожитиям :  <b>{KOMUS_STEP_SUMM}</b><br /><br />
		Доходность текущая :  <b>{KOMUS_STEP_PROFIT}</b><br /><br />
		Доходность в год % :  <b>{KOMUS_STEP_PROFITYEAR}</b><br /><br />
		Банк:  <b>{KOMUS_STEP_BANK}</b><br /><br />
		Сегмент:  <b>{KOMUS_STEP_SEGMENT}</b><br /><br />
		Стратегия:  <b>{KOMUS_STEP_STRATEGY}</b><br /><br />
		Маркетинговое наименование:  <b>{KOMUS_STEP_MARKETNAME}</b><br /><br />
		Регион выдачи полиса:  <b>{KOMUS_STEP_REGION}</b><br /><br />
		Город выдачи полиса:  <b>{KOMUS_STEP_CITY}</b><br /><br />
		Клиент Дата Рождения:  <b>{KOMUS_STEP_BIRTHDATE}</b><br /><br />
		Клиент Адрес Регистрации:  <b>{KOMUS_STEP_ADDRESS}</b><br /><br />
		Клиент Телефон Домашний:  <b>{KOMUS_STEP_PHONE1}</b><br /><br />
		Клиент Телефон Мобильный:  <b>{KOMUS_STEP_PHONE2}</b><br /><br />
		Клиент Email:  <b>{KOMUS_STEP_EMAIL}</b><br /><br />
		Офис Выдачи Наименование:  <b>{KOMUS_STEP_OFFICE}</b><br /><br />
		
        Статус звонка: <b><span style="color: red;">{KOMUS_STEP_STATUS}</span></b>&nbsp;&nbsp;&nbsp;
        Кол-во звонков: <b><span style="color: red;">{KOMUS_STEP_QUANTITY_CALL}</span></b><br /> 
        </div>
        <!-- ENDIF -->
        
        <!-- IF {KOMUS_STEP_RUBRICATOR} -->
        <div id="rubricator">
        <h2>Рубрикатор</h2>
        {KOMUS_RUBRICATOR}
        </div>
        <!-- ENDIF -->
        </div>
        
        <!-- IF {KOMUS_STEP_RUBRICATOR} -->
        <div id="right_call"><h2>Поиск</h2>
        <form method="post" id="search" action="">
        <label><b>Ведите текст для поиска:</b></label>
        <input type="text" name="search" class="input" /><br /><br />
        <input type="checkbox" name="how_search"> Найти фразу целиком
        <p class="center"><input type="submit" class="submit" value="Найти" />&nbsp;&nbsp;&nbsp;<input type="reset" class="submit" value="Очистить" /></p>
        </form>
        <div id="result_search"></div>
        </div>
        <!-- ENDIF -->
        
        <div id="center_call">
        
        <!-- IF {KOMUS_STEP_OPERATOR_TEXT} -->
        <div class="body operator_text">
          {KOMUS_STEP_OPERATOR_TEXT}
        </div>
        <!-- ENDIF -->
        
        <!-- IF {KOMUS_STEP_ERRORS} -->
        <div class="body errors">{KOMUS_STEP_ERRORS}</div>
        <!-- ENDIF -->
      
        <div class="body abonent_answers">
                 
          <!-- BEGIN: ROW_ANSWER -->
          <div class="answer_block"{KOMUS_ROW_ANSWER_BLOCK_STYLE}>
            <!-- IF {KOMUS_ROW_ANSWER_TITLE} -->
            <div class="answer_title">{KOMUS_ROW_ANSWER_TITLE}</div>
            <!-- ENDIF -->
            <form action="{KOMUS_ROW_ANSWER_ACTION}" id="{KOMUS_ROW_ANSWER_FORM_ID}" name="f_{KOMUS_ROW_ANSWER_FORM_ID}" method="post">
              <!-- BEGIN: FIELD -->
              <!-- IF {PHP.hidden_field} == 0 -->
              <div class="field">
              <!-- ENDIF -->
                {KOMUS_ROW_ANSWER_FIELD}
              <!-- IF {PHP.hidden_field} == 0 -->
              </div>
              <!-- ENDIF -->
              <!-- END: FIELD -->
             
              <!--div class="field">
                Статус<sup>*</sup>
                <select name="status">
                  <option value=""></option>
                  <!-- BEGIN: STATUS_OPTION_ROW -->
                  <option value="{KOMUS_STATUS_OPTION_VALUE}"{KOMUS_STATUS_OPTION_SELECTED}>{KOMUS_STATUS_OPTION_TITLE}</option>
                  <!-- END: STATUS_OPTION_ROW -->
                </select>
                <div id="duplicate_comment" class="field_comment">Заполните комментарий!</div>
              </div-->
              
              <!-- IF {PHP.node_id} == 1000 AND {PHP.edit_access} -->
              <div class="buttons textcenter"><button type="submit" name="submit" value="ftp">Отправить на FTP</button> <button type="submit" name="submit" value="finish">Завершить</button></div>
              <!-- ELSE -->
              <div class="buttons textcenter"><button type="submit" name="submit">Продолжить >></button></div>
              <!-- ENDIF -->

			  <script type="text/javascript">
			 var cal = Calendar.setup({
				    showTime: true,
										
				onTimeChange  : function(cal) {
					var h = cal.getHours(), m = cal.getMinutes();
					if (h < 10) h = "0" + h;
					if (m < 10) m = "0" + m;
					DateStr = $("#date_meat").val();
					var Pos = DateStr.indexOf(' ');
					if (Pos > 0) {
						DateStr = DateStr.substring(0,Pos); 
						$("#date_meat").val(DateStr+' '+h+':'+m);
					}
				},				
				    trigger    : "date_meat_img",
				    inputField : "date_meat",
					dateFormat : "%d.%m.%Y %k:%M"
				});
								
              </script>
	   
              <input type="hidden" name="comment" value="" />
              <input type="hidden" name="form_id" value="{KOMUS_ROW_ANSWER_FORM_ID}" />
            </form>            
          </div>
          <!-- END: ROW_ANSWER -->
        <div class="comment">
            Комментарий оператора:<br>
            <textarea id="comment_text" class="width90 center">{KOMUS_STEP_COMMENT}</textarea>
          </div>         
        <div class="service_info">
          <div><span class="label"></div>
        </div>

          <div class="clear"></div>
          
        </div>
       
       </div>      
        <div class="clear"></div> 
       </div>
        
      </td>
    </tr>
  </table>
  <!-- END: STEP -->
  


  <!-- BEGIN: EDIT -->  
  {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

    <div class="body">
    <!-- BEGIN: HOME -->
      <p><a href="{KOMUS_EDIT_URL_LEGAL_BODIES}">Юридические лица</a></p>
      <p><a href="{KOMUS_EDIT_URL_PHYSICAL_BODIES}">Физические лица</a></p>
    <!-- END: HOME -->
     
    <!-- BEGIN: CONTACTS_LIST -->  
    <script>
        $(document).ready(function(){
            $('a.delete_contact').click(function() {
                if (!confirm('Вы действительно хотите удалить контакт?')) {
                    return false;
                }
            });
        });
    </script>
    <table class="cells">
      <tr>
        <th></th>
        <th>ID</th>
        <th>Оператор</th>
        <th>Время создания</th>
        <th>Отправлено на FTP</th>
      </tr>
      <!-- BEGIN: ROW_CONTACT -->
      <tr>
        <td>[<a class="delete_contact" href="{KOMUS_DELETE_CONTACT_URL}">x</a>] [<a href="{KOMUS_EDIT_CONTACT_URL}">ред.</a>]</td>
        <td>{KOMUS_CONTACT_ID}</td>
        <td>{KOMUS_OPERATOR_NAME}</td>
        <td>{KOMUS_CREATION_TIME}</td>
        <td class="textcenter">{KOMUS_SEND_TO_FTP}</td>
      </tr>
      <!-- END: ROW_CONTACT -->
    </table>
    <!-- END: CONTACTS_LIST -->  

    <!-- BEGIN: EDIT_CONTACT -->
    <table class="cells">
      <!-- BEGIN: ROW_FIELD -->
      <tr>
        <td class="label"></td>
        <td></td>
      </tr>
      <!-- END: ROW_FIELD -->
    </table>
    <!-- END: EDIT_CONTACT -->

    </div>
  <!-- END: EDIT -->  


<!-- END: MAIN -->
