<?php
/**
 * Page display.
 *
 * @package page
 * @version 0.7.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', 'any');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = cot_import('al', 'G', 'ALP');
$c = cot_import('c', 'G', 'TXT');
$pg = cot_import('pg', 'G', 'INT');

/* === Hook === */
foreach (cot_getextplugins('page.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "page_alias='".$al."'" : 'page_id='.$id;
	$sql_page = $db->query("SELECT p.*, u.* FROM $db_pages AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
			WHERE $where LIMIT 1");
}

if(!$id && empty($al) || !$sql_page || $sql_page->rowCount() == 0)
{
	$env['status'] = '404 Not Found';
	cot_redirect(cot_url('message', 'msg=404', '', true));
}
$pag = $sql_page->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin'], $usr['auth_download']) = cot_auth('page', $pag['page_cat'], 'RWA1');
cot_block($usr['auth_read']);

$al = empty($pag['page_alias']) ? '' : $pag['page_alias'];
$id = (int) $pag['page_id'];
$cat = $structure['page'][$pag['page_cat']];

$sys['sublocation'] = $pag['page_title'];

$pag['page_begin_noformat'] = $pag['page_begin'];
$pag['page_tab'] = empty($pg) ? 0 : $pg;
$pag['page_pageurl'] = empty($al) ? cot_url('page', array('id' => $id)) : cot_url('page', array('al' => $al));

if ($pag['page_state'] == 1 && !$usr['isadmin'] && $usr['id'] != $pag['page_ownerid'])
{
	$env['status'] = '403 Forbidden';
	cot_log("Attempt to directly access an un-validated page", 'sec'); // TODO i18n
	cot_redirect(cot_url('message', "msg=930", '', true));
}
if (mb_substr($pag['page_text'], 0, 6) == 'redir:')
{
	$env['status'] = '303 See Other';
	$redir = trim(str_replace('redir:', '', $pag['page_text']));
	$sql_page_update = $db->query("UPDATE $db_pages SET page_filecount=page_filecount+1 WHERE page_id=$id");
	header('Location: ' . (preg_match('#^(http|ftp)s?://#', $redir) ? '' : COT_ABSOLUTE_URL) . $redir);
	exit;
}
elseif (mb_substr($pag['page_text'], 0, 8) == 'include:')
{
	$pag['page_text'] = cot_readraw('datas/html/'.trim(mb_substr($pag['page_text'], 8, 255)));
}
if ($pag['page_file'] && $a == 'dl' && (($pag['page_file'] == 2 && $usr['auth_download']) || $pag['page_file'] == 1))
{
	/* === Hook === */
	foreach (cot_getextplugins('page.download.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	// Hotlinking protection
	if ($_SESSION['dl'] != $id
		&& $_SESSION['cat'] != $pag['page_cat'])
	{
		cot_redirect($pag['page_pageurl']);
	}

	unset($_SESSION['dl']);

	$file_size = @filesize($row['page_url']);
	if (!$usr['isadmin'] || $cfg['page']['count_admin'])
	{
		$pag['page_filecount']++;
		$sql_page_update = $db->query("UPDATE $db_pages SET page_filecount=page_filecount+1 WHERE page_id=".$id);
	}
	$redir = (preg_match('#^(http|ftp)s?://#', $pag['page_url']) ? '' : COT_ABSOLUTE_URL) . $pag['page_url'];
	header('Location: ' . $redir);
	echo cot_rc('page_code_redir');
	exit;
}
if (!$usr['isadmin'] || $cfg['page']['count_admin'])
{
	$pag['page_count']++;
	$sql_page_update =  $db->query("UPDATE $db_pages SET page_count='".$pag['page_count']."' WHERE page_id=$id");
}

if ($pag['page_cat'] == 'system')
{
	$out['subtitle'] = $pag['page_title'];
}
else
{
	$title_params = array(
		'TITLE' => $pag['page_title'],
		'CATEGORY' => $cat['title']
	);
	$out['subtitle'] = cot_title($cfg['page']['title_page'], $title_params);
}
$out['desc'] = strip_tags($pag['page_desc']);
$out['keywords'] = strip_tags($pag['page_keywords']);

/* === Hook === */
foreach (cot_getextplugins('page.main') as $pl)
{
	include $pl;
}
/* ===== */

if ($pag['page_file'])
{
	unset($_SESSION['dl']);
	$_SESSION['dl'] = $id;
}

require_once $cfg['system_dir'] . '/header.php';
require_once cot_incfile('users', 'module');

$mskin = cot_tplfile(array('page', $cat['tpl']));
$t = new XTemplate($mskin);

$t->assign(cot_generate_pagetags($pag, 'PAGE_', 0, $usr['isadmin']), $cfg['homebreadcrumb']);
$t->assign('PAGE_OWNER', cot_build_user($pag['page_ownerid'], htmlspecialchars($pag['user_name'])));
$t->assign(cot_generate_usertags($pag, 'PAGE_OWNER_'));

$pag['page_file'] = intval($pag['page_file']);
if ($pag['page_file'] > 0)
{
	if ($sys['now_offset'] > $pag['page_date'])
	{
		if (!empty($pag['page_url']))
		{
			$dotpos = mb_strrpos($pag['page_url'], ".") + 1;
			$type = mb_strtolower(mb_substr($pag['page_url'], $dotpos, 5));
			$pag['page_fileicon'] = cot_rc('page_icon_file_path');
			if (!file_exists($pag['page_fileicon']))
			{
				$pag['page_fileicon'] = cot_rc('page_icon_file_default');
			}
			$pag['page_fileicon'] = cot_rc('page_icon_file', array('icon' => $pag['page_fileicon']));
		}
		else
		{
			$pag['page_fileicon'] = '';
		}

		$t->assign(array(
			'PAGE_FILE_SIZE' => $pag['page_size'],
			'PAGE_FILE_SIZE_READABLE' => cot_build_filesize($pag['page_size']),
			'PAGE_FILE_COUNT' => $pag['page_filecount'],
			'PAGE_FILE_ICON' => $pag['page_fileicon'],
			'PAGE_FILE_NAME' => basename($pag['page_url']),
			'PAGE_FILE_COUNTTIMES' => cot_declension($pag['page_filecount'], $Ls['Times'])
		));

		if (($pag['page_file'] === 2 && $usr['id'] == 0) || ($pag['page_file'] === 2 && !$usr['auth_download']))
		{
			$t->assign(array(
				'PAGE_FILETITLE' => $L['Members_download'],
				'PAGE_FILE_URL' => cot_url('users', 'm=register')
			));
		}
		else
		{
			$t->assign(array(
				'PAGE_FILETITLE' => $pag['page_title'],
				'PAGE_FILE_URL' => cot_url('page', array('id' => $id, 'a' => 'dl'))
			));
		}
	}
}

// Multi tabs
$pag['page_tabs'] = explode('[newpage]', $t->vars['PAGE_TEXT'], 99);
$pag['page_totaltabs'] = count($pag['page_tabs']);

if ($pag['page_totaltabs'] > 1)
{
	if (empty($pag['page_tabs'][0]))
	{
		$remove = array_shift($pag['page_tabs']);
		$pag['page_totaltabs']--;
	}
	$max_tab = $pag['page_totaltabs'] - 1;
	$pag['page_tab'] = ($pag['page_tab'] > $max_tab) ? 0 : $pag['page_tab'];
	$pag['page_tabtitles'] = array();

	for ($i = 0; $i < $pag['page_totaltabs']; $i++)
	{
		if (mb_strpos($pag['page_tabs'][$i], '<br />') === 0)
		{
			$pag['page_tabs'][$i] = mb_substr($pag['page_tabs'][$i], 6);
		}

		$p1 = mb_strpos($pag['page_tabs'][$i], '[title]');
		$p2 = mb_strpos($pag['page_tabs'][$i], '[/title]');

		if ($p2 > $p1 && $p1 < 4)
		{
			$pag['page_tabtitle'][$i] = mb_substr($pag['page_tabs'][$i], $p1 + 7, ($p2 - $p1) - 7);
			if ($i == $pag['page_tab'])
			{
				$pag['page_tabs'][$i] = trim(str_replace('[title]'.$pag['page_tabtitle'][$i].'[/title]', '', $pag['page_tabs'][$i]));
			}
		}
		else
		{
			$pag['page_tabtitle'][$i] = $i == 1 ? $pag['page_title'] : $L['Page'] . ' ' . ($i + 1);
		}
		$tab_url = empty($al) ? cot_url('page', 'id='.$id.'&pg='.$i) : cot_url('page', 'al='.$al.'&pg='.$i);
		$pag['page_tabtitles'][] .= cot_rc_link($tab_url, ($i+1).'. '.$pag['page_tabtitle'][$i],
			array('class' => 'page_tabtitle'));
		$pn = cot_pagenav('page', (empty($al) ? 'id='.$id : 'al='.$al), $pag['page_tab'], $pag['page_totaltabs'], 1, 'pg');
		$pag['page_tabnav'] = $pn['main'];
		$pag['page_tabs'][$i] = str_replace('[newpage]', '', $pag['page_tabs'][$i]);
		$pag['page_tabs'][$i] = preg_replace('#^(<br />)+#', '', $pag['page_tabs'][$i]);
		$pag['page_tabs'][$i] = trim($pag['page_tabs'][$i]);
	}

	$pag['page_tabtitles'] = implode('<br />', $pag['page_tabtitles']);
	$pag['page_text'] = $pag['page_tabs'][$pag['page_tab']];

	$t->assign(array(
		'PAGE_MULTI_TABNAV' => $pag['page_tabnav'],
		'PAGE_MULTI_TABTITLES' => $pag['page_tabtitles'],
		'PAGE_MULTI_CURTAB' => $pag['page_tab'] + 1,
		'PAGE_MULTI_MAXTAB' => $pag['page_totaltabs'],
		'PAGE_TEXT' => $pag['page_text']
	));
	$t->parse('MAIN.PAGE_MULTI');
}

/* === Hook === */
foreach (cot_getextplugins('page.tags') as $pl)
{
	include $pl;
}
/* ===== */
if ($usr['isadmin'] || $usr['id'] == $pag['page_ownerid'])
{
	$t->parse('MAIN.PAGE_ADMIN');
}
if (($pag['page_file'] === 2 && $usr['id'] == 0) || ($pag['page_file'] === 2 && !$usr['auth_download']))
{
	$t->parse('MAIN.PAGE_FILE.MEMBERSONLY');
}
else
{
	$t->parse('MAIN.PAGE_FILE.DOWNLOAD');
}
if (!empty($pag['page_url']))
{
	$t->parse('MAIN.PAGE_FILE');
}
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_page'])
{
	$cache->page->write();
}
?>