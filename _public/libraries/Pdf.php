<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
 
    public function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
    function load($param = NULL)
    {
        /** PHPExcel root directory */
        if (!defined('PDF_ROOT')) {
            define('PDF_ROOT', dirname(__FILE__) . '/');
            require(PDF_ROOT . 'mpdf60/mpdf.php');
        }
    
        // Default parameter jika tidak ada
        if ($param == NULL)
        {
            $param = 'en-GB-x,LEGAL,,,10,10,10,10,6,3';
        }
        
        // Memecah parameter untuk mendapatkan nilai sesuai format
        $param = explode(",", $param);
    
        // Menambahkan konfigurasi tambahan untuk mPDF (tempDir dan allow_charset_conversion)
        $config = [
            'tempDir' => sys_get_temp_dir(),  // Direktori sementara untuk mPDF
            'allow_charset_conversion' => true // Mengizinkan konversi charset
        ];
    
        // Menambahkan parameter dari $param ke dalam konfigurasi
        $config['mode'] = $param[0];
        $config['format'] = $param[1];
        $config['default_font_size'] = $param[2];
        $config['default_font'] = $param[3];
        $config['margin_left'] = $param[4];
        $config['margin_right'] = $param[5];
        $config['margin_top'] = $param[6];
        $config['margin_bottom'] = $param[7];
        $config['margin_header'] = $param[8];
        $config['margin_footer'] = $param[9];
    
        // Membuat objek mPDF dengan konfigurasi yang sudah diperbarui
        return new mPDF($config);
    }
    

}