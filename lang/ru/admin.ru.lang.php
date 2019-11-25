<?php

/**
 * Russian Language File for the Admin Module (admin.ru.lang.php)
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Translators Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Common words
 */

$L['Extension'] = 'Расширение';
$L['Extensions'] = 'Расширения';

/**
 * Home Section
 */

$L['home_newusers'] = 'Новые пользователи';
$L['home_newpages'] = 'Новые страницы';
$L['home_newtopics'] = 'Новые темы';
$L['home_newposts'] = 'Новые сообщения на форуме';
$L['home_newpms'] = 'Новые личные сообщения';

$L['home_db_rows'] = 'БД SQL, строк';
$L['home_db_indexsize'] = 'БД SQL, размер индекса (KB)';
$L['home_db_datassize'] = 'БД SQL, размер данных (KB)';
$L['home_db_totalsize'] = 'БД SQL, общий размер (KB)';

$L['home_ql_b1_title'] = 'Настройки сайта';
$L['home_ql_b1_1'] = 'Основные настройки системы';
$L['home_ql_b1_2'] = 'Заголовки (тэг &lt;title&gt;)';
$L['home_ql_b1_3'] = 'Скины и кодировка';
$L['home_ql_b1_4'] = 'Слоты для меню в tpl-файлах';
$L['home_ql_b1_5'] = 'Язык сайта ';
$L['home_ql_b1_6'] = 'Время и дата';

$L['home_ql_b2_1'] = 'Структура страниц и категорий';
$L['home_ql_b2_2'] = 'Дополнительные поля для страниц';
$L['home_ql_b2_3'] = 'Дополнительные поля для категорий';
$L['home_ql_b2_4'] = 'Настройки парсинга';

$L['home_ql_b3_1'] = 'Настройка пользователей';
$L['home_ql_b3_2'] = 'Дополнительные поля для профиля';
$L['home_ql_b3_4'] = 'Права групп';

$L['home_rev_title'] = 'редакция';
$L['home_rev'] = 'r';
$L['home_update_notice'] = 'Доступно обновление';
$L['home_update_revision'] = 'Текущая версия: <span style="color:#C00;font-weight:bold;">%1$s(r%2$s)</span><br />Новая версия: <span style="color:#4E9A06;font-weight:bold;">%3$s(r%4$s)</span>'; // %1/%2 Current Version/Revision %3/%4 Updated Version/Revision

/**
 * Config Section
 */

$L['core_forums'] = &$L['Forums'];
$L['core_locale'] = &$L['Locale'];
$L['core_main'] = 'Настройки сайта';
$L['core_menus'] = &$L['Menus'];
$L['core_page'] = &$L['Pages'];
$L['core_parser'] = &$L['Parser'];
$L['core_performance'] = 'Производительность';
$L['core_pfs'] = &$L['PFS'];
$L['core_plug'] = &$L['Plugins'];
$L['core_pm'] = &$L['Private_Messages'];
$L['core_polls'] = &$L['Polls'];
$L['core_rss'] = &$L['RSS_Feeds'];
$L['core_structure'] = &$L['Categories'];
$L['core_theme'] = &$L['Themes'];
$L['core_time'] = 'Время и дата';
$L['core_title'] = 'Заголовки и мета-теги';
$L['core_users'] = &$L['Users'];

$L['cfg_struct_defaults'] = 'Настройки по умолчанию для структуры';

/**
 * Config Section
 * Locale Subsection
 */

$L['cfg_forcedefaultlang'] = array('Принудительная установка языка по умолчанию для всех пользователей', ' ');
$L['cfg_defaulttimezone'] = array('Часовой пояс по умолчанию', 'Для гостей и при регистрации, от -12 до +12');


/**
 * Config Section
 * Main Subsection
 */

