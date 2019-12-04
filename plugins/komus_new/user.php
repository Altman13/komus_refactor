<?php
require "config/config.php";
require "vendor/autoload.php";

$faker = Faker\Factory::create();

for ($i = 0; $i < 100; $i++) {
    $user_login = $faker->name;
    $user_password = $faker->password();
    $user_email = $faker->email;
    $user_firstname = $faker->name();
    $user_lastname = $faker->lastName;
    $user_gender = 'не указано';
    $user_birthdate = $faker->dateTime($max = 'now', $timezone = null);
    $u_birthdate = date_format($user_birthdate, 'Y-m-d H:i:s');
    $user_lastvisit = $faker->dateTime($max = 'now', $timezone = null);
    $u_last_visit = date_format($user_lastvisit, 'Y-m-d H:i:s');
    $user_ban = null;
    //TODO: добавить запросы на получение текущих значений ключей для таблиц timezone и group_users
    $timezones_id = $faker->numberBetween($min = 1, $max = 8);
    $groups_users_id = $faker->numberBetween($min = 1, $max = 3);
    $insert_user = $db->prepare("INSERT INTO `komus_new`.`users` (`user_login`, `user_password`, `user_email`, 
                                                            `user_firstname`, `user_lastname`, `user_gender`,
                                                            `user_birthdate`, `user_lastvisit`, `user_ban`,
                                                            `timezones_id`, `groups_users_id`) 
                            VALUES (:user_login, :user_password, :user_email, 
                                    :user_firstname, :user_lastname, :user_gender, 
                                    :user_birthdate, :user_lastvisit, 
                                    :user_ban, :timezones_id, :groups_users_id)");
    $insert_user->bindParam(':user_login', $user_login, PDO::PARAM_STR);
    $insert_user->bindParam(':user_password', $user_password, PDO::PARAM_STR);
    $insert_user->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $insert_user->bindParam(':user_firstname', $user_firstname, PDO::PARAM_STR);
    $insert_user->bindParam(':user_lastname', $user_lastname, PDO::PARAM_STR);
    $insert_user->bindParam(':user_gender', $user_gender, PDO::PARAM_STR);
    $insert_user->bindParam(':user_birthdate', $u_birthdate, PDO::PARAM_STR);
    $insert_user->bindParam(':user_lastvisit', $u_last_visit, PDO::PARAM_STR);
    $insert_user->bindParam(':user_ban', $user_ban, PDO::PARAM_STR);
    $insert_user->bindParam(':timezones_id', $timezones_id, PDO::PARAM_STR);
    $insert_user->bindParam(':groups_users_id', $groups_users_id, PDO::PARAM_STR);
    try {
        $insert_user->execute();
    } catch (\Throwable $th) {
        echo 'Произошла ошибка при добавлении пользователей ' . $th->getMessage() . "\r\n";
        die();
    }
}
echo 'Пользователи успешно добавлены';
