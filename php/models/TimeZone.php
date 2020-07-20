<?php

namespace Komus;

class TimeZone
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Create
     *
     * @param  mixed $timezone
     *
     * @return void
     */
    public function Create($timezone)
    {
        $timezones = json_decode($timezone);
        //TODO: дописать запрос на инсерт временных зон
        $this->db->prepare("INSERT INTO ");
        foreach ($timezones as $tz) { }
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        $all_time_zones = $this->db->prepare("SELECT * FROM timezone");
        try {
            $all_time_zones->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке временных зон ' . $th->getMessage());
        }
        $timezone = $all_time_zones->fetchAll();
        //echo json_encode($timezone);
        return json_encode($timezone);
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
