<?php
/**
 * Contact Plugin API
 *
 * @package contact
 * @version 2.1.0
 * @author Seditio.by & Cotonti Team
 * @copyright (c) 2008-2011 Seditio.by and Cotonti Team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('komus_load', 'plug');

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');        
include_once 'PHPExcel.php';    
class MyReadFilter implements PHPExcel_Reader_IReadFilter {
	            private $_startRow = 0;
	            private $_endRow = 0;
	            private $_columns = array();

	            public function __construct($startRow, $endRow, $columns) {
		            $this->_startRow	= $startRow;
		            $this->_endRow		= $endRow;
		            $this->_columns		= $columns;
	            }

	            public function readCell($column, $row, $worksheetName = '') {
		           if ($row >= $this->_startRow && $row <= $this->_endRow) {
			           if (in_array($column,$this->_columns)) {
				           return true; 
			           }
		           }
		           return false;
	           }
}
        
?>