$L['cfg_adminemail'] = array('E-mail администратора сайта', 'Обязательно!');
$L['cfg_clustermode'] = array('Серверный кластер', 'Выберите Да, если используется кластерная система балансировки нагрузок.');
$L['cfg_cookiedomain'] = array('Домен для cookies', 'По умолчанию пусто');
$L['cfg_cookielifetime'] = array('Срок действия cookies', 'В секундах');
$L['cfg_cookiepath'] = array('Путь для cookies', 'По умолчанию пусто');
$L['cfg_devmode'] = array('Режим отладки', 'Только для отладки под localhost');
$L['cfg_easypagenav'] = array('Дружественная паджинация', 'Использует номера страниц в ссылках вместо смещений БД');
$L['cfg_hostip'] = array('IP-адрес сервера', 'Необязательно');
$L['cfg_jquery'] = array('Включить jQuery', ' ');
$L['cfg_maintenance'] = array('Режим обслуживания', 'Доступа к сайту разрешен только администраторам');
$L['cfg_maintenancereason'] = array('Причина режима обслуживания', 'Коротко опишите почему сайт находится в режиме обслуживания');
$L['cfg_maxrowsperpage'] = array('Макс. количество элементов на страницу', 'Стандартный лимит элементов для паджинации');
$L['cfg_parser'] = array('Парсер разметки', 'По умолчанию: простой текст');
$L['cfg_redirbkonlogin'] = array('Возврат после авторизации', 'Вернуться на страницу, посещённую перед авторизацией');
$L['cfg_redirbkonlogout'] = array('Возврат после выхода', 'Вернуться на страницу, посещённую перед выходом');
$L['cfg_shieldenabled'] = array('Включить защиту', 'Защита против спама и хаммеринга');
$L['cfg_shieldtadjust'] = array('Настройка таймеров защиты (в %)', 'Чем выше, тем сильнее защита против спама');
$L['cfg_shieldzhammer'] = array('Анти-хаммер после * хитов', 'Чем меньше, тем короче срок автоблокировки пользователя');
$L['cfg_turnajax'] = array('Включить Ajax', 'Работает только если jQuery включен');

/**
 * Config Section
 * Menus Subsection
 */

$L['cfg_banner'] = array('Баннер<br />{HEADER_BANNER} в header.tpl', ' ');
$L['cfg_bottomline'] = array('Нижняя строка<br />{FOOTER_BOTTOMLINE} в footer.tpl', ' ');
$L['cfg_topline'] = array('Верхняя строка<br />{HEADER_TOPLINE} в header.tpl', ' ');

$L['cfg_menu1'] = array('Меню #1<br />{PHP.cfg.menu1} во всех файлах .tpl', ' ');
$L['cfg_menu2'] = array('Меню #2<br />{PHP.cfg.menu2} во всех файлах .tpl', ' ');
$L['cfg_menu3'] = array('Меню #3<br />{PHP.cfg.menu3} во всех файлах .tpl', ' ');
$L['cfg_menu4'] = array('Меню #4<br />{PHP.cfg.menu4} во всех файлах .tpl', ' ');
$L['cfg_menu5'] = array('Меню #5<br />{PHP.cfg.menu5} во всех файлах .tpl', ' ');
$L['cfg_menu6'] = array('Меню #6<br />{PHP.cfg.menu6} во всех файлах .tpl', ' ');
$L['cfg_menu7'] = array('Меню #7<br />{PHP.cfg.menu7} во всех файлах .tpl', ' ');
$L['cfg_menu8'] = array('Меню #8<br />{PHP.cfg.menu8} во всех файлах .tpl', ' ');
$L['cfg_menu9'] = array('Меню #9<br />{PHP.cfg.menu9} во всех файлах .tpl', ' ');

