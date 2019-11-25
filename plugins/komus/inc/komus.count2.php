<?php
function ShowCount($usr_id, $item_id)
{
    global $db, $db_x, $t;

    // Статусы звонка
    $refArray = array();
    $sql_ref_string = "SELECT * FROM {$db_x}komus_references_items 
                            WHERE reference_id = $item_id ORDER BY sort";
    $sql_ref = $db->query($sql_ref_string);
    foreach ($sql_ref as $key => $row) {
        $refArray[$row['id']]['title'] = $row['title'];
        $refArray[$row['id']]['count'] = 0;
    }
    // Кол-во звонков по статусам
    $sql_count_string = "SELECT COUNT(*) AS count, status FROM cot_komus_calls 
                            WHERE user_id = {$usr_id} AND status != 0
                            GROUP BY status";
    $sql_count = $db->query($sql_count_string);
    $count_data       = $sql_count->fetchAll();
    foreach ($count_data as $result) {
        $refArray[$result['status']]['count'] = $result['count'];
    }
    // Шапка
    foreach ($refArray as $item) {
        $t->assign(array(
            'KOMUS_QUANTITY_HEADER' =>  $item['title']
        ));
        $t->parse('MAIN.OPERATOR.COUNT_HEADER');
    }
    // Кол-во
    foreach ($refArray as $item) {
        $t->assign(array(
            'KOMUS_QUANTITY_STATUS' =>  $item['count']
        ));
        $t->parse('MAIN.OPERATOR.COUNT_STATUS');
    }
    $t->assign(array(
        'KOMUS_COUNT_SHOW'       =>  true
    ));
}
