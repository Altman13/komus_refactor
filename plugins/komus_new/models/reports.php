<?php
//header("Access-Control-Allow-Origin: *");
class Report
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function Create()
    {
        # code...
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        
        return json_encode($reports);
    }
    /**
     * Update
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function Update($id)
    {
        # code...
    }
    /**
     * Delete
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function Delete($id)
    {
        # code...
    }
}
//количество попыток совершенных оператором
$calls_count = $db->prepare("SELECT COUNT(calls.contacts_id) AS tryed_to_call, calls.status, 
                                        contacts.id, contacts.phone, 
                                        CONCAT(users.user_firstname, ' ', users.user_lastname) 
                                    FROM contacts
                                    LEFT JOIN calls ON contacts.id=calls.contacts_id
                                    LEFT JOIN users ON users.user_id =contacts.users_user_id
                                    GROUP BY calls.contacts_id");
try {
    $calls_count->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе истории звонков и попыток дозвона ' . $th->getMessage());
}
$all_calls_count = $calls_count->fetchAll(PDO::FETCH_ASSOC);

// звонки, совершенные оператором
$operator_calls = $db->prepare("SELECT contacts.id AS cont_id, contacts.phone, 
                                        CONCAT(users.user_firstname, ' ', users.user_lastname) AS operator_fio 
                                    FROM contacts
                                    LEFT JOIN calls ON contacts.id=calls.contacts_id
                                    LEFT JOIN users ON users.user_id =contacts.users_user_id");
try {
    $operator_calls->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборке истории звонков по оператору ' . $th->getMessage());
}
$oper = $operator_calls->fetchAll(PDO::FETCH_ASSOC);

//звоноки по всем операторам
$calls_all_oper = $db->prepare("SELECT calls.contacts_id, calls.status, contacts.id, contacts.phone
                                    FROM contacts
                                    LEFT JOIN calls ON contacts.id=calls.contacts_id
                                    WHERE calls.contacts_id IS NOT NULL");
try {
    $calls_all_oper->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе истории звонков по всем операторам ' . $th->getMessage());
}
$hs_calls_all_oper = $calls_all_oper->fetchAll(PDO::FETCH_ASSOC);

//все контакты для звонков
//если по контакту было 3 звонка - больше по нему не работаем
//TODO: дописать выборку по дате recall time - фильтр на перезвон
$all_contats = $db->prepare("SELECT calls.contacts_id, COUNT(calls.contacts_id) AS count_calls, 
                                calls.status, contacts.id, contacts.phone
                        FROM contacts
                        LEFT JOIN calls ON contacts.id=calls.contacts_id
                        WHERE calls.contacts_id IS NOT NULL
                        HAVING count_calls < 3");
try {
    $all_contats->execute();
} catch (\Throwable $th) {
    die('Произошла ошибка при выборе контактов для обзвона ' . $th->getMessage());
}
$contacts = $all_contats->fetchAll(PDO::PARAM_STR);