$L['cfg_freetext1'] = array('Текст #1<br />{PHP.cfg.freetext1} во всех файлах .tpl', ' ');
$L['cfg_freetext2'] = array('Текст #2<br />{PHP.cfg.freetext2} во всех файлах .tpl', ' ');
$L['cfg_freetext3'] = array('Текст #3<br />{PHP.cfg.freetext3} во всех файлах .tpl', ' ');
$L['cfg_freetext4'] = array('Текст #4<br />{PHP.cfg.freetext4} во всех файлах .tpl', ' ');
$L['cfg_freetext5'] = array('Текст #5<br />{PHP.cfg.freetext5} во всех файлах .tpl', ' ');
$L['cfg_freetext6'] = array('Текст #6<br />{PHP.cfg.freetext6} во всех файлах .tpl', ' ');
$L['cfg_freetext7'] = array('Текст #7<br />{PHP.cfg.freetext7} во всех файлах .tpl', ' ');
$L['cfg_freetext8'] = array('Текст #8<br />{PHP.cfg.freetext8} во всех файлах .tpl', ' ');
$L['cfg_freetext9'] = array('Текст #9<br />{PHP.cfg.freetext9} во всех файлах .tpl', ' ');

/**
 * Config Section
 * Performance Subsection
 */

$L['cfg_gzip'] = array('Gzip', 'Gzip-сжатие для исходящего HTML-кода');
$L['cfg_headrc_consolidate'] = array('Объединять ресурсы header/footer (JS/CSS)');
$L['cfg_headrc_minify'] = array('Минифицировать объединённые JS/CSS');
$L['cfg_jquery_cdn'] = array('Использовать jQuery из CDN по этой ссылке', 'Пример: https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js');

/**
 * Config Section
 * Skins Subsection
 */

$L['cfg_charset'] = array('Набор символов (кодовая страница)', ' ');
$L['cfg_disablesysinfos'] = array('Отключить время создания страницы', '(в footer.tpl)');
$L['cfg_doctypeid'] = array('Тип документа', '&lt;!DOCTYPE&gt; в HTML-разметке');
$L['cfg_forcedefaulttheme'] = array('Принудительная установка темы по умолчанию для всех пользователей', ' ');
$L['cfg_homebreadcrumb'] = array('Ссылка на главную страницу в &laquo;навигационной цепочке&raquo;', 'Установить ссылку на главную страницу в начале &laquo;навигационной цепочки&raquo;');
$L['cfg_keepcrbottom'] = array('Оставить копирайт в тэге {FOOTER_BOTTOMLINE}', '(в footer.tpl)');
$L['cfg_metakeywords'] = array('Ключевые слова', '(через запятую)');
$L['cfg_msg_separate'] = array('Показывать сообщения отдельно для каждого источника', '');
$L['cfg_separator'] = array('Разделитель', '(используется в навигационной цепочке и т .д.)');
$L['cfg_showsqlstats'] = array('Показывать статистику SQL-запросов', '(в footer.tpl)');

/**
 * Config Section
 * Title Subsection
 */

$L['cfg_maintitle'] = array('Название сайта', 'Обязательно');
$L['cfg_subtitle'] = array('Описание сайта', 'Необязательно');
$L['cfg_title_header'] = array('Основной заголовок', 'Опции: {MAINTITLE}, {DESCRIPTION}, {SUBTITLE}');
$L['cfg_title_header_index'] = array('Заголовок главной страницы', 'Опции: {MAINTITLE}, {DESCRIPTION}, {SUBTITLE}');
$L['cfg_title_users_details'] = array('Пользователи - просмотр профиля', 'Опции: {USER}, {NAME}');
$L['cfg_subject_mail'] = array('Заголовок email', 'Опции: {SITE_TITLE}, {SITE_DESCRIPTION}, {MAIL_SUBJECT}');
$L['cfg_body_mail'] = array('Текст email', 'Опции: {SITE_TITLE}, {SITE_DESCRIPTION}, {SITE_URL}, {ADMIN_EMAIL}, {MAIL_BODY}, {MAIL_SUBJECT}');
/**
 * Config Section
 * Users Subsection
 */

