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
			$paid_from_date=" and DATE(i.added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
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
		$paid_to_date=" and DATE(i.added_date)<='".date('Y-m-d')."'";
	}
	$pay_type=""; //and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
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
		$select_directory='order by DATE(i.added_date) asc,order by DATE(i.ext_invoice_no) asc';                  
	                   
	$sel_for_Num_rows="select i.*,e.invoice_id from inventory_invoice e, inventory i where 1 and i.inventory_id=e.inventory_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." group by inventory_id ".$select_directory." ";
	//$sel_for_Num_rows="select i.*,e.* from inventory_invoice i, inventory e where 1 and i.inventory_id=e.inventory_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." ";
	//and amount>0
	$my_querxy=mysql_query($sel_for_Num_rows);
	$no_of_rows=mysql_num_rows($my_querxy);	
	//$no_of_rows = (intval($no_of_rows*4)+1);
	//$no_of_rows_new = (intval($no_of_rows*4)+1);

//================Apply styles============================

//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L5:L$no_of_rows");
/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K5:K$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L5:L$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "M5:M$no_of_rows");*/


//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:K4");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:F1");
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

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth("40");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("12");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth("30");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("12");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth("12");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth("12");
//$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth("12");
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
/*$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:I'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:J'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); */

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
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Address','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Country','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'State','6');
	//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Invoice No','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'Registration Type','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'GSTIN/UIN','6');
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
		$where_cm=" and i.cm_id='".$_SESSION['cm_id']."'";
	}
	
	$select_directory='order by i.added_date asc';
	$sql_query="select i.*,e.invoice_id from inventory_invoice e, inventory i where 1 and i.inventory_id=e.inventory_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." group by i.vendor_id ".$select_directory."";
	//$sql_query= "select i.*,e.* from inventory_invoice i, inventory e where 1 and i.inventory_id=e.inventory_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; 
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
	$i=2;
	$rowCount=2;
	$k=1;
	
	while($val_query=mysql_fetch_array($query_order))
	{
		$total_amnts=0;
		$total_price=$val_query['total_cost'];
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		/*$sel_branch= " select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
		$ptr_branch= mysql_query($sel_branch);
		$data_branch = mysql_fetch_array($ptr_branch);*/
							
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);		
		//$newRowCount=intval($rowCount+3);
		/*$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		*/
		
		$sel_name="select name,vendor_id,address,gst_no from vendor where vendor_id='".$val_query['vendor_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		$cust_name=$data_name['name'];
		$cust_id=$data_name['vendor_id'];
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $cust_name.' - '.$cust_id);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_name['address']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'India');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, '');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, 'Regular');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $data_name['gst_no']);
		
		$k++;
		$rowCount++;
		$i=$rowCount;
		$i++;
		//$totals_tds +=intval($val_query['amount']);
	}
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A2:A$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "B2:B$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "C2:C$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "D2:D$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "E2:E$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "F2:F$i");
/*	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "G2:G$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "H2:H$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "I2:I$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "J2:J$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K2:K$i");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L2:L$i");*/

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
	header('Content-Disposition: attachment;filename="Purchase Name Tally Report.xls"');
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