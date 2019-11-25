<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Komus Reports Plugin for Cotonti CMF
 *
 * @package komus_load
 * @version 1.0.0
 * @author Sergey Lobanov
 * @copyright (c) Komus
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/*========================================*/
$max_calls = 4;
/*========================================*/

require_once cot_langfile('komus_load');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'w');

$gr_operator_groups = array(5, 6);
$operator_groups = array();

$gr_operator_access = false;
$operator_access = false;

$sql_user_string = "SELECT gru_groupid FROM {$db_x}groups_users WHERE gru_userid = {$usr['id']}";
$sql_user = $db->query($sql_user_string);

foreach ($sql_user->fetchAll() as $group) {
	if (in_array($group['gru_groupid'], $gr_operator_groups)) {
		$gr_operator_access = true;
	}
	if (in_array($group['gru_groupid'], $operator_groups)) {
		$operator_access = true;
	}
}

$plugin_title = $L['komus_reports_title'];

$mode = cot_import('mode', 'G', 'ALP');

switch ($mode) {
	case 'load':
		$target = 'datas/users/load.xls';

		//подключаем и создаем класс PHPExcel
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
		include_once 'PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		//PHPExcel_Settings::setLocale('ru');

		if (move_uploaded_file($_FILES["fileload"]["tmp_name"], $target)) {
			//$objPHPExcel = PHPExcel_IOFactory::load($target);

			// Использование фильтра загрузки
			$inputFileType = PHPExcel_IOFactory::identify($target);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

			// фильтр (нормально работает для Excel2007 и ODF OpenOffic
			//$filterSubset = new MyReadFilter(1,3,range('A','C'));
			//$objReader->setReadFilter($filterSubset);

			// для ODF OpenOffic
			if ($inputFileType == 'OOCalc') {
				$objReader->setLoadSheetsOnly('Лист1');
			}

			$objPHPExcel = $objReader->load($target);
			////////////////////////////////////////

			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

			foreach ($sheetData as $row) {

				$insert_base['fio']       	= $row['B'];
				$insert_base['policenumber']  	= $row['C'];
				$insert_base['productnumber']  	= $row['D'];
				$insert_base['productname']		= $row['E'];
				$insert_base['currency']		= $row['F'];
				$insert_base['contractdate']	= $row['G'];
				$insert_base['dateend']     	= $row['I'];
				$insert_base['period']     		= $row['L'];
				$insert_base['premium']     	= $row['O'];
				$insert_base['summ']     		= $row['P'];
				$insert_base['profit']     		= $row['T'];
				$insert_base['profityear']     	= $row['V'];
				$insert_base['bank']     		= $row['AA'];
				$insert_base['segment']     	= $row['AC'];
				$insert_base['strategy']     	= $row['AD'];
				$insert_base['marketname']     	= $row['AE'];
				$insert_base['region']     		= $row['AF'];
				$insert_base['city']     		= $row['AG'];
				$insert_base['birthdate']     	= $row['AH'];
				$insert_base['address']     	= $row['AJ'];
				$insert_base['phone1']     		= $row['AK'];
				$insert_base['phone2']     		= $row['AL'];
				$insert_base['email']     		= $row['AN'];
				$insert_base['office']     		= $row['AM'];

				// $insert_base['phone3']   	= $row['I'];

				$insert_base['time_zone'] = 0;
				$sql_insert = $db->insert($db_x . 'komus_contacts', $insert_base);

				$url = 'e=komus_load&mode=loadok';
			}
		} else {
			$url = 'e=komus_load&mode=loaderror';
		}

		header('Location: ' . cot_url('plug', $url, '', 'true'));
		exit;
		break;

	case 'loaderror':
		$t->parse('MAIN.LOADERROR');
		break;

	case 'loadok':
		$t->parse('MAIN.LOADOK');
		break;


	default:
		if ($gr_operator_access) {
			$t->assign(array(
				'KOMUS_LOAD_URL'   => cot_url('plug', 'e=komus_load&mode=load')
			));
			$t->parse('MAIN.HOME.GRAND_OPERATOR');
		}

		if ($operator_access) {
			$t->assign(array());
			$t->parse('MAIN.HOME.OPERATOR');
		}
}

$t->assign(array(
	'KOMUS_LOAD_TITLE' => $L['komus_load_title']
));
$t->parse('MAIN.HOME');
