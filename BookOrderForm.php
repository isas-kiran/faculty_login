<?php 

date_default_timezone_set(@date_default_timezone_get());
header("p3p: CP=\"IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT\""); 
session_start();

require("/demo/machform.php");

$mf_param['form_id'] = 6;
$mf_param['base_path'] = 'http://www.appnitro.com/demo/';
$mf_param['show_border'] = true;
display_machform($mf_param);

?>