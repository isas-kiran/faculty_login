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
	
	if($_REQUEST['keyword']!="Keyword")
		$keyword=trim($_REQUEST['keyword']);
	if($keyword)
		$pre_keyword=" and (product_name like '%".$keyword."%' || product_code like '%".$keyword."%' || description like '%".$keyword."%' || amount like '%".$keyword."%' || commission like '%".$keyword."%' || price like '%".$keyword."%' || vender like '%".$keyword."%' || type like '%".$keyword."%')";
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
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$search_cm_id_S=" and p.cm_id='".$data_cm_id['cm_id']."'";
		}
		else
		{
			$branch_name='';
			$search_cm_id_S='';
		}
	}
	else
	{
		$search_cm_id_S='';
		$search_admin_id_S='';
	}
	if($_REQUEST['stockiest'] !='')
	{
		$st_admin_id=$_REQUEST['stockiest'];
		$search_admin_id=" and admin_id='".$st_admin_id."'";
		$search_admin_id_S=" and ps.user_id='".$st_admin_id."'";
	}
	else
	{
		$st_admin_id='';
		$search_admin_id_S='';
	}
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

	if($_GET['orderby']=='product_name' )
		$img1 = $img;

	if($_GET['order'] !='' && ($_GET['orderby']=='product_name'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		$select_directory='order by product_id desc';  
					
	$record_cat_id='';
	if($_GET['record_id'] !='')
	{
		$record_cat_id="and product_id='".$_GET['record_id']."' ";
	}
	
	$vendor_ids='';
	
	$user_id=$_SESSION['user_id'];
	if($_SESSION['type']=="A")
	{
		$user_id='';
	} 
	
	$cm_ids=='';
	$admin_ids='';
	
	$user_id=$_SESSION['user_id'];
	if($_SESSION['type']=="A")
	{
		$user_id='';
	} 
	
	if($_SESSION['where'] !='')
	{
		$cm_ids="and p.cm_id='".$_SESSION['cm_id']."'";
	}
	if($user_id !='')
	{
		$admin_ids="and p.admin_id='".$_SESSION['admin_id']."'";
	}
	
	//$status_type="and p.status='Active'";
	if($_REQUEST['status_type'])
	{
		$status_type="and (p.status='".$_REQUEST['status_type']."'";
		if($_REQUEST['status_type']=='Inactive')
		{
			$status_type .=" or p.status is NULL )";
		}
		else
			$status_type .=")";
	}
	
	$sel_for_Num_rows="SELECT ps.user_id,ps.product_id as prod_id,ps.quantity,ps.quantity_in_shelf, ps.quantity_in_consumable, ps.user_id,p.product_name, p.product_code, p.status, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.added_date,ps.admin_id,p.hsn_code FROM product_user_map ps, product p, product_category pc, product_subcategory sub where 1 and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%') and ps.product_id=p.product_id and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$vendor_ids." ".$cm_ids." ".$search_cm_id_S." ".$search_admin_id_S." order by p.product_name asc"; 
        
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
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "K2:K$no_of_rows");
	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "L2:L$no_of_rows");

	$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:L1");
	
	
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
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);

	//======================== Merge cells	======================
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
	//======================== Add some data======================
	//echo "<br />".date('H:i:s') . "\t Add some data\n";
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Sr. No.');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Product Name');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Brand');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'Product Category');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'Product Sub Category');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'Qty(Shelf)');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'Qty(Cons.)');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'Size');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I1', 'Last issue qty');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J1', 'Last issue date');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K1', 'Available Qty');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L1', 'Owner');
	
	$sql_query="SELECT ps.user_id,ps.product_id as prod_id,ps.quantity,ps.quantity_in_shelf, ps.quantity_in_consumable, ps.user_id,p.product_name, p.product_code, p.status, p.description, p.size, p.commission, p.price, p.pcategory_id, p.sub_id, p.product_id,p.added_date,ps.admin_id,p.hsn_code FROM product_user_map ps, product p, product_category pc, product_subcategory sub where 1 and (p.product_name like '%".$keyword."%' or p.product_code like '%".$keyword."%' or p.description like '%".$keyword."%' or p.size like '%".$keyword."%' or p.commission like '%".$keyword."%' or p.price like '%".$keyword."%' or pc.pcategory_name like '%".$keyword."%' or sub.sub_name like '%".$keyword."%') and ps.product_id=p.product_id and p.pcategory_id=pc.pcategory_id and p.sub_id=sub.sub_id ".$vendor_ids." ".$cm_ids." ".$search_cm_id_S." ".$search_admin_id_S." order by p.product_name asc";
		
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$listed_record_id=$val_query['prod_id'];
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		//==============================Product Name=======================================
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['product_name']);
		//===============================Brand Name========================================
		$select_pbrand="select brand,unit,size from product where product_name like '%".$val_query['product_name']."%'";
		$query_pbrand=mysql_query($select_pbrand);
		$data_pbrand=mysql_fetch_array($query_pbrand);
		
		$select_brand="select brand_name from product_brand where brand_id='".$data_pbrand['brand']."'";
		$query_brand=mysql_query($select_brand);
		$data_brand=mysql_fetch_array($query_brand);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $data_brand['brand_name']);
		//==============================Category Name=======================================
		$select_prod_cat="select pcategory_name,pcategory_id from product_category where pcategory_id='".$val_query['pcategory_id']."'";
		$query_cat=mysql_query($select_prod_cat);
		$fetch_cat=mysql_fetch_array($query_cat);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $fetch_cat['pcategory_name']);
		//=============================Subcategory Name======================================
		$select_prod_subcat="select sub_name,sub_id from product_subcategory where sub_id='".$val_query['sub_id']."'";
		$query_subcat=mysql_query($select_prod_subcat);
		$fetch_subcat=mysql_fetch_array($query_subcat);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $fetch_subcat['sub_name']);
		//=================================Qty Shelf=========================================
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['quantity_in_shelf']);
		//===============================Qty Consumable======================================						
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_query['quantity_in_consumable']);	
		//====================================Unit===========================================
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $data_pbrand['size']." ".$data_pbrand['unit']);
		//===============================Last Issue Qty======================================
		$select_prods="select added_date,issue_qty from checkout_product_map where product_id='".$val_query['prod_id']."' and employee_id='".$val_query['user_id']."' order by checkout_map_id desc limit 0,1 ";
		$ptr_prods=mysql_query($select_prods);
		$data_prods=mysql_fetch_array($ptr_prods);						
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $data_prods['issue_qty']);
		//===============================Last Issue Date=====================================
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $data_prods['added_date']);
		//===============================Available Quantity==================================
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_query['quantity_in_consumable']);
		//===================================Owner===========================================
		$name='';
		$sel_emp="select name from site_setting where admin_id='".$val_query['user_id']."'";
		$ptr_admin_id=mysql_query($sel_emp);
		if(mysql_num_rows($ptr_admin_id))
		{
			$data_name=mysql_fetch_array($ptr_admin_id);
			$name= "".$data_name['name']."";
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, trim($name));
		//========================================================================================
		$k++;
		$rowCount++;
		$i++;
	}

	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="product.xls"');
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