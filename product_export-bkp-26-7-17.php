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
$sharedStyle3 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
//styles

     $sharedStyle3->applyFromArray(
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
		 
		  $sharedStyle3->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								
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
		$pre_keyword=" and (product_name like '%".$keyword."%' || product_code like '%".$keyword."%' || description like '%".$keyword."%' || amount like '%".$keyword."%' || commission like '%".$keyword."%' || price like '%".$keyword."%' || vender like '%".$keyword."%' || type like '%".$keyword."%')";
	else
		$pre_keyword="";

	if($_GET['order'] !='' && ($_GET['orderby']=='product_name'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		$select_directory='order by product_name asc'; 
	
	if($pre_keyword=='') 
	{                   
		$sel_for_Num_rows= "SELECT * FROM product where 1 ".$record_cat_id." ".$_SESSION['where']." ".$_SESSION['user_id']."  ".$select_directory.""; 
	}
	else
	{
		$cm_ids=='';
		$admin_ids='';
		if($_SESSION['where'] !='')
		{
			$cm_ids="and p.cm_id='".$_SESSION['cm_id']."'";
		}
		if($_SESSION['user_id'] !='')
		{
			$admin_ids="and p.admin_id='".$_SESSION['admin_id']."'";
		}
		//$sql_query= "SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory.""; 
		$sel_for_Num_rows="SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory." ";

	}
		
        
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+1);
  	$no_of_rows_new = ($no_of_rows+1);
//================Apply styles============================
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A2:A$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "B2:B$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "C2:C$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "D2:D$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "E2:E$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "F2:F$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "G2:G$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "H2:H$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "I2:I$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "J2:J$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "K2:K$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "L2:L$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "M2:M$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "N2:N$no_of_rows");

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A1:N1");

//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:M2");

//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");

/*$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A35:A37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B35:B37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C35:C37");

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A39:A41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B39:B41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C39:C41");*/


//================== Set column widths==============================
/* $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); */

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

/* 
$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('D1:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('E1:E'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('F1:F'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('G1:G'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
	 */
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



	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr. No.' ,'6');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Name','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Product Code','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Product Category','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Product Sub Category','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Product Description','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Size','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Unit','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Commission (in %)','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Non Tax Price','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Brand','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Select Vender');
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Type','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Quantity','6');

	$select_directory='order by product_name asc';                      
	$sql_query= "SELECT * FROM `enrollment` WHERE 1 and ref_id='0' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory." "; 
		
	if($pre_keyword=='') 
	{                   
		$sql_query= "SELECT * FROM product where 1 ".$record_cat_id." ".$_SESSION['where']." ".$_SESSION['user_id']."  ".$select_directory.""; 
	}
	else
	{
		$cm_ids=='';
		$admin_ids='';
		if($_SESSION['where'] !='')
		{
			$cm_ids="and p.cm_id='".$_SESSION['cm_id']."'";
		}
		if($_SESSION['user_id'] !='')
		{
			$admin_ids="and p.admin_id='".$_SESSION['admin_id']."'";
		}
		$sql_query= "SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory.""; 
		//$sel_for_Num_rows="SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory." ";

	}
	/* if($_GET['keyword']!='')
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->getActiveSheet()->SetCellValue('C2', ''.$_GET['keyword'].'');
	} */
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $val_query['product_name']);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $val_query['product_code']);

		$select_prod_cat="select pcategory_name,pcategory_id from product_category where pcategory_id='".$val_query['pcategory_id']."'";
		$query_cat=mysql_query($select_prod_cat);
		$fetch_cat=mysql_fetch_array($query_cat);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $fetch_cat['pcategory_name']);
		
		$select_prod_subcat="select sub_name,sub_id from product_subcategory where sub_id='".$val_query['sub_id']."'";
		$query_subcat=mysql_query($select_prod_subcat);
		$fetch_subcat=mysql_fetch_array($query_subcat);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $fetch_subcat['sub_name']);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $val_query['description']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, trim($val_query['size']));						
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $val_query['unit']);
				
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_query['commission']);						
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, trim($val_query['price']));
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $val_query['brand']);
		
		$select_vendor_map="select product_id,vendor_id from product_vendor_map where product_id='".$val_query['product_id']."' ";
		$query_vendor_map=mysql_query($select_vendor_map);
		$total_vendor=mysql_num_rows($query_vendor_map);
		$v=1;
		$vendor_name='';
		while($fetch_vendor_map=mysql_fetch_array($query_vendor_map))
		{
			$sql_vendor = " select name, vendor_id from vendor where vendor_id='".$fetch_vendor_map['vendor_id']."' ";
			$ptr_vendor = mysql_query($sql_vendor);
			$data_vendor = mysql_fetch_array($ptr_vendor);
			$vendor_name.= $data_vendor['name'];
			if($total_vendor=$total_vendor-1)
			{
				$vendor_name.=',';
			}
			$v++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, trim($vendor_name));
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $val_query['type']);						
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $val_query['quantity']);

		$k++;
		$rowCount++;
		$i++;
		
	}

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
$objWriter->save('excel_files/Products_Report_'.date('Y-m-d').'.xlsx');
//$objWriter->save('php://output');
ob_end_flush();

?>
<a href="manage_product.php">Back</a>
<script>
document.location.href='exports_products.php';
</script>


