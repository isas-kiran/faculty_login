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
		
	if($keyword)
	{                            
		$pre_keyword =" and (name like '%".$keyword."%' )";
		$pre_keyword_i =" and (e.name like '%".$keyword."%' )";
	}                            
	else
	{
		$pre_keyword="";
		$pre_keyword_i ="";
	}
	if($_REQUEST['gst_student']!="")
		$gst_keyword =trim($_REQUEST['gst_student']);
	
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
			$search_cm_id=" and i.cm_id='".$data_cm_id['cm_id']."'";
			$cm_ids=$data_cm_id['cm_id'];
		}
		else
		{
			$search_cm_id='';
		}
	}
	if($gst_keyword)
	{
		if($gst_keyword=="with_gst")
		{
			$where_gst =" and e.cust_gst_no !=''";
			$where_gst_i =" and e.cust_gst_no !=''";
		}
		else if($gst_keyword=="without_gst")
		{
			$where_gst =" and e.cust_gst_no=''";
			$where_gst_i =" and e.cust_gst_no=''";
		}
		else
		{
			$where_gst="";
			$where_gst_i ="";
		}
	}                            
	else
	{
		$where_gst="";
		$where_gst_i ="";
	}
	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
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
		$pre_to_date="";
		$installment_to_date="";
		$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
		$paid_to_date_i=" and DATE(i.added_date)<='".date('Y-m-d')."'";
	}
	if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
	$select_directory='order by i.invoice_id desc';                     
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and i.cm_id='".$_SESSION['cm_id']."'";
	}
        
  	$sel_for_Num_rows="SELECT DISTINCT(i.enroll_id) FROM invoice i,enrollment e WHERE 1 and i.enroll_id=e.enroll_id ".$where_gst_i." ".$search_cm_id." ".$where_cm." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) ".$select_directory."";
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


