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
			$search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
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
			$where_gst =' and e.cust_gst_no !=""';
			$where_gst_i =' and e.cust_gst_no !=""';
		}
		else if($gst_keyword=="without_gst")
		{
			$where_gst =' and e.cust_gst_no=""';
			$where_gst_i =' and (e.cust_gst_no="" or e.cust_gst_no is null)';
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
		$paid_from_date_i=" and DATE(s.added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date=""; 
		if($_REQUEST['to_date']=='')
		{
			$paid_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime('-30 days'))."'";
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
		$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
		$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		$pre_to_date="";
		$installment_to_date="";
		$paid_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
		$paid_to_date_i=" and DATE(s.added_date)<='".date('Y-m-d')."'";
	}
	if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
	$select_directory='order by s.customer_service_id desc';                     
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and s.cm_id='".$_SESSION['cm_id']."'";
	}
        
  	$sel_for_Num_rows="SELECT s.* FROM customer_service s,customer e WHERE 1 and s.customer_id=e.cust_id ".$where_cm." ".$search_cm_id." ".$where_gst_i." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (s.cgst_tax_in_percent >0 or s.sgst_tax_in_percent >0) and (s.cgst_tax >0 or s.sgst_tax >0) ".$select_directory." ";
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


$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:H4");
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


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 


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
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Customer Name','6');
 
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Product Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Product Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'GST in %','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'GST Value','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Total GST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Date','6');
	
	$total_down_cgst=0;
	$total_down_sgst=0;
	$total_down=0;
	$total_ins_cgst=0;
	$total_ins_sgst=0;
	$total_ins=0;
	
	$select_directory='order by customer_service_id desc';                     
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and s.cm_id='".$_SESSION['cm_id']."'";
	}                     
	$sql_query= "SELECT s.* FROM customer_service s,customer e WHERE 1 and s.customer_id=e.cust_id ".$where_cm." ".$search_cm_id." ".$where_gst_i." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (s.cgst_tax_in_percent >0 or s.sgst_tax_in_percent >0) and (s.cgst_tax >0 or s.sgst_tax >0) ".$select_directory." "; 
		
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
		$sel_name="select cust_name,cust_gst_no from customer where cust_id='".$val_query['customer_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$name=$data_name['cust_name'];
		if($data_name['cust_gst_no'])
		$name .="\n GST no.: ".$data_name['cust_gst_no'];
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $name);
		$course_data='';
		
		$totals_products_gst=0;
		$product_price='';
		$product_name='';
		$gst_per='';
		$gst_val='';
		
		"<br/>".$sel_inst_amnt="select service_id from customer_service_map where 1 and customer_service_id='".$val_query['customer_service_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$s=1;
			$service_name='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_prod_name =" SELECT service_name FROM servies where service_id ='".$data_inst_amnt['service_id']."' ";
				$ptr_prod_name= mysql_query($select_prod_name);
				$data_product_name =mysql_fetch_array($ptr_prod_name);
				$service_name .=$s.". ".$data_product_name['service_name']."\n";
				$s++;
			}
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $service_name);
		}
		$gst_per='';
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['discount_price']);
		if($val_query['cgst_tax_in_percent'])
		{
			$gst_per .= "CGST (".$val_query['cgst_tax_in_percent']."%)";
		}
		if($val_query['sgst_tax_in_percent'])
		{
			$gst_per .= " + SGST (".$val_query['sgst_tax_in_percent']."%)";
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $gst_per);
		
		$gst_val='';
		if($val_query['cgst_tax_in_percent'])
		{
			$gst_val .= $val_query['cgst_tax'];
			$total_cgst +=$val_query['cgst_tax'];
		}
		if($val_query['sgst_tax_in_percent'])
		{
			$gst_val .= " + ".$val_query['sgst_tax'];
			$total_sgst +=$val_query['sgst_tax'];
		}
		
		if($val_query['cgst_tax_in_percent'] || $val_query['sgst_tax_in_percent'])
		{
			$gst_val .= " = ";
			$gst_val .= $total_prod_gst =$val_query['cgst_tax']+$val_query['sgst_tax'];
			$totals_gst +=$total_prod_gst;
			
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $gst_val);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $total_prod_gst);
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $date);
		
		
		$k++;
		$rowCount++;
		$i++;
		
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount,'CGST- '.intval($total_cgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount,'SGST- '.intval($total_sgst));
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount,'GST- '.intval($totals_gst));


$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client?s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="service_incoming_gst.xls"');
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



