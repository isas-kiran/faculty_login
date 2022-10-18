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
		$pre_keyword_i =" and (i.total_cost like '%".$keyword."%')";
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
	$pay_type="";//and (i.paid_type='2' or i.paid_type='4' or i.paid_type='5')
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
							                  
							    
  	$sel_for_Num_rows="select i.*, e.* from customer_service_invoice i, customer_service e where 1 and i.customer_service_id = e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".		$select_directory." "; 
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	if($no_of_rows=mysql_num_rows($my_querxy))
	{
		while($data_total=mysql_fetch_array($my_querxy))
		{
			$sel_prod="select * from customer_service_map where 1 and customer_service_id='".$val_query['customer_service_id']."'";
			$ptr_insmap_amnt=mysql_query($sel_prod);
			$total_map=mysql_num_rows($ptr_insmap_amnt);
			$total_row_cnt=$total_row_cnt+$total_map;
		}
	}
	$total_num=intval($no_of_rows)+ intval($total_row_cnt);
  	$no_of_rows = intval($total_num+6);
  	$no_of_rows_new = intval($no_of_rows+3);
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F2', $no_of_rows);

	//=======================================Apply styles===========================================
	
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
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "R5:R$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "S5:S$no_of_rows");

	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:S4");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A5:S5");
	//============================================= Set column widths===============================
	/*$objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex()->getColumnDimension('F')->setAutoSize(true); */

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth("10");

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("8");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth("8");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth("8");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth("10");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setWidth("12");


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
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M1:M'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('N1:N'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('O1:O'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('P1:P'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('Q1:Q'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('R1:R'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('S1:S'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true);
	
