<?php

namespace Komus;

class Report
{
    private $db;
    public function __construct($db)
    {
        $this->db =$db;
    }
    public function read()
    {
        $get_report = $this->db->prepare("SELECT calls.status, contacts.id, contacts.phone, contacts.fio, contacts.naimenovanie,
                                        contacts.organization, CONCAT(users.firstname, ' ', users.lastname) as fio 
                                    FROM contacts
                                    LEFT JOIN calls ON contacts.id=calls.contacts_id
                                    LEFT JOIN users ON users.id =contacts.users_id
                                    GROUP BY calls.contacts_id");
        try {
            $get_report->execute();
        } catch (\Throwable $th) {
            echo ('Произошла ошибка при выборе истории звонков и попыток дозвона ' . $th->getMessage());
        }
        $report_calls = $get_report->fetchAll(\PDO::FETCH_ASSOC);
        return $report_calls;
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
