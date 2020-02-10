<?php
class ReportController
{
    private $report;
    public function __construct(Report $report)
    {
        $this->report=$report;
    }
    public function show($args = array ())
    {
        $this->report->Read();
    }
}
