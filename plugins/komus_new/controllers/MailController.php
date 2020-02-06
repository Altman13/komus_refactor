<?php
require "../models/calls.php";
//$CallController = new Calls($db);
class MailController{
    private $calls;
    public function __construct(Calls $calls)
    {
        $this->calls=$calls;
    }
    public public function sendMail($email_adress, $data = array())
    {
        $this->calls->Read();
    }
}