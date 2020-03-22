<?php

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
    public function Create()
    {
        # code...
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
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
