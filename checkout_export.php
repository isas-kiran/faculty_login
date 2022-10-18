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
        $search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
        $cm_ids=$data_cm_id['cm_id'];
    }
    else
    {
        $search_cm_id='';
    }
}
if($_REQUEST['employee_id'])
{
    $emp_id=$_REQUEST['employee_id'];
    $employee_id=" and employee_id ='".$emp_id."'";
}
else
{
    $employee_id=""; 
}
if($_REQUEST['brand_id'])
{
    $emp_id=$_REQUEST['brand_id'];
    $brand_id=" and p.brand ='".$emp_id."'";
}
else
{
    $brand_id=""; 
}
if($_REQUEST['product_name'])
{
  $p_id=$_REQUEST['product_name'];
    $product_id="and cpm.product_id ='".$p_id."'";
}
else
{
     $product_id=""; 
}

if($_REQUEST['product_name'])
{
     $p_id1=$_REQUEST['product_name'];
    $product_id1="and product_id ='".$p_id1."'";
}
else
{
    $product_id1=""; 
}

if($_REQUEST['from_date']!="")
{
    $sep=explode("/",$_REQUEST['from_date']);
    $from_date=$sep[2]."-".$sep[1]."-".$sep[0];
      $from_date=" and added_date >='".date('Y-m-d',strtotime($from_date))."'";
}
if($_REQUEST['to_date']!="")
{
    $sep=explode("/",$_REQUEST['to_date']);
    $to_date=$sep[2]."-".$sep[1]."-".$sep[0];
    $to_date=" and added_date <='".date('Y-m-d',strtotime($to_date))."'";
}

if($_GET['page'])
    $page=$_GET['page'];
else
    $page=0;

if($_GET['show_records'])
    $show=$_GET['show'];
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

if($_GET['orderby']=='pcategory_name' )
    $img1 = $img;

