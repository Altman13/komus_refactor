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
    /**
     * Read
     *
     * @return void
     */
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
    /**
     * Update
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function update($id)
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
    public function delete($id)
    {
        # code...
    }
}
