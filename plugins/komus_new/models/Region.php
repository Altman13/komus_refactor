<?php

namespace Komus;

class Region
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
    public function create($regions)
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
