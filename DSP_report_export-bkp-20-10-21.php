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
	if($keyword)
	{                            
		$pre_keyword =" and (name like '%".$keyword."%' )";
	}                            
	else
		$pre_keyword="";
	
	if($_REQUEST['on_date'] && $_REQUEST['on_date']!=="0000-00-00" && $_REQUEST['on_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['on_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$date_for_month=$frm_date[2]."-".$frm_date[1];
		$start_date=$frm_dates;
		$first_date_month=date("Y-m-d", strtotime($frm_dates . "first day of this month"));
		$last_date_month=date('Y-m-d',strtotime($frm_dates ."last day of this month"));
		$added_date=" and DATE(added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$dsr_added_date=" and DATE(dsr_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d',strtotime($frm_dates))."' ";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates . "last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $frm_dates ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-30 days'))."'"; //
	}
	else
	{
		$first_date_month=date("Y-m-d", strtotime("first day of this month"));
		$last_date_month=date('Y-m-d',strtotime("last day of this month"));
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d')."'";
		$added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$dsr_added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d')."'";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d')."'";
		$date_for_month=date('Y-m');
		$date=date('Y-m-d');
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d')."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d')."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d')."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime("last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime("first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime("last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime("last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime("first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $date ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'"; //
	}
	
	$search_cm_id='';
	//$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			//$cm_ids=$data_cm_id['cm_id'];
			$search_cm_id_e=" and e.cm_id='".$data_cm_id['cm_id']."'";
		}
		else
		{
			$search_cm_id=" and cm_id='2'";
			$search_cm_id_e=" and e.cm_id='2'";
		}
	}
	
	$cm_ids=='';
	if($_SESSION['where'] !='')
	{
		$cm_ids=" and e.cm_id='".$_SESSION['cm_id']."'";
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
        
  	$sel_for_Num_rows="SELECT DISTINCT(enroll_id) FROM `invoice` WHERE 1 ".$paid_from_date." ".$paid_to_date." ".$_SESSION['where']." ".$search_cm_id." ".$select_directory." ";
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
	
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
	
	$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
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
	
	$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$admin_cnt=mysql_num_rows($ptr_counc);
	$ts=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue("".$arr_alph[$ts]."3", "".$data_couc['name']."",'6');
		$ts++;
	}
	
		//=========================1======================
		$tota_ld_lead='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t1=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$sql_query="SELECT * FROM inquiry where 1 and campaign_type='lead_distribution' and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id."  ".$added_date." ";
			$ptr_query=mysql_query($sql_query);
			$tota_ld_lead=mysql_num_rows($ptr_query);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t1].'4', $tota_ld_lead,'6');
			$t1++;
		}
		//=========================2=======================
		$count_enquiry='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t2=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enquiry="select inquiry_id from inquiry where 1 and (campaign_type !='lead_distribution' or campaign_type is NULL ) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
			$query_enquiery=mysql_query($select_enquiry);
			$count_enquiry=mysql_num_rows($query_enquiery);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t2].'5', $count_enquiry,'6');
			$t2++;
		}
		//=========================3=======================
		$count_enq_called='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t3=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
			$query_enq_cnt=mysql_query($select_enq_cnt);
			$count_enq_called=mysql_num_rows($query_enq_cnt);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t3].'6', $count_enq_called,'6');
			$t3++;
		}
		//=========================4=======================
		$no_of_foll_call='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t4=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
			$query_enq_cnt=mysql_query($select_enq_cnt);
			$count_enq_called=mysql_num_rows($query_enq_cnt);
			
			$select_tot_called="Select DISTINCT(student_id) from followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
			$query_tot_called=mysql_query($select_tot_called);
			$tot_foll_called=mysql_num_rows($query_tot_called);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t4].'7', round($tot_foll_called - $count_enq_called),'6');
			$t4++;
		}
		//=========================5=======================
		$salon_foll_called='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t5=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$salon_tot_called="select followup_id from service_followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
			$salon_tot_called=mysql_query($salon_tot_called);
			$salon_foll_called=mysql_num_rows($salon_tot_called);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t5].'8', $salon_foll_called,'6');
			$t5++;
		}
		//=========================6=======================
		$count_enq_catd='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t6=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_cat="select inquiry_id from inquiry where 1 and enquiry_type_category ='career_consultant' and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
			$query_enq_cat=mysql_query($select_enq_cat);
			$count_enq_catd=mysql_num_rows($query_enq_cat);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t6].'9', $count_enq_catd,'6');
			$t6++;
		}
		//=========================7=======================
		$count_enq_tieup='';
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t7=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_tieup="select inquiry_id from inquiry where 1 and enquiry_type_category ='other_tie-up' and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
			$query_enq_tieup=mysql_query($query_enq_tieup);
			$count_enq_tieup=mysql_num_rows($query_enq_cat);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t7].'10', $count_enq_tieup,'6');
			$t7++;
		}
		//=========================8=======================
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t8=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_tot_called="Select followup_id from followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
			$query_tot_called=mysql_query($select_tot_called);
			$total_foll_called=mysql_num_rows($query_tot_called);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t8].'10', round($total_foll_called),'6');
			$t8++;
		}
		//=========================9=======================
		$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
		$ptr_counc=mysql_query($select_counc);
		$t9=0;
		while($data_couc=mysql_fetch_array($ptr_counc))
		{
			$select_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
			$query_enq_walkin=mysql_query($select_enq_walkin);
			$count_enq_walkin=mysql_num_rows($query_enq_walkin);
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t9].'11', round($count_enq_walkin),'6');
			$t9++;
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