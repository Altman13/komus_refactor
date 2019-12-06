<?php

class Users
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Create
     *
     * @param  mixed $users
     *
     * @return void
     */
    public function Create($users)
    {
        $new_user = json_decode($users);
        //TODO: дописать запрос на инсерт пользователей
        $this->db->prepare("INSERT INTO ");
        foreach ($new_user as $us) { }
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        $all_users = $this->db->prepare("SELECT * FROM users");
        try {
            $all_users->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке контактов ' . $th->getMessage());
        }
        $users = $all_users->fetchAll();
        //echo json_encode($users);
        return json_encode($users);
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
