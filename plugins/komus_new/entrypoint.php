<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
/**
 * undocumented class
 */
class ApiEntryPoint 
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
    public function SetXml($json)
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
