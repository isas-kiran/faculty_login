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
	$keyword='';
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
	if($keyword)
		$pre_keyword=" and (product_name like '%".$keyword."%' || product_code like '%".$keyword."%' || description like '%".$keyword."%' || amount like '%".$keyword."%' || commission like '%".$keyword."%' || price like '%".$keyword."%' || vender like '%".$keyword."%' || type like '%".$keyword."%')";
	else
		$pre_keyword="";
	
	if($_SESSION['type']=="S")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$search_cm_id_S=" and cm_id='".$data_cm_id['cm_id']."'";
		}
		else
		{
			$branch_name='';
			$search_cm_id='';
			$search_cm_id_S='';
		}
		if($_REQUEST['stockiest'] !='')
		{
			$st_admin_id=$_REQUEST['stockiest'];
			$search_admin_id=" and admin_id='".$st_admin_id."'";
			$search_admin_id_S=" and admin_id='".$st_admin_id."'";
		}
		else
		{
			$st_admin_id='';
			$search_admin_id='';
			$search_admin_id_S='';
		}
	}
	else
	{
		$search_cm_id='';
		$search_admin_id='';
		$search_cm_id_S='';
		$search_admin_id_S='';
	}
	
	if($_GET['order'] !='' && ($_GET['orderby']=='product_name'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		$select_directory='order by product_name asc'; 
	
	/*if($pre_keyword=='') 
	{                   
		$sel_for_Num_rows= "SELECT * FROM product where 1 ".$record_cat_id." ".$_SESSION['where']." ".$_SESSION['user_id']." ".$search_cm_id." ".$search_admin_id." ".$select_directory.""; 
	}
	else
	{*/
	
	$cm_ids=='';
	$admin_ids='';
	if($_SESSION['where'] !='')
	{
		$cm_ids="and cm_id='".$_SESSION['cm_id']."'";
	}
	if($_SESSION['user_id'] !='')
	{
		$admin_ids="and admin_id='".$_SESSION['admin_id']."'";
	}
	
	/*$status_type="and p.status='Active'";
	if($_REQUEST['status_type'])
	{
		
		$status_type="and (p.status='".$_REQUEST['status_type']."'";
		if($_REQUEST['status_type']=='Inactive')
		{
			$status_type .=" or p.status is NULL )";
		}
		else
			$status_type .=")";
	}*/
	//$sql_query= "SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$select_directory.""; 
		
	/*$sel_for_Num_rows="SELECT p.product_name, p.product_code, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.quantity,p.added_date,p.admin_id FROM product p, product_category pc, product_subcategory sub where 1  and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%' ) and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$cm_ids." ".$admin_ids." ".$search_cm_id_S." ".$search_admin_id_S." ".$select_directory." ";*/
	//}
	
	$sel_for_Num_rows= "SELECT product_name, product_code,status, description, size, commission, price, pcategory_id, sub_id, product_id, quantity, quantity_in_shelf,quantity_in_consumable,added_date,admin_id,cm_id,hsn_code,brand FROM product where 1 and status='Active'  ".$status_type." ".$vendor_ids." ".$cm_ids."  ".$search_cm_id_S." ".$search_admin_id_S." ".$select_directory.""; 
        
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+1);
  	$no_of_rows_new = ($no_of_rows+1);
//================Apply styles============================
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "A2:A$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "B2:B$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "C2:C$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "D2:D$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "E2:E$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "F2:F$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "G2:G$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "H2:H$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "I2:I$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "J2:J$no_of_rows");
/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "K2:K$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "L2:L$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "M2:M$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "N2:N$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "O2:O$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "P2:P$no_of_rows");*/

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:JP1");

//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A2:M2");

//$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");

/*$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A35:A37");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B35:B37");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C35:C37");

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A39:A41");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "B39:B41");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "C39:C41");*/


//================== Set column widths==============================
/* $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true); */

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
/*$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
*/
/* 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex()->getHighestRow())->getAlignment()->setWrapText(true); 
	 */
//======================== Merge cells	======================

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');

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

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Sr. No.' ,'6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Product Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Product Code','6');

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'Price','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'Brand','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'Vender');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'Type','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'Quantity','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I1', 'Staff','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J1', 'Product Id','6');

$select_directory='order by product_name asc';                      

	$cm_ids=='';
	$admin_ids='';
	if($_SESSION['where'] !='')
	{
		$cm_ids="and cm_id='".$_SESSION['cm_id']."'";
	}
	if($_SESSION['user_id'] !='')
	{
		$admin_ids="and admin_id='".$_SESSION['admin_id']."'";
	}
	
	/*$status_type="and p.status='Active'";
	if($_REQUEST['status_type'])
	{
		$status_type="and (p.status='".$_REQUEST['status_type']."'";
		if($_REQUEST['status_type']=='Inactive')
		{
			$status_type .=" or p.status is NULL )";
		}
		else
			$status_type .=")";
	}*/
			
	$sql_query= "SELECT product_name, product_code,status, description, size, commission, price, pcategory_id, sub_id, product_id, quantity, quantity_in_shelf,quantity_in_consumable,added_date,admin_id,cm_id,hsn_code,brand FROM product where 1 and status='Active'  ".$status_type." ".$vendor_ids." ".$cm_ids."  ".$search_cm_id_S." ".$search_admin_id_S." ".$select_directory.""; //".$admin_ids."
		
	
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['product_name'].' - '.$val_query['product_id']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['product_code']);

		/*$select_prod_cat="select pcategory_name,pcategory_id from product_category where pcategory_id='".$val_query['pcategory_id']."'";
		$query_cat=mysql_query($select_prod_cat);
		$fetch_cat=mysql_fetch_array($query_cat);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $fetch_cat['pcategory_name']);
		
		$select_prod_subcat="select sub_name,sub_id from product_subcategory where sub_id='".$val_query['sub_id']."'";
		$query_subcat=mysql_query($select_prod_subcat);
		$fetch_subcat=mysql_fetch_array($query_subcat);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $fetch_subcat['sub_name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['description']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, trim($val_query['size']));						
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['unit']);
				
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_query['commission']);	*/					
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, trim($val_query['price']));
		
		$sel_brand="select * from product_brand where brand_id='".$val_query['brand']."'";
		$ptr_sel=mysql_query($sel_brand);
		$data_brand=mysql_fetch_array($ptr_sel);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $data_brand['brand_name']);
		
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
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, trim($vendor_name));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_query['type']);						
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['quantity']);
		
		$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $data_name['name']);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_query['product_id']);
		
		$k++;
		$rowCount++;
		$i++;
	}

	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="product-stock.xls"');
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