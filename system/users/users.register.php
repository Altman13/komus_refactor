<?php

/**
 * User Registration Script
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('auth');

$v = cot_import('v','G','ALP');
$y = cot_import('y','G','INT');

if ($cfg['disablereg'])
{
	$env['status'] = '403 Forbidden';
	cot_redirect(cot_url('message', 'msg=117', '', true));
}

/* === Hook === */
foreach (cot_getextplugins('users.register.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a=='add')
{
	cot_shield_protect();
	
	$ruser = array();

	/* === Hook for the plugins === */
	foreach (cot_getextplugins('users.register.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$ruser['user_name'] = cot_import('rusername','P','TXT', 100, TRUE);
	$ruser['user_email'] = cot_import('ruseremail','P','TXT',64, TRUE);
	$rpassword1 = cot_import('rpassword1','P','TXT',16);
	$rpassword2 = cot_import('rpassword2','P','TXT',16);
	$ruser['user_country'] = cot_import('rcountry','P','TXT');
	$ruser['user_timezone'] = cot_import('rtimezone','P','TXT',5);
	$ruser['user_timezone'] = is_null($ruser['user_timezone']) ? $cfg['defaulttimezone'] : (float) $ruser['user_timezone'];
	$ruser['user_gender'] = cot_import('rusergender','P','TXT');
	$ruser['user_email'] = mb_strtolower($ruser['user_email']);

	// Extra fields
	foreach($cot_extrafields[$db_users] as $row)
	{
		$ruser['user_'.$row['field_name']] = cot_import_extrafields('ruser'.$row['field_name'], $row);
	}
	$ruser['user_birthdate'] = (int)cot_import_date('ruserbirthdate', false);

	$user_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_name = ? LIMIT 1", array($ruser['user_name']))->fetch();
	$email_exists = (bool)$db->query("SELECT user_id FROM $db_users WHERE user_email = ? LIMIT 1", array($ruser['user_email']))->fetch();

	if (preg_match('/&#\d+;/', $ruser['user_name']) || preg_match('/[<>#\'"\/]/', $ruser['user_name'])) cot_error('aut_invalidloginchars', 'rusername');
	if (mb_strlen($ruser['user_name']) < 2) cot_error('aut_usernametooshort', 'rusername');
	if (mb_strlen($rpassword1) < 4) cot_error('aut_passwordtooshort', 'rpassword1');
	if (mb_strlen($ruser['user_email']) < 4 || !preg_match('#^[\w\p{L}][\.\w\p{L}\-]+@[\w\p{L}\.\-]+\.[\w\p{L}]+$#u', $ruser['user_email']))
		cot_error('aut_emailtooshort', 'ruseremail');
	if ($user_exists) cot_error('aut_usernamealreadyindb', 'rusername');
	if ($email_exists) cot_error('aut_emailalreadyindb', 'ruseremail');
	if ($rpassword1 != $rpassword2) cot_error('aut_passwordmismatch', 'rpassword2');
	
	$extrafields = array();
	foreach($cot_extrafields[$db_users] as $row)
	{
		$extrafields['user_'.$row['field_name']] = cot_import_extrafields('ruser'.$row['field_name'], $row);
	}

	/* === Hook for the plugins === */
	foreach (cot_getextplugins('users.register.add.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if (!cot_error_found())
	{
		$userid = add_user($ruser['user_email'], $ruser['user_name'], $rpassword1, $ruser['user_country'], $ruser['user_timezone'], $ruser['user_gender'], $ruser['user_birthdate'], $extrafields);
		
		/* === Hook for the plugins === */
		foreach (cot_getextplugins('users.register.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		if ($cfg['regnoactivation'] || $db->countRows($db_users) == 1)
		{
			cot_redirect(cot_url('message', 'msg=106', '', true));
		}
		elseif ($cfg['regrequireadmin'])
		{
			cot_redirect(cot_url('message', 'msg=118', '', true));
		}
		else
		{
			cot_redirect(cot_url('message', 'msg=105', '', true));
		}
	}
	else
	{
		cot_redirect(cot_url('users', 'm=register', '', true));
	}
}

elseif ($a == 'validate' && mb_strlen($v) == 32)
{
	/* === Hook for the plugins === */
	foreach (cot_getextplugins('users.register.validate.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_shield_protect();
	$sql = $db->query("SELECT * FROM $db_users WHERE user_lostpass='$v' AND (user_maingrp=2 OR user_maingrp='-1') LIMIT 1");

	if ($row = $sql->fetch())
	{
		if ($row['user_maingrp'] == 2)
		{
			if ($y == 1)
			{
				$sql = $db->update($db_users, array('user_maingrp' => 4), "user_id='".$row['user_id']."' AND user_lostpass='$v'");
				$sql = $db->update($db_groups_users, array('gru_groupid' => 4), "gru_groupid=2 AND gru_userid='".$row['user_id']."'");

				/* === Hook for the plugins === */
				foreach (cot_getextplugins('users.register.validate.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

				cot_auth_clear($row['user_id']);
				cot_redirect(cot_url('message', 'msg=106', '', true));
			}
			elseif ($y == 0)
			{
				foreach($cot_extrafields[$db_users] as $i => $row_extf) 
				{ 
					if ($row_extf['field_type']=='file')
					{
						 @unlink($cfg['extrafield_files_dir']."/".$sql['user_'.$row_extf['field_name']]); 
					}
				}
				
				$sql = $db->delete($db_users, "user_maingrp='2' AND user_lastlog='0' AND user_id='".$row['user_id']."' ");
				$sql = $db->delete($db_users, "user_id='".$row['user_id']."'");
				$sql = $db->delete($db_groups_users, "gru_userid='".$row['user_id']."'");

				/* === Hook for the plugins === */
				foreach (cot_getextplugins('users.register.validate.rejected') as $pl)
				{
					include $pl;
				}
				/* ===== */

				cot_redirect(cot_url('message', 'msg=109', '', true));
			}
		}
		elseif ($row['user_maingrp'] == -1)
		{
			$sql = $db->update($db_users, array('user_maingrp' => $row['user_sid']), "user_id='".$row['user_id']."' AND user_lostpass='$v'");
			cot_redirect(cot_url('message', 'msg=106', '', true));
		}
	}
	else
	{
		$env['status'] = '403 Forbidden';
		cot_shield_update(7, "Account validation");
		cot_log("Wrong validation URL", 'sec');
		cot_redirect(cot_url('message', 'msg=157', '', true));
	}
}

/* === Hook === */
foreach (cot_getextplugins('users.register.main') as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['aut_registertitle'];
$out['head'] .= $R['code_noindex'];
require_once $cfg['system_dir'] . '/header.php';
$t = new XTemplate(cot_tplfile('users.register', 'core'));

require_once cot_incfile('forms');

$timezonelist = array('-12', '-11', '-10', '-09', '-08', '-07', '-06', '-05', '-04', '-03',  '-03.5', '-02', '-01', '+00', '+01', '+02', '+03', '+03.5', '+04', '+04.5', '+05', '+05.5', '+06', '+07', '+08', '+09', '+09.5', '+10', '+11', '+12');
foreach($timezonelist as $x)
{
	$timezonename[] = 'GMT ' . $x;
}
$form_timezone = cot_selectbox($ruser['user_timezone'], 'rtimezone', $timezonelist, $timezonename, false);
$form_timezone .= ' '.$usr['gmttime']." / ".cot_date('datetime_medium', $sys['now_offset'] + $usr['timezone']*3600).' '.$usr['timetext'];

$t->assign(array(
	'USERS_REGISTER_TITLE' => $L['aut_registertitle'],
	'USERS_REGISTER_SUBTITLE' => $L['aut_registersubtitle'],
	'USERS_REGISTER_ADMINEMAIL' => $cot_adminemail,
	'USERS_REGISTER_SEND' => cot_url('users', 'm=register&a=add'),
	'USERS_REGISTER_USER' => cot_inputbox('text', 'rusername', $ruser['user_name'], array('size' => 24, 'maxlength' => 100)),
	'USERS_REGISTER_EMAIL' => cot_inputbox('text', 'ruseremail', $ruser['user_email'], array('size' => 24, 'maxlength' => 64)),
	'USERS_REGISTER_PASSWORD' => cot_inputbox('password', 'rpassword1', '', array('size' => 8, 'maxlength' => 32)),
	'USERS_REGISTER_PASSWORDREPEAT' => cot_inputbox('password', 'rpassword2', '', array('size' => 8, 'maxlength' => 32)),
	'USERS_REGISTER_COUNTRY' => cot_selectbox_countries($ruser['user_country'], 'rcountry'),
	'USERS_REGISTER_TIMEZONE' => $form_timezone,
	'USERS_REGISTER_GENDER' => cot_selectbox_gender($ruser['user_gender'],'rusergender'),
	'USERS_REGISTER_BIRTHDATE' => cot_selectbox_date(cot_mktime(1, 0, 0, $rmonth, $rday, $ryear), 'short', '', cot_date('Y', $sys['now_offset']), cot_date('Y', $sys['now_offset']) - 100, false),
));

// Extra fields
foreach($cot_extrafields[$db_users] as $i => $row)
{
	$t->assign('USERS_REGISTER_'.strtoupper($row['field_name']), cot_build_extrafields('ruser'.$row['field_name'],  $row, htmlspecialchars($ruser['user_extrafields'][$row['field_name']])));
	$t->assign('USERS_REGISTER_'.strtoupper($row['field_name']).'_TITLE', isset($L['user_'.$row['field_name'].'_title']) ? $L['user_'.$row['field_name'].'_title'] : $row['field_description']);
}

// Error and message handling
cot_display_messages($t);


/* === Hook === */
foreach (cot_getextplugins('users.register.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';

?>