<?php
/**
 * Contact Plugin API
 *
 * @package contact
 * @version 2.1.0
 * @author Seditio.by & Cotonti Team
 * @copyright (c) 2008-2011 Seditio.by and Cotonti Team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('komus_search', 'plug');

function getReferenceItem($ref_id) {
    global $db, $db_x;

    if (empty($ref_id)) {
        return '';
    } else {
        $sql_ref_string = "
            SELECT title
            FROM {$db_x}komus_references_items
            WHERE id = $ref_id
        ";
        $sql_ref = $db->query($sql_ref_string);

        return $sql_ref->fetchColumn();
    }
} 

function getStatusItem($ref_id) {
    global $db, $db_x;

    if (empty($ref_id)) {
        return '';
    } else {
        $sql_ref_string = "
            SELECT title
            FROM {$db_x}komus_statuses
            WHERE id = $ref_id
        ";
        $sql_ref = $db->query($sql_ref_string);

        return $sql_ref->fetchColumn();
    }
}

function getSelect($value, $referens) {
    global $db, $db_x;
    $sql_string = "
                     SELECT * 
                     FROM {$db_x}komus_references_items
                     WHERE reference_id = {$referens}
                     ORDER BY sort                              
                   ";
        
    $sql_select = $db->query($sql_string);  
    $field_html .= '<option value="0"></option>';               
    foreach ($sql_select->fetchAll() as $field) {                 	
       if ($value == $field['id']) {
      	   $field_html .= '<option value="'.$field['id'].'" selected>'.$field['title'].'</option>';
       } else {
           $field_html .= '<option value="'.$field['id'].'">'.$field['title'].'</option>';
  	   }
    }
    
    return $field_html;
} 
?>
