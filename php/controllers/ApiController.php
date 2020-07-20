<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
/**
 * undocumented class
 */
class ApiController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function GetXml()
    {
        # code...
        return $xml;
    }
    public function SetXml($xml)
    {
        # code...
    }
    public function GetJson()
    {
        # code...
        return $json;
    }
    public function SetJson($json)
    {
        # code...
    }
    public function GetHtml()
    {
        # code...
        return $html;
    }
    public function SetRequest($request)
    {
        # code...
    }
}
