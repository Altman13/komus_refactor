<?php

namespace Komus;

class MailLog
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
    public function read()
    {
        $mailslog = $this->db->prepare("SELECT * FROM mailog");
        try {
            $mailslog->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке почтовых отправлений ' . $th->getMessage());
        }
        $mails = $mailslog->fetchAll();
        return json_encode($mails);
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
