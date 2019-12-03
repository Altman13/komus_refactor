<?php
require "config\config.php";
require "vendor\autoload.php";
$faker = Faker\Factory::create();

$regions_insert = $db->prepare("INSERT INTO `komus_new`.`regions` 
                                (`name`, `code`, `subcode`, `timezones_id`) 
                    VALUES (region_name:, :region_code, :region_subcode, :timezone_id);");
$regions_insert->bindParam(':region_name', $region_name, PDO::PARAM_STR);
$regions_insert->bindParam(':region_code', $region_code, PDO::PARAM_STR);
$regions_insert->bindParam(':region_subcode', $region_code, PDO::PARAM_STR);
$regions_insert->bindParam(':timezone_id', $timezone_id, PDO::PARAM_STR);

try {
    $regions_insert->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при добавлении регионов ' . $th->getMessage());
}
