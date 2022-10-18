<?php
include 'inc_classes.php';
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object						
$objPHPExcel = new PHPExcel();
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
//styles

    $sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
							),
		  'borders' => array(
		                         'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							),
		  'alignment' => array(
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							   'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

		 ));
		 
  $sharedStyle2->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('argb' => '99ccff')
							),
		  'borders' => array(
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
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
	
	
  	$no_of_rows = 37;
  	$no_of_rows_new = 37;
	
	$arr_alph=array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC');
	
	/*$select_cnt="select * from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_cnt=mysql_query($select_cnt);
	$cnt=mysql_num_rows($ptr_cnt);*/
	
	//================Apply styles============================
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A4:A$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B4:B$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C4:C$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D4:D$no_of_rows");
	
	$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$admin_cnt=mysql_num_rows($ptr_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "".$arr_alph[$ts]."3:".$arr_alph[$ts]."$no_of_rows");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($arr_alph[$ts])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle(''.$arr_alph[$ts].'1:'.$arr_alph[$ts].''.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
		$ts++;
	}
	
	/*$select_paymode="select payment_mode_id from payment_mode where 1 order by payment_mode_id asc";
	$ptr_paymode=mysql_query($select_paymode);
	$pay_cnt=mysql_num_rows($ptr_paymode);
	while($data_paymode=mysql_fetch_array($ptr_paymode))
	{
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "".$arr_alph[$ts]."5:".$arr_alph[$ts]."$no_of_rows");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($arr_alph[$ts])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle(''.$arr_alph[$ts].'1:'.$arr_alph[$ts].''.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
		$ts++;
	}*/
	
	$cnt=$admin_cnt-1;
	$alpha=$arr_alph[$cnt];

	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "E5:E$no_of_rows");
	
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A3:".$alpha."3");
	
	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A2:M2");
	
	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");
	
	/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A35:A37");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B35:B37");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C35:C37");
	
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A39:A41");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B39:B41");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C39:C41");*/
	
	
	//================== Set column widths==============================
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("30");
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
	//======================== Merge cells	======================
	
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	
	
	
	//======================== Add some data======================
	//echo "<br />".date('H:i:s') . "\t Add some data\n";
	$objPHPExcel->setActiveSheetIndex(0);

	/* $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('1','3', 'Sr. No.' ,'3');
 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('2','3', 'Sales Order No.','3');
 
 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('3','3', 'Mo No','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('4','3', 'Mo Date','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('5','3', 'customer Name','3');
 
  $objPHPExcel->setActiveSheetIndex(0)->suyetCellValueByColumnAndRow('6','3', 'Concern Person','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('7','3', 'Item Description','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('8','3', 'PO No','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('9','3', 'PO Quantity','3');
  
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('10','3', 'Item Rate','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('11','3', 'Plan Date','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('12','3', 'BD User','3');
  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('13','3', 'Status','3');*/

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', '1' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'No of leads given by L.D.','6');
 	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A5', '2' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B5', 'No of Fresh Lead Assign','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A6', '3' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B6', 'No of Fresh Call Done','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A7', '4' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B7', 'No. of followup Call Done','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A8', '5' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B8', 'Total Salon followup Call Done','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A9', '6' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B9', 'No. of Career Consultant calls','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A10', '7' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B10', 'Any other Tie-up calls','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A11', '8' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B11', 'Total Calls Done','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A12', '9' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B12', 'No. of Cousnseling Done Today','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A13', '10' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B13', 'No. of Cousnseling Done Till Date (Monthly)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A14', '11' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B14', 'No. of Enrollments done today','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A15', '12' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B15', 'No. of Enrollments till date (Monthly)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A16', '13' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B16', 'No. of upgrade done today','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A17', '14' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B17', 'No. of upgrade done till date (Monthly)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A18', '15' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B18', 'No of Pending Followups since last 4 months','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A19', '16' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B19', 'No of Invalid leads done Today','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A20', '17' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B20', 'No of Not Interested leads done Today','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A21', '18' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B21', 'Todays Realised Amount','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A22', '19' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B22', 'Amount Realised Till Date (Monthly)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A23', '20' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B23', 'Recovery for this Month','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A24', '21.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B24', 'Recovery Realised for this month till date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A25', '22' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B25', 'Recovery Pending of Last Month','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A26', '23' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B26', 'Recovery Pending of Second Last Month','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A27', '24' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B27', 'Recovery Pending since before second last month','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A28', '25','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B28', 'No of Very Hot Leads (Last 30 days)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A29', '26' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B29', 'No of Hot Leads (Last 30 days)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A30', '27' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B30', 'No of Warm Leads (Last 30 days)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A31', '28' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B31', 'Booking Amount Funnel (Last 30 Days)','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A32', '29' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B32', 'Realised Amount Funnel','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A33', '30' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B33', 'No of Student Review','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A34', '31' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B34', 'No. of Student Testimonial','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A35', '32' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B35', 'No. of Models added in Model Bank','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A36', '33' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B36', 'DSR Report Matched','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A3', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B3', 'Details','6');
	
	$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$admin_cnt=mysql_num_rows($ptr_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue("".$arr_alph[$ts]."3", "".$data_couc['name']."",'6');
		$ts++;
	}
	
		
		
	$cnttotal=$rowCount+1;
	$objPHPExcel->getActiveSheet()->setTitle('Simple');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Total_sales_report_'.date('Y-m-d').'.xls"');
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