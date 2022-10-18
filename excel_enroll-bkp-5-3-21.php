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
		
			$cm_id_filter='';
			$sel_branch="select cm_id from site_setting where branch_name like '".$keyword."' "; 
			$ptr_branch=mysql_query($sel_branch);     
			if(mysql_num_rows($ptr_branch)) 
			{
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id_filter="|| cm_id = '".$data_branch['cm_id']."'";
			} 
			
			$course_name_filter='';
			$select_installments = " select course_id from courses where course_name like '%".$keyword."%' ";
			$ptr_installment = mysql_query($select_installments);
			if($total=mysql_num_rows($ptr_installment))
			{
				$xx='';
				$i=1;
				while($data_installment = mysql_fetch_array($ptr_installment))
				{
					
				 
					$course_name_filter.= " || course_id =".$data_installment['course_id'];
					if($i !=$total)
					{
						//$xx.= '<br /><hr >';
					}
					$i++;
				}
			}
			                    
			$pre_keyword =" and (name like '%".$keyword."%' || contact like '%".$keyword."%' || mail like '%".$keyword."%' || username like '%".$keyword."%' || qualification like '%".$keyword."%' ".$cm_id_filter." ".$course_name_filter.")";
		}                            
	else
		$pre_keyword="";
	
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

	if($_GET['order'] !='' && ($_GET['orderby']=='name'))
	{
		$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
		$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
	}
	else
		
$select_directory='order by enroll_id desc';                      
        
  $sel_for_Num_rows="SELECT * FROM enrollment where 1 and ref_id='0' ".$_SESSION['where']." ".$search_cm_id." ".$pre_keyword." ".$select_directory."";
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
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "I5:I$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "J5:J$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "K5:K$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "L5:L$no_of_rows");


$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:L4");

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


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G1:G'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H1:H'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I1:I'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J1:J'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('K1:K'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:L'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
//======================== Add some data======================
//echo "<br />".date('H:i:s') . "\t Add some data\n";
//$objPHPExcel->setActiveSheetIndex(0);

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



 $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'5');
 $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Name','5');
 
 $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Contact No.','6');
 $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Email ID','6');
 
   if($_SESSION['type']=='S')
		  {
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Branch Name','6');
		  }
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Course Name','6');

  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Course Prise','6');
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Down Payment','6');
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Balance Fees','6');
   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Assign to','6');
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Installments','6');
  $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Date','6');
 

	$select_directory='order by enroll_id desc';                      
	$sql_query= "SELECT * FROM enrollment where 1 and ref_id='0' ".$_SESSION['where']." ".$search_cm_id." ".$pre_keyword." ".$select_directory.""; 
		
	if($_GET['keyword']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
	}
	 
	/* if($_GET['status']!='')
	 {
		 $sub_query1=" and status='".$_GET['status']."' ";
		 
		 $objPHPExcel->setActiveSheetIndex0()->SetCellValue('G2', 'Status : '.$_GET['status'].'');
	 }
	 
	 if($_GET['month']!='')
	 {
		 $sub_query2=" and MONTH(STR_TO_DATE(`mo_date`, '%d/%m/%Y'))='".$_GET['month']."' ";
		 
		 $monthNum = $_GET['month'];
         $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		 
		 $objPHPExcel->setActiveSheetIndex0()->SetCellValue('D2', 'Month : '.$monthName.'');
	 }
	 
	 if($_GET['year']!='')
	 {
		 $sub_query3=" and (YEAR(STR_TO_DATE(`mo_date`, '%d/%m/%Y')) ='".$_GET['year']."') ";
		 
		 $objPHPExcel->setActiveSheetIndex0()->SetCellValue('F2', 'Year : '.$_GET['year'].'');
	 }*/
	 
	 /*if($_GET['status']!='' || $_GET['month']!='' || $_GET['year']!='')
	 {*/
		
		
	//$sql_order= "SELECT * FROM bp_order where 1 ".$sub_query1." ".$sub_query2." ".$sub_query3." ORDER BY `order_id` desc"; 
    //$sql_order= "SELECT * FROM bp_order where 1 order by order_id desc ";
	$query_order=mysql_query($sql_query);
	
	$i=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		
		$select_course = "select * from courses where course_id = '".$val_query['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['name']);
		//echo '<br/>'.$contact_fetch4['mo_no'];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['contact']);					
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['mail']);
		if($_SESSION['type']=='S')
		{
			$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
			$ptr_branch=mysql_query($sel_branch); 
			$data_branch=mysql_fetch_array($ptr_branch);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $data_branch['branch_name']);						
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_course['course_name']);		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $val_query['net_fees']);		
		/************************************item_description******************************************/	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $val_query['down_payment']);	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $val_query['balance_amt']);	
		
		
		$sel_name="select name from site_setting where admin_id='".$val_query['assigned_to']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $data_name['name']);	
		/************************************po_qty******************************************/
						
		$select_installments = " SELECT * FROM `installment` where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."'  ";
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
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $xx);			
							
				
			 
		/************************************Item rate******************************************/
		
						  
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, $val_query['added_date']);	
							
		/************************************Plan Date******************************************/
		
				
		
		$k++;
		$rowCount++;
		$i++;
						
		
		
	}
// Miscellaneous glyphs, UTF-8
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Enroll_report_'.date('Y-m-d').'.xls"');
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


