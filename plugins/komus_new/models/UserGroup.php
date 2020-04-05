<?php

namespace Komus;

class UserGroup
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Create
     *
     * @param  mixed $group_users
     *
     * @return void
     */
    public function Create($group_users)
    {
        //TODO: дописать запрос на инсерт групп пользователей
        $this->db->prepare("INSERT INTO ");
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        $all_groups_users = $this->db->prepare("SELECT * FROM groups_users");
        try {
            $all_groups_users->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке групп пользователей ' . $th->getMessage());
        }
        $groups_users = $all_groups_users->fetchAll();
        //echo json_encode($group_users);
        return json_encode($groups_users);
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
