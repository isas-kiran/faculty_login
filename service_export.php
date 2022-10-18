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
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							   'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							   
							   )
		  
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

//==========================properties========================
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


$total_found =0;	
	$not_found=0; 
	
			if($_REQUEST['keyword']!="Keyword")
				$keyword=trim($_REQUEST['keyword']);
			else
				$keyword='';
			if($keyword)
				$pre_keyword=" and (service_name like '%".$keyword."%' || service_description like '%".$keyword."%' || service_price like '%".$keyword."%' || service_time like '%".$keyword."%' || service_code like '%".$keyword."%' || status like '%".$keyword."%')";
			else
				$pre_keyword="";
			
			if($_REQUEST['page'])
				$page=$_REQUEST['page'];
			else
				$page=0;
			
			if($_REQUEST['show_records'])
				$show=$_REQUEST['show'];
			else
				$show=0;
			
			if($_REQUEST['branch_name'])
			{
				$sel_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_name']."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				
				$branch_keyword="  and cm_id ='".$cm_id."'";
				$branch_keyword_p="and cs.cm_id ='".$cm_id."'";
			}
			else 
			{
				$branch_keyword="";
				$branch_keyword_p="";
			}
			
			if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
			{
				$frm_date=explode("/",$_REQUEST['from_date']);
				$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
				
				$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
				$paid_from_date_cs=" and DATE(cs.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
			}
			else
			{
				$paid_from_date="";
				$paid_from_date_cs="";
				$frm_dates='';
			}
			if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
			{
				$to_date=explode("/",$_REQUEST['to_date']);
				$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
				
				$paid_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";
				$paid_to_date_cs=" and DATE(cs.added_date) <='".date('Y-m-d',strtotime($to_dates))."'";
			}
			else
			{
				$paid_to_date='';
				$paid_to_date_cs='';
			}
			
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
			
			if($_GET['orderby']=='service_name' )
				$img1 = $img;
			
			if($_GET['order'] !='' && ($_GET['orderby']=='service_name'))
			{
				$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
				$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
			}
			else
				$select_directory='order by customer_service_id desc';
			$record_cat_id='';
			$record_cat_idss='';
			if($_GET['record_id'] !='')
			{
				$record_cat_id="and customer_service_id='".$_GET['record_id']."' ";
				$record_cat_idss="and cs.customer_service_id='".$_GET['record_id']."' ";
			}	
			$cmids="";
			if($_SESSION['where']!='')
			{
				$cmids=" and cs.cm_id='".$_SESSION['cm_id']."'";
			}
						
			$select_directory='order by DATE(cs.added_date) desc';   
			
			             
  			$sql_query= "SELECT distinct(cs.customer_service_id) as customer_service_id FROM customer_service cs, customer c, servies s, customer_service_map csm where 1  and (cs.service_price like '%".$keyword."%' or cs.discount_price like '%".$keyword."%' or cs.service_tax like '%".$keyword."%' or cs.total_cost like '%".$keyword."%' or c.cust_name like '%".$keyword."%' or c.mobile1 like '%".$keyword."%' or s.service_name like '%".$keyword."%' or s.service_price like '%".$keyword."%') and cs.customer_id=c.cust_id and cs.customer_service_id=csm.customer_service_id  and csm.service_id=s.service_id ".$cmids." ".$branch_keyword_p." ".$record_cat_idss." ".$paid_from_date_cs." ".$paid_to_date_cs." ".$where_service_id." order by cs.customer_service_id desc ";
			$my_querxy=mysql_query($sel_for_Num_rows);
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
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "J5:I$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K5:I$no_of_rows");


$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:K4");
//$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "A2:M2");
//$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");
/*$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "A35:A37");
$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "B35:B37");
$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "C35:C37");
$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "A39:A41");
$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "B39:B41");
$objPHPExcel->setActiveSheetIndex()->setSharedStyle($sharedStyle2, "C39:C41");*/

//================== Set column widths==============================
/*$objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex()->getColumnDimension('F')->setAutoSize(true); */

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("30");


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:I'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:J'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 

//======================== Merge cells	======================

