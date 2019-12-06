<?php

class Regions
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Create
     *
     * @param  mixed $region
     *
     * @return void
     */
    public function Create($regions)
    {
        $new_region = json_decode($regions);
        //TODO: дописать запрос на инсерт регионов
        $this->db->prepare("INSERT INTO ");
        foreach ($new_region as $rs) { }
    }
    /**
     * Read
     *
     * @return void
     */
    public function Read()
    {
        $all_regions = $this->db->prepare("SELECT * FROM regions");
        try {
            $all_regions->execute();
        } catch (\Throwable $th) {
            die('Произошла ошибка при выборке регионов ' . $th->getMessage());
        }
        $regions = $all_regions->fetchAll();
        //echo json_encode($regions);
        return json_encode($regions);
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
