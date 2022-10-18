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
		$pre_keyword_i =" and (e.total_price like '%".$keyword."%')";
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
		$paid_from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
		$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date=""; 
		if($_REQUEST['to_date']=='')
		{
			$paid_from_date=" ";
			$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
			$paid_from_date=" and DATE(e.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
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
		$paid_to_date=" and DATE(e.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
		$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		$pre_to_date="";
		$installment_to_date="";
		$paid_to_date=" ";
		$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d')."'";
		$paid_to_date=" and DATE(e.added_date)<='".date('Y-m-d')."'";
	}
	$pay_type=""; //and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
	if($_REQUEST['pay_type'] !='')
	{
		$pay_type=" and e.paid_type='".$_REQUEST['pay_type']."'";
	}
	$bank_ids="";
	if($_REQUEST['bank_id'] !='')
	{
		$bank_ids=" and e.bank_id='".$_REQUEST['bank_id']."'";
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
			$search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
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
			$search_cm_id=" and e.cm_id='".$_SESSION['cm_id']."'";
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
		$select_directory='order by e.customer_service_id asc'; 
	
	$sel_for_Num_rows="select i.customer_service_id,e.added_date,i.receipt_no,e.gst_type,e.cgst_tax_in_percent,e.sgst_tax_in_percent,e.igst_tax_in_percent,e.cgst_tax,e.sgst_tax,e.igst_tax,e.excluded_tax,e.payable_amount,e.bank_id,e.service_price,e.customer_id,e.ext_invoice_no,e.type,e.nonmemb_discount,e.amount,e.nonmemb_discount_type from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; //                     
	//$sel_for_Num_rows="select i.invoice_id,i.added_date,i.receipt_no,i.gst_type,i.cgst_tax_in_percent,i.sgst_tax_in_percent,i.igst_tax_in_percent,i.cgst_tax,i.sgst_tax,i.igst_tax,i.excluded_tax_amount,i.payable_amount,i.bank_id,i.service_price, e.customer_id,e.ext_invoice_no,e.type,e.nonmemb_discount from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory.""; //15-4-20
	//and amount>0
	$my_querxy=mysql_query($sel_for_Num_rows);
	$no_of_rows=mysql_num_rows($my_querxy);
	$no_of_rows = (intval($no_of_rows*4)+1);
	$no_of_rows_new = (intval($no_of_rows*4)+1);

//================Apply styles============================
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A2:A$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B2:B$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C2:C$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D2:D$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "E2:E$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "F2:F$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "G2:G$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "H2:H$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "I2:I$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "J2:J$no_of_rows");
//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K2:K$no_of_rows");
//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L2:L$no_of_rows");
/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K5:K$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L5:L$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "M5:M$no_of_rows");*/


//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:K4");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:J1");
//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A2:K2");
//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A3:K3");
/*$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:K2');*/
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
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth("12");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("12");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth("12");
/*$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth("25");*/


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
//$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
//$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 

