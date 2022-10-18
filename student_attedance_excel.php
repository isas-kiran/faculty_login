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

    $todo=$_GET['todo'];
$enroll_id=$_GET['enroll_id'];

                     
    $sel_for_Num_rows=  "select * FROM student_attendence where enroll_id='".$_GET['enroll_id']."'  and course_batch_id='".$_GET['c_b_id']."' ";  

	
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


$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);

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
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'date','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'status','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'uniform','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'latemark','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'mobile submitted','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'sms status','6');

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A1', 'Sr. No.' ,'6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B1', 'date','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C1', 'status','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D1', 'uniform','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E1', 'latemark','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F1', 'mobile submitted','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G1', 'sms status','6');


if($_GET['year'].'-'.$_GET['month'])
{
	$number = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']); // 31
	//echo "There were {$number} days in ".$_GET['month']." 2003";
	for($i = 1; $i <=  $number; $i++)
	{   
 		$dates[] =  str_pad($i, 2, '0', STR_PAD_LEFT);
 	}
	$total_found =0;	
	$not_found=0;
	$x=0; 
	$y=0;
        $z=0;
        $k=0;
        
        $i=1;
	$rowCount=2;
	$k=1;
	
	for($i=1;$i<$number;$i++)
	{
		 if($i<=9)
	    {
		 $a=0;
		 $i=$a.$i;
	     }
		if($_GET['Pre'] !="")
		{
			if($_GET['Pre']=='all')
	   		{
                $sql_query="select * from student_attendence where enroll_id='".$_GET['enroll_id']."' and course_batch_id='".$_GET['c_b_id']."' and `attendence_date` like '".$_GET['year']."-".$_GET['month']."-".$i."' ";
		        
	    	}
			else
			{
				$sql_query= "select * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and course_batch_id='".$_GET['c_b_id']."' and attendence='".$_GET['Pre']."' and `attendence_date` like '".$_GET['year']."-".$_GET['month']."-".$i."'";  
	
			}
            $query=mysql_query($sql_query);
           
			if($total_rows=mysql_num_rows($query))
			{
                $array=mysql_fetch_array( $query);
                
                $new_date= explode('-',$array['attendence_date'],3); 
                $date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
                
               
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $date_email);
                if(mysql_num_rows($query))
                {
                 if($array['attendence']=="present")
                 {
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount,'Present');
                    $total_found++;
                    }
                       if($array['attendence']=="absent")
                  {
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, 'Abscent');
                    $not_found++;
                  }
                }
                if($array['attendence']=="present")
                {
               if($array['uniform'] =="no"){
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'no');
               }else{
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'yes');
               }
               if($array['latemark'] =="no"){
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "no");
               }else{
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "yes");
               }
               if($array['mobile_submit'] =="no") {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "no");
               }else{
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "yes");   
               }
       
               }
       
               if($array['attendence']=="absent")
                 {
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'AB'); 
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "AB");
                   $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "AB");
                 }
       
               if($array["sms_send"] =="yes"){
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, "yes");
                 }else{
                    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount,"No");
                 }
               
                               
           
            $k++;
            $rowCount++;	
            $i++;	
				
				
			}
			  
	 	}
	}
}



if($_GET['Pre']=="")
	{


$t=0;	
$total_found =0;	
$not_found=0; 
 $sql_query= "select * FROM student_attendence where enroll_id='".$_GET['enroll_id']."'  and course_batch_id='".$_GET['c_b_id']."' ";  

 $qu=mysql_query($sql_query);
	$i=1;
	$rowCount=2;
	$k=1;
	while($array=mysql_fetch_array($qu))
	{
        $new_date= explode('-',$array['attendence_date'],3); 
        $date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
       
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $date_email);
        if(mysql_num_rows($qu))
        {
         if($array['attendence']=="present")
         {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, "Present");
			$total_found++;
			}
	   	    if($array['attendence']=="absent")
	      {
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, "Abscent");
	    	$not_found++;
	      }
        }
        if($array['attendence']=="present")
         {
        if($array['uniform'] =="no"){
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'no');
        }else{
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'yes');
        }
        if($array['latemark'] =="no"){
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "no");
        }else{
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "yes");
        }
        if($array['mobile_submit'] =="no") {
         $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "no");
        }else{
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "yes");   
        }

        }

        if($array['attendence']=="absent")
	      {
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, 'AB'); 
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, "AB");
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, "AB");
          }

       if($array["sms_send"] =="yes"){
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, "yes");
		 }else{
            $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount,"No");
		 }
       
       				
   
	$k++;
    $rowCount++;	
	$i++;	
    } 
		
}	
	

$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_attendence.xls"');
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



