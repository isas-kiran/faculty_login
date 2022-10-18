<?php include 'inc_classes.php';
/*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excel_'.date('Y-m-d').''.'.xlsx"');
header('Cache-Control: max-age=0');*/
?>
<?php
/** Include path **/
ini_set('include_path', ini_get('include_path').'../Classes/');
 /** PHPExcel */
include 'PHPExcel/Classes/PHPExcel.php';
/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
$local_path = 'excel_files/';
// Create new PHPExcel object						
//echo  "<br /> Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
// Set properties
//echo  "<br/> Set properties\n";
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
	/* if($_REQUEST['gst_student']!="")
		$gst_keyword =trim($_REQUEST['gst_student']);
	
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
	} */
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
	$select_directory='order by s.expense_id desc';                     
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and s.cm_id='".$_SESSION['cm_id']."'";
	}
        
  	$sel_for_Num_rows="SELECT DISTINCT(s.expense_id),s.vendor_id,s.added_date,s.expense_type_id,s.total_price FROM expense s, expense_tax_map sm WHERE 1 and s.expense_id=sm.expense_id ".$where_cm." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (sm.tax_type !='') ".$select_directory." ";
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+5);
  	$no_of_rows_new = ($no_of_rows+3);

//================Apply styles============================
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B5:B$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "C5:C$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "D5:D$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "E5:E$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "F5:F$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "G5:G$no_of_rows");
//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "H5:H$no_of_rows");


$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:G4");
//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:M2");
//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");
/*$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A35:A37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B35:B37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C35:C37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A39:A41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B39:B41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C39:C41");*/

//================== Set column widths==============================
/*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); */

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
//$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");


$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('D1:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('E1:E'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('F1:F'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('G1:G'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
//$objPHPExcel->getActiveSheet()->getStyle('H1:H'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 


//======================== Merge cells	======================

//$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
//$objPHPExcel->getActiveSheet()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->getActiveSheet()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');


//======================== Add some data======================
//echo "<br />".date('H:i:s') . "\t Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);

	/* $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1','3', 'Sr. No.' ,'3');
 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2','3', 'Sales Order No.','3');
 
 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3','3', 'Mo No','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4','3', 'Mo Date','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5','3', 'customer Name','3');
 
  $objPHPExcel->getActiveSheet()->suyetCellValueByColumnAndRow('6','3', 'Concern Person','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7','3', 'Item Description','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8','3', 'PO No','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9','3', 'PO Quantity','3');
  
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10','3', 'Item Rate','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('11','3', 'Plan Date','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('12','3', 'BD User','3');
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('13','3', 'Status','3');*/

	$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Sr. No.' ,'6');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Vendor Name','6');
 
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Expense Name','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Price (Excl. GST)','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'GST','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Total GST','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Date','6');
	
	$total_down_cgst=0;
	$total_down_sgst=0;
	$total_down=0;
	$total_ins_cgst=0;
	$total_ins_sgst=0;
	$total_ins=0;
	
	$select_directory='order by s.expense_id desc';                     
	$where_cm='';
	if($_SESSION['where']!='')
	{
		$where_cm=" and s.cm_id='".$_SESSION['cm_id']."'";
	}                    
	$sql_query= "SELECT DISTINCT(s.expense_id),s.vendor_id,s.added_date,s.expense_type_id,s.total_price FROM expense s, expense_tax_map sm WHERE 1 and s.expense_id=sm.expense_id ".$where_cm." ".$pre_keyword_i." ".$paid_from_date_i." ".$paid_to_date_i." and (sm.tax_type !='') ".$select_directory." "; 
		
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
		$sel_name="select name,gst_no from vendor where vendor_id='".$val_query['vendor_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$name=$data_name['name'];
		if($data_name['gst_no'])
		$name .="\n GST no.: ".$data_name['gst_no'];
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $name);
		$sel_inst_amnt="select expense_type from expense_type where 1 and expense_type_id='".$val_query['expense_type_id']."' ";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		$data_inst_amnt=mysql_fetch_array($ptr_ins_amnt);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $data_inst_amnt['expense_type']);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $val_query['total_price']);
	
		$course_data='';
		$totals_products_gst=0;
		$product_price='';
		$product_name='';
		$gst_per='';
		$gst_val='';
		$amount=0;
		$sel_inst_amnt="select * from expense_tax_map where 1 and expense_id='".$val_query['expense_id']."' and (tax_type !='' or tax_value !='')";
		$ptr_ins_amnt=mysql_query($sel_inst_amnt);
		if($total_inst=mysql_num_rows($ptr_ins_amnt))
		{
			
			$ins=1;
			while($data_inst_amnt=mysql_fetch_array($ptr_ins_amnt))
			{
				
				if($ins >1)
					$gst_per .= "\n";
				if($data_inst_amnt['tax_type']=="CGST")
				{
					$total_cgst +=$data_inst_amnt['tax_amount'];
				}
				if($data_inst_amnt['tax_type']=="SGST")
				{
					$total_sgst +=$data_inst_amnt['tax_amount'];
				}
				
				$gst_per .= $data_inst_amnt['tax_type']."(".$data_inst_amnt['tax_value']."%)- ".$data_inst_amnt['tax_amount'];
				$amount +=$data_inst_amnt['tax_amount'];
				
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $gst_per);
				$ins++;
				
			}
		}
		$total_gst +=$amount;
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $amount);
		$sep=explode(" ",$val_query['added_date']);
		$sep_date=explode("-",$sep[0]);
		$date=$sep_date[2]."/".$sep_date[1]."/".$sep_date[0];
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $date);
		
		$k++;
		$rowCount++;
		$i++;
		
	}
	
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'CGST- '.intval($total_cgst));
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'SGST- '.intval($total_sgst));
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'Total- '.intval($total_gst));


$objPHPExcel->getActiveSheet()->setTitle('Simple');

/*$file_name ='excel_files/order_details_'.date('Y-m-d').'.xlsx';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_get_clean();
$objWriter->save('excel_files/order_details_'.date('Y-m-d').'.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;  filename="order_details_'.date('Y-m-d').'.xlsx"');
header('Content-Length: ' . filesize($file_name));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

//stream file
ob_get_clean();
echo file_get_contents($file_name);
ob_end_flush();*/
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_get_clean();
$objWriter->save('excel_files/Expense_Outgoing_GST_Report_'.date('Y-m-d').'.xlsx');
//$objWriter->save('php://output');
ob_end_flush();

?>
<a href="product_incomming_gst.php">Back</a>

<script>
document.location.href='exports_outgoing_expense_gst.php';
</script>