//$objPHPExcel->setActiveSheetIndex()->mergeCells('A7:B7');
//$objPHPExcel->setActiveSheetIndex()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->setActiveSheetIndex()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');


//======================== Add some data======================
//echo "<br />".date('H:i:s') . "\t Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);

	/* $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('1','3', 'Sr. No.' ,'3');
 $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('2','3', 'Sales Order No.','3');
 
 $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('3','3', 'Mo No','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('4','3', 'Mo Date','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('5','3', 'customer Name','3');
 
  $objPHPExcel->setActiveSheetIndex()->suyetCellValueByColumnAndRow('6','3', 'Concern Person','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('7','3', 'Item Description','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('8','3', 'PO No','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('9','3', 'PO Quantity','3');
  
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('10','3', 'Item Rate','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('11','3', 'Plan Date','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('12','3', 'BD User','3');
  $objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow('13','3', 'Status','3');*/

	$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Branch','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Customer Name','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Services Details','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Total Service Price','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Discount Price','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Total Price','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Paid Amount','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Remaining Amount','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Status','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('K4', 'Added date','6');
	
	$total_down_cgst=0;
	$total_down_sgst=0;
	$total_down=0;
	$total_ins_cgst=0;
	$total_ins_sgst=0;
	$total_ins=0;
	
	$cmids="";
	if($_SESSION['where']!='')
	{
		$cmids=" and cs.cm_id='".$_SESSION['cm_id']."'";
	}
	$select_directory='order by DATE(cs.added_date) desc';                      
	$sql_query= "SELECT distinct(cs.customer_service_id) as customer_service_id FROM customer_service cs, customer c, servies s, customer_service_map csm where 1  and (cs.service_price like '%".$keyword."%' or cs.discount_price like '%".$keyword."%' or cs.service_tax like '%".$keyword."%' or cs.total_cost like '%".$keyword."%' or c.cust_name like '%".$keyword."%' or c.mobile1 like '%".$keyword."%' or s.service_name like '%".$keyword."%' or s.service_price like '%".$keyword."%') and cs.customer_id=c.cust_id and cs.customer_service_id=csm.customer_service_id  and csm.service_id=s.service_id ".$cmids." ".$branch_keyword_p." ".$record_cat_idss." ".$paid_from_date_cs." ".$paid_to_date_cs." ".$where_service_id." order by cs.customer_service_id desc ";
	
	if($_GET['keyword']!='')
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->getActiveSheet()->SetCellValue('C2', ''.$_GET['keyword'].'');
	}
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=5;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$sel_name="select name,cust_gst_no from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$name=$data_name['name'];
		if($data_name['cust_gst_no'])
		$name .="\n GST no.: ".$data_name['cust_gst_no'];
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		$sql_branch = " select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
		$ptr_branch = mysql_query($sql_branch);
		$data_branch = mysql_fetch_array($ptr_branch);
								
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		
		 $sel_cust_name="select cust_name,mobile1 from customer where cust_id='".$val_query['customer_id']."'";
		$ptr_cust=mysql_query($sel_cust_name);
		$data_cust_name=mysql_fetch_array($ptr_cust);
								
								
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $data_cust_name['cust_name']."\n".$data_cust_name['mobile1']);
		
		
		/*$sel_inst_amnt="select enroll_id,paid,course_id from enrollment where enroll_id='".$val_query['enroll_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount=0;
			$total_paid_data='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					$amount=0;
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						if($data_installment[amount] >0)
						{
							$amount +=$data_installment['amount'];
							$dt=strtotime($data_installment['added_date']);
							$datess=date("Y-m-d", $dt);
							$total_paid_data .= $data_installment['amount']."/- ".$datess." : ".$data_installment['status']."\n";
							$total_paid=$total_paid+$data_installment['amount'];
						}
					}
				}
				 $total_paid_data .="Total Paid- ".$amount."";
				 if($total_inst = $total_inst-1 )
				 {
					$total_paid_data .="\n";
					$total_paid_data .= '--------------------------------';
					$total_paid_data .="\n";
				 }
			}
		}*/
		//==========================NEW AND INSTALLMENT===============================================================
		
		$sel_cust_services="select customer_service_id,customer_id,service_id from customer_service_map where customer_service_id ='".$val_query['customer_service_id']."'";
		$ptr_sel_service=mysql_query($sel_cust_services);
		$ins=1;
		$product_name='';
		while($data_service=mysql_fetch_array($ptr_sel_service))
		{
		
		
			$select_service_name="select service_name,service_price from servies where service_id='".$data_service['service_id']."'";
			$ptr_service=mysql_query($select_service_name);
			$data_service_name=mysql_fetch_array($ptr_service);
			
			if($ins !=1)
			$product_name .= "\n";
			$product_name .= $data_service_name['service_name'];
			$ins++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $product_name);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $val_query['service_price']);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $val_query['nonmemb_discount_price']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $val_query['total_cost']);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $val_query['payable_amount']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_query['remaining_amount']);	
		/* $sel_inst_amnt="select enroll_id,paid,course_id from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount1=0;
			$total_paid_data1='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$paid_from_date." ".$paid_to_date." ";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					$amount1=0;
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						
						if($data_installment[amount] >0)
						{
							$amount1 +=$data_installment['amount'];
							$dt=strtotime($data_installment['added_date']);
							$datess=date("Y-m-d", $dt);
							$total_paid_data1 .= $data_installment[amount]."/- ".$datess." : ".$data_installment['status']."\n";
							$total_paid1=$total_paid1+$data_installment['amount'];
						}
					}
				}
				 $total_paid_data1 .="Total Paid- ".$amount1."";
				 if($total_inst = $total_inst-1 )
				 {
					$total_paid_data1 .="\n";
					$total_paid_data1 .= '--------------------------------';
					$total_paid_data1 .="\n";
				 }
			}
		}
		 */
		//=================================GST in %=======================================================================
		
		
		/* $sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$expected=0;
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						$expected = $expected + $data_installment['installment_amount'];	
						$monthly_expected = $monthly_expected + $data_installment['installment_amount'];
					}
				}
				else
				{
					$expected .=0;
				}
				if($total_inst = $total_inst-1 )
				{
					$expected .= "\n";
					$expected .= '----------------------------';
					$expected .= "\n";
				}
			
			}
		} */
		
		
		//======================GST VALUE=================================================
		
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $val_query['status']);
		
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $date);	
		/* $sel_inst_amnt="select course_id,enroll_id,balance_amt from enrollment where ref_id='".$val_query['enroll_id']."' || enroll_id='".$val_query['enroll_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$installment_data='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments = " SELECT * FROM installment where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						$installment_data .= $data_installment['installment_amount']."/- ".$data_installment['installment_date']." : ".$data_installment['status']."\n";	
					}
				}
				$installment_data .= "Total Remaining- ".$data_inst_amnt['balance_amt']."";
				if($total_inst = $total_inst-1 )
				$installment_data .= "\n---------------------------------\n";
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $installment_data);		 */
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $val_course['course_price']);		
		/************************************item_description******************************************/	
		//$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $val_query['down_payment']);	
		//$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_query['balance_amt']);	
		/************************************po_qty******************************************/
			/*$select_installments = " SELECT * FROM `installment` where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."'  ";
			$ptr_installment = mysql_query($select_installments);
			if($total=mysql_num_rows($ptr_installment))
			{
				$xx='';
				$i=1;
			while($data_installment = mysql_fetch_array($ptr_installment))
			{
			 $xx.= $i.") ".$data_installment['installment_amount'].'/- '.$data_installment['installment_date'].' : '.$data_installment['status']." ";
				if($i !=$total)
				{
					//$xx.= '<br /><hr >';
				}
				$i++;
			}
			}
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $xx);*/			
		 /************************************Item rate******************************************/
		//$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $val_query['added_date']);	
		/************************************Plan Date******************************************/
		$k++;
		$rowCount++;
		$i++;
			$totals_tds +=intval($val_query['payable_amount']);
	}
	
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,intval($totals_tds));



$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="service_export.xls"');
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