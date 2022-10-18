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

//==========================properties========================
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


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
			$search_cm_id_s=" and s.cm_id='".$data_cm_id['cm_id']."'";
			
		}
		else
		{
			$search_cm_id='';
			$search_cm_id_s='';
		}
	}
	else
	{
		$select_br="select branch_name from site_setting where cm_id='".$_SESSION['cm_id']."' and type='A'";
		$ptr_br=mysql_query($select_br);
		$data_br=mysql_fetch_array($ptr_br);
		$branch_name=$data_br['branch_name'];
	}
	
	if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
	 {
		 $frm_date=explode("/",$_REQUEST['start_date']);
		 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		 
		$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
	 }
	else
	{
		$pre_from_date="";                            
	}
	if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['end_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		 
		$pre_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
	}
	else
		$pre_to_date="";
	
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
	
		//===============================================================================================
		//$branch_id='';
		/*if($_SESSION['type'] !='S')
		{
			$sel_cm_id_from_branch="select inquiry_id from inquiry where cm_id='".$_SESSION['cm_id']."'";
			$ptr_branch=mysql_query($sel_cm_id_from_branch);
			while($data_branch=mysql_fetch_array($ptr_branch))
			{
				$inquiry_id=$data_branch['inquiry_id'];
				$branch_id='and student_id='.$inquiry_id.'';
			}
			
		}*/
		//================================================================================================
		

	$sel_for_Num_rows="select * from inquiry where status = 'Enquiry' and campaign_id!='' and followup_date IS NULL and enquiry_source!='7' ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$search_cm_id." order by added_date desc";
	
  	$my_querxy=mysql_query($sel_for_Num_rows);
  	$no_of_rows=mysql_num_rows($my_querxy);
  	$no_of_rows = ($no_of_rows+5);
  	$no_of_rows_new = ($no_of_rows+3);

//================Apply styles============================
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A5:A$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B5:B$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "C5:C$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "D5:D$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "E5:E$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "F5:F$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "G5:G$no_of_rows");
/*$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "H5:H$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "I5:I$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "J5:J$no_of_rows");*/


$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:G4");

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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
/*$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);*/


//======================== Merge cells	======================

//$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
//$objPHPExcel->getActiveSheet()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');
//$objPHPExcel->getActiveSheet()->mergeCells('A$no_of_rows_new:B$no_of_rows_new');


$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('D1:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('E1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('F1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('G1:C'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
/*$objPHPExcel->getActiveSheet()->getStyle('H1:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('I1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('J1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); */


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

	$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Sr. No.' ,'5');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Branch Name','5');
 
 // $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Contact No.','6');
  // $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Email ID','6');
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Campaign Name','5');
	if($_SESSION['type']=='S')
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Name','5');
	}
	$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Mobile No.','5');
	$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Email Id','5');
	$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Added Date','5'); 
	/*  $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Respose Category','5');
  	$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Date','5');
  	$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Status','5');
	*/
	
		  
	$sql_query= "select * from inquiry where status = 'Enquiry' and campaign_id!='' and followup_date IS NULL and enquiry_source!='7' ".$_SESSION['where']." ".$pre_from_date." ".$pre_to_date." ".$search_cm_id." order by added_date desc"; 
	
	if($_SESSION['type']=="S")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Branch by =>');
			$objPHPExcel->getActiveSheet()->SetCellValue('C2', ''.$branch_name.'');
		}
	}
	
	
	 if($_GET['start_date']!='')
	 {
		
	   $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'From Date =>');
	   
	   $objPHPExcel->getActiveSheet()->SetCellValue('E2', ''.$_GET['start_date'].'');
	 }
	 if($_GET['end_date']!='')
	 {
		
	   $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'End Date =>');
	   
	   $objPHPExcel->getActiveSheet()->SetCellValue('E3', ''.$_GET['end_date'].'');
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
	$rowCount=5;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		if($_SESSION['type']=='S')
		{
			$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
			$ptr_branch=mysql_query($sel_branch);
			$data_branch=mysql_fetch_array($ptr_branch);
			  
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $data_branch['branch_name']);						
		}
		$campaign_name=$val_query['campaign_id'];
					
		$sel_cmp="select campaign_name from campaign where c_id='".$campaign_name."'";
		$ptr_cmp=mysql_query($sel_cmp);
		if(mysql_num_rows($ptr_cmp))
		{
			$data_cmp=mysql_fetch_array($ptr_cmp);
			$campaign_name=$data_cmp['campaign_name'];
		}
		
		$sep_date=explode(" ",$val_query['added_date']);
		$sep=explode("-",$sep_date[0]);
		$added_date=$sep[2].'/'.$sep[1].'/'.$sep[0];
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $campaign_name);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $val_query['firstname'].' '.$val_query['lastname']);		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $val_query['mobile1']);	
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $val_query['email_id']);	
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $added_date);			
		
		
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
$objWriter->save('excel_files/Campaign_Inquiry_of_'.$branch_name.'_Branch_'.date('Y-m-d').'.xlsx');
//$objWriter->save('php://output');
ob_end_flush();

?>
<a href="index.php">Back</a>
<script>
document.location.href='campaign_exports_set.php?branch_name=<?php echo $branch_name; ?>';
</script>


