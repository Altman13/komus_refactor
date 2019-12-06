<?php

class Contacts
{
    private $db;
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
    public function Create($contact)
    {
        $new_contacts = json_decode($contact);
        //TODO: дописать запрос на инсерт контактов
        $this->db->prepare("INSERT INTO ");
        foreach ($new_contacts as $ct) { }
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        $all_contacts = $this->db->prepare("SELECT * FROM contacts");
        try {
            $all_contacts->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке контактов ' . $th->getMessage());
        }
        $contacts = $all_contacts->fetchAll();
        //echo json_encode($contacts);
        return json_encode($contacts);
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