$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:G4");
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

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
	
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

	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Name','6');
 
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Course Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'New and Installment','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'GST in %','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'GST Value','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Admission Date','6');
	$total_down_cgst=0;
	$total_down_sgst=0;
	$total_down=0;
	$total_ins_cgst=0;
	$total_ins_sgst=0;
	$total_ins=0;
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and i.cm_id='".$_SESSION['cm_id']."'";
	}
	$branch_id='';
	$select_directory='order by i.invoice_id desc';                      
	$sql_query= "SELECT DISTINCT(i.enroll_id) FROM invoice i,enrollment e WHERE 1 and i.enroll_id=e.enroll_id ".$where_gst_i." ".$search_cm_id." ".$where_cm." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (i.cgst_tax_in_per >0 or i.sgst_tax_in_per >0) ".$select_directory.""; 
		
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
		$sel_name="select name,cust_gst_no,added_date from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$name=$data_name['name'];
		if($data_name['cust_gst_no'])
		$name .="\n GST no.: ".$data_name['cust_gst_no'];
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $name);
		$course_data='';
		
		$sel_total_course="select enroll_id,course_id,down_payment,discount,net_fees,admission_date from enrollment where enroll_id='".$val_query['enroll_id']."'";
		$ptr_ref=mysql_query($sel_total_course);
		$totals_courses=mysql_num_rows($ptr_ref);
		$totals_cntt=mysql_num_rows($ptr_ref);
		while($data_total=mysql_fetch_array($ptr_ref))
		{
			$select_course = "select course_name from courses where course_id = '".$data_total['course_id']."'  ";
			$query=mysql_query($select_course);
			$val_course= mysql_fetch_array($query);
			
			$course_data .= $val_course['course_name']."\n Course fee ".$data_total['net_fees']."/-\n Down Payment- ".$data_total['down_payment']."\n  Discount- ".$data_total['discount']."\n Date: ".$data_total['admission_date']."\n";
			if($totals_courses = $totals_courses-1 )
			{
				//$course_data .="\n";
				$course_data .= '----------------------------------';
				$course_data .="\n";
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $course_data);		
		
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
		$sel_inst_amnt="select enroll_id,paid,course_id,down_payment,admission_date,invoice_no from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount=0;
			$data_inst='';
			//echo '<td>';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments =" SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					$amount=0;
					$in=1;
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						if($data_installment['type']=="down_payment")
						{
							$data_inst="Down Payment\n";
							$data_inst .=$data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admission_date']."\n";
						}
						else
						{
							if($in==1)
							{
								$data_inst .="\nInstallment";
							}
							$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
							$ptr_paymode=mysql_query($sel_paymode);
							$data_paymode=mysql_fetch_array($ptr_paymode);
							$amount +=$data_installment['amount'];
							//$col_paid ='<font color="#006600">';
							$dt=strtotime($data_installment['added_date']);
							$datess=date("Y-m-d", $dt);
							$data_inst .= "\n".$data_installment['amount'].'/- '.$datess.' : '.$data_paymode[''];
							$total_paid=$total_paid+$data_installment['amount'];
							$in++;
						}
					}
					//$data_inst.="\n";
				}
				
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $data_inst);
			
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
		$sel_inst_amnt="select amount,cgst_tax_in_per,cgst_tax,sgst_tax_in_per,sgst_tax,type from invoice where 1 and enroll_id='".$val_query['enroll_id']."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$in=1;
			$gst_per='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				
				if($data_inst_amnt['type']=="down_payment")
				{
					$gst_per="Down Payment GST";
					if($data_inst_amnt['cgst_tax_in_per'] > 0)
					{
						$gst_per .="\n";
						$gst_per .='CGST ('.$data_inst_amnt['cgst_tax_in_per'].'%)';
					}
					if($data_inst_amnt['sgst_tax_in_per'] > 0)
					{
						$gst_per .=' + SGST ('.$data_inst_amnt['sgst_tax_in_per'].'%)';
					}
					$gst_per .= "\n";
					//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
				}
				else
				{
					if($in==1)
					{
						$gst_per .="\n";
						$gst_per .= "Installmet GST";
					}
					
					if($data_inst_amnt['cgst_tax_in_per'] > 0)
					{
						$gst_per .="\n";
						$gst_per .='CGST ('.$data_inst_amnt['cgst_tax_in_per'].'%)';
					}
					if($data_inst_amnt['sgst_tax_in_per'] > 0)
					{
						$gst_per .=' + SGST ('.$data_inst_amnt['sgst_tax_in_per'].'%)';
					}
					$in++;
					//echo '</br>';
				}
				
			}
			
		}
		else
		{
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $gst_per);
		
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
		
		
		//===============================================GST VALUE==================================================================
		$gst_amount=0;
		$down_total=0;
		
		$sel_inst_amnt="select amount,cgst_tax_in_per,cgst_tax,sgst_tax_in_per,sgst_tax,type,cf_gst_amnt from invoice where 1 and enroll_id='".$val_query['enroll_id']."' and amount>0 and (cgst_tax_in_per >0 or sgst_tax_in_per >0) ".$paid_from_date." ".$paid_to_date."";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$ins=1;
			$gst_val='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$gst_amount=0;
				if($data_inst_amnt['type'] =="down_payment")
				{
					$gst_val .= "Down Payment GST\n";
					$down_cgst=0;
					$down_sgst=0;
					if($data_inst_amnt['cgst_tax'] > 0)
					{
						$gst_val .= $down_cgst=intval($data_inst_amnt['cgst_tax']);
					}
					if($data_inst_amnt['sgst_tax'] > 0)
					{
						$gst_val .= ' + ';
						$gst_val .= $down_sgst=intval($data_inst_amnt['sgst_tax']);
					}
					$gst_val .= ' =';
					$gst_val .= $down_total=intval($down_cgst + $down_sgst);
					$total_down_cgst +=$down_cgst;
					$total_down_sgst +=$down_sgst;
					$total_down +=$down_total;
					//echo'</strong>';
					$gst_val .= "\n";
					//echo $data_inst_amnt['down_payment'].'/- '.$data_inst_amnt['admissio n_date']."<br>";
				}
				else if($data_inst_amnt['cf_gst_amnt']>0) //===============8/10/18================
				{
					$gst_val .= "CF Loan GST\n";
					$down_cgst=0;
					$down_sgst=0;
					if($data_inst_amnt['cgst_tax'] > 0)
					{
						$gst_val .= $cf_gst_amnt=intval($data_inst_amnt['cf_gst_amnt']);
					}
					
					$gst_val .= ' =';
					$gst_val .= $down_total=intval($data_inst_amnt['cf_gst_amnt']);
					$total_down +=$down_total;
					//echo'</strong>';
					$gst_val .= "\n";
				}
				else
				{
					if($ins==1)
					{
						$gst_val .= "\n";
						$gst_val .= "Installmet GST";
					}
					$ins_total=0;
					$ins_cgst=0;
					$ins_sgst=0;
					if($data_inst_amnt['cgst_tax'] > 0)
					{
						$gst_val .= "\n".$ins_cgst=intval($data_inst_amnt['cgst_tax']);
					}
					if($data_inst_amnt['sgst_tax'] > 0)
					{
						$gst_val .= ' + ';
						$gst_val .= $ins_sgst=intval($data_inst_amnt['sgst_tax']);
					}
					$gst_val .= ' =';
					$gst_val .= $ins_total=intval($ins_cgst + $ins_sgst);
					$total_ins_cgst +=$ins_cgst;
					$total_ins_sgst +=$ins_sgst;
					$total_ins +=$ins_total;
					//echo'</strong>';
					$gst_val .= "\n";
					$ins++;
				}
				
				/*"<br />".$select_installments = " SELECT * FROM invoice where enroll_id ='".$data_inst_amnt['enroll_id']."' and course_id='".$data_inst_amnt['course_id']."' and invoice_id !='".$data_inst_amnt['invoice_no']."' and amount > 0 ";
				$ptr_installment = mysql_query($select_installments);
				if(mysql_num_rows($ptr_installment))
				{
					echo "<br/><strong >Installment GST</strong></br>";
					while($data_installment = mysql_fetch_array($ptr_installment))
					{
						if($data_installment['cgst_tax'] >0 || $data_installment['sgst_tax'] >0)
						{
							$inst_cgst=0;
							$inst_sgst=0;
							if($data_installment['cgst_tax'] > 0)
							{
								echo $inst_cgst=$data_installment['cgst_tax'];
							}
							if($data_installment['sgst_tax'] > 0)
							{
								echo ' + ';
								echo $inst_sgst=$data_installment['sgst_tax'];
							}
							
							echo ' = <strong>';
							echo $inst_total=intval($inst_cgst + $inst_sgst);
							echo'</strong>';
							//echo $data_installment['amount'].'/- '.$datess.' : '.$data_paymode['payment_mode']."<br>";
							//$total_paid=$total_paid+$data_installment['amount'];
						}
					}
				}
				$gst_amount=intval($down_total+$inst_total);
				$total_gst +=$gst_amount;
				echo "<br/><br/><strong>Total GST- ".$gst_amount."<strong><br/>";
				if($total_inst = $total_inst-1 )
				echo '<hr />';*/
			}
			//echo '</td>';
		}
		else
		{
			//echo '<td align="center">--</td>';
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $gst_val);						
		  
		$sep=explode(" ",$data_name['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $date);	
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
		$objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$rowCount, $installment_data);		 */
		
		//$objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$rowCount, $val_course['course_price']);		
		/************************************item_description******************************************/	
		//$objPHPExcel->setActiveSheetIndex()->SetCellValue('H'.$rowCount, $val_query['down_payment']);	
		//$objPHPExcel->setActiveSheetIndex()->SetCellValue('I'.$rowCount, $val_query['balance_amt']);	
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
		$objPHPExcel->setActiveSheetIndex()->SetCellValue('J'.$rowCount, $xx);*/			
		 /************************************Item rate******************************************/
		//$objPHPExcel->setActiveSheetIndex()->SetCellValue('K'.$rowCount, $val_query['added_date']);	
		/************************************Plan Date******************************************/
		$k++;
		$rowCount++;
		$i++;
		
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount,'CGST- '.intval($total_down_cgst+$total_ins_cgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount,'SGST- '.intval($total_down_sgst+$total_ins_sgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount,'GST- '.intval($total_down+$total_ins));


$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Enroll_Incomming_GST_Report_With_GST_No.xls"');
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



