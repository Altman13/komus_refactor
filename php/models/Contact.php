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

    public function create($contact)
    {
        $new_contacts = json_decode($contact);
        //TODO: дописать запрос на инсерт контактов
        $this->db->prepare("INSERT INTO ");
        foreach ($new_contacts as $ct) {
        }
    }
    
    //TODO: дописать запрос на выборку контактов + условия на перезвон ограничения по времени
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

    //Лочим контакты, которые выбрали для обзвона, чтобы не было состояния гонки,
    // по одним и тем же контактам одновременно работают несколько операторов
    public function lockContacts($contacts)
    {
        foreach ($contacts as $contact) {
            try {
                $contacts = $this->db->prepare("UPDATE contacts SET allow_call='0' WHERE contacts.id=:id");
                $contacts->bindParams(':id', $contact['id'], PDO::PARAM_STR);
                $contacts->execute();
                $this->resp = $contacts;
            } catch (\Throwable $th) {
                $this->resp = 'Произошла ошибка при блокировки контактов для обзвона ' . $th->getMessage();
            }
        }
        return $this->resp;
    }
    
    public function updateStatusCall($call)
    {
        //TODO: подключить новую базу, где привязка оператора к контакту идет через таблицу звонок,
        // кроме того перенести обновление статуса звонка на api call, а не contacts
        //TODO: begin_time, end_time
        try {
            $call_insert = $this->db->prepare("INSERT INTO `calls` (`begin_time`, `end_time`, `recall_time`, 
                                                                    `status`, `contacts_id`) 
                                        VALUES (NOW(), NOW(), :date_recall, 
                                                                    :status_call, :id);");
            $call_insert->bindParam(':id', $call->data->id, PDO::PARAM_STR);
            $call_insert->bindParam(':status_call', $call->data->status_call, PDO::PARAM_STR);
            $call_insert->bindParam(':date_recall', $call->data->date_recall, PDO::PARAM_STR);
            //$call_insert->bindParam(':operator_id', $call->data->operator_id, PDO::PARAM_STR);
            $call_insert->execute();
            $this->resp = $call_insert;
        } catch (\Throwable $th) {
            echo ('Произошла ошибка при добавлении статуса звонка ' . $th->getMessage());
        }
        return $this->resp;
    }

    public function delete($id)
    {
        # code...
    }
}
