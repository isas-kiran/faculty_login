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
	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['from_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and a.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date=""; 
		$enquiry_from_date="";
		$installment_from_date="";                           
	}
				
	if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['to_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
		$enquiry_to_date=" and a.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		$pre_to_date="";
		$enquiry_to_date="";
		$installment_to_date="";
	}
	
	//======================================From Stack Report=======================================
	if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="Start Date")
	{
		$frm_date=explode("/",$_REQUEST['start_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and a.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	
	
	if($_REQUEST['end_date']  && $_REQUEST['end_date']!="End Date")
	{
		$to_date=explode("/",$_REQUEST['end_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
		$enquiry_to_date=" and a.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	
	//=============================================================================
	$search_cm_id='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
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
		$where_course=" and a.course_id='".$course_id."'";
	}
	/*$where_type='';
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
	}*/
	
	$where_added_by='';
	if($_REQUEST['added_by']!='')
	{
		$added_id=$_REQUEST['added_by'];
		$where_added_by=" and a.admin_id='".$added_id."'";
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
	
	$where_cm_id='';
	if($_SESSION['where']!='')
	{
		$where_cm_id=" and e.cm_id='".$_SESSION['cm_id']."' ";
	}
	$select_directory='order by id desc';                   
        
  	$sel_enroll="SELECT a.name,a.course_id,a.enroll_id,a.added_date,a.admin_id,e.balance_amt,e.net_fees,e.cm_id FROM action_print_certificate a, enrollment e where 1 and e.enroll_id=a.enroll_id ".$where_cm_id." ".$where_course." ".$where_added_by."  ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." group by a.enroll_id ".$select_directory."";
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
	
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:H4");
	
	//================== Set column widths==============================
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
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

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'5');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Student Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Course Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Course Fees','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Total Outstanding','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Certificate Print Date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Print by','5');
	
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
	
	$select_directory='order by id desc';                   
	$sql_query="SELECT a.name,a.course_id,a.enroll_id,a.added_date,a.admin_id,e.balance_amt,e.net_fees,e.cm_id FROM action_print_certificate a, enrollment e where 1 and e.enroll_id=a.enroll_id ".$where_cm_id." ".$where_course." ".$where_added_by."  ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." group by a.enroll_id ".$select_directory."";
	$query_order=mysql_query($sql_query);
	$sr=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$select_course = "select course_name from courses where course_id='".$val_query['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $sr);
		$sel_br="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
		$ptr_branch=mysql_query($sel_br);
		$data_branch=mysql_fetch_array($ptr_branch);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_course['course_name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $val_query['net_fees']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['balance_amt']);
		$date_ex=explode("-",$val_query['added_date']);
		$date_added=$date_ex[2].'/'.$date_ex[1].'/'.$date_ex[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $date_added);	
		$sel_admin="select name from site_setting where admin_id='".$val_query['admin_id']."'";
		$ptr_admin=mysql_query($sel_admin);
		$data_name=mysql_fetch_array($ptr_admin);		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $data_name['name']);
		
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
header('Content-Disposition: attachment;filename="certificate_issue_report.xls"');
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