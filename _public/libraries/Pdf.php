<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
 
    public function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
		/** PHPExcel root directory */
		if (!defined('PDF_ROOT')) {
			define('PDF_ROOT', dirname(__FILE__) . '/');
			// require(PDF_ROOT . 'mpdf60/mpdf.php');
			require(PDF_ROOT . 'mpdf61/mpdf.php');
		}
		
		// Doi::dump($param);die();
        // include_once APPPATH.'/libraries/mpdf/mpdf.php';
 
        if ($param == NULL)
        {
            $param = 'en-GB-x,LEGAL,,,10,10,10,10,6,3';
        }
        $param = explode(",", $param);
        // var_dump($param[1]);
        // die();
        return new mPDF($param[0], $param[1], $param[2], $param[3], $param[4], $param[5], $param[6], $param[7], $param[8], $param[9]);
    }

}