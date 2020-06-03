<?php

use Komus\report;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class ReportController
{
    private $report;
    public function __construct(Container $container)
    {
        $this->report = $container['report'];
    }
    public function show()
    {
        $data_for_xls = $this->report->read();
        $row_count = count($data_for_xls);
        $k=0;
        for ($i = 0; $i < $row_count; $i++) {
            foreach ($data_for_xls as $key => $data_row) {
                foreach ($data_row as $key => $column_val) {
                echo $column_val . '<br>';
                }
            }
            //echo $k++;
        }
    }
}
