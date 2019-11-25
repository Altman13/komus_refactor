<?php
/**
 * Edit page.
 *
 * @package page
 * @version 0.9.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', 'any');

/* === Hook === */
foreach (cot_getextplugins('page.edit.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_read']);

$parser_list = cot_get_parsers();

if ($a == 'update')
{
	$sql_page = $db->query("SELECT * FROM $db_pages WHERE page_id=$id LIMIT 1");
	cot_die($sql_page->rowCount() == 0);
	$row_page = $sql_page->fetch();
	
	$sys['parser'] = $row_page['page_parser'];

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $row_page['page_cat']);

	/* === Hook === */
	foreach (cot_getextplugins('page.edit.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $row_page['page_ownerid']);

	$rpage['page_keywords'] = cot_import('rpagekeywords', 'P', 'TXT');
	$rpage['page_alias'] = cot_import('rpagealias', 'P', 'ALP');
	$rpage['page_title'] = cot_import('rpagetitle', 'P', 'TXT');
	$rpage['page_desc'] = cot_import('rpagedesc', 'P', 'TXT');
	$rpage['page_text'] = cot_import('rpagetext', 'P', 'HTM');
	$rpage['page_parser'] = cot_import('rpageparser', 'P', 'ALP');
	$rpage['page_author'] = cot_import('rpageauthor', 'P', 'TXT');
	$rpage['page_file'] = cot_import('rpagefile', 'P', 'INT');
	$rpage['page_url'] = cot_import('rpageurl', 'P', 'TXT');
	$rpage['page_size'] = cot_import('rpagesize', 'P', 'TXT');
	$rpage['page_file'] = ($rpage['page_file'] == 0 && !empty($rpage['page_url'])) ? 1 : $rpage['page_file'];

	$rpage['page_cat'] = cot_import('rpagecat', 'P', 'TXT');

	$rpagedatenow = cot_import('rpagedatenow', 'P', 'BOL');
	$rpage['page_date'] = ($rpagedatenow) ? $sys['now_offset'] : (int)cot_import_date('rpagedate');
	$rpage['page_begin'] = (int)cot_import_date('rpagebegin');
	$rpage['page_expire'] = (int)cot_import_date('rpageexpire');
	$rpage['page_expire'] = ($rpage['page_expire'] <= $rpage['page_begin']) ? $rpage['page_begin'] + 31536000 : $rpage['page_expire'];

	// Extra fields
	foreach ($cot_extrafields[$db_pages] as $row_extf)
	{
		$rpage['page_'.$row_extf['field_name']] = cot_import_extrafields('rpage'.$row_extf['field_name'], $row_extf, 'P', $row_page['page_'.$row_extf['field_name']]);
	}

	if ($usr['isadmin'])
	{
		$rpage['page_count'] = cot_import('rpagecount', 'P', 'INT');
		$rpage['page_ownerid'] = cot_import('rpageownerid', 'P', 'INT');
		$rpage['page_filecount'] = cot_import('rpagefilecount', 'P', 'INT');
	}
	$rpagedelete = cot_import('rpagedelete', 'P', 'BOL');

	cot_check(empty($rpage['page_cat']), 'page_catmissing', 'rpagecat');
	cot_check(mb_strlen($rpage['page_title']) < 2, 'page_titletooshort', 'rpagetitle');
	cot_check(empty($rpage['page_text']), 'page_textmissing', 'rpagetext');
	
	if (empty($rpage['page_parser']) || !in_array($rpage['page_parser'], $parser_list) || !cot_auth('plug', $sys['parser'], 'W'))
	{
		$rpage['page_parser'] = $cfg['page']['parser'];
	}

	/* === Hook === */
	foreach (cot_getextplugins('page.edit.update.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if($rpagedelete)
	{
		$sql_page_delete = $db->query("SELECT * FROM $db_pages WHERE page_id=$id LIMIT 1");

		if ($row_page_delete = $sql_page_delete->fetch())
		{
			if ($row_page_delete['page_state'] != 1)
			{
				$sql_page_delete = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code='".$row_page_delete['page_cat']."' ");
			}

			foreach($cot_extrafields[$db_pages] as $i => $row_extf) 
			{ 
				if ($row_extf['field_type']=='file')
				{
					 @unlink($cfg['extrafield_files_dir']."/".$row_page_delete['page_'.$row_extf['field_name']]); 
				}
			}
			
			$sql_page_delete = $db->delete($db_pages, "page_id=$id");
			cot_log("Deleted page #".$id,'adm');
			/* === Hook === */
			foreach (cot_getextplugins('page.edit.delete.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
			if ($cache)
			{
				if ($cfg['cache_page'])
				{
					$cache->page->clear('page/' . str_replace('.', '/', $structure['page'][$row_page_delete['page_cat']]['path']));
				}
				if ($cfg['cache_index'])
				{
					$cache->page->clear('index');
				}
			}
			cot_redirect(cot_url('page', "c=".$row_page['page_cat'], '', true));
		}
	}
	elseif (!cot_error_found())
	{
		if (!empty($rpage['page_alias']))
		{
			$sql_page_update = $db->query("SELECT page_id FROM $db_pages WHERE page_alias='".$db->prep($rpage['page_alias'])."' AND page_id!=$id");
			$rpage['page_alias'] = ($sql_page_update->rowCount() > 0) ? $rpage['page_alias'].rand(1000, 9999) : $rpage['page_alias'];
		}

		$sql_page_update = $db->query("SELECT page_cat, page_state FROM $db_pages WHERE page_id=$id");
		$row_page_update = $sql_page_update->fetch();

		if ($row_page_update['page_cat'] != $rpage['page_cat'] /*&& ($row_page_update['page_state'] == 0 || $row_page_update['page_state'] == 2)*/)
		{
			$sql_page_update = $db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code='".$db->prep($row_page_update['page_cat'])."' AND structure_area = 'page'");
		}

		//$usr['isadmin'] = cot_auth('page', $rpage['page_cat'], 'A');
		if ($usr['isadmin'] && $cfg['page']['autovalidate'])
		{
			$rpublish = cot_import('rpublish', 'P', 'ALP');
			if ($rpublish == 'OK' )
			{
				$rpage['page_state'] = 0;
				if ($row_page_update['page_state'] == 1 || $row_page_update['page_cat'] != $rpage['page_cat'])
				{
					$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code='".$db->prep($rpage['page_cat'])."' AND structure_area = 'page'");
				}
			}
			else
			{
				$rpage['page_state'] = 1;
			}
		}
		else
		{
			$rpage['page_state'] = 1;
		}
		if ($rpage['page_state'] == 1 && $row_page_update['page_state'] != 1)
		{
			$db->query("UPDATE $db_structure SET structure_count=structure_count-1 WHERE structure_code='".$db->prep($rpage['page_cat'])."' ");
		}

		$sql_page_update = $db->update($db_pages, $rpage, 'page_id=?', array($id));
		cot_extrafield_movefiles();
		/* === Hook === */
		foreach (cot_getextplugins('page.edit.update.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($rpage['page_state'] == 0 && $cache)
		{
			if ($cfg['cache_page'])
			{
				$cache->page->clear('page/' . str_replace('.', '/', $structure['page'][$rpage['page_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->page->clear('index');
			}
		}

		cot_log("Edited page #".$id,'adm');
		cot_redirect(cot_url('page', "id=".$id, '', true));
	}
	else
	{
		cot_redirect(cot_url('page', "m=edit&id=$id", '', true));
	}
}

$sql_page = $db->query("SELECT * FROM $db_pages WHERE page_id=$id LIMIT 1");
cot_die($sql_page->rowCount() == 0);
$pag = $sql_page->fetch();

$sys['parser'] = $pag['page_parser'];

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $pag['page_cat']);
cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $pag['page_ownerid']);

$out['subtitle'] = $L['page_edittitle'];
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $structure['page'][$c]['title'];

/* === Hook === */
foreach (cot_getextplugins('page.edit.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';

$mskin = cot_tplfile(array('page', 'edit', $structure['page'][$pag['page_cat']]['tpl']));
$t = new XTemplate($mskin);

$pageedit_array = array(
	'PAGEEDIT_PAGETITLE' => $L['page_edittitle'],
	'PAGEEDIT_SUBTITLE' => $L['page_editsubtitle'],
	'PAGEEDIT_FORM_SEND' => cot_url('page', "m=edit&a=update&id=".$pag['page_id']),
	'PAGEEDIT_FORM_ID' => $pag['page_id'],
	'PAGEEDIT_FORM_STATE' => $pag['page_state'],
	'PAGEEDIT_FORM_CAT' => cot_selectbox_categories($pag['page_cat'], 'rpagecat'),
	'PAGEEDIT_FORM_CAT_SHORT' => cot_selectbox_categories($pag['page_cat'], 'rpagecat', $c),
	'PAGEEDIT_FORM_KEYWORDS' => cot_inputbox('text', 'rpagekeywords', $pag['page_keywords'], array('size' => '32', 'maxlength' => '255')),
	'PAGEEDIT_FORM_ALIAS' => cot_inputbox('text', 'rpagealias', $pag['page_alias'], array('size' => '32', 'maxlength' => '255')),
	'PAGEEDIT_FORM_TITLE' => cot_inputbox('text', 'rpagetitle', $pag['page_title'], array('size' => '64', 'maxlength' => '255')),
	'PAGEEDIT_FORM_DESC' => cot_inputbox('text', 'rpagedesc', $pag['page_desc'], array('size' => '64', 'maxlength' => '255')),
	'PAGEEDIT_FORM_AUTHOR' => cot_inputbox('text', 'rpageauthor', $pag['page_author'], array('size' => '24', 'maxlength' => '100')),
	'PAGEEDIT_FORM_DATE' => cot_selectbox_date($pag['page_date'],'long', 'rpagedate').' '.$usr['timetext'],
	'PAGEEDIT_FORM_DATENOW' => cot_checkbox(0, 'rpagedatenow'),
	'PAGEEDIT_FORM_BEGIN' => cot_selectbox_date($pag['page_begin'], 'long', 'rpagebegin').' '.$usr['timetext'],
	'PAGEEDIT_FORM_EXPIRE' => cot_selectbox_date($pag['page_expire'], 'long', 'rpageexpire').' '.$usr['timetext'],
	'PAGEEDIT_FORM_FILE' => cot_selectbox($pag['page_file'], 'rpagefile', range(0, 2), array($L['No'], $L['Yes'], $L['Members_only']), false),
	'PAGEEDIT_FORM_URL' => cot_inputbox('text', 'rpageurl', $pag['page_url'], array('size' => '56', 'maxlength' => '255')),
	'PAGEEDIT_FORM_SIZE' => cot_inputbox('text', 'rpagesize', $pag['page_size'], array('size' => '56', 'maxlength' => '255')),
	'PAGEEDIT_FORM_TEXT' => cot_textarea('rpagetext', $pag['page_text'], 24, 120, '', 'input_textarea_editor'),
	'PAGEEDIT_FORM_DELETE' => cot_radiobox(0, 'rpagedelete', array(1, 0), array($L['Yes'], $L['No'])),
	'PAGEEDIT_FORM_PARSER' => cot_selectbox($pag['page_parser'], 'rpageparser', cot_get_parsers(), cot_get_parsers(), false)
);
if ($usr['isadmin'])
{
	$pageedit_array += array(
		'PAGEEDIT_FORM_OWNERID' => cot_inputbox('text', 'rpageownerid', $pag['page_ownerid'], array('size' => '24', 'maxlength' => '24')),
		'PAGEEDIT_FORM_PAGECOUNT' => cot_inputbox('text', 'rpagecount', $pag['page_count'], array('size' => '8', 'maxlength' => '8')),
		'PAGEEDIT_FORM_FILECOUNT' => cot_inputbox('text', 'rpagefilecount', $pag['page_filecount'], array('size' => '8', 'maxlength' => '8'))
	);
}

$t->assign($pageedit_array);

// Extra fields
foreach($cot_extrafields[$db_pages] as $i => $row_extf)
{
	$uname = strtoupper($row_extf['field_name']);
	$t->assign('PAGEEDIT_FORM_'.$uname, cot_build_extrafields('rpage'.$row_extf['field_name'], $row_extf, $pag['page_'.$row_extf['field_name']]));
	$t->assign('PAGEEDIT_FORM_'.$uname.'_TITLE', isset($L['page_'.$row_extf['field_name'].'_title']) ?  $L['page_'.$row_extf['field_name'].'_title'] : $row_extf['field_description']);
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('page.edit.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['page']['autovalidate']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';

?>