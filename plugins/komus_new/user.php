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
    
    //Выбираем значения по внешним ключам из связанной таблицы для заполнения
    $select_timezone_id=$db->prepare("SELECT timezones.id FROM timezones");
    try {
        $select_timezone_id->execute();
    } catch (\Throwable $th) {
        echo 'Произошла ошибка при выборе внешних ключей из таблицы timezone ' .$th->getMessage()."<br/>";
    }
    $tz_id=$select_timezone_id->fetchAll(PDO::FETCH_ASSOC);
    $min_tz_id=($tz_id[0]['id']);
    end($tz_id);
    $last_key = key($tz_id);
    $max_tz_id=($tz_id[$last_key]['id']);
    $timezones_id = $faker->numberBetween($min = $min_tz_id, $max = $max_tz_id);
    
    //Выбираем значения по внешним ключам из связанной таблицы для заполнения
    $select_groups_users_id=$db->prepare("SELECT groups_users.id FROM groups_users");
    try {
        $select_groups_users_id->execute();
    } catch (\Throwable $th) {
        echo 'Произошла ошибка при выборе внешних ключей из таблицы groups_users ' .$th->getMessage()."<br/>";
    }
    $gu_id=$select_groups_users_id->fetchAll(PDO::FETCH_ASSOC);
    $min_gu_id=($gu_id[0]['id']);
    end($gu_id);
    $last_key = key($gu_id);
    $max_gu_id=($gu_id[$last_key]['id']);
    $groups_users_id = $faker->numberBetween($min = $min_gu_id, $max = $max_gu_id);
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
