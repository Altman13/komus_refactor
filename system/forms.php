<?php

/**
 * Form generation API
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Trustmaster
 * @copyright Copyright (c) Cotonti Team 2008-2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Registers textarea instances to inform RichText editors that they need to be loaded
 */
$cot_textarea_count = 0;

/**
 * Generates a checkbox output
 * @param bool $chosen Checkbox state
 * @param string $name Input name
 * @param string $title Option caption
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @param string $value Input value (passed), defaults to 'on' or '1'
 */
function cot_checkbox($chosen, $name, $title = '', $attrs = '', $value = '1')
{
	global $R;
	$input_attrs = cot_rc_attr_string($attrs);
	$checked = $chosen ? ' checked="checked"' : '';
	$rc_name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;
	$rc = empty($R["input_checkbox_{$rc_name}"]) ? 'input_checkbox' : "input_checkbox_{$rc_name}";
	return cot_rc($rc, array(
		'value' => htmlspecialchars(cot_import_buffered($name, $value)),
		'name' => $name,
		'checked' => $checked,
		'title' => $title,
		'attrs' => $input_attrs
	));
}

/**
 * Generates a form input from a resource string
 *
 * @param string $type Input type: text, checkbox, button, file, hidden, image, password, radio, reset, submit
 * @param string $name Input name
 * @param string $value Entered value
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @param string $custom_rc Custom resource string name
 * @return string
 */
function cot_inputbox($type, $name, $value = '', $attrs = '', $custom_rc = '')
{
	global $R, $cfg;
	$input_attrs = cot_rc_attr_string($attrs);
	$rc_name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;
	$rc = empty($custom_rc)
		? (empty($R["input_{$type}_{$rc_name}"]) ? "input_$type" : "input_{$type}_{$rc_name}")
		: $custom_rc;
	if (!isset($R[$rc]))
	{
		$rc = 'input_default';
	}
	$error = $cfg['msg_separate'] ? cot_implode_messages($name, 'error') : '';
	return cot_rc($rc, array(
		'type' => $type,
		'name' => $name,
		'value' => htmlspecialchars(cot_import_buffered($name, $value)),
		'attrs' => $input_attrs,
		'error' => $error
	));
}

/**
 * Generates a radio input group
 *
 * @param string $chosen Seleced value
 * @param string $name Input name
 * @param array $values Options available
 * @param array $titles Titles for options
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @param string $separator Option separator, by default is taken from $R['input_radio_separator']
 * @return string
 */
function cot_radiobox($chosen, $name, $values, $titles = array(), $attrs = '', $separator = '')
{
	global $R;
	if (!is_array($values))
	{
		$values = explode(',', $values);
	}
	if (!is_array($titles))
	{
		$titles = explode(',', $titles);
	}
	$use_titles = count($values) == count($titles);
	$input_attrs = cot_rc_attr_string($attrs);
	$chosen = cot_import_buffered($name, $chosen);
	if (empty($separator))
	{
		$separator = $R['input_radio_separator'];
	}
	$i = 0;
	$result = '';
	$rc_name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;
	$rc = empty($R["input_radio_{$rc_name}"]) ? 'input_radio' : "input_radio_{$rc_name}";
	foreach ($values as $k => $x)
	{
		$checked = ($x == $chosen) ? ' checked="checked"' : '';
		$title = $use_titles ? htmlspecialchars($titles[$k]) : htmlspecialchars($x);
		if ($i > 0)
		{
			$result .= $separator;
		}
		$result .= cot_rc($rc, array(
			'value' => htmlspecialchars($x),
			'name' => $name,
			'checked' => $checked,
			'title' => $title,
			'attrs' => $input_attrs
		));
		$i++;
	}
	return $result;
}

/**
 * Renders a dropdown
 *
 * @param mixed $chosen Seleced value (or values array for mutli-select)
 * @param string $name Dropdown name
 * @param array $values Options available
 * @param array $titles Titles for options
 * @param bool $add_empty Allow empty choice
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @return string
 */
function cot_selectbox($chosen, $name, $values, $titles = array(), $add_empty = true, $attrs = '')
{
	global $R, $cfg;

	if (!is_array($values))
	{
		$values = explode(',', $values);
	}
	if (!is_array($titles))
	{
		$titles = explode(',', $titles);
	}
	$use_titles = count($values) == count($titles);
	$input_attrs = cot_rc_attr_string($attrs);
	$chosen = cot_import_buffered($name, $chosen);
	$multi = is_array($chosen) && isset($input_attrs['multiple']);
	$error = $cfg['msg_separate'] ? cot_implode_messages($name, 'error') : '';
	$rc_name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;

	$selected = (is_null($chosen) || $chosen === '' || $chosen == '00') ? ' selected="selected"' : '';
	$rc = empty($R["input_option_{$rc_name}"]) ? 'input_option' : "input_option_{$rc_name}";
	if ($add_empty)
	{
		$options .= cot_rc($rc, array(
			'value' => '',
			'selected' => $selected,
			'title' => $R['code_option_empty']
		));
	}
	foreach ($values as $k => $x)
	{
		$x = trim($x);
		$selected = ($multi && in_array($x, $chosen)) || (!$multi && $x == $chosen) ? ' selected="selected"' : '';
		$title = $use_titles ? htmlspecialchars($titles[$k]) : htmlspecialchars($x);
		$options .= cot_rc($rc, array(
			'value' => htmlspecialchars($x),
			'selected' => $selected,
			'title' => $title
		));
	}
	$rc = empty($R["input_select_{$rc_name}"]) ? 'input_select' : "input_select_{$rc_name}";
	$result .= cot_rc($rc, array(
		'name' => $name,
		'attrs' => $input_attrs,
		'error' => $error,
		'options' => $options
	));
	return $result;
}

