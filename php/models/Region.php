<?php

namespace Komus;

class Region
{
    private $db;
    private $ret;
    public function __construct($db)
    {
        $this->db = $db;
        $this->ret =array('data' =>'', 'error_text'=> '');
    }
    
    public function create($regions)
    {
        # code...
    }

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
    
    public function update($id)
    {
        # code...
    }
    
    public function delete($id)
    {
        # code...
    }
}
