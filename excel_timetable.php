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
		
	$search_cm_id='';
	if($_SESSION['type']=="S")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			$search_cm_id_s=" and cm_id='".$data_cm_id['cm_id']."'";
		}
		else
		{
			$search_cm_id='';
			$search_cm_id_s='';
		}
	}
	$lead_grade_by='';
	
	
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
	
$record_id=$_GET['record_id'];

$sel_for_Num_rows="select logsheet_id from logsheet_map where logsheet_id='".$record_id."' order by day asc ";
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

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:F4");

//================== Set column widths==============================
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("40");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth("40");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
//======================== Merge cells	======================

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1:C'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E1:E'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 

//======================== Add some data======================

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Days','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Dates','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Topic Name','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Topic Content','7');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Model Required','5');
	
if($_GET['keyword']!='' || $_GET['keyword']!="Keyword")
{
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
}

$sql_records= "SELECT * FROM logsheet where logsheet_id=".$record_id." order by logsheet_id desc";
$ptr_records=mysql_query($sql_records);
if($tot_rec=mysql_num_rows($ptr_records))
{
	$data_rec=mysql_fetch_array($ptr_records);
	
	$sql_query= "select DISTINCT(day) from logsheet_map where logsheet_id='".$data_rec['logsheet_id']."' order by day asc "; 
	$query_order=mysql_query($sql_query);
	$i=1;
	$rowCount=5;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, 'Day '.$val_query['day']);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, '');
		
		$sel_topic="select topic_id,topic_content,model_required from logsheet_map where logsheet_id='".$data_rec['logsheet_id']."' and day='".$val_query['day']."' order by logsheet_map_id asc";
		$ptr_topics=mysql_query($sel_topic);
		if($tot_top=mysql_num_rows($ptr_topics))
		{
			$t=1;
			while($data_topics=mysql_fetch_array($ptr_topics))
			{
				$select_topic_name ="select topic_id,topic_name from topic where topic_id='".$data_topics['topic_id']."' ";
				$ptr_topic_name=mysql_query($select_topic_name);
				$data_topic_name = mysql_fetch_array($ptr_topic_name);
				
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $data_topic_name['topic_name']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $data_topics['topic_content']);
				$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $data_topics['model_required']);
				$t++;
				$rowCount++;
			}
		}	
		$k++;
		//$rowCount++;
		$i++;			
	}
}
// Miscellaneous glyphs, UTF-8
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Course_timetable_'.date('Y-m-d').'.xls"');
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