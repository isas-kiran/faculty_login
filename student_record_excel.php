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

   
    if($_REQUEST['batch_id'])
    {   
        $batch= 'and batch_id ='.$_REQUEST['batch_id'].'';
    }else{
        $batch="";
    }
    
    if($batch)
    {
         $pre_keyword1=" and(batch_id like '%".$batch."%')";
    }
    else{
        $pre_keyword1="";
    }
    
    if($_REQUEST['enroll_id'])
    {   
        $enroll= 'and enroll_id ='.$_REQUEST['enroll_id'].'';
    }else{
        $enroll="";
    }

    if($_REQUEST['keyword']!="Keyword")
    {
        $keyword=trim($_REQUEST['keyword']);
    }
    if($keyword)
    {
        $pre_keyword=" and (en.name like '%".$keyword."%'||en.contact like '%".$keyword."%' ||en.mail like '%".$keyword."%' )";
    }
    else
    {
        $pre_keyword="";
    }
    
    if($_REQUEST['page'])
    {
        $page=$_REQUEST['page'];
    }
    else
    {
        $page=0;
    }
    
    if($_REQUEST['show_records'])
    {
        $show=$_REQUEST['show'];
    }
    else
    {
        $show=0;
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
    {
        $order='desc';
    }

    if($_GET['orderby']=='employee_name' )
    {
        $img1 = $img;
    }

    if($_GET['order'] !='' && ($_GET['orderby']=='employee_name'))
    {
        $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
        $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
    }
                            
    $sel_for_Num_rows= "select * FROM student_course_batch_map where 1 ".$batch." ".$enroll." ".$pre_keyword.""; 

	
	//$sel_for_Num_rows="select DISTINCT(employee_id) from checkout_product_map where 1 ".$_SESSION['where']." ".$product_id1."  order by employee_id asc"; 
                       		
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
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'student Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'course Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'Total days','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'Abscent days','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'No. of latemark','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'Without Uniform','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'Mobile submitted','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I1', '% of present','6');

$sql_query= "select * FROM student_course_batch_map where 1 ".$batch." ".$enroll." ".$pre_keyword.""; 

	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
       
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);

        $select_name = "select name from enrollment where enroll_id='".$val_query['enroll_id']."' ";
        $pre_sel=mysql_query($select_name);
        $data_name=mysql_fetch_array($pre_sel);
        
        $sel_course="select course_name from courses where course_id='".$val_query['course_id']."'";
        $pre_course=mysql_query($sel_course);
        $data_course=mysql_fetch_array($pre_course);

        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_name['name']);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $data_course['course_name']);

        $select_att="select stud_attendence_id from student_attendence where course_batch_id ='".$val_query['c_b_id']."' and enroll_id= ".$val_query['enroll_id']."";
        $ptr_att= mysql_query($select_att);
        $total_attendence = mysql_num_rows($ptr_att);
        
        $select_counter= "SELECT * from student_attendence where enroll_id= ".$val_query['enroll_id']." and course_batch_id='".$val_query['c_b_id']."' and attendence='absent' ";
        $pre_counter= mysql_query($select_counter);
        $count_absent= mysql_num_rows($pre_counter);

        $select_latemark= "SELECT * from student_attendence where enroll_id= ".$val_query['enroll_id']." and course_batch_id='".$val_query['c_b_id']."' and latemark='' ";
        $pre_latemark= mysql_query($select_latemark);
        $count_latemark= mysql_num_rows($pre_latemark);
        
        $select_uniform= "SELECT * from student_attendence where enroll_id= ".$val_query['enroll_id']." and course_batch_id='".$val_query['c_b_id']."' and uniform='' ";
        $pre_uniform= mysql_query($select_uniform);
        $count_uniform= mysql_num_rows($pre_uniform);
        
        $select_mobile= "SELECT * from student_attendence where enroll_id= ".$val_query['enroll_id']." and course_batch_id='".$val_query['c_b_id']."' and mobile_submit='' ";
        $pre_mobile= mysql_query($select_mobile);
        $count_mobile= mysql_num_rows($pre_mobile);

        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $total_attendence);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $count_absent);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $count_latemark);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $count_uniform);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $count_mobile);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, round((($total_attendence-$count_absent)/$total_attendence)*100));
								
   
	$k++;
    $rowCount++;	
	$i++;	
    } 
		
		
	

$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_report.xls"');
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