/*$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M1:M'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); */

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

	
	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');*/
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Date','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Vochure No','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Vochure Type','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Sub-Vochure Type','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Enroll ID','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Invoice No','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'Student Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'Account','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'Product','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'Quantity','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'Rate','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I1', 'Disc. Rate','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J1', 'Amount','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L1', 'Cost Center','6');
	
	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Net Fee','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'CGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'SGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Payment Type','6');*/
	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Chaque','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Credit Card','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Online','6');*/
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Payment Details','6');
	
	$total_down_cgst=0;
	$total_down_sgst=0;
	$total_down=0;
	$total_ins_cgst=0;
	$total_ins_sgst=0;
	$$total_amnt=0;
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and e.cm_id='".$_SESSION['cm_id']."'";
	}
	$branch_id='';
	
	$select_directory='order by e.customer_service_id asc';
	
	 $sql_query="select i.customer_service_id,e.added_date,i.receipt_no,e.gst_type,e.cgst_tax_in_percent,e.sgst_tax_in_percent,e.igst_tax_in_percent,e.cgst_tax,e.sgst_tax,e.igst_tax,e.excluded_tax,e.payable_amount,e.bank_id,e.service_price,e.customer_id,e.ext_invoice_no,e.type,e.nonmemb_discount,e.amount,e.nonmemb_discount_type,e.apply_gst,e.nonmemb_discount_price from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; //                       
	//$sql_query="select i.invoice_id,i.added_date,i.receipt_no,i.gst_type,i.cgst_tax_in_percent,i.sgst_tax_in_percent,i.igst_tax_in_percent,i.cgst_tax,i.sgst_tax,i.igst_tax,i.excluded_tax_amount,i.payable_amount,i.bank_id,i.service_price, e.customer_id,e.ext_invoice_no,e.type,e.nonmemb_discount,e.amount,e.nonmemb_discount_type from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory.""; 
	//and amount>0
	
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B3', $sql_query);
	$month= strtoupper(date("F", strtotime($curr_date)));
	$year= strtoupper(date("Y", strtotime($curr_date)));
	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', strtoupper($_REQUEST['branch_name']));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A2', 'SALES REPORT '.$month.' '.$year.' ');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C3', 'Search by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D3', $start_date);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E3', $end_date);*/	
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{		
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);		
		$newRowCount=intval($rowCount+3);
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'Sales');		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'Service');
		$cust_id='';
		if($val_query['type']=='Student')
		{
			$sql_product="select name,contact,enroll_id from enrollment where enroll_id='".$val_query['customer_id']."' ";
			$ptr_product=mysql_query($sql_product);
			$data_product=mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
			$cust_id=$data_product['enroll_id'];
		}
		else if($val_query['type']=='Employee')
		{
			$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$val_query['customer_id']."' ";
			$ptr_product=mysql_query($sql_product);
			$data_product=mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
			$mobile=$data_product['contact_phone'];
			$cust_id=$data_product['admin_id'];
		}
		else
		{
			$sql_product="select cust_name,cust_id,mobile1 from customer where cust_id='".$val_query['customer_id']."' ";
			$ptr_product=mysql_query($sql_product);
			$data_product=mysql_fetch_array($ptr_product);
			$name=$data_product['cust_name'];
			$mobile=$data_product['mobile1'];
			$cust_id=$data_product['cust_id'];
		}
		$cust_name=$name;
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $cust_name.' - '.$cust_id);		
		
		if(trim($val_query['gst_type'])=="m_gst" && $val_query['apply_gst']!='no')
		{
			$gst_val='CGST '.$val_query['cgst_tax_in_percent'].' % &nbsp;&nbsp;&nbsp; SGST '.$val_query['sgst_tax_in_percent'].'%';
			$gst_tot=$val_query['cgst_tax_in_percent'] + $val_query['sgst_tax_in_percent'];
		}
		else if(trim($val_query['gst_type'])=="m_igst" && $val_query['apply_gst']!='no')
		{
			$gst_val='IGST '.$val_query['igst_tax_in_percent'].' %';
			$gst_tot=$val_query['igst_tax_in_percent'];
		}
		else
		{
			$gst_val='0';
			$gst_tot='0';
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Sales @ '.$gst_tot.'%');
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, 'Item');	
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '1');	
		if($val_query['nonmemb_discount']>=100 && $val_query['nonmemb_discount_type']=='percentage')
		{
			$disc = '100';
			$rate=number_format($val_query['service_price'],3,'.','');
			$price=number_format($val_query['excluded_tax'],3,'.','');
		}else if($val_query['apply_gst']!='no')
		{
			$disc = '0';
			//$rate=round($val_query['excluded_tax']);
			$rate = number_format($val_query['nonmemb_discount_price'] * 100/(100 + $gst_tot),3,'.','');
			//$price=round($val_query['excluded_tax']);
			$price = number_format($val_query['nonmemb_discount_price'] * 100/(100 + $gst_tot),3,'.','');
		}
		else
		{
			$disc = '0';
			$rate=number_format($val_query['nonmemb_discount_price'],3,'.','');
			$price=number_format($val_query['nonmemb_discount_price'],3,'.','');
		}
		//$total_net +=$val_query['amount'];
		//$total_val =intval($val_query['amount']-$val_query['cgst_tax']-$val_query['sgst_tax']-$val_query['igst_tax']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $rate);	
		//$total_cgst += $val_query['cgst_tax'];
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_query['cgst_tax']);
		//$total_sgst +=$val_query['sgst_tax'];
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_query['sgst_tax']);	
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $disc);	
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $price);
		
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, intval($val_query['amount']+$val_query['cgst_tax']+$val_query['sgst_tax']));		
		/*$sel_name="select payment_mode from payment_mode where 1 and payment_mode_id='".$val_query['paid_type']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $data_name['payment_mode']);*/
		//$total_amnt =intval($val_query['amount']+$val_query['cgst_tax']+$val_query['sgst_tax']);
		
		//===================COST CENTER===============================
		/*$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
		$ptr_bnk=mysql_query($sel_bnk);
		$data_bank=mysql_fetch_array($ptr_bnk);
		
		if($val_query['paid_type']!=1)
		{
			//echo "Acc. No.- ".$data_bank['account_no'];
			if($data_bank['account_no'])
			{
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Acc. No.- ".$data_bank['account_no']);
			}
			//echo "Bank Name- ".$data_bank['bank_name']."<br/>Acc. No.- ".$data_bank['account_no'];
		}*/
		
		
		/*$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
		$ptr_bnk=mysql_query($sel_bnk);
		$data_bank=mysql_fetch_array($ptr_bnk);
		
		//=============================================================================
		if($val_query['paid_type']=='1')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, '');
		}
		else if($val_query['paid_type']=='2')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Acc. No.- ".$data_bank['account_no']);
			//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Bank Name- ".$data_bank['bank_name']."\nAcc. No.- ".$data_bank['account_no']."\nChEque No.- ".$val_query['cheque_detail']."\nCheque Date.- ".$val_query['chaque_date']);
		}
		else if($val_query['paid_type']=='4')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Acc. No.- ".$data_bank['account_no']);
			//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Bank Name- ".$data_bank['bank_name']."\nAcc. No.- ".$data_bank['account_no']."\nCredit Card No.- ".$val_query['credit_card_no']);
		}
		else if($val_query['paid_type']=='5')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Acc. No.- ".$data_bank['account_no']);
			//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, "Bank Name- ".$data_bank['bank_name']."\nAcc. No.- ".$data_bank['account_no']."\nRef No.- ".$val_query['bank_ref_no']);
		}
		else
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, '-');
		}*/
		//$objPHPExcel->setActiveSheetIndex()->mergeCells('K'.$rowCount.':K'.$newRowCount);
		/************************************Item rate******************************************/
		//$objPHPExcel->setActiveSheetIndex()->SetCellValue('K'.$rowCount, $val_query['added_date']);	
		/************************************Plan Date******************************************/
		$k++;
		$rowCount++;
		$GST_Amount=0;
		$IGST_Amount=0;
		if(trim($val_query['gst_type'])=="m_gst" && $val_query['apply_gst']!='no')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Output CGST '.$val_query['cgst_tax_in_percent'].'%');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '');	
			$gst_total=$val_query['cgst_tax_in_percent']+$val_query['sgst_tax_in_percent'];
			$GST_Amount = $val_query['amount'] * $gst_total /(100 + $gst_total);
			$gst_amnts=$GST_Amount/2;
			
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, number_format($gst_amnts,3,'.',''));	
			$rowCount++;
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Output SGST '.$val_query['sgst_tax_in_percent'].'%');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, number_format($gst_amnts,3,'.',''));	
			$rowCount++;
		}
		else if(trim($val_query['gst_type'])=="m_igst" && $val_query['apply_gst']!='no')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Output IGST '.$val_query['igst_tax_in_percent'].'%');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '');	
			$IGST_Amount = $price * $val_query['igst_tax_in_percent'] /(100 + $val_query['igst_tax_in_percent']);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, number_format($IGST_Amount,3,'.',''));	
			$rowCount++;
		}
		else if($val_query['apply_gst']!='no')
		{
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '');	
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, '');	
			$rowCount++;
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $date);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['ext_invoice_no']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Total ');	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, '');	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '');	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, '');	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '');	
		$total_amount=$price+$GST_Amount+$IGST_Amount;
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, number_format($total_amount,3,'.',''));	
		$rowCount++;
		//$i++;
		//$totals_tds +=intval($val_query['amount']);
	}
	
	/*$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $total_net);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $total_cgst);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $total_sgst);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $total_amnt);*/
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount,intval($totals_tds));
	$objPHPExcel->getActiveSheet()->setTitle('Simple');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Service Tally Report '.date("d-m-Y").'.xls"');
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