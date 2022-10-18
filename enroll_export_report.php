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
	array('fill' 	=> array(
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
	$total_found =0;	
	$not_found=0; 
	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['from_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";	
		$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date=""; 
		$enquiry_date="";
		$installment_from_date="";                           
	}
	
	if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['to_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
		$enquiery_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		$pre_to_date="";
		$enquiery_to_date="";
		$installment_to_date="";
	}
	$search_cm_id='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$search_cm_id='';
		}
	}
	$where_course='';
	if($_REQUEST['course_id']!='')
	{
		$course_id=$_REQUEST['course_id'];
		$where_course=" and course_id='".$course_id."'";
	}
	$where_type='';
	if($_REQUEST['ad_type_id']!='')
	{
		$ref_id=$_REQUEST['ad_type_id'];
		if($ref_id=='0')
			$where_type=" and (ref_id=0 or ref_id is NULL)";
		else
			$where_type=" and ref_id > 0 ";
	}
	$where_assign_to='';
	if($_REQUEST['assign_to']!='')
	{
		$assign_id=$_REQUEST['assign_to'];
		$where_assign_to=" and assigned_to='".$assign_id."'";
	}
	
	$where_added_by='';
	if($_REQUEST['added_by']!='')
	{
		$added_id=$_REQUEST['added_by'];
		$where_added_by=" and admin_id='".$added_id."'";
	}
	
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
		
	$select_directory='order by enroll_id desc';                      
        
  	$sel_enroll="SELECT * FROM enrollment where 1 and (student_status ='Active' or student_status is NULL) ".$_SESSION['where']." ".$where_course." ".$where_type." ".$where_assign_to." ".$where_added_by." ".$search_cm_id." ".$pre_from_date." ".$pre_to_date."  ".$select_directory."";
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
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "O5:O$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "P5:P$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "Q5:Q$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "R5:R$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "S5:S$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "T5:T$no_of_rows");
	
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:T4");
	
	//================== Set column widths==============================
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
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
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
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
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('P1:P'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('Q1:Q'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('R1:R'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('S1:S'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('T1:T'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Enroll Key Id','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Enroll Id','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Enroll No','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Bill No','6');
	
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Name','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Contact No.','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Contact No 2.','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Email','5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Course Name','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Course Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M4', 'Down Payment','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N4', 'Total Paid','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O4', 'Balance Fees','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P4', 'Receipt Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q4', 'Installments','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('R4', 'Assign to','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('S4', 'Added by','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('T4', 'Date','6');
	
	
	
	
	if($_REQUEST['branch_name']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Branch by =>');
	    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B3', ''.$_REQUEST['branch_name'].'');
	}
	if($_REQUEST['course_id']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D2', 'Course by =>');
		$select_course = "select * from courses where course_id = '".$_REQUEST['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
	    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D3', ''.$val_course['course_name'].'');
	}
	
	$select_directory='order by enroll_id asc';                   
	$sql_query="SELECT * FROM enrollment where 1 and (student_status ='Active' or student_status is NULL) ".$_SESSION['where']." ".$where_course." ".$where_type." ".$where_assign_to." ".$where_added_by." ".$search_cm_id." ".$pre_from_date." ".$pre_to_date." ".$select_directory."";
	$query_order=mysql_query($sql_query);
	$sr=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$select_course = "select * from courses where course_id = '".$val_query['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $sr);
		$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['enroll_id']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['installment_display_id']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $val_query['ext_invoice_no']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['enroll_id']);
								
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_query['name']);			
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['contact']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_query['contact_home']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_query['mail']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_course['course_name']);	
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, $val_query['net_fees']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowCount, $val_query['down_payment']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N'.$rowCount, round($val_query['net_fees']-$val_query['balance_amt']));		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O'.$rowCount, $val_query['balance_amt']);		
		
		
		//===================================Receipt Details=============================
		$select_installments = " SELECT * FROM `invoice` where enroll_id ='".$val_query['enroll_id']."' and status='paid' ";
		$ptr_installment = mysql_query($select_installments);
		$mm='';
		if($total=mysql_num_rows($ptr_installment))
		{
			$m=1;
			while($data_invs= mysql_fetch_array($ptr_installment))
			{
				$mm.= "\n".$m.") ".$data_invs['receipt_no'].' - '.$data_invs['amount'].'/- '.$data_invs['added_date'].' : '.$data_invs['status']." ";
				if($m !=$total)
				{
					//$xx.= '<br /><hr >';
				}
				$m++;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P'.$rowCount, $mm);
		/************************************INSTALLMENT******************************************/
		$select_installments = " SELECT * FROM `installment` where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."'  ";
		$ptr_installment = mysql_query($select_installments);
		$xx='';
		if($total=mysql_num_rows($ptr_installment))
		{
			$i=1;
			while($data_installment = mysql_fetch_array($ptr_installment))
			{
				$xx.= "\n".$i.") ".$data_installment['installment_amount'].'/- '.$data_installment['installment_date'].' : '.$data_installment['status']." ";
				if($i !=$total)
				{
					//$xx.= '<br /><hr >';
				}
				$i++;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowCount, $xx);
		//====================================================================================		
		$sel_assign="select name from site_setting where admin_id='".$val_query['assigned_to']."'";
		$ptr_assign=mysql_query($sel_assign);
		$data_assign=mysql_fetch_array($ptr_assign);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('R'.$rowCount, $data_assign['name']);
		$sel_added="select name from site_setting where admin_id='".$val_query['assigned_to']."'";
		$ptr_added=mysql_query($sel_added);
		$data_added=mysql_fetch_array($ptr_added);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('S'.$rowCount, $data_added['name']);				
		/************************************Item rate******************************************/
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('T'.$rowCount, $val_query['added_date']);	
		/************************************Plan Date******************************************/
				
		
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
header('Content-Disposition: attachment;filename="enrollment_report.xls"');
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