/**
 * Renders country dropdown
 *
 * @param string $chosen Seleced value
 * @param string $name Dropdown name
 * @param bool $add_empty Add empty language option
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @return string
 */
function cot_selectbox_countries($chosen, $name, $add_empty = true, $attrs = '')
{
	global $cot_countries;

	if (!$cot_countries)
		include_once cot_langfile('countries', 'core');

	return cot_selectbox($chosen, $name, array_keys($cot_countries), array_values($cot_countries), $add_empty, $attrs);
}

/**
 * Generates date part dropdown
 *
 * @param int $utime Selected timestamp
 * @param string $mode Display mode: 'short' or complete
 * @param string $name Variable name preffix
 * @param int $max_year Max. year possible
 * @param int $min_year Min. year possible
 * @param bool $usertimezone Use user timezone
 * @return string
 */
function cot_selectbox_date($utime, $mode = 'long', $name = '', $max_year = 2030, $min_year = 2000, $usertimezone = true)
{
	global $L, $R, $usr;
	$name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;

	$utime = ($usertimezone && $utime > 0) ? ($utime + $usr['timezone'] * 3600) : $utime;

	if ($utime == 0)
	{
		list($s_year, $s_month, $s_day, $s_hour, $s_minute) = array(null, null, null, null, null);
	}
	else
	{
		list($s_year, $s_month, $s_day, $s_hour, $s_minute) = explode('-', @date('Y-m-d-H-i', $utime));
	}
	$months = array();
	$months[1] = $L['January'];
	$months[2] = $L['February'];
	$months[3] = $L['March'];
	$months[4] = $L['April'];
	$months[5] = $L['May'];
	$months[6] = $L['June'];
	$months[7] = $L['July'];
	$months[8] = $L['August'];
	$months[9] = $L['September'];
	$months[10] = $L['October'];
	$months[11] = $L['November'];
	$months[12] = $L['December'];

	$year = cot_selectbox($s_year, $name.'[year]', range($min_year, $max_year));
	$month = cot_selectbox($s_month, $name.'[month]', array_keys($months), array_values($months));
	$day = cot_selectbox($s_day, $name.'[day]', range(1, 31));

	$range = array();
	for ($i = 0; $i < 24; $i++)
	{
		$range[] = sprintf('%02d', $i);
	}
	$hour = cot_selectbox($s_hour, $name.'[hour]', $range);

	$range = array();
	for ($i = 0; $i < 60; $i++)
	{
		$range[] = sprintf('%02d', $i);
	}

	$minute = cot_selectbox($s_minute, $name.'[minute]', $range);

	$rc = empty($R["input_date_{$mode}"]) ? 'input_date' : "input_date_{$mode}";
	$rc = empty($R["input_date_{$name}"]) ? $rc : "input_date_{$name}";

	$result = cot_rc($rc, array(
		'day' => $day,
		'month' => $month,
		'year' => $year,
		'hour' => $hour,
		'minute' => $minute
	));

	return $result;
}

/**
 * Returns language selection dropdown
 *
 * @param string $chosen Seleced value
 * @param string $name Dropdown name
 * @param bool $add_empty Add empty language option
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @return string
 */
function cot_selectbox_lang($chosen, $name, $add_empty = false, $attrs = '')
{
	global $cot_languages, $cot_countries, $cfg;

	$handle = opendir($cfg['lang_dir'] . '/');
	while ($f = readdir($handle))
	{
		if ($f[0] != '.')
		{
			$langlist[] = $f;
		}
	}
	closedir($handle);
	sort($langlist);

	if (!$cot_countries)
		include_once cot_langfile('countries', 'core');

	$vals = array();
	$titles = array();
	foreach ($langlist as $lang)
	{
		$vals[] = $lang;
		$titles[] = (empty($cot_languages[$lang]) ? $cot_countries[$lang] : $cot_languages[$lang]) . " ($lang)";
	}
	return cot_selectbox($chosen, $name, $vals, $titles, $add_empty, $attrs);
}

/**
 * Generates a textarea
 *
 * @param string $name Input name
 * @param string $value Entered value
 * @param int $rows Number of rows
 * @param int $cols Number of columns
 * @param mixed $attrs Additional attributes as an associative array or a string
 * @param string $custom_rc Custom resource string name
 * @return string
 */
function cot_textarea($name, $value, $rows, $cols, $attrs = '', $custom_rc = '')
{
	global $cot_textarea_count, $R;
	$cot_textarea_count++;
	$input_attrs = cot_rc_attr_string($attrs);
	$rc_name = preg_match('#^(\w+)\[(.*?)\]$#', $name, $mt) ? $mt[1] : $name;
	$rc = empty($custom_rc)
		? (empty($R["input_textarea_{$rc_name}"]) ? 'input_textarea' : "input_textarea_{$rc_name}")
		: $custom_rc;
	$error = $cfg['msg_separate'] ? cot_implode_messages($name, 'error') : '';
	return cot_rc($rc, array(
		'name' => $name,
		'value' => htmlspecialchars(cot_import_buffered($name, $value)),
		'rows' => $rows,
		'cols' => $cols,
		'attrs' => $input_attrs,
		'error' => $error
	));
}
?>