$L['cfg_disablereg'] = array('Отключить регистрацию', 'Запретить регистрацию новых пользователей');
$L['cfg_disablewhosonline'] = array('Отключить статистику &laquo;Кто онлайн&raquo;', 'Включается автоматически при включении защиты');
$L['cfg_forcerememberme'] = array('Зафиксировать &quot;запомнить меня&quot;', 'Используйте на мультидоменных сайтах или при случайных выходах из системы');
$L['cfg_maxusersperpage'] = array('Максимальное количество записей на страницу в списке пользователей', ' ');
$L['cfg_regnoactivation'] = array('Отменить проверку e-mail при регистрации', 'По причине безопасности рекомендуется &laquo;Нет&raquo;!');
$L['cfg_regrequireadmin'] = array('Утверждение новых учетных записей администратором', ' ');
$L['cfg_timedout'] = array('Задержка ожидания в секундах', 'По истечении данного срока пользователь считается покинувшим сайт');
$L['cfg_user_email_noprotection'] = array('Выключить защиту смены e-mail с паролем', 'По причине безопасности рекомендуется &laquo;Нет&raquo;!');
$L['cfg_useremailchange'] = array('Разрешить пользователям изменять свой e-mail', 'По причине безопасности рекомендуется &laquo;Нет&raquo;!');
$L['cfg_usertextimg'] = array('Разрешить изображения и HTML-код в подписях пользователей', 'По причине безопасности рекомендуется &laquo;Нет&raquo;!');
$L['cfg_usertextmax'] = array('Максимальная длина подписи, символов', '');

/**
 * Config Section
 * Common strings
 */
$L['cfg_css'] = array('Подключить CSS модуля/плагина');
$L['cfg_editor'] = array('Редактор разметки', '');
$L['cfg_markup'] = array('Включить разметку', 'Включает HTML/BBcode или другой парсинг, установленный в вашей системе');

/**
 * Extension management
 */

$L['ext_already_installed'] = 'Данное расширение уже установлено: {$name}';
$L['ext_auth_installed'] = 'Значения авторизации по умолчанию установлены';
$L['ext_auth_locks_updated'] = 'Блокировки авторизации обновлены';
$L['ext_auth_uninstalled'] = 'Опции авторизации удалены';
$L['ext_bindings_installed'] = 'Установлено связок хуков: {$cnt}';
$L['ext_bindings_uninstalled'] = 'Удалено связок хуков: {$cnt}';
$L['ext_config_error'] = 'Ошибка настройки конфигурации';
$L['ext_config_installed'] = 'Конфигурация установлена';
$L['ext_config_uninstalled'] = 'Конфигурация удалена';
$L['ext_config_updated'] = 'Опции конфигурации обновлены';
$L['ext_config_struct_error'] = 'Ошибка настройки конфигурации структуры';
$L['ext_config_struct_installed'] ='Конфигурация структуры установлена';
$L['ext_config_struct_updated'] = 'Опции конфигурации структуры обновлены';
$L['ext_dependency_error'] = '{$dep_type} &quot;{$dep_name}&quot; required by {$type} &quot;{$name}&quot; is neither installed nor selected for installation';
$L['ext_executed_php'] = 'Выполнена часть PHP-хэндлера: {$ret}';
$L['ext_executed_sql'] = 'Выполнена часть SQL-хэндлера: {$ret}';
$L['ext_installing'] = 'Установка {$type} &quot;{$name}&quot;';
$L['ext_invalid_format'] = 'Расширение несовместимо с Cotonti версии 0.9 и выше. Пожалуйста, свяжитесь с разработчиками.';
$L['ext_old_format'] = 'Это старый плагин для Genoa/Seditio. Он может работать некорректно или не работать вовсе.';
$L['ext_patch_applied'] = 'Установлен патч {$f}: {$msg}';
$L['ext_patch_error'] = 'Ошибка установки патча {$f}: {$msg}';
$L['ext_setup_not_found'] = 'Файл установок не найден: {$path}';
$L['ext_uninstall_confirm'] = 'Вы действительно хотите удалить это расширение? Все данные, связанные с этим расширением, будут удалены без возможности восстановления.<br/><a href="{$url}">Да, удалить вместе с данными.</a>';
$L['ext_uninstalling'] = 'Удаление {$type} &quot;{$name}&quot;';
$L['ext_up2date'] = '{$type} &quot;{$name}&quot; не требует обновления';
$L['ext_update_error'] = 'Ошибка обновления {$type} &quot;{$name}&quot;';
$L['ext_updated'] = '{$type} &quot;{$name}&quot; обновлен до версии {$ver}';
$L['ext_updating'] = 'Обновление {$type} &quot;{$name}&quot;';

