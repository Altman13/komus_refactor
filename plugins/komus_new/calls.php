<?php

class Calls
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
    public function Read()
    {
        $all_cals = $this->db->prepare("SELECT * FROM calls");
        try {
            $all_cals->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке звонков ' . $th->getMessage());
        }
        $calls = $all_cals->fetchAll();
        return $calls;
    }
    public function Update()
    {
        # code...
    }
    public function Delete()
    {
        # code...
    }
}
