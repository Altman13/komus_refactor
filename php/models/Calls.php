<?php

namespace Komus;

class Calls
{
    private $db;
    private $resp;
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
        try {
            $all_calls = $this->db->prepare("SELECT * from contacts
        /*LEFT JOIN calls on calls.contacts_id=contacts.id where contacts.id=441*/");
            $all_calls->execute();
        } catch (\Throwable $th) {
            echo 'Произошла ошибка при выборке звонков ' . $th->getMessage();
        }
        $this->resp = $all_calls->fetchAll();
        //$fn_data = (array) json_decode(file_get_contents('./columns_name.json'));
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