/**
 * Structure Section
 */

$L['adm_cat_exists'] = 'Категория с таким кодом уже существует';
$L['adm_tpl_mode'] = 'Установка шаблона';
$L['adm_tpl_empty'] = 'По умолчанию';
$L['adm_tpl_forced'] = 'Как';
$L['adm_tpl_parent'] = 'Как родительская категория';
$L['adm_tpl_resyncalltitle'] = 'Синхронизировать все счетчики страниц';
$L['adm_tpl_resynctitle'] = 'Синхронизировать счетчики страниц в разделе';
$L['adm_help_structure'] = 'Страницы категории &laquo;system&raquo; не отображаются в списках страниц и являются отдельными, самостоятельными страницами';

/**
 * Structure Section
 * Extrafields Subsection
 */

$L['adm_extrafields_desc'] = 'Создание / правка дополнительных полей';
$L['adm_extrafields_all'] = 'Все таблицы';
$L['adm_help_structure_extrafield'] = 'HTML-код поля установится в значение по умолчанию автоматически, если его очистить и обновить<br /><br />
<b>Новые тэги в tpl-файлах:</b><br /><br />
<u>list.tpl:</u><br /><br />
&nbsp;&nbsp;&nbsp;{LIST_XXXXX}, {LIST_XXXXX_TITLE}<br /><br />
<u>list.group.tpl:</u><br /><br />
&nbsp;&nbsp;&nbsp;{LIST_XXXXX}, {LIST_XXXXX_TITLE}<br /><br />
<u>admin.structure.inc.tpl :</u><br /><br />
&nbsp;&nbsp;&nbsp;&lt;!-- BEGIN: OPTIONS --&gt; {ADMIN_STRUCTURE_XXXXX}, {ADMIN_STRUCTURE_XXXXX_TITLE} &lt;!-- END: OPTIONS --&gt;<br /><br />
&nbsp;&nbsp;&nbsp;&lt;!-- BEGIN: DEFULT --&gt; {ADMIN_STRUCTURE_FORMADD_XXXXX}, {ADMIN_STRUCTURE_FORMADD_XXXXX_TITLE} &lt;!-- END: DEFULT --&gt;<br /><br />
<br />';

/**
 * Users Section
 */

$L['adm_rightspergroup'] = 'Права групп';
$L['adm_maxsizesingle'] = 'Максимальный размер одного файла в разделе &laquo;'.$L['PFS'].'&raquo; (Кб)';
$L['adm_maxsizeallpfs'] = 'Максимальный размер всех файлов в разделе &laquo;'.$L['PFS'].'&raquo; (Кб)';
$L['adm_copyrightsfrom'] = 'Установить права как в группе';
$L['adm_rights_maintenance'] = 'Разрешить авторизацию при включенном режиме обслуживания';

/**
 * Users Section
 * Extrafields Subsection
 */

$L['adm_help_users_extrafield'] = 'Поле &laquo;Базовый HTML&raquo; устанавливается в значение по умолчанию автоматически, если его очистить и обновить.<br /><br />
<b>Новые тэги в tpl-файлах:</b><br /><br />
users.profile.tpl: {USERS_PROFILE_XXXXX}, {USERS_PROFILE_XXXXX_TITLE}<br /><br />
users.edit.tpl: {USERS_EDIT_XXXXX}, {USERS_EDIT_XXXXX_TITLE}<br /><br />
users.details.tpl: {USERS_DETAILS_XXXXX}, {USERS_DETAILS_XXXXX_TITLE}<br /><br />
user.register.tpl: {USERS_REGISTER_XXXXX}, {USERS_REGISTER_XXXXX_TITLE}<br /><br />
forums.posts.tpl: {FORUMS_POSTS_ROW_USERXXXXX}, {FORUMS_POSTS_ROW_USERXXXXX_TITLE}<br />';

