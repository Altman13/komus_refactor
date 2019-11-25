<?php
function Filter()
{
    global $db, $db_x, $t;

    //Фильтр по сфере деятельности
    $sql_filtr_string = "SELECT DISTINCT segment FROM {$db_x}komus_contacts
                         ORDER BY segment ";
    $sql_filtr = $db->query($sql_filtr_string);
    $field_html1 = "<select name=\"filtr1\">\n";
    $field_html1 .= "<option value=\"0\"> </option>\n";
    foreach ($sql_filtr->fetchAll() as $field) {
        $field['segment'] = trim($field['segment']);
        $selected = ($_SESSION['filtr1'] == $field['segment']) ?
            ' selected="true"' : '';
        $field_html1 .= <<<HTML
    <option value="{$field['segment']}"{$selected}>{$field['segment']}</option>\n
HTML;
    }
    $field_html1 .= "</select>\n";

    //Фильтр по сфере деятельности
    $sql_filtr_string = "SELECT DISTINCT city FROM {$db_x}komus_contacts ORDER BY city";
    $sql_filtr = $db->query($sql_filtr_string);
    $field_html = "<select name=\"filtr\">\n";
    $field_html .= "<option value=\"0\"> </option>\n";
    foreach ($sql_filtr->fetchAll() as $field) {
        $field['city'] = trim($field['city']);
        $selected = ($_SESSION['filtr'] == $field['city']) ?
            ' selected="true"' : '';
        $field_html .= <<<HTML
            <option value="{$field['city']}"{$selected}>{$field['city']}</option>\n
        HTML;
    }
    $field_html .= "</select>\n";
    $t->assign(array(
        'KOMUS_SPLASH_FILTER_SEGMENT'   => "Сфера деятельности: " . $field_html1,
        'KOMUS_SPLASH_FILTER_ACTIVITY'  => "База: " . $field_html2,
        'KOMUS_SPLASH_FILTER_REGION'    => "Город: " . $field_html,
        'KOMUS_FILTER_SHOW'             => true
    ));
}
