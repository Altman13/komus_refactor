<?php

namespace Komus;
use PDO;
class Contact
{
    private $db;
    private $resp;
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Create
     *
     * @param  mixed $contact
     *
     * @return void
     */
    public function create($contact)
    {
        $new_contacts = json_decode($contact);
        //TODO: дописать запрос на инсерт контактов
        $this->db->prepare("INSERT INTO ");
        foreach ($new_contacts as $ct) {
        }
    }
    /**
     * Read
     *
     * @return void
     */
    public function read()
    {
        try {
            $all_contacts = $this->db->prepare("SELECT * FROM contacts");
            $all_contacts->execute();
        } catch (\Throwable $th) {
            echo ('Произошла ошибка при выборке контактов ' . $th->getMessage());
        }
        $contacts = $all_contacts->fetchAll();
        return json_encode($contacts);
    }
    /**
     * Update
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function updateStatusCall($id, $status_call)
    {
        //TODO: begin_time, recall_time, end_time
        try {
            $call_insert = $this->db->prepare("INSERT INTO `calls` (`begin_time`, `end_time`, `recall_time`, 
                                                                    `status`, `contacts_id`) 
                                        VALUES (NOW(), NOW(), NOW(), 
                                                                    :status_call, :id);");
            $call_insert->bindParam(':id', $id, PDO::PARAM_STR);
            $call_insert->bindParam(':status_call', $status_call, PDO::PARAM_STR);
            $call_insert->execute();
            $this->resp = $call_insert;
        } catch (\Throwable $th) {
            echo ('Произошла ошибка при добавлении статуса звонка ' . $th->getMessage());
        }
        return $this->resp;
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
