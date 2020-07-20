<?php

namespace Komus;

use PDO;

class MailLog
{
    private $db;
    private $ret;

    public function __construct($db)
    {
        $this->db = $db;
        $this->ret = false;
    }
    /**
     * Create
     *
     * @return void
     */
    public function create()
    {
        # code...
    }
    /**
     * Read
     *
     * @return void
     */
    public function read($data)
    {
        //TODO: дописать выборку необходимых данных для формирования сообщения
        if ($data) {
            try {
                $contact_info = $this->db->prepare("SELECT * FROM contact WHERE id =:id");
                $contact_info->bindParam(':id', $data['id'], PDO::PARAM_STR);
                $contact_info->execute();
            } catch (\Throwable $th) {
                echo 'Произошла ошибка при выборке почтовых отправлений ' . $th->getMessage();
            }
            $this->ret = $contact_info->fetchAll();
            $this->ret = json_encode($this->ret, JSON_UNESCAPED_UNICODE);
        }
        return $this->ret;
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
