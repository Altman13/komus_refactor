  <div class="body">
    <div><a href="{KOMUS_REPORTS_BASE_URL}">Отчет по базе</a> (Excel)</div>
    <div><a href="{KOMUS_REPORTS_OPERATOR_URL}">Отчет по операторам</a> (Excel)</div>
  </div>
  <div class="body">
    <form action="{KOMUS_CREATE_ACTION}" method="post">
      С: {KOMUS_CREATE_FROM_DATE}<br />
      По: {KOMUS_CREATE_TO_DATE}<br />
      <button type="submit">Выгрузить отчет</button>
    </form>
  </div>
  <div class="body">
    {KOMUS_REPORTS_HTML_OUT}
  </div>
  <div class="body"><a href="/reports/{KOMUS_REPORTS_XLS_FILENAME}">Получить отчет</a></div>