/**
 * Plug Section
 */

$L['adm_defauth_guests'] = 'Права гостей по умолчанию';
$L['adm_deflock_guests'] = 'Блокировать гостей по маске';
$L['adm_defauth_members'] = 'Права пользователей по умолчанию';
$L['adm_deflock_members'] = 'Блокировать пользователей по маске';

$L['adm_present'] = 'Присутствует';
$L['adm_missing'] = 'Отсутствует';
$L['adm_paused'] = 'Выполнение приостановлено';
$L['adm_running'] = 'Запущен';
$L['adm_partrunning'] = 'Запущен частично';
$L['adm_partstopped'] = 'Частично остановлен';
$L['adm_installed'] = 'Установлен';
$L['adm_notinstalled'] = 'Не установлен';

$L['adm_plugsetup'] = 'Настройки плагина';
$L['adm_override_guests'] = 'Системная блокировка: незарегистрированным и неактивированным пользователям доступ к администрированию запрещен';
$L['adm_override_banned'] = 'Системная блокировка: учетная запись заблокирована';
$L['adm_override_admins'] = 'Системная блокировка: администраторы';

$L['adm_opt_install'] = 'Установить';
$L['adm_opt_install_explain'] = 'Установка или сброс всех компонентов плагина в значения по умолчанию';
$L['adm_opt_pause'] = 'Приостановить';
$L['adm_opt_pauseall'] = 'Приостановить все';
$L['adm_opt_pauseall_explain'] = 'Остановка выполнения всех компонентов плагина';
$L['adm_opt_update'] = 'Обновить';
$L['adm_opt_update_explain'] = 'Обновление конфигурации и данных если файлы расширения на носителе уже обновлены';
$L['adm_opt_uninstall'] = 'Удалить';
$L['adm_opt_uninstall_explain'] = 'Отключение всех компонентов плагина без физического удаления файлов';
$L['adm_opt_unpause'] = 'Продолжить выполнение';
$L['adm_opt_unpauseall'] = 'Продолжить выполнение всех';
$L['adm_opt_unpauseall_explain'] = 'Возобновление выполнения всех компонентов плагина';

$L['adm_opt_setup_missing'] = 'Ошибка: отсутствует файл настроек!';

/**
 * Tools Section
 */

$L['adm_listisempty'] = 'Элементы списка отсутствуют';

/**
 * Other Section
 * Cache Subsection
 */

$L['adm_delcacheitem'] = 'Элемент кэша удален';
$L['adm_internalcache'] = 'Внутренний кэш';
$L['adm_purgeall_done'] = 'Кэш очищен полностью';
$L['adm_diskcache'] = 'Дисковый кэш';

/**
 * Other Section
 * Log Subsection
 */

$L['adm_log'] = 'Системный протокол';
$L['adm_infos'] = 'Информация';
$L['adm_versiondclocks'] = 'Версии и таймеры';
$L['adm_checkcorethemes'] = 'Проверить файлы ядра и скинов';
$L['adm_checkcorenow'] = 'Проверить файлы ядра!';
$L['adm_checkingcore'] = 'Проверяю файлы ядра...';
$L['adm_checkthemes'] = 'Проверить наличие всех файлов в скине';
$L['adm_checkskin'] = 'Проверить TPL-файлы скина';
$L['adm_checkingskin'] = 'Проверяю скин...';
$L['adm_check_ok'] = 'Ok';
$L['adm_check_missing'] = 'Отсутствует';

/**
 * Other Section
 * Infos Subsection
 */

