<?php

/**
 * Administration panel - Extra fields editor for structure part
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

require_once cot_incfile('extrafields');

$extra_blacklist = array($db_auth, $db_cache, $db_cache_bindings, $db_core, $db_updates, $db_logger, $db_online, $db_extra_fields, $db_config, $db_plugins);
$extra_whitelist = array(
	$db_users => array('name' => $db_users, 'caption' => $L['Users'], 'help' => $L['adm_help_structure_extrafield']),
	$db_structure => array('name' => $db_structure, 'caption' => $L['Categories'], 'help' => $L['adm_help_users_extrafield']),
);
$adminpath[] = array(cot_url('admin', 'm=extrafields'), $L['adm_extrafields']);

$t = new XTemplate(cot_tplfile(array('admin', 'extrafields', $n), 'core'));

/* === Hook === */
foreach (cot_getextplugins('admin.extrafields.first') as $pl)
{
	include $pl;
}
/* ===== */

if (empty($n) || in_array($n, $extra_blacklist))
{
	// no params
	$sql = $db->query("SHOW TABLES WHERE 1");
	$tablelist = array();
	while ($row = $sql->fetch())
	{
		$table = current($row);
		if (!in_array($table, $extra_blacklist))
		{
			if (cot_import('alltables', 'G', 'BOL'))
			{
				$tablelist[] = $table;
			}
			elseif(isset($extra_whitelist[$table]))
			{
				$tablelist[] = $table;
			}
		}
	}
	$ii = 0;
	foreach ($tablelist as $table)
	{	
		$ii++;
		$t->assign(array(
			'ADMIN_EXTRAFIELDS_ROW_TABLENAME' => (isset($extra_whitelist[$table])) ? $extra_whitelist[$table]['caption'] : $table,
			'ADMIN_EXTRAFIELDS_ROW_TABLEURL' => cot_url('admin', 'm=extrafields&n='.$table),
			'ADMIN_EXTRAFIELDS_COUNTER_ROW' => $ii,
			'ADMIN_EXTRAFIELDS_ODDEVEN' => cot_build_oddeven($ii)
		));
		$t->parse('MAIN.TABLELIST.ROW');
	}
	$t->assign('ADMIN_EXTRAFIELDS_ALLTABLES', cot_url('admin', 'm=extrafields&alltables=1'));
	/* === Hook  === */
	foreach (cot_getextplugins('admin.extrafields.tablelist.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
	$t->parse('MAIN.TABLELIST');
}
else
{
	$a = cot_import('a', 'G', 'ALP');
	$id = (int)cot_import('id', 'G', 'INT');
	$name = cot_import('name', 'G', 'ALP');
	list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
	$parse_type = array('HTML', 'Text');
	
	$adminpath[] = array(cot_url('admin', 'm=extrafields&n='.$n), (isset($extra_whitelist[$n])) ? $extra_whitelist[$n]['caption'] : $n); 
	
	if ($a == 'add')
	{
		$field['field_name'] = cot_import('field_name', 'P', 'ALP');
		$field['field_type'] = cot_import('field_type', 'P', 'ALP');
		$field['field_html'] = cot_import('field_html', 'P', 'NOC');
		$field['field_variants'] = cot_import('field_variants', 'P', 'HTM');
		$field['field_params'] = cot_import('field_params', 'P', 'HTM');
		$field['field_description'] = cot_import('field_description', 'P', 'NOC');
		$field['field_default'] = cot_import('field_default', 'P', 'HTM');
		$field['field_required'] = cot_import('field_required', 'P', 'BOL');
		$field['field_parse'] = cot_import('field_parse', 'P', 'ALP');
		$field['field_noalter'] = cot_import('field_noalter', 'P', 'BOL');
		$field['field_enabled'] = 1;
		if (empty($field['field_html']))
		{
			$field['field_html'] = cot_default_html_construction($field['field_type']);
		}

		/* === Hook === */
		foreach (cot_getextplugins('admin.extrafields.add') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if (!empty($field['field_name']) && !empty($field['field_type']))
		{
			if (cot_extrafield_add($n, $field['field_name'], $field['field_type'], $field['field_html'], $field['field_variants'], $field['field_default'], $field['field_required'], $field['field_parse'], $field['field_description'], $field['field_params'], $field['field_enabled'], $field['field_noalter']))
			{
				cot_message('adm_extrafield_added');
			}
			else
			{
				cot_error('adm_extrafield_not_added');
			}
		}
	}
	elseif ($a == 'upd')
	{
		$field_name = cot_import('field_name', 'P', 'ARR');
		$field_type = cot_import('field_type', 'P', 'ARR');
		$field_html = cot_import('field_html', 'P', 'ARR');
		$field_variants = cot_import('field_variants', 'P', 'ARR');
		$field_params = cot_import('field_params', 'P', 'ARR');
		$field_description = cot_import('field_description', 'P', 'ARR');
		$field_default = cot_import('field_default', 'P', 'ARR');
		$field_required = cot_import('field_required', 'P', 'ARR');
		$field_parse = cot_import('field_parse', 'P', 'ARR');
		$field_enabled = cot_import('field_enabled', 'P', 'ARR');

		/* === Hook - Part1 : Set === */
		$extp = cot_getextplugins('admin.extrafields.update');
		/* ===== */
		if (is_array($field_name))
		{
			foreach ($field_name as $k => $v)
			{
				$field['field_name'] = cot_import($field_name[$k], 'D', 'ALP');
				$field['field_type'] = cot_import($field_type[$k], 'D', 'ALP');
				$field['field_html'] = cot_import($field_html[$k], 'D', 'NOC');
				$field['field_variants'] = cot_import($field_variants[$k], 'D', 'HTM');
				$field['field_params'] = cot_import($field_params[$k], 'D', 'HTM');
				$field['field_description'] = cot_import($field_description[$k], 'D', 'NOC');
				$field['field_default'] = cot_import($field_default[$k], 'D', 'HTM');
				$field['field_required'] = cot_import($field_required[$k], 'D', 'BOL');
				$field['field_parse'] = cot_import($field_parse[$k], 'D', 'ALP');
				$field['field_enabled'] = cot_import($field_enabled[$k], 'D', 'BOL');
				$field['field_location'] = $n;

				if ($field != $cot_extrafields[$n][$field['field_name']] && !empty($field['field_name']) && !empty($field['field_type']))
				{
					if (empty($field['field_html']) || $field['field_type'] != $cot_extrafields[$n][$field['field_name']]['field_type'])
					{
						$field['field_html'] = cot_default_html_construction($field['field_type']);
					}

					/* === Hook - Part2 : Include === */
					foreach ($extp as $pl)
					{
						include $pl;
					}
					/* ===== */

					$fieldresult = cot_extrafield_update($n, $k, $field['field_name'], $field['field_type'], $field['field_html'], $field['field_variants'], $field['field_default'], $field['field_required'], $field['field_parse'], $field['field_description'], $field['field_params'], $field['field_enabled']);
					if ($fieldresult == 1)
					{
						cot_message(sprintf($L['adm_extrafield_updated'], $k));
					}
					elseif (!$fieldresult)
					{
						cot_error(sprintf($L['adm_extrafield_not_updated'], $k));
					}
				}
			}
		}
	}
	elseif ($a == 'del' && isset($name))
	{
		/* === Hook === */
		foreach (cot_getextplugins('admin.extrafields.delete') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if (cot_extrafield_remove($n, $name))
		{
			cot_message('adm_extrafield_removed');
		}
		else
		{
			cot_error('adm_extrafield_not_removed');
		}
	}

	$cache && $cache->db->remove('cot_extrafields', 'system');

	$totalitems = $db->query("SELECT COUNT(*) FROM $db_extra_fields WHERE field_location = '$n'")->fetchColumn();
	$res = $db->query("SELECT * FROM $db_extra_fields WHERE field_location = '$n' ORDER BY field_name ASC LIMIT $d, ".$cfg['maxrowsperpage']);

	$pagenav = cot_pagenav('admin', 'm=extrafields&n='.$n, $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

	$field_types = array('input', 'inputint', 'currency', 'double', 'textarea', 'select', 'checkbox', 'radio', 'datetime', 'country', 'file'/* , 'filesize' */);

	$ii = 0;
	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('admin.extrafields.loop');
	/* ===== */
	foreach ($res->fetchAll() as $row)
	{
		$t->assign(array(
			'ADMIN_EXTRAFIELDS_ROW_NAME' => cot_inputbox('text', 'field_name['.$row['field_name'].']', $row['field_name']),
			'ADMIN_EXTRAFIELDS_ROW_DESCRIPTION' => cot_textarea('field_description['.$row['field_name'].']', $row['field_description'], 1, 30),
			'ADMIN_EXTRAFIELDS_ROW_SELECT' => cot_selectbox($row['field_type'], 'field_type['.$row['field_name'].']', $field_types, $field_types, false),
			'ADMIN_EXTRAFIELDS_ROW_VARIANTS' => cot_textarea('field_variants['.$row['field_name'].']', $row['field_variants'], 1, 60),
			'ADMIN_EXTRAFIELDS_ROW_PARAMS' => cot_textarea('field_params['.$row['field_name'].']', $row['field_params'], 1, 60),
			'ADMIN_EXTRAFIELDS_ROW_HTML' => cot_textarea('field_html['.$row['field_name'].']', $row['field_html'], 1, 60),
			'ADMIN_EXTRAFIELDS_ROW_DEFAULT' => cot_textarea('field_default['.$row['field_name'].']', $row['field_default'], 1, 60),
			'ADMIN_EXTRAFIELDS_ROW_REQUIRED' => cot_checkbox($row['field_required'], 'field_required['.$row['field_name'].']'),
			'ADMIN_EXTRAFIELDS_ROW_ENABLED' => cot_checkbox($row['field_enabled'], 'field_enabled['.$row['field_name'].']', '', 'title="'.$L['adm_extrafield_enable'].'"'),
			'ADMIN_EXTRAFIELDS_ROW_PARSE' => cot_selectbox($row['field_parse'], 'field_parse['.$row['field_name'].']', $parse_type, $parse_type, false),
			'ADMIN_EXTRAFIELDS_ROW_BIGNAME' => strtoupper($row['field_name']),
			'ADMIN_EXTRAFIELDS_ROW_ID' => $row['field_name'],
			'ADMIN_EXTRAFIELDS_ROW_DEL_URL' => cot_url('admin', 'm=extrafields&n='.$n.'&a=del&name='.$row['field_name'])
		));

		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->parse('MAIN.TABLE.EXTRAFIELDS_ROW');
		$ii++;
	}

	$t->assign(array(
		'ADMIN_EXTRAFIELDS_URL_FORM_EDIT' => cot_url('admin', 'm=extrafields&n='.$n.'&a=upd&d='.$durl),
		'ADMIN_EXTRAFIELDS_NAME' => cot_inputbox('text', 'field_name', ''),
		'ADMIN_EXTRAFIELDS_DESCRIPTION' => cot_textarea('field_description', '', 1, 30),
		'ADMIN_EXTRAFIELDS_SELECT' => cot_selectbox('input', 'field_type', $field_types, $field_types, false),
		'ADMIN_EXTRAFIELDS_VARIANTS' => cot_textarea('field_variants', '', 1, 60),
		'ADMIN_EXTRAFIELDS_PARAMS' => cot_textarea('field_params', '', 1, 60),
		'ADMIN_EXTRAFIELDS_HTML' => cot_textarea('field_html', '', 1, 60),
		'ADMIN_EXTRAFIELDS_DEFAULT' => cot_textarea('field_default', '', 1, 60),
		'ADMIN_EXTRAFIELDS_REQUIRED' => cot_checkbox(0, 'field_required'),
		'ADMIN_EXTRAFIELDS_PARSE' => cot_selectbox('HTML', 'field_parse', $parse_type, $parse_type, false),
		'ADMIN_EXTRAFIELDS_URL_FORM_ADD' => cot_url('admin', 'm=extrafields&n='.$n.'&a=add&d='.$durl),
		'ADMIN_EXTRAFIELDS_PAGINATION_PREV' => $pagenav['prev'],
		'ADMIN_EXTRAFIELDS_PAGNAV' => $pagenav['main'],
		'ADMIN_EXTRAFIELDS_PAGINATION_NEXT' => $pagenav['next'],
		'ADMIN_EXTRAFIELDS_TOTALITEMS' => $totalitems,
		'ADMIN_EXTRAFIELDS_COUNTER_ROW' => $ii,
		'ADMIN_EXTRAFIELDS_ODDEVEN' => cot_build_oddeven($ii)
	));

	cot_display_messages($t);

	if (isset($extra_whitelist[$n]['help']))
	{
		$adminhelp = $extra_whitelist[$n]['help'];
	}	
	/* === Hook  === */
	foreach (cot_getextplugins('admin.extrafields.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse('MAIN.TABLE');
}
$t->parse('MAIN');
$adminmain = $t->text('MAIN');
?>