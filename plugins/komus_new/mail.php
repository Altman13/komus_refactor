<?php
require "config/config.php";
require "vendor/autoload.php";
$faker = Faker\Factory::create();
global $contact_id;
global $mail_log;
//Выбираем значения по внешним ключам из связанной таблицы для заполнения
$contacts_id = $db->prepare("SELECT contacts.id FROM contacts");
try {
    $contacts_id->execute();
} catch (\Throwable $th) {
    echo 'Произошла ошибка при выборе внешних ключей из таблицы timezone ' . $th->getMessage() . PHP_EOL;
}
$ct_id = $contacts_id->fetchAll(PDO::FETCH_ASSOC);
$min_ct_id = ($ct_id[0]['id']);
end($ct_id);
$last_key = key($ct_id);
$max_ct_id = ($ct_id[$last_key]['id']);
$mail_log = 'письмо отправлено';
for ($i = 0; $i < 100; $i++) {
    $contact_id = $faker->numberBetween($min = $min_ct_id, $max = $max_ct_id);
    $maillog_insert = $db->prepare("INSERT INTO `komus_new`.`maillog` (`DATETIME_`, `log`, `contacts_id`) 
                                VALUES (NOW(), :mail_log, :contact_id);");
    $maillog_insert->bindParam(':mail_log', $mail_log, PDO::PARAM_STR);
    $maillog_insert->bindParam(':contact_id', $contact_id, PDO::PARAM_STR);
    try {
        $maillog_insert->execute();
    } catch (\Throwable $th) {
        echo 'Произошла ошибка при добавлении лога почты ' . $th->getMessage();
    }
}
echo 'Лог отправленных писем добавлен'. PHP_EOL;