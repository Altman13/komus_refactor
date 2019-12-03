<?php
require "../../config/config.php";
require "../../vendor/autoload.php";
$faker = Faker\Factory::create();

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
        echo 'Произошла ошибка при добавлении записей ' . $th->getMessage();
    }
    echo 'данные добавлены' . "<br/>";
}
