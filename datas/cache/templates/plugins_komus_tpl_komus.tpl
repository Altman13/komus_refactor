a:1:{s:4:"MAIN";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:9:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<h2>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:11:"KOMUS_TITLE";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</h2>";}}s:5:"ERROR";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:25:"<div class="error">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:5:"Error";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:9:"ERROR_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:13:"ERROR_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}s:7:"WARNING";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:27:"<div class="warning">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:7:"Warning";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:11:"WARNING_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"WARNING_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}s:4:"DONE";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:24:"<div class="done">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:4:"Done";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:8:"DONE_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:12:"DONE_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}s:14:"CONTINUE_CALLS";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:5:{i:0;s:14:"<form action="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_NEXT_CALL_ACTION";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:53:"" method="post">
      <div class="body textcenter">";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_CONTINUE_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:198:"</div>
      <div class="textcenter"><button type="submit" name="submit" value="2">Продолжить</button> <button type="submit" name="submit" value="1">Выйти</button></div>
    </form>";}}}}s:9:"NEXT_CALL";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:5:{i:0;s:831:"<script>
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
    <form id="next_call" action="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_NEXT_CALL_ACTION";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:29:"" method="post">
      <div>";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:20:"KOMUS_HAVE_NEXT_CALL";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:336:"</div>
      <div><button type="submit" name="submit" value="1">Да</button> <button type="submit" name="submit" value="0">Нет</button></div>
      <div class="new_call_timer">До нового звонка осталось&nbsp;<span class="sec_dig">1</span> <span class="sec_str">секунд</span></div>
    </form>
  </div>";}}}}s:10:"STEP_ERROR";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:19:"<div class="error">";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:27:"KOMUS_STEP_ERROR_NO_SESSION";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:6:"</div>";}}}}s:4:"STEP";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:20:{i:0;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_RUBRICATOR";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:87:"  <script src="plugins/komus/js/komus.rubricat.js" type="text/javascript"></script>
  ";}}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:5:{i:0;s:491:"   
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
  ";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:28:"KOMUS_STEP_REQUIRED_NAMES_JS";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:4:"
  ";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:29:"KOMUS_STEP_REQUIRED_TITLES_JS";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:54:"
  
  
  
  
  $(document).ready(function(){
	  ";}}i:2;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_RUBRICATOR";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:17:"  rubricatorRun('";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_SEARCH_URL";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:8:"');
	  ";}}}}}i:3;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:2315:"    
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
  
  ";}}i:4;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_INTERRUP_CALL";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:102:"  <div id="top_buttons">
    <table>
      <tr>
        <td>
          <form id="f_break" action="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:23:"KOMUS_TOP_BUTTON_ACTION";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:156:"" method="post">
            <fieldset><legend>Выход из разговора</legend>
            <select name="status">             
              ";}}s:21:"TOP_FINISH_OPTION_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:7:{i:0;s:15:"<option value="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_TOP_FINISH_VALUE";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:1:""";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:25:"KOMUS_TOP_FINISH_SELECTED";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:1:">";i:5;O:9:"Cotpl_var":3:{s:7:" * name";s:29:"KOMUS_TOP_FINISH_OPTION_TITLE";s:7:" * keys";N;s:12:" * callbacks";N;}i:6;s:9:"</option>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:109:"</select>
            <input type="submit" value="OK" />
            <input type="hidden" name="id" value="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_TOP_FINISH_ID";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:159:"" />
            <input type="hidden" name="comment" value="" />
          </fieldset>
          </form>
        </td>
      </tr>
    </table>
  </div>";}}}}}i:5;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:86:"  
  <table id="content_wrap">
    <tr>
      <td id="content">
        
        ";}}i:6;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_CF_TABS_INFO";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:5:{i:0;s:106:"        <div id="call_info" class="body">
          <div id="additional_buttons">
             <a href="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"KOMUS_PAGE1_URL";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:88:"" rel="shadowbox">АКЦИИ</a> |&nbsp;                        
             <a href="";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"KOMUS_PAGE2_URL";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:97:"" rel="shadowbox">Адреса магазинов</a>
          </div>
        </div>
        ";}}}}}i:7;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:86:"        
        <div id="wrapper" >
        <div id="left_call">
       
        ";}}i:8;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_CF_TYPE_PROJECT";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:53:{i:0;s:64:"        <div id="left-info">  
        Клиент ФИО: <b>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:14:"KOMUS_STEP_FIO";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:62:"</b><br />               
        Полис Номер:  <b>";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:23:"KOMUS_STEP_POLICENUMBER";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:51:"</b><br />
        Продукт Номер:  <b>";i:5;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_STEP_PRODUCTNUMBER";s:7:" * keys";N;s:12:" * callbacks";N;}i:6;s:59:"</b><br />
		Продукт Наименование:  <b>";i:7;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_STEP_PRODUCTNAME";s:7:" * keys";N;s:12:" * callbacks";N;}i:8;s:32:"</b><br />
		Валюта:  <b>";i:9;O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_STEP_CURRENCY";s:7:" * keys";N;s:12:" * callbacks";N;}i:10;s:64:"</b><br />
		Договор Дата Заключения:  <b>";i:11;O:9:"Cotpl_var":3:{s:7:" * name";s:23:"KOMUS_STEP_CONTRACTDATE";s:7:" * keys";N;s:12:" * callbacks";N;}i:12;s:64:"</b><br />
		Покрытие Дата Окончания:  <b>";i:13;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_STEP_DATEEND";s:7:" * keys";N;s:12:" * callbacks";N;}i:14;s:64:"</b><br />
		Срок действия программы:  <b>";i:15;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_PERIOD";s:7:" * keys";N;s:12:" * callbacks";N;}i:16;s:56:"</b><br /><br />
		Покрытие Премия :  <b>";i:17;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_STEP_PREMIUM";s:7:" * keys";N;s:12:" * callbacks";N;}i:18;s:72:"</b><br /><br />
		Сумма выплат по дожитиям :  <b>";i:19;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"KOMUS_STEP_SUMM";s:7:" * keys";N;s:12:" * callbacks";N;}i:20;s:62:"</b><br /><br />
		Доходность текущая :  <b>";i:21;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_PROFIT";s:7:" * keys";N;s:12:" * callbacks";N;}i:22;s:59:"</b><br /><br />
		Доходность в год % :  <b>";i:23;O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_PROFITYEAR";s:7:" * keys";N;s:12:" * callbacks";N;}i:24;s:34:"</b><br /><br />
		Банк:  <b>";i:25;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"KOMUS_STEP_BANK";s:7:" * keys";N;s:12:" * callbacks";N;}i:26;s:40:"</b><br /><br />
		Сегмент:  <b>";i:27;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_STEP_SEGMENT";s:7:" * keys";N;s:12:" * callbacks";N;}i:28;s:44:"</b><br /><br />
		Стратегия:  <b>";i:29;O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_STEP_STRATEGY";s:7:" * keys";N;s:12:" * callbacks";N;}i:30;s:77:"</b><br /><br />
		Маркетинговое наименование:  <b>";i:31;O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_MARKETNAME";s:7:" * keys";N;s:12:" * callbacks";N;}i:32;s:64:"</b><br /><br />
		Регион выдачи полиса:  <b>";i:33;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_REGION";s:7:" * keys";N;s:12:" * callbacks";N;}i:34;s:62:"</b><br /><br />
		Город выдачи полиса:  <b>";i:35;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"KOMUS_STEP_CITY";s:7:" * keys";N;s:12:" * callbacks";N;}i:36;s:64:"</b><br /><br />
		Клиент Дата Рождения:  <b>";i:37;O:9:"Cotpl_var":3:{s:7:" * name";s:20:"KOMUS_STEP_BIRTHDATE";s:7:" * keys";N;s:12:" * callbacks";N;}i:38;s:72:"</b><br /><br />
		Клиент Адрес Регистрации:  <b>";i:39;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_STEP_ADDRESS";s:7:" * keys";N;s:12:" * callbacks";N;}i:40;s:70:"</b><br /><br />
		Клиент Телефон Домашний:  <b>";i:41;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_PHONE1";s:7:" * keys";N;s:12:" * callbacks";N;}i:42;s:72:"</b><br /><br />
		Клиент Телефон Мобильный:  <b>";i:43;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_PHONE2";s:7:" * keys";N;s:12:" * callbacks";N;}i:44;s:44:"</b><br /><br />
		Клиент Email:  <b>";i:45;O:9:"Cotpl_var":3:{s:7:" * name";s:16:"KOMUS_STEP_EMAIL";s:7:" * keys";N;s:12:" * callbacks";N;}i:46;s:72:"</b><br /><br />
		Офис Выдачи Наименование:  <b>";i:47;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_OFFICE";s:7:" * keys";N;s:12:" * callbacks";N;}i:48;s:86:"</b><br /><br />
		
        Статус звонка: <b><span style="color: red;">";i:49;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_STATUS";s:7:" * keys";N;s:12:" * callbacks";N;}i:50;s:96:"</span></b>&nbsp;&nbsp;&nbsp;
        Кол-во звонков: <b><span style="color: red;">";i:51;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_STEP_QUANTITY_CALL";s:7:" * keys";N;s:12:" * callbacks";N;}i:52;s:44:"</span></b><br /> 
        </div>
        ";}}}}}i:9;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:18:"        
        ";}}i:10;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_RUBRICATOR";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:78:"        <div id="rubricator">
        <h2>Рубрикатор</h2>
        ";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:16:"KOMUS_RUBRICATOR";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:26:"
        </div>
        ";}}}}}i:11;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:34:"        </div>
        
        ";}}i:12;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:21:"KOMUS_STEP_RUBRICATOR";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:587:"        <div id="right_call"><h2>Поиск</h2>
        <form method="post" id="search" action="">
        <label><b>Ведите текст для поиска:</b></label>
        <input type="text" name="search" class="input" /><br /><br />
        <input type="checkbox" name="how_search"> Найти фразу целиком
        <p class="center"><input type="submit" class="submit" value="Найти" />&nbsp;&nbsp;&nbsp;<input type="reset" class="submit" value="Очистить" /></p>
        </form>
        <div id="result_search"></div>
        </div>
        ";}}}}}i:13;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:60:"        
        <div id="center_call">
        
        ";}}i:14;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_STEP_OPERATOR_TEXT";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:52:"        <div class="body operator_text">
          ";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_STEP_OPERATOR_TEXT";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:26:"
        </div>
        ";}}}}}i:15;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:18:"        
        ";}}i:16;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_ERRORS";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:33:"        <div class="body errors">";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_STEP_ERRORS";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:16:"</div>
        ";}}}}}i:17;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:81:"      
        <div class="body abonent_answers">
                 
          ";}}s:10:"ROW_ANSWER";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:9:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:25:"<div class="answer_block"";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:28:"KOMUS_ROW_ANSWER_BLOCK_STYLE";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:15:">
            ";}}i:1;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:1:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_ROW_ANSWER_TITLE";s:7:" * keys";N;s:12:" * callbacks";N;}s:4:"prec";i:0;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:38:"            <div class="answer_title">";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_ROW_ANSWER_TITLE";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:20:"</div>
            ";}}}}}i:2;O:10:"Cotpl_data":1:{s:9:" * chunks";a:7:{i:0;s:26:"            <form action="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:23:"KOMUS_ROW_ANSWER_ACTION";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:6:"" id="";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_ROW_ANSWER_FORM_ID";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:10:"" name="f_";i:5;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_ROW_ANSWER_FORM_ID";s:7:" * keys";N;s:12:" * callbacks";N;}i:6;s:32:"" method="post">
              ";}}s:5:"FIELD";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:3:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:1:{i:0;s:12:"hidden_field";}s:12:" * callbacks";N;}s:4:"prec";i:0;}i:1;a:2:{s:3:"var";d:0;s:4:"prec";i:0;}i:2;a:2:{s:2:"op";i:21;s:4:"prec";i:4;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:49:"              <div class="field">
              ";}}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:16:"                ";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_ROW_ANSWER_FIELD";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:16:"
              ";}}i:2;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:3:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:1:{i:0;s:12:"hidden_field";}s:12:" * callbacks";N;}s:4:"prec";i:0;}i:1;a:2:{s:3:"var";d:0;s:4:"prec";i:0;}i:2;a:2:{s:2:"op";i:21;s:4:"prec";i:4;}}}s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:36:"              </div>
              ";}}}}}}}i:3;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:170:"<!--div class="field">
                Статус<sup>*</sup>
                <select name="status">
                  <option value=""></option>
                  ";}}s:17:"STATUS_OPTION_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:7:{i:0;s:15:"<option value="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:25:"KOMUS_STATUS_OPTION_VALUE";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:1:""";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:28:"KOMUS_STATUS_OPTION_SELECTED";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:1:">";i:5;O:9:"Cotpl_var":3:{s:7:" * name";s:25:"KOMUS_STATUS_OPTION_TITLE";s:7:" * keys";N;s:12:" * callbacks";N;}i:6;s:9:"</option>";}}}}i:4;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:181:"</select>
                <div id="duplicate_comment" class="field_comment">Заполните комментарий!</div>
              </div-->
              
              ";}}i:5;O:13:"Cotpl_logical":3:{s:7:" * expr";O:10:"Cotpl_expr":1:{s:9:" * tokens";a:5:{i:0;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:1:{i:0;s:7:"node_id";}s:12:" * callbacks";N;}s:4:"prec";i:0;}i:1;a:2:{s:3:"var";d:1000;s:4:"prec";i:0;}i:2;a:2:{s:2:"op";i:21;s:4:"prec";i:4;}i:3;a:2:{s:3:"var";O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:1:{i:0;s:11:"edit_access";}s:12:" * callbacks";N;}s:4:"prec";i:0;}i:4;a:2:{s:2:"op";i:11;s:4:"prec";i:6;}}}s:7:" * data";a:0:{}s:6:"blocks";a:2:{i:0;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:231:"              <div class="buttons textcenter"><button type="submit" name="submit" value="ftp">Отправить на FTP</button> <button type="submit" name="submit" value="finish">Завершить</button></div>
              ";}}}i:1;a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:136:"              <div class="buttons textcenter"><button type="submit" name="submit">Продолжить >></button></div>
              ";}}}}}i:6;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:746:"  <script type="text/javascript">
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
              <input type="hidden" name="form_id" value="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_ROW_ANSWER_FORM_ID";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:55:"" />
            </form>            
          </div>";}}}}i:18;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:146:"<div class="comment">
            Комментарий оператора:<br>
            <textarea id="comment_text" class="width90 center">";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:18:"KOMUS_STEP_COMMENT";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:327:"</textarea>
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
  </table>";}}}}s:4:"EDIT";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:8:{s:5:"ERROR";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:25:"<div class="error">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:5:"Error";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:9:"ERROR_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:13:"ERROR_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}s:7:"WARNING";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:27:"<div class="warning">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:7:"Warning";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:11:"WARNING_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:15:"WARNING_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}s:4:"DONE";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:24:"<div class="done">
	<h4>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:3:"PHP";s:7:" * keys";a:2:{i:0;s:1:"L";i:1;s:4:"Done";}s:12:" * callbacks";N;}i:2;s:11:"</h4>
	<ul>";}}s:8:"DONE_ROW";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:3:{i:0;s:4:"<li>";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:12:"DONE_ROW_MSG";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:5:"</li>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:12:"</ul>
</div>";}}}}i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:24:"<div class="body">
    ";}}s:4:"HOME";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:5:{i:0;s:12:"<p><a href="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:27:"KOMUS_EDIT_URL_LEGAL_BODIES";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:61:"">Юридические лица</a></p>
      <p><a href="";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:30:"KOMUS_EDIT_URL_PHYSICAL_BODIES";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:39:"">Физические лица</a></p>";}}}}s:13:"CONTACTS_LIST";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:541:"<script>
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
      ";}}s:11:"ROW_CONTACT";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:13:{i:0;s:51:"<tr>
        <td>[<a class="delete_contact" href="";i:1;O:9:"Cotpl_var":3:{s:7:" * name";s:24:"KOMUS_DELETE_CONTACT_URL";s:7:" * keys";N;s:12:" * callbacks";N;}i:2;s:19:"">x</a>] [<a href="";i:3;O:9:"Cotpl_var":3:{s:7:" * name";s:22:"KOMUS_EDIT_CONTACT_URL";s:7:" * keys";N;s:12:" * callbacks";N;}i:4;s:33:"">ред.</a>]</td>
        <td>";i:5;O:9:"Cotpl_var":3:{s:7:" * name";s:16:"KOMUS_CONTACT_ID";s:7:" * keys";N;s:12:" * callbacks";N;}i:6;s:19:"</td>
        <td>";i:7;O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_OPERATOR_NAME";s:7:" * keys";N;s:12:" * callbacks";N;}i:8;s:19:"</td>
        <td>";i:9;O:9:"Cotpl_var":3:{s:7:" * name";s:19:"KOMUS_CREATION_TIME";s:7:" * keys";N;s:12:" * callbacks";N;}i:10;s:38:"</td>
        <td class="textcenter">";i:11;O:9:"Cotpl_var":3:{s:7:" * name";s:17:"KOMUS_SEND_TO_FTP";s:7:" * keys";N;s:12:" * callbacks";N;}i:12;s:18:"</td>
      </tr>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:8:"</table>";}}}}s:12:"EDIT_CONTACT";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:3:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:29:"<table class="cells">
      ";}}s:9:"ROW_FIELD";O:11:"Cotpl_block":2:{s:7:" * data";a:0:{}s:6:"blocks";a:1:{i:0;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:69:"<tr>
        <td class="label"></td>
        <td></td>
      </tr>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:8:"</table>";}}}}i:1;O:10:"Cotpl_data":1:{s:9:" * chunks";a:1:{i:0;s:6:"</div>";}}}}}}}