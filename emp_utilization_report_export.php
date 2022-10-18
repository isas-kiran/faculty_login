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
	array('fill'=> array('type'=> PHPExcel_Style_Fill::FILL_SOLID,),
		  'borders'=> array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
							'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
							'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
							'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							),
		  'alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							));
		 
  	$sharedStyle2->applyFromArray(array('fill' 	=> array('type'=> PHPExcel_Style_Fill::FILL_SOLID,'color'=> array('argb' => '99ccff')),
	'borders' => array('bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
						),
		  'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		 ));

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$total_found =0;	
	$not_found=0; 
	
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
		
	if($keyword)
	{                            
		$pre_keyword =" and (name like '%".$keyword."%' )";
	}                            
	else
		$pre_keyword="";

	if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['start_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$start_date=$frm_dates;
		$enquiry_from_date=" and DATE(report_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
	   $enquiry_from_date=" and DATE(`report_date`) >='".date('Y-m-d',strtotime('-1 days'))."'"; //date('Y-m-d',strtotime('-1 days'))

	}
	
	//$search_cm_id='';
	//$cm_ids=$_SESSION['cm_id'];
	//if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	//{
		if($_REQUEST['branch_name_s']!='')
		{
			$branch_name=$_REQUEST['branch_name_s'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A' and system_status='Enabled'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$cm_ids=$_SESSION['cm_id'];
			$search_cm_id=" and cm_id='".$cm_ids."'";
		}
	//}
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A2',$_REQUEST['branch_name_s'],'6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2',$select_cm_id,'6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D2',$cm_ids,'6');
	if($_REQUEST['staff_id'])
	{
		$staff_ids=$_REQUEST['staff_id'];
		$where_staff_id=" and admin_id='".$staff_ids."'";
	}
	else
	{
		$where_staff_id='';
	}
		
  	$no_of_rows=40;
  	$no_of_rows = ($no_of_rows+5);
  	$no_of_rows_new = ($no_of_rows+3);
	
	$arr_alph=array('D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	
	//================Apply styles============================
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B5:B$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C5:C$no_of_rows");
	
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$admin_cnt=mysql_num_rows($ptr_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "".$arr_alph[$ts]."5:".$arr_alph[$ts]."$no_of_rows");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($arr_alph[$ts])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle(''.$arr_alph[$ts].'1:'.$arr_alph[$ts].''.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
		$ts++;
	}
	
	$cnt=intval($admin_cnt);
	$alpha=$arr_alph[$cnt];

	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:".$alpha."4");
			
	//================== Set column widths==============================
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("30");
	//======================== Merge cells	======================
	
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
	
	//======================== Add some data======================
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Field Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Sub Filed Name','6');
	
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'4', $data_couc['name'],'6');
		$t++;
	}
	
	//==========================================1======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A5', '1' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B5', 'Timesheet Status','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C5', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select timesheet_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'5', $data_per['timesheet_mark'],'6');
		$t++;
	}
	//==========================================2======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A6', '2' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B6', 'Utilisation','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C6', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select utilisation_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'6', $data_per['utilisation_mark'],'6');
		$t++;
	}
	//==========================================3======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A7', '3' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B7', 'Presence','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C7', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select presence from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'7', $data_per['presence'],'6');
		$t++;
	}
	//==========================================4======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A8', '4' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B8', 'Working Hours','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C8', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select working_hrs from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'8', $data_per['working_hrs'],'6');
		$t++;
	}
	//==========================================5======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A9', '5' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B9', 'Task Completion','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C9', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select task_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'9', $data_per['task_mark'],'6');
		$t++;
	}
	//==========================================6======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A10', '6' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B10', 'Quality Of Work','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C10', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select quality_work_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'10', $data_per['quality_work_mark'],'6');
		$t++;
	}
	//==========================================7======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A11', '7' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B11', 'Rules Followed','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C11', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select * from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date."";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		
		$rules_foll=round($data_per['class_start_time_mark']+$data_per['class_end_time_r_mark']+$data_per['faculty_grooming_r_mark']+$data_per['logsheet_send_r_mark']+$data_per['mobile_used_r_mark']+$data_per['timetable_followed_r_mark']+$data_per['student_decoram_r_mark']);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'11', $rules_foll,'6');
		$t++;
	}
	//==========================================8-A======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A12', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B12', 'A','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C12', 'Class Start on Time','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select class_start_time_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'12', $data_per['class_start_time_mark'],'6');
		$t++;
	}
	//==========================================8-B======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A13', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B13', 'B','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C13', 'Class End on Time','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select class_end_time_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'13', $data_per['class_end_time_r_mark'],'6');
		$t++;
	}
	//==========================================8-C======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A14', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B14', 'C','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C14', 'Faculty Grooming','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select faculty_grooming_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'14', $data_per['faculty_grooming_r_mark'],'6');
		$t++;
	}	
	//==========================================8-D======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A15', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B15', 'D','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C15', 'Logsheet Send','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select logsheet_send_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'15', $data_per['logsheet_send_r_mark'],'6');
		$t++;
	}	
	//==========================================8-E======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A16', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B16', 'E','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C16', 'Mobile Not Used in Batch Hours','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select mobile_used_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'16', $data_per['mobile_used_r_mark'],'6');
		$t++;
	}
	//==========================================8-F======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A17', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B17', 'F','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C17', 'Timetable Followed','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select timetable_followed_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'17', $data_per['timetable_followed_r_mark'],'6');
		$t++;
	}
	//==========================================8-G======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A18', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B18', 'G','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C18', 'Student Decoram','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select student_decoram_r_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'18', $data_per['student_decoram_r_mark'],'6');
		$t++;
	}
	//==========================================9======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A19', '8' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B19', 'Phone Submited','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C19', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select phone_submited from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'19', $data_per['phone_submited'],'6');
		$t++;
	}
	//==========================================10======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A20', '9' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B20', 'No. Of Negative Remark','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C20', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select negative_remarks from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'20', $data_per['negative_remarks'],'6');
		$t++;
	}
	//==========================================10-A======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A21', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B21', 'A','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C21', 'Late Login Without Info','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select late_login_without_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'21', $data_per['late_login_without_info_mark'],'6');
		$t++;
	}
	//==========================================10-B======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A22', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B22', 'B','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C22', 'Absent Without Info','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select absent_without_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'22', $data_per['absent_without_info_mark'],'6');
		$t++;
	}
	//==========================================10-C======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A23', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B23', 'C','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C23', 'Early Checkout Without Info','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select early_checkout_info_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'23', $data_per['early_checkout_info_mark'],'6');
		$t++;
	}
	//==========================================10-D======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A24', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B24', 'D','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C24', 'Misconduct With Staff','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select misconduct_with_staff_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'24', $data_per['misconduct_with_staff_mark'],'6');
		$t++;
	}
	//==========================================10-E======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A25', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B25', 'E','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C25', 'Misconduct With Student','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select misconduct_with_student_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'25', $data_per['misconduct_with_student_mark'],'6');
		$t++;
	}
	//==========================================10-F======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A26', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B26', 'F','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C26', 'Logsheet Not Checked','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select logsheet_not_checked_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'26', $data_per['logsheet_not_checked_mark'],'6');
		$t++;
	}
	//==========================================10-G======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A27', '' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B27', 'G','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C27', 'Other Issue','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select other_issue_mark from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'27', $data_per['other_issue_mark'],'6');
		$t++;
	}
	//==========================================11======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A28', '10' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B28', 'Points','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C28', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select points from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'28', $data_per['points'],'6');
		$t++;
	}
	//==========================================12======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A29', '11' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B29', 'Monthly Points','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C29', '','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select monthly_points from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'29', $data_per['monthly_points'],'6');
		$t++;
	}
	//==========================================13======================================
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A30','12' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B30','Comments','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C30','','6');
	
	$tota_ld_lead='';
	$select_counc="select * from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$select_per="select comments from emp_performance_report where employee_id='".$data_couc['admin_id']."' ".$enquiry_from_date." ";
		$ptr_per=mysql_query($select_per);
		$data_per=mysql_fetch_array($ptr_per);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'30', $data_per['comments'],'6');
		$t++;
	}

	$objPHPExcel->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

if($branch_name!='')
{
	$staff_nams.=$branch_name.'_branch_for_';
}
if($_REQUEST['staff_id']!='')
{
	$select_adm="select name from site_setting where 1 and system_status='Enabled'  ".$search_cm_id." ".$where_staff_id." order by admin_id asc";
	$ptr_adm=mysql_query($select_adm);
	$data_staff=mysql_fetch_array($ptr_adm);
	$staff_nams=$data_staff['name'];
}
else
{
	$staff_nams.='all_staff';
}


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="EPR_of_'.$staff_nams.'_'.date('Y-m-d').'.xls"');
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