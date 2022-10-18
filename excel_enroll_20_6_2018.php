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
                               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		  
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
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A6:A$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B6:B$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "C6:C$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "D6:D$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "E6:E$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "F6:F$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "G6:G$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "H6:H$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "I6:I$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "J6:J$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "K6:K$no_of_rows");



$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:K4");

//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:M2");

//$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A$no_of_rows_new:M$no_of_rows_new");

/*$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A35:A37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B35:B37");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C35:C37");

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A39:A41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B39:B41");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "C39:C41");*/


//================== Set column widths==============================
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
 $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Name','6');
 
 $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Contact No.','6');
  $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Email ID','6');
   if($_SESSION['type']=='S')
		  {
  $objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Branch Name','6');
		  }
  $objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Course Name','6');

  $objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Course Prise','6');
  $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Down Payment','6');
  $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Balance Fees','6');
  
  $objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Installments','6');
  $objPHPExcel->getActiveSheet()->SetCellValue('K4', 'Date','6');
 
 
 
 
	
	
		$select_directory='order by enroll_id desc';                      
		$sql_query= "SELECT * FROM enrollment where 1 and ref_id='0' ".$_SESSION['where']." ".$search_cm_id." ".$pre_keyword." ".$select_directory.""; 
		
	 if($_GET['keyword']!='')
	 {
	   $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Search by =>');
	   
	    $objPHPExcel->getActiveSheet()->SetCellValue('C2', ''.$_GET['keyword'].'');
	 }
	 
	/* if($_GET['status']!='')
	 {
		 $sub_query1=" and status='".$_GET['status']."' ";
		 
		 $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Status : '.$_GET['status'].'');
	 }
	 
	 if($_GET['month']!='')
	 {
		 $sub_query2=" and MONTH(STR_TO_DATE(`mo_date`, '%d/%m/%Y'))='".$_GET['month']."' ";
		 
		 $monthNum = $_GET['month'];
         $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		 
		 $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Month : '.$monthName.'');
	 }
	 
	 if($_GET['year']!='')
	 {
		 $sub_query3=" and (YEAR(STR_TO_DATE(`mo_date`, '%d/%m/%Y')) ='".$_GET['year']."') ";
		 
		 $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Year : '.$_GET['year'].'');
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
		
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $val_query['name']);
		
		 
			//echo '<br/>'.$contact_fetch4['mo_no'];
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $val_query['contact']);					
			
			
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $val_query['mail']);
		
		if($_SESSION['type']=='S')
		  {
			  $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
			  $ptr_branch=mysql_query($sel_branch);
			  $data_branch=mysql_fetch_array($ptr_branch);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $data_branch['branch_name']);						
		  }
		
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $val_course['course_name']);		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $val_course['course_price']);		
		/************************************item_description******************************************/	
							
		 
					
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $val_query['down_payment']);	
						
				
			
		
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_query['balance_amt']);	
		
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
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $xx);			
							
				
			 
		 /************************************Item rate******************************************/
		
						  
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $val_query['added_date']);	
							
		/************************************Plan Date******************************************/
		
				
		
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
$objWriter->save('excel_files/Enrollment_'.date('Y-m-d').'.xlsx');
//$objWriter->save('php://output');
ob_end_flush();

?>
<a href="manage_enroll.php">Back</a>
<script>
document.location.href='exports_enroll.php';
</script>


