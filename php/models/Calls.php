<?php

namespace Komus;

class Calls
{
    private $db;
    private $resp;
    //private $ret;
    public function __construct($db)
    {
        $this->db = $db;
        //$this->ret =array('data' =>'', 'error' => '', 'error_text'=> '');
        //$return=json_encode($ret, JSON_UNESCAPED_UNICODE);
    }
    public function create()
    {
        # code...
    }

    public function read()
    {
        try {
            $all_contacts = $this->db->prepare("SELECT * FROM contacts WHERE contacts.allow_call='1' LIMIT 3");
            $all_contacts->execute();
            $contacts = $all_contacts->fetchAll();
            $this->resp = $contacts;
            //$this->lockContacts($contacts);
        } catch (\Throwable $th) {
            $this->resp= 'Произошла ошибка при выборке контактов ' . $th->getMessage();
        }
        return json_encode($this->resp);
    }

    public function update($id)
    {
        # code...
    }

    public function delete($id)
    {
        # code...
    }
}
