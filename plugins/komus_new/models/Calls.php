<?php

namespace Komus;

class Calls
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function create()
    {
        # code...
    }
    /**
     * Read
     *
     * @return void
     */
    public function read()
    {
        //TODO: поправить кодировку у некоторых таблиц
        $unicode =$this->db->prepare("SET NAMES utf8 COLLATE utf8_unicode_ci");
        $unicode->execute();
        $all_calls = $this->db->prepare("SELECT * FROM calls");
        try {
            $all_calls->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке звонков ' . $th->getMessage());
        }
        $calls = $all_calls->fetchAll();
        //echo json_encode($calls);
        return json_encode($calls);
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