if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
{
    $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
    $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
}


	
	$sel_for_Num_rows="select DISTINCT(employee_id) from checkout_product_map where 1 ".$_SESSION['where']." ".$product_id1."  order by employee_id asc"; 
                       		
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
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "J2:J$no_of_rows");
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "K2:K$no_of_rows");
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "L2:L$no_of_rows");
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "M2:M$no_of_rows");
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "N2:N$no_of_rows");
// $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "O2:O$no_of_rows");

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:O1");

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
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
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
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Employee Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Product Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'stock qty','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'consumable qty','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'shelf qty','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'available stock qty','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'available consumable qty','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I1', 'available shelf qty','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J1', 'Non Tax Price','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K1', 'Brand','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L1', 'Select Vender');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M1', 'Type','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('N1', 'Quantity','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('O1', 'Staff','6');

//$select_directory='order by p.product_name asc';                      

	  
// $search_cm_id='';
// $cm_ids=$_SESSION['cm_id'];
// if($_SESSION['type']=="S")
// {
//     if($_REQUEST['branch_name']!='')
//     {
//         $branch_name=$_REQUEST['branch_name'];
//         $select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
//         $ptr_cm_id=mysql_query($select_cm_id);
//         $data_cm_id=mysql_fetch_array($ptr_cm_id);
//         $search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
//         $cm_ids=$data_cm_id['cm_id'];
//     }
//     else
//     {
//         $search_cm_id='';
//     }
// }
// if($_REQUEST['employee_id'])
// {
//     $emp_id=$_REQUEST['employee_id'];
//     $employee_id=" and employee_id ='".$emp_id."'";
// }
// else
// {
//     $employee_id=""; 
// }
// if($_REQUEST['brand_id'])
// {
//     $emp_id=$_REQUEST['brand_id'];
//     $brand_id=" and p.brand ='".$emp_id."'";
// }
// else
// {
//     $brand_id=""; 
// }
// if($_REQUEST['product_name'])
// {
//    echo  $p_id=$_REQUEST['product_name'];
//     $product_id="and cpm.product_id ='".$p_id."'";
// }
// else
// {
//     echo $product_id=""; 
// }

// if($_REQUEST['product_name'])
// {
//    echo  $p_id1=$_REQUEST['product_name'];
//     $product_id1="and product_id ='".$p_id1."'";
// }
// else
// {
//     $product_id1=""; 
// }

// if($_REQUEST['from_date']!="")
// {
//     $sep=explode("/",$_REQUEST['from_date']);
//     $from_date=$sep[2]."-".$sep[1]."-".$sep[0];
//       $from_date=" and added_date >='".date('Y-m-d',strtotime($from_date))."'";
// }
// if($_REQUEST['to_date']!="")
// {
//     $sep=explode("/",$_REQUEST['to_date']);
//     $to_date=$sep[2]."-".$sep[1]."-".$sep[0];
//     $to_date=" and added_date <='".date('Y-m-d',strtotime($to_date))."'";
// }

// if($_GET['page'])
//     $page=$_GET['page'];
// else
//     $page=0;

// if($_GET['show_records'])
//     $show=$_GET['show'];
// else
//     $show=0;

// if($_GET['order']=='asc')
// {
//     $order='desc';
//     $img = "<img src='images/sort_up.png' border='0'>";
// }
// else if($_GET['order']=='desc')
// {
//     $order='asc';
//     $img = "<img src='images/sort_down.png' border='0'>";
// }
// else
//     $order='desc';

// if($_GET['orderby']=='pcategory_name' )
//     $img1 = $img;

// if($_GET['order'] !='' && ($_GET['orderby']=='pcategory_name'))
// {
//     $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
//     $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
// }

	 $sql_query= "select DISTINCT(employee_id) from checkout_product_map where 1 ".$_SESSION['where']." ".$search_cm_id." ".$employee_id." ".$product_id1." ".$from_date." ".$to_date." order by employee_id asc"; 
                       		
	//}
	/* if($_GET['keyword']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
	} */
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
       
      
        $sel_name="select name from site_setting where admin_id='".$val_query['employee_id']."'";
        $ptr_name=mysql_query($sel_name);
        if(mysql_num_rows($ptr_name))
        {
           $data_names=mysql_fetch_array($ptr_name);

            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_names['name']);
        
        $select_product_ids="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
        $query_product_ids=mysql_query($select_product_ids);
        $count_prod_ids=mysql_num_rows($query_product_ids);
        $n = 1;
        while($fetch_prod_ids=mysql_fetch_array($query_product_ids))
        {
            $sel_product="select product_name from product where product_id ='".$fetch_prod_ids['product_id']."' ".$brand_id." ";
            $ptr_product=mysql_query($sel_product);
            $data_product=mysql_fetch_array($ptr_product);
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $data_product['product_name']);

            $select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
          
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {
                
                if($fetch_prod_qty['issue_qty'] != ''){
		            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $fetch_prod_qty['issue_qty']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, '0');
                }
               
            }

            $select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."' and type='consumable'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
           
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {
                
                if($fetch_prod_qty['issue_qty'] != ''){
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $fetch_prod_qty['issue_qty']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, '0');
                }
               
            }

            $select_product_qty="select SUM(issue_qty) as issue_qty from checkout_product_map where employee_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."' and type='shelf'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
          
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {
                
                if($fetch_prod_qty['issue_qty'] != ''){
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $fetch_prod_qty['issue_qty']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['description']);
                }
              
            }

            $select_product_qty="select SUM(quantity) as quantity from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
           
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {
                if($fetch_prod_qty['quantity'] != ''){
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $fetch_prod_qty['quantity']);
                }else{
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, '0');
                }
               	
            }

            $select_product_qty="select SUM(quantity_in_consumable) as quantity_in_consumable from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
            
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {	
                if($fetch_prod_qty['quantity_in_consumable'] != ''){				
		            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $fetch_prod_qty['quantity_in_consumable']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $fetch_prod_qty['quantity_in_consumable']);
                }
              
            }

            $select_product_qty="select SUM(quantity_in_shelf) as quantity_in_shelf from product_user_map where user_id='".$val_query['employee_id']."' and product_id='".$fetch_prod_ids['product_id']."'";
            $query_product_qty=mysql_query($select_product_qty);
            $count_prod_qty=mysql_num_rows($query_product_qty);
            
            while($fetch_prod_qty=mysql_fetch_array($query_product_qty))
            {
                if($fetch_prod_qty['quantity_in_shelf'] != ''){
                 $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $fetch_prod_qty['quantity_in_shelf']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, '0');
                }
               
            }

          $n++;
          $rowCount++;
        }

		// $select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $m =1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
           
        //     $m++;
        // }

        // $select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $o = 1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
            
        //     $o++; 
        // }

        // $select_product_ids1="select DISTINCT(cpm.product_id) from checkout_product_map cpm,product p where cpm.employee_id='".$val_query['employee_id']."' ".$product_id." ".$brand_id." and cpm.product_id=p.product_id";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $p = 1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
            
        //     $p++;
        // }

        // $select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $q = 1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
           
        //     $q++;
        // }
        // $select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc ";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $r = 1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
            
        //     $r++; 
        // }
        // $select_product_ids1="select DISTINCT(product_id) from product_user_map where user_id='".$val_query['employee_id']."' ".$product_id1." order by product_id asc ";
        // $query_product_ids1=mysql_query($select_product_ids1);
        // $count_prod_ids1=mysql_num_rows($query_product_ids1);
        // $s = 1;
        // while($fetch_prod_ids1=mysql_fetch_array($query_product_ids1))
        // {
           
           
        //     $s++;
        // }
    }

   
	$k++;
    $rowCount++;	
		$i++;	
} 
		
		
	

$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="checkout_report.xls"');
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


