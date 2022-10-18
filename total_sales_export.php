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

	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date") // on 3-2-2018
	{
		$frm_date=explode("/",$_REQUEST['from_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		
		$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
		$installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
		$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
		$paid_from_date_i=" and DATE(i.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date=""; 
		if($_REQUEST['to_date']=='')
		{
			$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
			$paid_from_date_i=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
			$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
		}
		else
		{
			$paid_from_date="";
			$paid_from_date_i="";
		}
		$installment_from_date="";                           
	}
	if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['to_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		
		$pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and DATE(`installment_date`)<='".date('Y-m-d',strtotime($to_dates))."' ";
		$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
		$paid_to_date_i=" and DATE(i.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		//$pre_to_date="";
		$installment_to_date="";
		$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
		$paid_to_date_i=" and DATE(i.added_date)<='".date('Y-m-d')."'";
		$pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d')."'";
	}
	$search_cm_id='';
	if($_SESSION['type']=="S" || $_SESSION['type']=="Z" || $_SESSION['type']=="LD")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			
		}
		else
		{
			$search_cm_id=" and cm_id='2'";
		}
	}
	if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
	{
		$select_directory = " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		$select_directory='order by invoice_id desc';                      
        
  	$sel_for_Num_rows="SELECT DISTINCT(enroll_id) FROM `invoice` WHERE 1 ".$paid_from_date." ".$paid_to_date." ".$_SESSION['where']." ".$search_cm_id." ".$select_directory." ";
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+5);
  	$no_of_rows_new = ($no_of_rows+3);
	
	$arr_alph=array('E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC');
	
	/*$select_cnt="select * from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_cnt=mysql_query($select_cnt);
	$cnt=mysql_num_rows($ptr_cnt);*/
	
	//================Apply styles============================
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B5:B$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C5:C$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D5:D$no_of_rows");
	
	$select_counc="select * from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
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
	
	$select_paymode="select payment_mode_id from payment_mode where 1 order by payment_mode_id asc";
	$ptr_paymode=mysql_query($select_paymode);
	$pay_cnt=mysql_num_rows($ptr_paymode);
	while($data_paymode=mysql_fetch_array($ptr_paymode))
	{
		$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "".$arr_alph[$ts]."5:".$arr_alph[$ts]."$no_of_rows");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($arr_alph[$ts])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle(''.$arr_alph[$ts].'1:'.$arr_alph[$ts].''.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
		$ts++;
	}
	
	$cnt=intval($admin_cnt + $pay_cnt);
	$alpha=$arr_alph[$cnt];

	//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "E5:E$no_of_rows");
	
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:".$alpha."4");
	
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

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Name','6');
 
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Course Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Total Paid in month','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Total Paid in month','6');
	
	$select_counc="select * from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc=mysql_query($select_counc);
	$t=0;
	while($data_couc=mysql_fetch_array($ptr_counc))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'4', $data_couc['name'],'6');
		$t++;
	}
	
	$select_paymode="select payment_mode from payment_mode where 1 order by payment_mode_id asc";
	$ptr_paymode=mysql_query($select_paymode);
	while($data_paymode=mysql_fetch_array($ptr_paymode))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$t].'4', $data_paymode['payment_mode'],'6');
		$t++;
	}
		
	$select_directory='order by invoice_id desc';
	$sql_query="SELECT DISTINCT(enroll_id) FROM `invoice` WHERE 1 ".$paid_from_date." ".$paid_to_date." ".$_SESSION['where']." ".$search_cm_id." ".$select_directory." "; 
		
	if($_GET['keyword']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
	}
	 
	
	$query_order=mysql_query($sql_query);
	
	$i=1;
	$rowCount=5;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$sel_name="select name from enrollment where 1 and (student_status ='Active' or student_status is NULL) and enroll_id='".$val_query['enroll_id']."' ".$pre_keyword."";
		$ptr_name=mysql_query($sel_name);
		if(mysql_num_rows($ptr_name))
		{
			$data_name=mysql_fetch_array($ptr_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $data_name['name']);
			$course_data='';
			$sel_total_course="select enroll_id,course_id,net_fees,admission_date from enrollment where 1 and (student_status ='Active' or student_status is NULL) and enroll_id='".$val_query['enroll_id']."' ".$pre_keyword." order by enroll_id asc";
			$ptr_ref=mysql_query($sel_total_course);
			$totals_courses=mysql_num_rows($ptr_ref);
			$totals_cntt=mysql_num_rows($ptr_ref);
			$course_data='';
			while($data_total=mysql_fetch_array($ptr_ref))
			{
				$select_course = "select course_name from courses where course_id = '".$data_total['course_id']."'  ";
				$query=mysql_query($select_course);
				$val_course= mysql_fetch_array($query);
				
				$course_data .= $val_course['course_name']."\n Course fee ".$data_total['net_fees'];
				
				$sel_down="select down_payment,discount,enroll_id from enrollment where 1 and (student_status ='Active' or student_status is NULL) and enroll_id='".$data_total['enroll_id']."' ".$pre_from_date." ".$pre_to_date." ".$pre_keyword." order by enroll_id asc ";
				$ptr_down=mysql_query($sel_down);
				if(mysql_num_rows($ptr_down))
				{
					$data_amnt=mysql_fetch_array($ptr_down);
					
					$sel_enroll="select invoice_id, enroll_id, paid_type from invoice where enroll_id='".$data_amnt['enroll_id']."' and type='down_payment'";
					$ptr_enroll=mysql_query($sel_enroll);
					$data_enroll=mysql_fetch_array($ptr_enroll);
					
					$sel_pay="select payment_mode from payment_mode where payment_mode_id='".$data_enroll['paid_type']."'";
					$ptr_pay=mysql_query($sel_pay);
					$data_pay=mysql_fetch_array($ptr_pay);
					$course_data .="/-\n Down Payment- ".$data_amnt['down_payment']."\n  Payment Mode- ".$data_pay['payment_mode'];
					
					$total_paid_downpayment=$total_paid_downpayment+$data_amnt['down_payment'];
				}
				
				$course_data .="\n Date: ".$data_total['admission_date']."\n";
				
				if($totals_courses = $totals_courses-1 )
				{
					//$course_data .="\n";
					//$course_data .= '----------------------------------';
					//$course_data .="\n";
				}
			}
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $course_data);		
			
				
				
			$sel_inst_amnt="select enroll_id,paid,course_id,invoice_no from enrollment where 1 and (student_status ='Active' or student_status is NULL) and enroll_id='".$val_query['enroll_id']."' ".$pre_keyword." order by enroll_id asc";
			$ptr_ins_amnt=mysql_query($sel_inst_amnt);
			if($total_inst=mysql_num_rows($ptr_ins_amnt))
			{
				$amount1=0;
				$total_paid_data1='';
				while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
				{
					$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' and amount >0 ".$paid_from_date." ".$paid_to_date." ";
					$ptr_installment = mysql_query($select_installments);
					if(mysql_num_rows($ptr_installment))
					{
						$amount1=0;
						while($data_installment = mysql_fetch_array($ptr_installment))
						{
							
							//if($data_installment[amount] >0)
							//{
								$amount1 +=$data_installment['amount'];
								$dt=strtotime($data_installment['added_date']);
								$datess=date("Y-m-d", $dt);
								$total_paid_data1 .= $data_installment[amount]."/- ".$datess." : ".$data_installment['status']."\n";
								$total_paid1=$total_paid1+$data_installment['amount'];
							//}
						}
						
						 $total_paid_data1 .="Total Paid- ".$amount1."";
						 if($total_inst = $total_inst-1 )
						 {
							//$total_paid_data1 .="\n";
							//$total_paid_data1 .= '--------------------------------';
							//$total_paid_data1 .="\n";
						 }
					}
				}
			}
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $total_paid_data1);
			
			$select_counc1="select admin_id from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
			$ptr_counc1=mysql_query($select_counc1);
			$s=0;
			while($data_counc1=mysql_fetch_array($ptr_counc1))
			{
				$sel_inst_amnt="select enroll_id,paid,course_id,invoice_no,assigned_to from enrollment where 1 and (student_status ='Active' or student_status is NULL) and enroll_id='".$val_query['enroll_id']."' and assigned_to='".$data_counc1['admin_id']."' ".$pre_keyword." order by enroll_id asc";
				$ptr_ins_amnt=mysql_query($sel_inst_amnt);
				if($total_inst=mysql_num_rows($ptr_ins_amnt))
				{
					$data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);
					
					$select_installments = " SELECT SUM(amount) as amount FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and amount >0 ".$paid_from_date." ".$paid_to_date." "; //and assigned_to='".$data_inst_amnt['assigned_to']."'
					$ptr_installment = mysql_query($select_installments);
					$data_installment = mysql_fetch_array($ptr_installment);
					$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$s].''.$rowCount, $data_installment['amount']);
				}
				$s++;
			}
			
			$select_paymode="select payment_mode_id from payment_mode where 1 order by payment_mode_id asc";
			$ptr_paymode=mysql_query($select_paymode);
			while($data_paymode=mysql_fetch_array($ptr_paymode))
			{
				$sel_paymode="select SUM(amount) as amount from invoice where 1 and enroll_id='".$val_query['enroll_id']."' and amount >0 and paid_type='".$data_paymode['payment_mode_id']."' ".$paid_from_date." ".$paid_to_date."  order by enroll_id asc";
				$ptr_ins_amnt=mysql_query($sel_paymode);
				if($total_inst=mysql_num_rows($ptr_ins_amnt))
				{
					$data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);
					$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$s].''.$rowCount, $data_inst_amnt['amount']);
				}
				$s++;
			}
			
			
			$k++;
			$rowCount++;
			$i++;
		}
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $total_paid_downpayment);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $total_paid1);
	
	$select_counc1="select admin_id from site_setting where 1 and (type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$search_cm_id." order by admin_id asc";
	$ptr_counc1=mysql_query($select_counc1);
	$st=0;
	while($data_counc1=mysql_fetch_array($ptr_counc1))
	{
		$select_installments = " SELECT SUM(amount) as amount FROM invoice i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id and i.amount >0 and e.assigned_to='".$data_counc1['admin_id']."' ".$paid_from_date_i." ".$paid_to_date_i." ";
		$ptr_installment = mysql_query($select_installments);
		$data_installment = mysql_fetch_array($ptr_installment);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue($arr_alph[$st].$rowCount, $data_installment['amount']);
		//$total_bhakti=$total_bhakti +$data_installment['amount'];
		$st++;
	}
	
	$cnttotal=$rowCount+1;
	$toatal_all=intval($total_paid_downpayment+$total_paid1);
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A".$cnttotal.":D".$cnttotal."");
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$cnttotal, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$cnttotal, $toatal_all);

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