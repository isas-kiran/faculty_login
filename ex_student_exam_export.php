<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');
include 'ex_inc_classes.php';
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
	
	$sel_for_Num_rows= "select * from ex_student_exam_registration where exam_no=".$_GET['exam_no'].""; 
        
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
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "M2:M$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "N2:N$no_of_rows");
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle3, "O2:O$no_of_rows");

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A1:O1");



//================== Set column widths==============================

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);

//======================== Merge cells	======================



//======================== Add some data======================

$objPHPExcel->setActiveSheetIndex(0);



$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Sr. No.' ,'6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'Exam Number','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'Student name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'Exam password','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'course name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'Enroll number','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'Schoolcode','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H1', 'Present or Abscent','6');


$select_directory='order by p.product_name asc';                      

	
	
	
	$sql_query= "select * from ex_student_exam_registration where exam_no=".$_GET['exam_no']."";
		
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
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
        
        
          
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['exam_no']);
        $select_name="select name from enrollment where enroll_id='".$val_query['enroll_no']."'";
        $ptr_name=mysql_query($select_name);
        $nm = mysql_fetch_array($ptr_name);

		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $nm['name']);

		
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['pwd']);
        $select_course="select course_name from courses where course_id='".$val_query['course_id']."'";
								$ptr_course=mysql_query($select_course);
								$cs = mysql_fetch_array($ptr_course);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $cs['course_name']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_query['enroll_no']);

		$select_school_code = "select school_code FROM `ex_exams` WHERE exam_number='".$val_query['exam_no']."'";
									$ptr_schoolcode = mysql_query($select_school_code);
								$sc = mysql_fetch_array($ptr_schoolcode);

		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $sc['school_code']);

		if($val_query['status']=='0'){
			$act_selecteds = "Present";
		}elseif($val_query['status']=='1'){
			$act_selecteds="Abscent";
		}
	
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $act_selecteds);
		
		$k++;
		$rowCount++;
		$i++;
		
	}

$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_exam.xls"');
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


