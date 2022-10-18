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
	
	$from_date="";
						$to_date="";
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_dates=explode("/",$_REQUEST['to_date']);
							$to_date=$to_dates[2]."-".$to_dates[1]."-".$to_dates[0];
							
							$to_date=" and added_date<='".date('Y-m-d',strtotime($to_date))."'";
						}
						
						$where_cm_id_data="";
						if($_REQUEST['branch_id'])
						{						
							$cm_id='';
							$selected_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_id']."' and type='A' ";
							$ptr_selected=mysql_query($selected_branch);
							if(mysql_num_rows($ptr_selected))
							{
								$data_cm_id=mysql_fetch_array($ptr_selected);
								$cm_id= $data_cm_id['cm_id'];
							}
							
							$where_cm_id_data=" and cm_id = '".$cm_id."'";
						}
						
						
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
						{
							$pay_mode_filter='';
							$sel_pay_id="select payment_mode_id from payment_mode where payment_mode like '%".$keyword."%' "; 
							$ptr_pay_id=mysql_query($sel_pay_id);    
							if(mysql_num_rows($ptr_pay_id)) 
							{
								$data_pay_id=mysql_fetch_array($ptr_pay_id);
								$pay_mode_filter="|| payment_mode_id = '".$data_pay_id['payment_mode_id']."'";
							} 
							
							$expense_type_filter='';
							$sel_exp_id="select expense_type_id from expense_type where expense_type like '%".$keyword."%' "; 
							$ptr_exp_id=mysql_query($sel_exp_id);    
							if(mysql_num_rows($ptr_exp_id)) 
							{
								$data_exp_id=mysql_fetch_array($ptr_exp_id);
								$expense_type_filter="|| expense_type_id = '".$data_exp_id['expense_type_id']."'";
							}  
							 
							$bank_name_filter='';
							$select_bank = " select bank_id from bank where bank_name like '%".$keyword."%' ";
							$ptr_bank = mysql_query($select_bank);
							if($total=mysql_num_rows($ptr_bank))
							{
								while($data_bank_name = mysql_fetch_array($ptr_bank))
								{
									$bank_name_filter.= " || bank_id =".$data_bank_name['bank_id'];
								}
							}
							
							$added_by='';
							$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
							$ptr_enq=mysql_query($sel_enq);
							if(mysql_num_rows($ptr_enq))
							{
								$data_enq=mysql_fetch_array($ptr_enq);
								$added_by="|| employee_id = '".$data_enq['admin_id']."'";
							}
							
							$vendor_name_filter='';
							$sel_vendor="select vendor_id from vendor where name like '%".$keyword."%'";
							$ptr_vendor=mysql_query($sel_vendor);
							if(mysql_num_rows($ptr_vendor))
							{
								while($data_vendor=mysql_fetch_array($ptr_vendor))
								{
									"<br/>".$vendor_name_filter .="|| vendor_id = '".$data_vendor['vendor_id']."'";
								}
							}
							
							$pre_keyword =" and ( added_Date like '%".$keyword."%' ".$pay_mode_filter." ".$cm_id_filter." ".$expense_type_filter." ".$bank_name_filter." ".$added_by." ".$vendor_name_filter." || chaque_no like '%".$keyword."%' || chaque_date like '%".$keyword."%'  || credit_card_no like '%".$keyword."%' || amount like '%".$keyword."%' || description like '%".$keyword."%' ".$added_by.")";
							 
							 
						}
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

                        if($_GET['orderby']=='amount' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='expense_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by expense_id desc';  
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and expense_id='".$_GET['record_id']."' ";
							
						}    

						
  	$sel_for_Num_rows="SELECT * FROM expense where 1 ".$record_cat_id." ".$where_expense." ".$_SESSION['where']." ".$where_cm_id_data." ".$pre_keyword." ".$from_date." ".$to_date." ".$select_directory.""; 
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


$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:J4");
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
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Expense Type','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Payment Mode','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Bank Details','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('F4', ' Amount','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Description','6');
	
	$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Vendor','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Employee','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Added _date','6');
	
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
	//$select_directory='order by DATE(i.added_date) desc';                      
	$sql_query= "SELECT * FROM expense where 1 ".$record_cat_id." ".$where_expense." ".$_SESSION['where']." ".$where_cm_id_data." ".$pre_keyword." ".$from_date." ".$to_date." ".$select_directory.""; 
		
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
		$sel_branch= " select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
								$ptr_branch= mysql_query($sel_branch);
								$data_branch = mysql_fetch_array($ptr_branch);
								
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		
		
		$sel_expense_type="select expense_type from expense_type where expense_type_id='".$val_query['expense_type_id']."'";
								$ptr_expense_type=mysql_query($sel_expense_type);
								$data_expense_type=mysql_fetch_array($ptr_expense_type);
		
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $data_expense_type['expense_type']);			
		
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
		$sel_name="select payment_mode from payment_mode where payment_mode_id='".$val_query['payment_mode_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$payment_mode=$data_name['payment_mode'];
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $payment_mode);
		
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
		$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
								$ptr_bnk=mysql_query($sel_bnk);
								$data_bank=mysql_fetch_array($ptr_bnk);
								
									if($val_query['bank_ref_no'] !='')
									$b_details="Ref No.- ".$val_query['bank_ref_no'];
									
								if($val_query['cheque_detail'] !='')
									$b_details1="Chaque No.- ".$val_query['cheque_detail'];
								
								if($val_query['chaque_date'] !='')
									$b_details2= "Chaque Date.- ".$val_query['chaque_date'];
									
								if($val_query['credit_card_no'] !='')
									$b_details3= "Credit Card No.- ".$val_query['credit_card_no'];
								
		  
		  $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $data_bank['bank_name']."\n".$b_details1."\n".$b_details2."\n".$b_details3);
		  
		  
		  $val='Amount(w/o tax) -'.$val_query['amount_wo_tax'];
								if($val_query['discount_type']=="rupees")
									$dis_type=" Rs/-";
								else if($val_query['discount_type']=="percentage")
									$dis_type=" %";
								$val1='Discount ('.$val_query['discount'].''.$dis_type.') -'.round($val_query['discount_price']);
								$val2='Discounted price -'.round($val_query['total_price']);
								$sele_tax="select tax_type,tax_value,tax_amount from expense_tax_map where expense_id ='".$val_query['expense_id']."'";
								$ptr_tax=mysql_query($sele_tax);
								if(mysql_num_rows($ptr_tax))
								{
									while($data_tax=mysql_fetch_array($ptr_tax))
									{
									$val3=$data_tax['tax_type'].'('.$data_tax['tax_value'].'%) -'.round($data_tax['tax_amount']);
									}
								
									
								}
								$val4='Total Amount -'.round($val_query['amount']);
		  $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $val."\n".$val1."\n".$val2."\n".$val3."\n".$val4);	

	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $val_query['description']);
	
	$sel_vendor="select name from vendor where vendor_id='".$val_query['vendor_id']."'";
								$ptr_vendor=mysql_query($sel_vendor);
								$data_vendor=mysql_fetch_array($ptr_vendor);
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data_vendor['name']);
	$sel_emp="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_emp=mysql_query($sel_emp);
								$data_emp=mysql_fetch_array($ptr_emp);
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $data_emp['name']);	
		  
		$sep=explode(" ",$val_query['added_Date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $date);	
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
header('Content-Disposition: attachment;filename="expense_excel.xls"');
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



