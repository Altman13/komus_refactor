<!-- BEGIN: FOOTER -->

	</div>

	<div id="footer" class="body clear">
		<ul id="account">
<!-- BEGIN: GUEST -->
			<li><strong>{PHP.L.hea_youarenotlogged}</strong></li>
			<li><a href="users.php?m=auth">{PHP.L.Login}</a></li>
			<li><a href="users.php?m=register">{PHP.L.Register}</a></li>
<!-- END: GUEST -->
<!-- BEGIN: USER -->
			<li><strong>{PHP.usr.name} <!-- IF {PHP.usr.maingrp} == 5 OR {PHP.usr.maingrp} == 6  --> &nbsp; [ <a href="admin.php" class="lower">{PHP.L.Adminpanel}</a> ] &nbsp; [ <a href="plug.php?e=komus_reports" class="lower">Отчеты</a> ]
			 &nbsp; 
			 <!-- IF {FOOTTER_CF_PROJECT_TYPE} -->
			 [ <a href="plug.php?e=komus_load" class="lower">Загрузка базы</a> ] &nbsp; 
			 [ <a href="plug.php?e=komus_search" class="lower">Поиск</a> ] &nbsp; 
			 [ <a href="plug.php?e=komus_stat&item=1" class="lower">Статистика по фильтру</a> ] &nbsp; 
			 [ <a href="plug.php?e=komus_clear">Очистка базы</a> ] &nbsp; 
			 [ <a href="plug.php?e=komus_user">Статистика</a> ]
			 <!-- ENDIF -->
			 <!-- IF {PHP.usr.maingrp} == 5 -->
			 [ <a href="plug.php?e=komus_data" class="lower">Поля</a> ]
			 [ <a href="plug.php?e=komus_operator" class="lower">Импорт операторов</a> ]
			 <!-- ENDIF -->
			 <!-- ENDIF --></strong></li>
			 <li>
			 <!-- IF {PHP.usr.maingrp} == 4 OR {PHP.usr.maingrp} == 6  -->
				<!--<a href="/datas/users/business.doc">_Бизнес Завтрак - Турандот- краткое описание мероприятия</a>
				&nbsp;&nbsp;<a href="/datas/users/calls.xlsx">Приоритет по обзвону</a>
				&nbsp;&nbsp;<a href="/datas/users/script.doc">Скрипт_Диона Холдинг_согласовано</a>-->
			 <!-- ENDIF -->
			 </li>					 
			<li>{PHP.out.loginout}</li>
<!-- END: USER -->
		</ul>
		<hr />
	</div>

{FOOTER_JS}
</body>
</html>
<!-- END: FOOTER -->
