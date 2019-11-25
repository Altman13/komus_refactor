<?php
/**
 * Users loader
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */

define('COT_CODE', TRUE);
define('COT_USERS', TRUE);
define('COT_CORE', TRUE);
$env['location'] = 'users';
$env['ext'] = 'users';

if (isset($_GET['m']) && $_GET['m'] == 'auth')
{
	define('COT_AUTH', TRUE);
}

require_once './datas/config.php';
require_once $cfg['system_dir'] . '/functions.php';
require_once $cfg['system_dir'] . '/common.php';
require_once $cfg['system_dir'] . '/cotemplate.php';

require_once cot_incfile('extrafields');
require_once cot_incfile('uploads');

require_once cot_incfile('users', 'module');

if (!in_array($m, array('auth', 'details', 'edit', 'logout', 'passrecover', 'profile', 'register')))
{
	$m = 'main';
}

include cot_incfile('users', 'module', $m);

?>