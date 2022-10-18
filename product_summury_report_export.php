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
							$pre_keyword_i =" and (i.total_price like '%".$keyword."%')";
						}                            
                        else
						{
                            $pre_keyword="";
							$pre_keyword_i ="";
						}
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and DATE(`installment_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							if($_REQUEST['to_date']=='')
							{
								$paid_from_date=" ";
								$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
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
							$paid_to_date=" and DATE(i.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
							$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$installment_to_date="";
							$paid_to_date=" ";
							$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d')."'";
						}
						$pay_type="";
						//and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
						if($_REQUEST['pay_type'] !='')
						{
							$pay_type=" and i.paid_type='".$_REQUEST['pay_type']."'";
						}
						$bank_ids="";
						if($_REQUEST['bank_id'] !='')
						{
							$bank_ids=" and i.bank_id='".$_REQUEST['bank_id']."'";
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
								$search_cm_id=" and i.cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
							}
						}
						else
						{
							$search_cm_id='';
							if($_SESSION['where']!='')
							{
								$search_cm_id=" and i.cm_id='".$_SESSION['cm_id']."'";
							}
						}
						
						if($_REQUEST['inq'])
						{
							$inquiry=$_REQUEST['inq'];
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
							$select_directory='order by DATE(i.added_date) asc';                     
					    
$sel_for_Num_rows="select i.*, e.* from sales_product_invoice i, sales_product e where 1 and i.sales_product_id=e.sales_product_id and i.payable_amount>0 ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." ";
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	if($no_of_rows=mysql_num_rows($my_querxy))
	{
		while($data_total=mysql_fetch_array($my_querxy))
		{
			$sel_inst_amnt_map="select * from sales_product_map where 1 and sales_product_id='".$data_total['sales_product_id']."'";
			$ptr_insmap_amnt=mysql_query($sel_inst_amnt_map);
			$total_map=mysql_num_rows($ptr_insmap_amnt);
			$total_row_cnt=$total_row_cnt+$total_map;
		}
	}
	$total_num=intval($no_of_rows)+ intval($total_row_cnt);
  	$no_of_rows = intval($total_num+6);
  	$no_of_rows_new = intval($no_of_rows+3);
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F2', $no_of_rows);
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

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:Q4");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A5:Q5");
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
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth("20");

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:I'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:J'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M1:M'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('N1:N'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('O1:O'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('P1:P'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('Q1:Q'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
	
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
	
	$objPHPExcel->getActiveSheet()->mergeCells('E4:K4');
	
	$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
	$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
	$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
	$objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
	$objPHPExcel->getActiveSheet()->mergeCells('K4:K5');
	$objPHPExcel->getActiveSheet()->mergeCells('L4:L5');
	$objPHPExcel->getActiveSheet()->mergeCells('M4:M5');
	$objPHPExcel->getActiveSheet()->mergeCells('N4:N5');
	$objPHPExcel->getActiveSheet()->mergeCells('O4:O5');
	$objPHPExcel->getActiveSheet()->mergeCells('P4:P5');
	$objPHPExcel->getActiveSheet()->mergeCells('Q4:Q5');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Receipt No','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Customer Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Product Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Payment Type','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M4', 'Bank Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N4', 'Bank Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O4', 'Discount','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P4', 'Deposit Amount','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q4', 'Date','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E5', 'Product Name' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F5', 'Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G5', 'Quantity','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H5', 'CGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I5', 'SGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J5', 'IGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K5', 'Total','6');
	
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
	$select_directory='order by DATE(i.added_date) asc';     
	                 
	$sql_query= "select i.*, e.* from sales_product_invoice i, sales_product e where 1 and i.sales_product_id=e.sales_product_id and i.payable_amount>0 ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." ";
		
	if($_GET['keyword']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
	}
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$sel_name="select name,cust_gst_no from enrollment where 1 and enroll_id='".$val_query['enroll_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$name=$data_name['name'];
		if($data_name['cust_gst_no'])
		$name .="\n GST no.: ".$data_name['cust_gst_no'];
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$sel_branch= " select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
		$ptr_branch= mysql_query($sel_branch);
		$data_branch = mysql_fetch_array($ptr_branch);
								
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['receipt_no']);
		$name='';
		if($val_query['type']=='Customer')
		{
			$sql_product = " select cust_name, cust_id from customer where cust_id='".$val_query['customer_id']."' ";
			$ptr_product = mysql_query($sql_product);
			$data_product = mysql_fetch_array($ptr_product);
			$name=$data_product['cust_name'];
		}
		else
		if($val_query['type']=='Employee')
		{
			$sql_product = " select name, admin_id from site_setting where admin_id='".$val_query['customer_id']."' ";
			$ptr_product = mysql_query($sql_product);
			$data_product = mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
		}
		else
		{
			$sql_product = " select name from enrollment where enroll_id='".$val_query['customer_id']."' ";
			$ptr_product = mysql_query($sql_product);
			$data_product = mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $name);
			
		
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
		$product_name ='';
		$total_inst=0;
		$sel_inst_amnt="select * from sales_product_map where 1 and sales_product_id='".$val_query['sales_product_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount=0;
			$ins=1;
			$rowcnt=$rowCount;
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				//echo "<tr>";
				$select_prod_name ="SELECT product_name FROM product where product_id ='".$data_inst_amnt['product_id']."' ";
				$ptr_prod_name= mysql_query($select_prod_name);
				//if($ins !=1)
				//$product_name .= "\n";
				$data_product_name=mysql_fetch_array($ptr_prod_name);
				$product_name = $data_product_name['product_name'];
				
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowcnt, $product_name);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowcnt, $data_inst_amnt['discounted_price']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowcnt, $data_inst_amnt['product_qty']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowcnt, $data_inst_amnt['cgst_tax']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowcnt, $data_inst_amnt['sgst_tax']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowcnt, $data_inst_amnt['igst_tax']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowcnt, $data_inst_amnt['sales_product_price']);
				
				$totals_pro_price +=intval($data_inst_amnt['discounted_price']);
				$totals_qty +=intval($data_inst_amnt['product_qty']);
				$totals_cgst +=intval($data_inst_amnt['cgst_tax']);
				$totals_sgst +=intval($data_inst_amnt['sgst_tax']);
				$totals_amnts +=intval($data_inst_amnt['sales_product_price']);
				
				//('.$data_inst_amnt['discounted_price'].' * '.$data_inst_amnt['product_qty'].' + '.$data_inst_amnt['cgst_tax'].' + '.$data_inst_amnt['sgst_tax'].' =  '.$data_inst_amnt['sales_product_price'].' )'
				//$rowCount++;
				if($ins!=$total_inst)
				{
					$rowcnt++;	
				}
				$ins++;
			}
		}

		
		
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $product_name);
			
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
		$sel_name="select payment_mode from payment_mode where 1 and payment_mode_id='".$val_query['paid_type']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$payment_mode=$data_name['payment_mode'];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, $payment_mode);
		
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
		$bank_deta='';
		if($val_query['paid_type']!=1)
		{
			$bank_deta= "Bank Name.- ".$data_bank['bank_name']."\n Acc. No.- ".$data_bank['account_no'];	
		}
		$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
		$ptr_bnk=mysql_query($sel_bnk);
		$data_bank=mysql_fetch_array($ptr_bnk);
				
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowCount, $bank_deta);

		if($val_query['bank_ref_no'] !='')
			$b_details="Ref No.- ".$val_query['bank_ref_no'];
		if($val_query['cheque_detail'] !='')
			$b_details1="Chaque No.- ".$val_query['cheque_detail'];
		if($val_query['chaque_date'] !='')
			$b_details2= "Chaque Date.- ".$val_query['chaque_date'];
		if($val_query['credit_card_no'] !='')
			$b_details3= "Credit Card No.- ".$val_query['credit_card_no'];
							
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N'.$rowCount, $b_details."\n".$b_details1."\n".$b_details2."\n".$b_details3);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O'.$rowCount, $val_query['discount_price']);		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P'.$rowCount, $val_query['payable_amount']);
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowCount, $date);	
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
		if($total_inst>1)
		{
			$totalmerge=intval($rowCount+$total_inst-1);
			//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
			$objPHPExcel->getActiveSheet()->mergeCells("A$rowCount:A$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("B$rowCount:B$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("C$rowCount:C$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("D$rowCount:D$totalmerge");
			
			
			$objPHPExcel->getActiveSheet()->mergeCells("L$rowCount:L$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("M$rowCount:M$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("N$rowCount:N$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("O$rowCount:O$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("P$rowCount:P$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("Q$rowCount:Q$totalmerge");
		}
		$rowCount=$rowcnt;
		
		$k++;
		$rowCount++;
		$i++;
		$totals_tds +=intval($val_query['payable_amount']);
	}
	$objPHPExcel->getActiveSheet()->mergeCells("A$rowCount:D$rowCount");
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount,intval($totals_pro_price));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount,intval($totals_qty));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount,intval($totals_cgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount,intval($totals_sgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount,intval($totals_amnts));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowCount,intval($totals_tds));


$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="product_summury_report.xls"');
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



