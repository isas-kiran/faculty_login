<?php include 'inc_classes.php';?>
<?php
$branch_name=$_REQUEST['branch_name'];

$file_name ='excel_files/Campaign_Inquiry_of_'.$branch_name.'_Branch_'.date('Y-m-d').'.xlsx';
$finfo = finfo_open(FILEINFO_MIME_TYPE); 
$mime =  finfo_file($finfo, $file_name);
finfo_close($finfo);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;  filename="Campaign_Inquiry_of_'.$branch_name.'_Branch__'.date('Y-m-d').'.xlsx"');
header('Content-Length: ' . filesize($file_name));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

//stream file
ob_get_clean();
echo file_get_contents($file_name);
ob_end_flush();

?>
