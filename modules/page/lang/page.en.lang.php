<?php
/**
 * English Language File for the Page Module (page.en.lang.php)
 *
 * @package page
 * @version 0.7.0
 * @author Cotonti Translators Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['cfg_autovalidate'] = array('Autovalidate page', 'Autovalidate page if poster have admin rights for page category');
$L['cfg_count_admin'] = array('Count Administrators\' hits', '');
$L['cfg_maxlistsperpage'] = array('Max. lists per page', ' ');
$L['cfg_order'] = array('Sorting column');
$L['cfg_title_page'] = array('Page title tag format', 'Options: {TITLE}, {CATEGORY}');
$L['cfg_way'] = array('Sorting direction');

$L['info_desc'] = 'Extensible content management functionality: pages and page categories.';

/**
 * Structure Confing
 */

$L['cfg_order_params'] = array(); // Redefined in cot_page_config_order()
$L['cfg_way_params'] = array($L['Ascending'], $L['Descending']);

/**
 * Extrafields Subsection
 */

$L['adm_help_pages_extrafield'] = '<p><em>Base HTML</em> is set automaticaly if you leave it blank</p>
<p class="margintop10"><b>New tags in tpl files:</b></p>
<ul class="follow">
<li>page.tpl: {PAGE_XXXXX}, {PAGE_XXXXX_TITLE}</li>
<li>page.add.tpl: {PAGEADD_FORM_XXXXX}, {PAGEADD_FORM_XXXXX_TITLE}</li>
<li>page.edit.tpl: {PAGEEDIT_FORM_XXXXX}, {PAGEEDIT_FORM_XXXXX_TITLE}</li>
<li>page.list.tpl: {LIST_ROW_XXXXX}, {LIST_TOP_XXXXX}</li>
</ul>';

/**
 * Admin Page Section
 */

$L['adm_queue_deleted'] = 'Page was deleted in to trash can';
$L['adm_valqueue'] = 'Waiting for validation';
$L['adm_validated'] = 'Already validated';
$L['adm_structure'] = 'Structure of the pages (categories)';
$L['adm_sort'] = 'Sort';
$L['adm_sortingorder'] = 'Set a default sorting order for the categories';
$L['adm_showall'] = 'Show all';
$L['adm_help_page'] = 'The pages that belong to the category &quot;system&quot; are not displayed in the public listings, it\'s to make standalone pages.';
$L['adm_fileyesno'] = 'File (yes/no)';
$L['adm_fileurl'] = 'File URL';
$L['adm_filecount'] = 'File hit count';
$L['adm_filesize'] = 'File size';

/**
 * Page add and edit
 */

$L['page_addtitle'] = 'Submit new page';
$L['page_addsubtitle'] = 'Fill out all required fields and hit "Sumbit" to continue';
$L['page_edittitle'] = 'Page properties';
$L['page_editsubtitle'] = 'Edit all required fields and hit "Sumbit" to continue';

$L['page_catmissing'] = 'The category code is missing';
$L['page_notavailable'] = 'This page will be published in ';
$L['page_textmissing'] = 'Page text must not be empty';
$L['page_titletooshort'] = 'The title is too short or missing';
$L['page_validation'] = 'Awaiting validation';
$L['page_validation_desc'] = 'Your pages which have not been validated by administrator yet';

$L['page_file'] = 'File download';
$L['page_filehint'] = '(Set &quot;Yes&quot; to enable the download module at bottom of the page, and fill up the two fields below)';
$L['page_urlhint'] = '(If File download enabled)';
$L['page_filesize'] = 'Filesize, kB';
$L['page_filesizehint'] = '(If File download enabled)';
$L['page_filehitcount'] = 'File hit count';
$L['page_filehitcounthint'] = '(If File download enabled)';

$L['page_formhint'] = 'Once your submission is done, the page will be placed in the validation queue and will be hidden, awaiting confirmation from a site administrator or global moderator before being displayed in the right section. Check all fields carefully. If you need to change something, you will be able to do that later. But submitting changes puts a page into validation queue again.';

$L['page_pageid'] = 'Page ID';
$L['page_deletepage'] = 'Delete this page';

/**
 * Moved from theme.lang
 */

$L['pag_linesperpage'] = 'Lines per page';
$L['pag_linesinthissection'] = 'Lines in this section';

?>