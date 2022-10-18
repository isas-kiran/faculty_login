<?php
include 'inc_classes.php';
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
/** Include PHPExcel */
require_once dirname(__FILE__) .'/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
//styles
    $sharedStyle1->applyFromArray(
	array('fill' => array(
								'type'=> PHPExcel_Style_Fill::FILL_SOLID,							
							),
		  'borders' => array(
		                         'top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							),
		  'alignment' => array(
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							   'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		  
		 ));
	$sharedStyle2->applyFromArray(
	array('fill' 	=> array(
								'type'=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'=> array('argb' => '99ccff')
							),
		  'borders' => array(
								'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							),
		  'alignment' => array(
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		 ));
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	// Add some data
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
	if($keyword)
	{                            
		$select_name = "select course_name from courses where (course_name LIKE '%".$keyword."%' or course_description LIKE '%".$keyword."%')";
		if(mysql_num_rows($db->query($select_name)))
		{
			$val_name = $db->fetch_array($db->query($select_name));
			$name_to_array = "or course_name like concat(concat('%','".$val_name['course_name']."','%')) ";
		}
		$category = '';
		$select_category = "select category_id from course_category where category_name like '%".$keyword."%' ";
		if(mysql_num_rows($db->query($select_category)))
		{
			$val_category_name = $db->fetch_array($db->query($select_category));
		   $category = "or category_id = '".$val_category_name['category_id']."' ";
		}
		$pre_keyword=" and (course_name like '%".$keyword."%' or  course_description like '%".$keyword."%' $category $name_to_array)";
	}                            
	else
		$pre_keyword="";
	
	if($_REQUEST['free_course'])
		 $pre_keyword_corse="  and (free_course ='".$_REQUEST['free_course']."')";
	else 
		 $pre_keyword_corse="";
	
	if($_REQUEST['page'])
		$page=$_REQUEST['page'];
	else
		$page=0;
	
	if($_REQUEST['show_records'])
		$show=$_REQUEST['show'];
	else
		$show=0;

	if($_GET['order']=='asc')
	{
		$order='desc';
		$img = "<img src='images/sort_up.png' border='0'>";
	}
	else if($_GET['order']=='desc')
	{
		$order='asc';
		$img = "<img src='images/sort_down.png' border='0'>";
	}
	else
		$order='desc';

	if($_GET['orderby']=='name' )
		$img1 = $img;

	if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
		
	$select_directory='order by course_name asc';                      
        
  	$sel_enroll="SELECT course_id,category_id,course_name,course_price,course_duration,course_description FROM courses where 1 and status='Active' ".$pre_keyword." ".$select_directory."";
  	$my_querxy=mysql_query($sel_enroll);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+5);
  
  	$no_of_rows_new = ($no_of_rows+3);
	
	//================Apply styles============================
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B5:B$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C5:C$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D5:D$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "E5:E$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "F5:F$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "G5:G$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "H5:H$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "I5:I$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "J5:J$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K5:K$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L5:L$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "M5:M$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "N5:N$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:N4");
	
	//================== Set column widths==============================
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("30");
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
	
	//======================== Merge cells	======================
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');

	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:I'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:J'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('M1:M'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('N1:N'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Course Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Course Category','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Course Domain','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Price','4');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Course Duration (in days)','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Description','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Course Id','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Discount OTP','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Discount OTP INST','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Discount INST','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Discount NOW OTP','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M4', 'Discount NOW OTP INST','3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N4', 'Discount NOW INST','3');
	
	if($_REQUEST['branch_name']!='')
	{
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Branch by =>');
	    //$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B3', ''.$_REQUEST['branch_name'].'');
	}
	if($_REQUEST['course_id']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D2', 'Course by =>');
		$select_course = "select * from courses where course_id = '".$_REQUEST['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
	    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D3', ''.$val_course['course_name'].'');
	}
	
	$select_directory='order by course_name asc';  
	$sql_query= "SELECT course_id,category_id,course_name,course_price,course_duration,course_description,course_domain_id FROM courses where 1 and status='Active' ".$pre_keyword."  ".$select_directory."";
	$query_order=mysql_query($sql_query);
	$sr=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $sr);
		
		$select_category="select category_name from course_category where category_id='".$val_query['category_id']."'";
		$val_category = $db->fetch_array($db->query($select_category));
		
		$select_domain="select cat_name from course_domain_category  where cat_id='".$val_query['course_domain_id']."'";
		$val_domain= $db->fetch_array($db->query($select_category));
		
		$select_price="select * from courses_price where course_id='".$val_query['course_id']."'and cm_id='2'";
		$val_price= $db->fetch_array($db->query($select_price));
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['course_name']);						
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_category['category_name']);			
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_domain['cat_name']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $val_price['course_price']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['course_duration']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_query['course_description']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['course_id']);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_price['discount_otp']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_price['discount_otp_inst']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_price['discount_inst']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, $val_price['discount_now_otp']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowCount, $val_price['discount_now_otp_inst']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N'.$rowCount, $val_price['discount_now_inst']);
		
		$k++;
		$rowCount++;
		$sr++;
}
// Miscellaneous glyphs, UTF-8
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="courses_report.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;