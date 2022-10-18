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
								'type'=> PHPExcel_Style_Fill::FILL_SOLID,
							),
		  'borders' => array(
		                         'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							),
		  'alignment' => array(
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							   'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER		  
		 ));
		 
  $sharedStyle2->applyFromArray(
	array('fill' 	=> array(
								'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'	=> array('argb' => '99ccff')
							),
		  'borders' => array(
								'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
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
	
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
		
	if($keyword)
	{                            
		$pre_keyword =" and (e.name like '%".$keyword."%' )";
	}                            
	else
		$pre_keyword="";

	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['from_date']);
		$first_month=$frm_date[0];
		$first_year=$frm_date[1];
		$days_i_first_month = cal_days_in_month(CAL_GREGORIAN, $first_month, $first_year);
		
		$from_date="01-".$frm_date[0]."-".$frm_date[1];
		
		$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($from_date))."'";
		$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
		$installment_from_date_i=" and DATE(i.installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
		$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($from_date))."'";
	}
	else
	{
		$pre_from_date=""; 
		$paid_from_date="";
		$installment_from_date="";
		$installment_from_date_i="";
		if($_REQUEST['to_date']=='')
		{
			$first_month=date('m');
			$first_year=date('Y');
			$days_i_first_month = cal_days_in_month(CAL_GREGORIAN, $first_month, $first_year);
			
			$from_date="01-".$first_month."-".$first_year;
			
			$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($from_date))."'";
			$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($from_date))."'";
			$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
			$installment_from_date_i=" and DATE(i.installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
		}
		else
		{
			$first_month='';
			$first_year='';
			$paid_from_date="";
			$installment_from_date="";
			$installment_from_date_i="";
		}                         
	}
	if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['to_date']);
		$second_month=$to_date[0];
		$second_year=$to_date[1];
		$days_in_second_month = cal_days_in_month(CAL_GREGORIAN, $second_month, $second_year);
		
		$to_dates=$days_in_second_month."-".$to_date[0]."-".$to_date[1];
		
		$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
		$installment_to_date_i=" and DATE(i.installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
		$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";		
	}
	else
	{
		$second_month=date('m');
		$second_year=date('Y');
		$days_in_second_month = cal_days_in_month(CAL_GREGORIAN, $second_month, $second_year);
		$to_dates=$days_in_second_month."-".$second_month."-".$second_year;
		
		$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
		$installment_to_date_i=" and DATE(i.installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
		$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	
	$search_cm_id='';
	$search_cm_id_i='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$search_cm_id_i=" and e.cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$search_cm_id=" and cm_id='2'";
			$search_cm_id_i=" and e.cm_id='2'";
			$cm_ids=2;
		}
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
	else
		$select_directory='order by e.enroll_id desc'; 
		
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and e.cm_id='".$_SESSION['cm_id']."'";
	}
	
	$monthRanger = count(range($first_month, $second_month));
	$range_count=$monthRanger * 4;
	if($monthRanger >= 2 && $monthRanger <= 3)
	{
		$colspan = 11 + ($monthRanger * 4);
	}
	else if($monthRanger < 2)
	{
		$colspan= 14;
	}
	else
	{
		$colspan= 24;
	}
	                     
  	if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		$sql_query="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id,e.net_fees,e.down_payment,e.paid,balance_amt,e.assigned_to FROM enrollment e, installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory."  "; 
	}
	else
	{
		$sql_query="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id,e.net_fees,e.down_payment,e.paid,balance_amt, e.assigned_to FROM enrollment e,installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id and e.assigned_to='".$_SESSION['admin_id']."' ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory." "; 
	}
	
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+5);
  	$no_of_rows_new = ($no_of_rows+3);

	$arr_alph=array('L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	
	/*$select_cnt="select * from site_setting where 1 and (type='A' or type='C' or type='Z') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_cnt=mysql_query($select_cnt);
	$cnt=mysql_num_rows($ptr_cnt);*/
	$alpha=$arr_alph[$range_count];
	
	//================================Apply styles========================================
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

	$select_counc="select * from site_setting where 1 and (type='A' or type='C' or type='Z') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "".$arr_alph[$ts]."5:".$arr_alph[$ts]."$no_of_rows");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($arr_alph[$ts])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle(''.$arr_alph[$ts].'1:'.$arr_alph[$ts].''.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
		$ts++;
	}

	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A3:".$alpha."3");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:".$alpha."4");

	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A2:M2");
	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");
	/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A35:A37");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B35:B37");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C35:C37");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A39:A41");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B39:B41");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C39:C41");*/
	//============================== Set column widths==============================
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
	//============================== Merge cells ====================================
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
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:K3');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A3','Enrollment Outstanding Details');
	
	$yearArray = range($first_year, $second_year);
	$start=$first_month;	//$_REQUEST['first_month']
	$end=12;
	$sec_month=12;
	$ends=0;
	$st=0;
	foreach ($yearArray as $year) {
		$end=$sec_month;
		if($first_year==$second_year)
		{
			$end=$second_month;
		}					
		$monthArray = range($start, $end);
		$currentMonth =date('Y').'-'.date('m').'-01';
		
		$pre_st=0;
		$st=0;
		foreach ($monthArray as $month) {
			$monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
			$fdate = date("F", strtotime("2015-$monthPadding-01"));
			//$fdate.' - '.$monthPadding.' - '.$year.' - //January - 01 - 2020
			if($st==0 || $st%4==0)
			{
				if($st==0)
					$next_st=$pre_st;
				else
					$next_st=$st+1;
				
				$next_sts=$next_st+3;
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells($arr_alph[$pre_st].'3:'.$arr_alph[$next_sts].'3');
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$pre_st].'3', $fdate.' '.$year,'6');
				$pre_st = $next_sts+1;
			}
			$st++;
		}
		$sec_month=$second_month;   /// $_REQUEST['second_month']
		$start=1;
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Student Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Course Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Course Fees','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'DP Amount','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'DP Date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'DP Payment Mode','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Amount Realised Date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Pending Amount Till Date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Sales Executive','6');
	
	$yearArray = range($first_year, $second_year);
	$start=$first_month;
	$end=12;
	$sec_month=12;
	$ends=0;
	$st=0;
	$pre_st=0;
	foreach ($yearArray as $year) {
		$end=$sec_month;
		if($first_year==$second_year)
		{
			$end=$second_month;
		}					
		$monthArray=range($start, $end);
		$currentMonth=date('Y').'-'.date('m').'-01';
		foreach ($monthArray as $month) {
			$monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
			$fdate=date("F", strtotime("$first_year-$monthPadding-$start"));
			if($st==0 || $st%4==0)
			{
				if($st==0)
					$next_st=$pre_st;
				else
					$next_st=$st+1;
				
				$next_sts=$next_st+3;

				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$pre_st].'4', 'Installment Amount','6');
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$pre_st+1].'4', 'Installment Date','6');
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$pre_st+2].'4', 'Amount Realised','6');
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$pre_st+3].'4', 'Payment Mode','6');
				$pre_st = $next_sts+1;
			}
			$st++;
		}
		$sec_month=$second_month;
		$start=1;
	}
	
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="outstanding_inst_report.xls"');
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