$L['adm_phpver'] = 'Версия PHP';
$L['adm_zendver'] = 'Версия Zend';
$L['adm_interface'] = 'Интерфейс веб-сервер / PHP';
$L['adm_os'] = 'Операционная система';
$L['adm_clocks'] = 'Таймеры';
$L['adm_time1'] = '#1 : Чистое время сервера';
$L['adm_time2'] = '#2 : Время относительно GMT, возвращаемое сервером';
$L['adm_time3'] = '#3 : Время относительно GMT + сдвиг сервера (Cotonti reference)';
$L['adm_time4'] = '#4 : Ваше местное время из личных установок';
$L['adm_help_versions'] = 'Измените часовой пояс сервера для корректной установки таймера #3.<br />
Таймер #4 зависит от установок часового пояса в вашем профиле.<br />
Таймеры #1 и #2 игнорируются системой.';

/**
 * Common Entries
 */

$L['adm_area'] = 'Зона';
$L['adm_clicktoedit'] = '(правка)';
$L['adm_confirm'] = 'Подтвердить';
$L['adm_done'] = 'Выполнено';
$L['adm_failed'] = 'Ошибка';
$L['adm_from'] = 'От';
$L['adm_more'] = 'Показать все...';
$L['adm_purgeall'] = 'Очистить все';
$L['adm_queue_unvalidated'] = 'Публикация поставлена в очередь';
$L['adm_queue_validated'] = 'Публикация утверждена';
$L['adm_required'] = '(обязательно)';
$L['adm_setby'] = 'Установлено';
$L['adm_to'] = 'Кому';
$L['adm_totalsize'] = 'Общий объем';
$L['adm_warnings'] = 'Предупреждения';

$L['editdeleteentries'] = 'Правка / удаление';
$L['viewdeleteentries'] = 'Просмотр / удаление';

$L['alreadyaddnewentry'] = 'Новая запись добавлена';
$L['alreadyupdatednewentry'] = 'Запись обновлена';
$L['alreadydeletednewentry'] = 'Запись удалена';

/**
 * Extra Fields (Common Entries for Pages & Structure & Users)
 */

$L['adm_extrafields'] = 'Дополнительные поля';
$L['adm_extrafield_added'] = 'Новое поле добавлено';
$L['adm_extrafield_not_added'] = 'Ошибка! Новое поле не добавлено';
$L['adm_extrafield_updated'] = 'Поле "%1$s" отредактировано';
$L['adm_extrafield_not_updated'] = 'Ошибка! Поле "%1$s" не отредактировано';
$L['adm_extrafield_removed'] = 'Поле удалено';
$L['adm_extrafield_not_removed'] = 'Ошибка! Поле не удалено';
$L['adm_extrafield_confirmdel'] = 'Вы действительно хотите удалить поле? Все данные этого поля будут потеряны!';
$L['adm_extrafield_confirmupd'] = 'Вы действительно хотите редактировать поле? Некоторые данные этого поля могут быть потеряны.';
$L['adm_extrafield_default'] = 'Значение по умолчанию';
$L['adm_extrafield_required'] = 'Обязательное';
$L['adm_extrafield_parse'] = 'Парсинг';
$L['adm_extrafield_enable'] = 'Включить';
$L['adm_extrafield_params'] = 'Параметры поля';

$L['extf_Name'] = 'Название поля';
$L['extf_Type'] = 'Тип поля';
$L['extf_Base_HTML'] = 'HTML-код поля';
$L['extf_Page_tags'] = 'Тэги';
$L['extf_Description'] = 'Описание поля (_TITLE)';

$L['adm_extrafield_new'] = 'Новое поле';
$L['adm_extrafield_noalter'] = 'Не добавлять новое поле в БД, только зарегистрировать как дополнительное';
$L['adm_extrafield_selectable_values'] = 'Значения для select и radio (через запятую)';
$L['adm_help_extrafield'] = 'HTML-код поля устанавливается в значение по умолчанию автоматически, если его очистить и обновить';

/**
 * Help messages that still don't work
 */

$L['adm_help_cache'] = 'Недоступно';
$L['adm_help_check1'] = 'Недоступно';
$L['adm_help_check2'] = 'Недоступно';
$L['adm_help_config']= 'Недоступно';

?>