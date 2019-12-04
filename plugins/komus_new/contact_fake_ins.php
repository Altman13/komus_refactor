<?php
require "config/config.php";
require "vendor/autoload.php";
$faker = Faker\Factory::create();
$timezone = array(
    'Africa/Abidjan',
    'Africa/Accra',
    'Africa/Addis_Ababa',
    'Africa/Algiers',
    'Africa/Asmara',
    'Africa/Bamako',
    'Africa/Bangui',
);
foreach ($timezone as $tz) {
    $tzone = $db->prepare("INSERT INTO `komus_new`.`timezones` (`zone`) VALUES (:tz)");
    $tzone->bindParam(':tz', $tz, PDO::PARAM_STR);
    try {
        $tzone->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при добавлении временной зоны ' . $th->getMessage()."<br/>");
    }
}
echo 'Временные зоны добавлены '. "<br/>";

$faker = Faker\Factory::create();
for ($i = 0; $i < 100; $i++) {
    $region_name = $faker->city;
    $region_code = $faker->citySuffix;
    $region_subcode = $faker->randomNumber();
    $timezone_id = $faker->numberBetween($min = 1, $max = 1);
    $regions_insert = $db->prepare("INSERT INTO `komus_new`.`regions` 
                                (`name`, `code`, `subcode`, `timezones_id`) 
                    VALUES (:region_name, :region_code, :region_subcode, :timezone_id)");
    $regions_insert->bindParam(':region_name', $region_name, PDO::PARAM_STR);
    $regions_insert->bindParam(':region_code', $region_code, PDO::PARAM_STR);
    $regions_insert->bindParam(':region_subcode', $region_subcode, PDO::PARAM_STR);
    $regions_insert->bindParam(':timezone_id', $timezone_id, PDO::PARAM_STR);

    try {
        $regions_insert->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при добавлении регионов ' . $th->getMessage()."<br/>");
    }
}
echo 'Регионы добавлены ' ."<br/>";

$groups_user = array('оператор', 'старший оператор', 'администратор');
foreach ($groups_user as $gr_user) {
    $groups_user_insert = $db->prepare("INSERT INTO `komus_new`.`groups_users` (`groups`) VALUES (:gr_u)");
    $groups_user_insert->bindParam(':gr_u', $gr_user, PDO::PARAM_STR);
    try {
        $groups_user_insert->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при добавлении групп пользователей ' . $th->getMessage()."<br/>");
    }
}
echo 'Группы пользователей добавлены ' ."<br/>";
for ($i = 0; $i < 100; $i++) {

    $cont_insert = $db->prepare("INSERT INTO `komus_new`.`contacts` (`creation_time`, `city`, `organization`, 
                                `address`, `fio`, `phone`, `email`, `category`, `subcategory`, `question`, 
                                `comment`, `regions_id`, `users_user_id`) 
                                VALUES (NOW(), :city, :company, 
                                :streetAddress, :name, :phoneNumber, :email, :category, :subcategory,
                                :question, :comment, '1','6')");
    $cont_insert->bindParam(':city', $city, PDO::PARAM_STR);
    $cont_insert->bindParam(':company', $company, PDO::PARAM_STR);
    $cont_insert->bindParam(':streetAddress', $streetAddress, PDO::PARAM_STR);
    $cont_insert->bindParam(':name', $name, PDO::PARAM_STR);
    $cont_insert->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
    $cont_insert->bindParam(':email', $email, PDO::PARAM_STR);
    $cont_insert->bindParam(':category', $category, PDO::PARAM_STR);
    $cont_insert->bindParam(':subcategory', $subcategory, PDO::PARAM_STR);
    $cont_insert->bindParam(':question', $question, PDO::PARAM_STR);
    $cont_insert->bindParam(':comment', $comment, PDO::PARAM_STR);

    $city = $faker->city;
    $company = $faker->company;
    $streetAddress = $faker->streetAddress;
    $name = $faker->name;
    $phoneNumber = $faker->phoneNumber;
    $email = $faker->email;
    $category = "category " . $faker->word;
    $subcategory = "subcategory " . $faker->word;
    $question = "question " . $faker->word;
    $comment = "comment " . $faker->word;
    try {
        $cont_insert->execute();
    } catch (\Throwable $th) {
        die('Произошла ошибка при добавлении контактов ' . $th->getMessage()."<br/>");
    }
    echo 'Контакты добавлены ' . "<br/>";
}

