<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');
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
							 
	/*if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['start_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$start_date=$frm_dates;
		$enquiry_from_date=" and DATE(report_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
	   $enquiry_from_date=" and DATE(`report_date`) >='".date('Y-m-d',strtotime('-1 days'))."'"; 
	}
	
	$search_cm_id='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		if($_REQUEST['branch_name_s']!='')
		{
			$branch_name=$_REQUEST['branch_name_s'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$search_cm_id=" and cm_id='2'";
			$cm_ids='2';
		}
	}
	if($_REQUEST['staff_id'])
	{
		$staff_ids=$_REQUEST['staff_id'];
		$where_staff_id=" and admin_id='".$staff_ids."'";
	}
	else
	{
		$where_staff_id='';
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
	}  */                 
    
	$no_of_rows = 30;
  	$no_of_rows_new = 30;
	
	$arr_alph=array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC');
	
	/*$select_cnt="select * from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_cnt=mysql_query($select_cnt);
	$cnt=mysql_num_rows($ptr_cnt);*/
	
	//=========================Apply styles============================
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A4:A$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B4:B$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C4:C$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D4:D$no_of_rows");
	
	$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
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

	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', '1' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Timesheet Status','6');
 	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A5', '2' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B5', 'Utilisation','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A6', '3' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B6', 'Presence','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A7', '4' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B7', 'Working Hours','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A8', '5' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B8', 'Task Completion','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A9', '6' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B9', 'Quality Of Work','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A10', '7' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B10', 'Rules Followed','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A11', '8' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B11', 'Class Start on Time','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A12', '9' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B12', 'Class End on Time','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A13', '10' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B13', 'Faculty Grooming','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A14', '11' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B14', 'Logsheet Send','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A15', '12' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B15', 'Mobile Not Used in Batch Hours','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A16', '13' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B16', 'Timetable Followed','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A17', '14' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B17', 'Student Decoram','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A18', '15' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B18', 'Phone Submited','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A19', '16' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B19', 'No. Of Negative Remark','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A20', '17' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B20', 'Late Login Without Info','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A21', '18' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B21', 'Absent Without Info','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A22', '19' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B22', 'Early Checkout Without Info','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A23', '20' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B23', 'Misconduct With Staff','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A24', '21.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B24', 'Misconduct With Student','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A25', '22' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B25', 'Logsheet Not Checked','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A26', '23' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B26', 'Other Issue','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A27', '24' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B27', 'Points','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A28', '25','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B28', 'Monthly Points','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A29', '26' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B29', 'Comments','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A3', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B3', 'Field Name','6');*/
	
	/*$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$admin_cnt=mysql_num_rows($ptr_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue("".$arr_alph[$ts]."3", "".$data_couc['name']."",'6');
		$ts++;
	}*/
	
		//=========================1======================
		/*$tota_ld_lead='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t1=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select timesheet_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t1].'4', intval($data_per['timesheet_mark']),'6');
			$t1++;
		}
		//=========================2=======================
		$count_enquiry='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t2=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enquiry="select utilisation_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$query_enquiery=mysql_query($select_enquiry);
			$count_enquiry=mysql_num_rows($query_enquiery);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t2].'5', intval($data_per['utilisation_mark']),'6');
			$t2++;
		}
		//=========================3=======================
		$count_enq_called='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t3=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_cnt="select presence from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$query_enq_cnt=mysql_query($select_enq_cnt);
			$count_enq_called=mysql_num_rows($query_enq_cnt);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t3].'6', intval($data_per['presence']),'6');
			$t3++;
		}
		//=========================4=======================
		$no_of_foll_call='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t4=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select working_hrs from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t4].'7', intval($data_per['working_hrs']),'6');
			$t4++;
		}
		//=========================5=======================
		$salon_foll_called='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t5=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select task_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t5].'8', intval($data_per['task_mark']),'6');
			$t5++;
		}
		//=========================6=======================
		$count_enq_catd='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t6=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_cat="select quality_work_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date."";
			$query_enq_cat=mysql_query($select_enq_cat);
			$count_enq_catd=mysql_num_rows($query_enq_cat);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t6].'9', intval($data_per['quality_work_mark']),'6');
			$t6++;
		}
		//=========================7=======================
		$count_enq_tieup='';
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t7=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select * from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			$rules_foll=round($data_per['class_start_time_mark']+$data_per['class_end_time_r_mark']+$data_per['faculty_grooming_r_mark']+$data_per['logsheet_send_r_mark']+$data_per['mobile_used_r_mark']+$data_per['timetable_followed_r_mark']+$data_per['student_decoram_r_mark']);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t7].'10', intval($rules_foll),'6');
			$t7++;
		}
		//=========================8=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t8=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select class_start_time_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t8].'11', intval($data_per['class_start_time_mark']),'6');
			$t8++;
		}
		//=========================9=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t9=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select class_end_time_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t9].'12', intval($data_per['class_end_time_r_mark']),'6');
			$t9++;
		}
		//=========================10=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t10=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select faculty_grooming_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t10].'13', intval($data_per['faculty_grooming_r_mark']),'6');
			$t10++;
		}
		//=========================11=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t11=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select logsheet_send_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t11].'14', intval($data_per['logsheet_send_r_mark']),'6');
			$t11++;
		}
		//=========================12=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t12=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select mobile_used_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t12].'15', intval($data_per['mobile_used_r_mark']),'6');
			$t12++;
		}
		//=========================13=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t13=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select timetable_followed_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t13].'16', intval($data_per['timetable_followed_r_mark']),'6');
			$t13++;
			
		}
		//=========================14=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t14=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select student_decoram_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t14].'17', intval($data_per['student_decoram_r_mark']),'6');
			$t14++;
		}
		//=========================15=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t15=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select phone_submited from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t15].'18', $data_per['phone_submited'],'6');
			$t15++;
		}
		//=========================16=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t16=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select negative_remarks from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t16].'19', intval($data_per['negative_remarks']),'6');
			$t16++;
		}
		//=========================17=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t17=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select late_login_without_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t17].'20', intval($data_per['late_login_without_info_mark']),'6');
			$t17++;
		}
		//=========================18=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t18=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select absent_without_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t18].'21', intval($data_per['absent_without_info_mark']),'6');
			$t18++;
		}
		//=========================19=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t19=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select early_checkout_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t19].'22', intval($data_per['early_checkout_info_mark']),'6');
			$t19++;			
		}
		//=========================20=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t20=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select misconduct_with_staff_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t20].'23', intval($data_per['misconduct_with_staff_mark']),'6');
			$t20++;	
		}
		//=========================21=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t21=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$sel_rel_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$end_installment_date_i." ";
			$query_rel_amnt=mysql_query($sel_rel_amnt);
			$data_rel_amnt=mysql_fetch_array($query_rel_amnt);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t21].'24', intval($data_per['misconduct_with_student_mark']),'6');
			$t21++;	
		}
		//=========================22=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t22=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select logsheet_not_checked_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t22].'25', intval($data_per['logsheet_not_checked_mark']),'6');
			$t22++;
		}
		//=========================23=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t23=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select other_issue_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t23].'26', intval($data_per['other_issue_mark']),'6');
			$t23++;
		}
		//=========================24=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t24=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select points from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t24].'27', intval($data_per['points']),'6');
			$t24++;
		}
		//=========================25=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t25=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select monthly_points from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t25].'28', intval($data_per['monthly_points']),'6');
			$t25++;
		}
		//=========================26=======================
		$select_counc="select * from site_setting where 1 and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t26=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_per="select comments from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
			$ptr_per=mysql_query($select_per);
			$data_per=mysql_fetch_array($ptr_per);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t26].'29', $data_per['comments'],'6');
			$t26++;
		}*/
		
		
$cnttotal=$rowCount+1;
$objPHPExcel->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="employee_utilization_report_'.date('Y-m-d').'.xls"');
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