//======================== Merge cells	======================
//$objPHPExcel->setActiveSheetIndex()->mergeCells('A7:B7');
//$objPHPExcel->setActiveSheetIndex()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->setActiveSheetIndex()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//======================== Add some data======================
//echo "<br />".date('H:i:s') . "\t Add some data\n";
	$objPHPExcel->setActiveSheetIndex(0);

	$objPHPExcel->getActiveSheet()->mergeCells('E4:I4');
	
	$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
	$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
	$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
	$objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
	$objPHPExcel->getActiveSheet()->mergeCells('J4:J5');
	$objPHPExcel->getActiveSheet()->mergeCells('K4:K5');
	$objPHPExcel->getActiveSheet()->mergeCells('L4:L5');
	$objPHPExcel->getActiveSheet()->mergeCells('M4:M5');
	$objPHPExcel->getActiveSheet()->mergeCells('N4:N5');
	$objPHPExcel->getActiveSheet()->mergeCells('O4:O5');
	$objPHPExcel->getActiveSheet()->mergeCells('P4:P5');
	$objPHPExcel->getActiveSheet()->mergeCells('Q4:Q5');
	$objPHPExcel->getActiveSheet()->mergeCells('R4:R5');
	$objPHPExcel->getActiveSheet()->mergeCells('S4:S5');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Receipt No','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Customer Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Service Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Service Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'CGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'SGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M4', 'IGST','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N4', 'Discounted Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O4', 'Total Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P4', 'Payment Type','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q4', 'Bank Name','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('R4', 'Bank Details','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('S4', 'Date','6');
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E5', 'Service Name' ,'6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F5', 'Quantity','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G5', 'Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H5', 'Discounted Price','6');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I5', 'Total Price','6');
	
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
	
	$select_directory='order by DATE(i.added_date) asc';                      
	$sql_query= "select i.*, e.* from customer_service_invoice i, customer_service e where 1 and i.customer_service_id=e.customer_service_id ".$search_cm_id." ".$pre_keyword_i." ".$pay_type." ".$bank_ids." ".$paid_from_date." ".$paid_to_date." ".$select_directory." "; 
		
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
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$sel_branch= " select branch_name from site_setting where cm_id='".$val_query['cm_id']."'";
		$ptr_branch= mysql_query($sel_branch);
		$data_branch = mysql_fetch_array($ptr_branch);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);
		$course_data='';
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['receipt_no']);
		
		if($val_query['type']=='Student')
		{
			$sql_product = "select name,contact from enrollment where enroll_id='".$val_query['customer_id']."' ";
			$ptr_product = mysql_query($sql_product);
			$data_product = mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
			$mobile=$data_product['contact'];
		}
		else if($val_query['type']=='Employee')
		{
			$sql_product="select name, admin_id,contact_phone from site_setting where admin_id='".$val_query['customer_id']."' ";
			$ptr_product=mysql_query($sql_product);
			$data_product=mysql_fetch_array($ptr_product);
			$name=$data_product['name'];
			$mobile=$data_product['contact_phone'];
		}
		else 
		{
			$sql_product="select cust_name,cust_id,mobile1 from customer where cust_id='".$val_query['customer_id']."' ";
			$ptr_product=mysql_query($sql_product);
			$data_product=mysql_fetch_array($ptr_product);
			$name=$data_product['cust_name'];
			$mobile=$data_product['mobile1'];
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $name);		
		
		$product_name ='';
		$total_inst=0;
		$sel_inst_amnt="select * from customer_service_map where 1 and customer_service_id='".$val_query['customer_service_id']."' ";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			$ins=1;
			$amount=0;
			$ins=1;
			$rowcnt=$rowCount;
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				//echo "<tr>";
				$select_prod_name =" SELECT service_name FROM servies where service_id ='".$data_inst_amnt['service_id']."' ";
				$ptr_prod_name= mysql_query($select_prod_name);
				$data_product_name =mysql_fetch_array($ptr_prod_name);
				
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowcnt, $data_product_name['service_name']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowcnt, $data_inst_amnt['service_quantity']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowcnt, $data_inst_amnt['service_price']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowcnt, $data_inst_amnt['discount_price']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowcnt, $data_inst_amnt['total_price']);
				
				$totals_qty +=intval($data_inst_amnt['service_quantity']);
				$totals_price +=intval($data_inst_amnt['service_price']);
				$totals_disc +=intval($data_inst_amnt['discount_price']);
				$totals +=intval($data_inst_amnt['total_price']);
				
				if($ins!=$total_inst)
				{
					$rowcnt++;	
				}
				$ins++;
			}
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_query['excluded_tax']);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, round($val_query['cgst_tax'],2));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, round($val_query['sgst_tax'],2));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowCount, round($val_query['igst_tax'],2));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N'.$rowCount, $val_query['discount_price']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O'.$rowCount, round($val_query['total_cost']));
		
		$sel_name="select payment_mode from payment_mode where 1 and payment_mode_id='".$val_query['paid_type']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$payment_mode=$data_name['payment_mode'];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('P'.$rowCount, $payment_mode);
		
		$sel_bnk="select bank_name,account_no from bank where 1 and bank_id='".$val_query['bank_id']."' ";
		$ptr_bnk=mysql_query($sel_bnk);
		$data_bank=mysql_fetch_array($ptr_bnk);
								
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('Q'.$rowCount,"Bank Name.-". $data_bank['bank_name']."\n Acc. No.- ".$data_bank['account_no']);		
						
		if($val_query['bank_ref_no'] !='')
			$b_details="Ref No.- ".$val_query['bank_ref_no'];
			
		if($val_query['cheque_detail'] !='')
			$b_details1="Chaque No.- ".$val_query['cheque_detail'];
		
		if($val_query['chaque_date'] !='')
			$b_details2= "Chaque Date.- ".$val_query['chaque_date'];
			
		if($val_query['credit_card_no'] !='')
			$b_details3= "Credit Card No.- ".$val_query['credit_card_no'];
		  
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('R'.$rowCount, $b_details."\n".$b_details1."\n".$b_details2."\n".$b_details3);
		 
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('S'.$rowCount, $date);	
		
		/************************************Merge ******************************************/
		if($total_inst>1)
		{
			$totalmerge=intval($rowCount+$total_inst-1);
			//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
			$objPHPExcel->getActiveSheet()->mergeCells("A$rowCount:A$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("B$rowCount:B$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("C$rowCount:C$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("D$rowCount:D$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("J$rowCount:J$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("K$rowCount:K$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("L$rowCount:L$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("M$rowCount:M$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("N$rowCount:N$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("O$rowCount:O$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("P$rowCount:P$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("Q$rowCount:Q$totalmerge");
			$objPHPExcel->getActiveSheet()->mergeCells("R$rowCount:R$totalmerge");
		}
		$rowCount=$rowcnt;
		
		$k++;
		$rowCount++;
		$i++;
		$totals_tds +=intval($val_query['payable_amount']);
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, 'Total');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount,intval($totals_tds));

	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="service_summury_report.xls"');
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