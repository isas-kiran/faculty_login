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


// Add some data
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

						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							
							$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date_i=" and DATE(i.installment_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							$paid_from_date_i=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							$paid_from_date_i="";
							if($_REQUEST['to_date']=='')
							{
								$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
								$paid_from_date_i=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'";
								
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
							
							$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
							$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
							
							$installment_to_date_i=" and DATE(i.installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
							$paid_to_date_i=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$installment_to_date="";
							$paid_to_date=" and DATE(added_date)<='".date('Y-m-d')."'";
							$paid_to_date_i=" and DATE(added_date)<='".date('Y-m-d')."'";
						}
						$search_cm_id='';
						$search_cm_id_i='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_i=" and cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
								$search_cm_id_i="";
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
                       		$select_directory='order by sales_product_id desc'; 
							$where_cm='';
							if($_SESSION['where']!='')
							{
								$where_cm=" and cm_id='".$_SESSION['cm_id']."'";
							}                  
  	$sel_for_Num_rows="SELECT * FROM sales_product WHERE 1  ".$where_cm." ".$search_cm_id_i." ".$pre_keyword." ".$select_directory."  ";
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



$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:F4");

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
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);




//======================== Merge cells	======================

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 


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
 
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Product Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Total Paid','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Total Paid in month','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Remaining','6');


	$select_directory='order by sales_product_id desc';                      
	$sql_query= "SELECT * FROM sales_product WHERE 1  ".$where_cm." ".$search_cm_id_i." ".$pre_keyword." ".$select_directory."  "; 
		
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
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		if($val_query['type']=='Student')
								{
								$sql_cust = "select name from enrollment where 1 ".$_SESSION['where']." AND enroll_id=".$val_query['customer_id']." order by enroll_id asc";
								$ptr_prod= mysql_query($sql_cust);
								$ptr_cust =mysql_fetch_array($ptr_prod);
								$name=$ptr_cust['name'];
								}
								else
								{
								 $sql_cust = "select cust_name from customer where 1 ".$_SESSION['where']." AND cust_id=".$val_query['customer_id']." order by cust_id asc";
								$ptr_prod= mysql_query($sql_cust);
								$ptr_cust =mysql_fetch_array($ptr_prod);
								$name=$ptr_cust['cust_name'];
								}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $name);
		
								
				$sel_inst_amnt="select sales_product_id,product_id from sales_product_map where sales_product_id='".$val_query['sales_product_id']."'";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount=0;
			$ins=1;
			$product_name='';
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				//echo "<tr>";
				$select_prod_name =" select product_name from product where product_id='".$data_inst_amnt['product_id']."'";
				$ptr_prod_name= mysql_query($select_prod_name);
				if($ins !=1)
					$product_name .= "\n";
				$data_product_name =mysql_fetch_array($ptr_prod_name);
				$product_name .= $data_product_name['product_name'];
				$ins++;
			}
		}				
								
								
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $product_name);		
		
		
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['payable_amount']);
			$sel_inst_amnt="select * from sales_product_invoice where 1 and  sales_product_id='".$val_query['sales_product_id']."' ".$paid_from_date." ".$paid_to_date."";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		$total_paid_data='';
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$amount1='';
			
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				$select_installments = "select payment_mode from payment_mode where payment_mode_id='".$data_inst_amnt['paid_type']."'";
				$ptr_installment = mysql_query($select_installments);
				$data_paymode=mysql_fetch_array($ptr_installment);
				$dt1=strtotime($data_inst_amnt['added_date']);
				$datess1=date("Y-m-d", $dt1);
				$amount1 +=$data_inst_amnt['payable_amount'];
				$all=$data_inst_amnt['payable_amount'].'/- '.$datess1.' : '.$data_paymode['payment_mode'];
				 $total_paid_data .=$all."Total Paid- ".$amount1;
				 if($total_inst = $total_inst-1 )
				 {
					$total_paid_data .="\n";
					$total_paid_data .= '--------------------------------';
					$total_paid_data .="\n";
				 }
			}
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $total_paid_data);
		
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['remaining_amount']);						
		  
			
		
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_course['course_price']);		
		/************************************item_description******************************************/	
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['down_payment']);	
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_query['balance_amt']);	
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
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $xx);*/			
		 /************************************Item rate******************************************/
		//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_query['added_date']);	
		/************************************Plan Date******************************************/
		$k++;
		$rowCount++;
		$i++;
		$total_paid +=$val_query['payable_amount'];
		$total_paid1 +=$amount1;
		$remain +=$val_query['remaining_amount'];
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $total_paid);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $total_paid1);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $remain);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="outstand.xls"');
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


