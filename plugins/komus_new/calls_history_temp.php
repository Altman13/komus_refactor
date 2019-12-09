<?php
require "config/config.php";
require "vendor/autoload.php";

// история звонков+количество попыток совершенных оператором
$history_calls_count = $db->prepare("SELECT COUNT(calls.contacts_id) AS tryed_to_call, calls.status, contacts.id, contacts.phone, 
                                CONCAT(users.user_firstname, ' ', users.user_lastname) 
                            FROM contacts
                            LEFT JOIN calls ON contacts.id=calls.contacts_id
                            LEFT JOIN users ON users.user_id =contacts.users_user_id
                            GROUP BY calls.contacts_id");
$history_calls_count->execute();
$all_calls_count = $history_calls_count->fetchAll(PDO::FETCH_ASSOC);

// история звонков, совершенных оператором
$operator_calls_history = $db->prepare("SELECT contacts.id AS cont_id, contacts.phone, 
                                CONCAT(users.user_firstname, ' ', users.user_lastname) AS operator_fio 
                            FROM contacts
                            LEFT JOIN calls ON contacts.id=calls.contacts_id
                            LEFT JOIN users ON users.user_id =contacts.users_user_id");
$operator_calls_history->execute();
$oper_histroy = $operator_calls_history->fetchAll(PDO::FETCH_ASSOC);

//история звоноков по всем операторам
$history_calls_all_oper = $db->prepare("SELECT calls.contacts_id, calls.status, contacts.id, contacts.phone
                                    FROM contacts
                                    LEFT JOIN calls ON contacts.id=calls.contacts_id
                                    WHERE calls.contacts_id IS NOT NULL");
$history_calls_all_oper->execute();
$hs_calls_all_oper = $history_calls_all_oper->fetchAll(PDO::FETCH_ASSOC);

//все контакты для звонков
//если по контакту было 3 звонка - больше по нему не работаем
//TODO: дописать выборку по дате recall time - фильтр на перезвон
$all_contats = $db->prepare("SELECT calls.contacts_id, COUNT(calls.contacts_id) AS count_calls, calls.status, contacts.id, contacts.phone
                            FROM contacts
                            LEFT JOIN calls ON contacts.id=calls.contacts_id
                            WHERE calls.contacts_id IS NOT NULL
                            HAVING count_calls < 3");
    $all_contats->execute();
    $contacts=$all_contats->fetchAll(PDO::PARAM_STR);
