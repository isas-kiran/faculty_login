<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php include 'inc_classes.php';?>
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
			/*$sel_course_name="select course_id from courses where course_name like '%".$keyword."%' "; 
			$ptr_course_name=mysql_query($sel_course_name);    
			if(mysql_num_rows($ptr_course_name)) 
			{
				$data_course_name=mysql_fetch_array($ptr_course_name);
				$course_name_filter="|| course_id = '".$data_course_name['course_id']."'";
			}  */
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
			
			$enquiry_added='';
			$sel_enq="select admin_id from site_setting where name like '%".$keyword."%'";
			$ptr_enq=mysql_query($sel_enq);
			if(mysql_num_rows($ptr_enq))
			{
				$data_enq=mysql_fetch_array($ptr_enq);
				$enquiry_added="|| admin_id = '".$data_enq['admin_id']."'";
			}
			
			$pre_keyword =" and (name like '%".$keyword."%' || username like '%".$keyword."%' || contact like '%".$keyword."%' ".$cm_id_filter." ".$course_name_filter." ".$enquiry_added." || address like '%".$keyword."%' || mail like '%".$keyword."%' || status like '%".$keyword."%' || enquiry_source like '%".$keyword."%' || response like '%".$keyword."%')";
		}                            
	else
		$pre_keyword="";
	
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
	$status_type='';
	if($_REQUEST['status_type'])
	{
		
		$status_tp=$_REQUEST['status_type'];
		if($status_tp=='all_campaign')
		{
			$status_type=" and i.campaign_id!=''";
		}
		else if($status_tp=='all_enquiries')
		{
			$status_type=" and i.status = 'Enquiry'";
		}
		else if($status_tp=='all_enrolled')
		{
			$status_type=" and i.status = 'Enrolled'";
		}
		else if($status_tp=='all_closed')
		{
			$status_type=" and i.status = 'Cancelled'";
		}							
	}
	if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
	{
		 $frm_date=explode("/",$_REQUEST['start_date']);
		 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		 
		$pre_from_date=" and DATE(i.followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
	}
	else
	{
		$pre_from_date="";                            
	}
	if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['end_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		 
		$pre_to_date=" and DATE(i.followup_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
	}
	else
		$pre_to_date="";
		
	
	$enquiry_added='';
	if($_REQUEST['enquiry_added'])
	{
		$enquiry_ad=$_REQUEST['enquiry_added'];
		$enquiry_added="and s.admin_id='".$enquiry_ad."'";
	}
	$assigned_to='';
	if($_REQUEST['assigned_to'])
	{
		$assigned=$_REQUEST['assigned_to'];
		$assigned_to="and i.employee_id='".$assigned."'";
	}
	
	$enquiry_src='';
	if($_REQUEST['enquiry_src'])
	{
		$enq_src=$_REQUEST['enquiry_src'];
		$enquiry_src=" and s.enquiry_source = '".$enq_src."'";
	}
		
	$response='';
	if($_REQUEST['response'])
	{
		$resp=$_REQUEST['response'];
		$response="and s.response='".$resp."'";
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
		
		//===============================================================================================
		$branch_id='';
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
		

	$sel_for_Num_rows="SELECT s.student_id,s.status,s.name,s.cm_id,s.contact,s.address,s.mail,s.added_date,s.course_id,s.admin_id,s.enquiry_source,s.response,s.qualification,s.dob,s.class_id,i.employee_id FROM stud_regi s, inquiry i where 1  and s.student_id=i.inquiry_id ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id_s." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$response." ".$pre_from_date."".$pre_to_date." ";
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
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "H5:H$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "I5:I$no_of_rows");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "J5:J$no_of_rows");


$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A4:J4");

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
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


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
$objPHPExcel->getActiveSheet()->getStyle('H1:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('I1:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('J1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 


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
 $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Name','5');
 
 // $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Contact No.','6');
  // $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Email ID','6');
  $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Course Name','5');
 if($_SESSION['type']=='S')
{
  $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Branch Name','5');
}
  $objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Enquiry Added By','5');
  $objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Enquiry Assigned By','5');
  $objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Enquiry Source','5');
  
  $objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Respose Category','5');
  $objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Date','5');
  $objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Status','5');
 
 
 
		$select_directory='order by s.student_id desc';                      
		$sql_query= "SELECT s.student_id,s.status,s.name,s.cm_id,s.contact,s.address,s.mail,s.added_date,s.course_id,s.admin_id,s.enquiry_source,s.response,s.qualification,s.dob,s.class_id,i.employee_id FROM stud_regi s, inquiry i where 1  and s.student_id=i.inquiry_id ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id_s." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$response." ".$pre_from_date."".$pre_to_date." ".$select_directory.""; 
		
	 if($_GET['keyword']!='' || $_GET['keyword']!="Keyword")
	 {
	   $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Search by =>');
	   
	   $objPHPExcel->getActiveSheet()->SetCellValue('C2', ''.$_GET['keyword'].'');
	 }
	if($_SESSION['type']=="S")
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Branch by =>');
			$objPHPExcel->getActiveSheet()->SetCellValue('D3', ''.$branch_name.'');
		}
	}
	if($_GET['enquiry_added'] !="")
	{
		$sel_name="select name from site_setting where admin_id='".$_GET['enquiry_added']."'";
		$ptr_name=mysql_query($sel_name);
		$data_names=mysql_fetch_array($ptr_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Enquiry added by =>');
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', ''.$data_names['name'].'');
	}
	if($_GET['assigned_to'] !="")
	{
		$sel_name="select name from site_setting where admin_id='".$_GET['assigned_to']."'";
		$ptr_name=mysql_query($sel_name);
		$data_names=mysql_fetch_array($ptr_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Assigned to =>');
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', ''.$data_names['name'].'');
	}
	if($_GET['enquiry_src']!='')
	{
		$enq_src="select source_name from source where source_id='".$_GET['enquiry_src']."' order by source_name asc";
		$ptr_enq_src=mysql_query($enq_src);
		$data_enq_src=mysql_fetch_array($ptr_enq_src);
		
		//$enq_source=$val_query['campaign_id'];
		"<br/>". $enq_src="select campaign_name from campaign where campaign_id='".$_GET['enquiry_src']."'";
		$ptr_enq_src=mysql_query($enq_src);
		if(mysql_num_rows($ptr_enq_src))
		{
			$data_enq_src=mysql_fetch_array($ptr_enq_src);
			$enq_source=$data_enq_src['campaign_name'];
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Enquiry source by =>');
		$objPHPExcel->getActiveSheet()->SetCellValue('G3', ''.$enq_source.'');
	}
	if($_GET['response']!='')
	{
		if($_GET['response'] == "walk_in" || $_GET['response'] == "1")
		{
			$response="Walk in";
		}
		else if($_GET['response'] == "will_walkin" || $_GET['response'] == "2")
		{
			$response="Will walk in";
		}
		else if($_GET['response'] == "call_back_later" || $_GET['response'] == "3")
		{
			$response="Call Back Later";
		}
		else if($_GET['response'] == "call_not_pickup" || $_GET['response'] == "4")
		{
			$response="Call did not pick up";
		}
		else if($_GET['response'] == "not_reachable" || $_GET['response'] == "5")
		{
			$response="Not reachable";
		}
		else if($_GET['response'] == "call_taken" || $_GET['response'] == "6")
		{
			$response="Call Taken";
		}
	   $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Response by =>');
	   $objPHPExcel->getActiveSheet()->SetCellValue('H3', ''.$response.'');
	 }
	 if($_GET['start_date']!='')
	 {
		
	   $objPHPExcel->getActiveSheet()->SetCellValue('J2', 'From Date =>');
	   
	   $objPHPExcel->getActiveSheet()->SetCellValue('K2', ''.$_GET['start_date'].'');
	 }
	 if($_GET['end_date']!='')
	 {
		
	   $objPHPExcel->getActiveSheet()->SetCellValue('J3', 'End Date =>');
	   
	   $objPHPExcel->getActiveSheet()->SetCellValue('K3', ''.$_GET['end_date'].'');
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
		
		$sel_curse="select course_name from courses where course_id='".$val_query['course_id']."' ";
		$ptr_course=mysql_query($sel_curse);
		$data_course_name=mysql_fetch_array($ptr_course);
		
		"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_names=mysql_fetch_array($ptr_name);
		
		"<br />".$sel_name_assign="select name from site_setting where admin_id='".$val_query['employee_id']."'";
		$ptr_name_assign=mysql_query($sel_name_assign);
		if(mysql_num_rows($ptr_name_assign))
		{
			$data_names_assign=mysql_fetch_array($ptr_name_assign);
			$asssign_name=$data_names_assign['name'];
		}
		else
		{
			$asssign_name="Self";
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $val_query['name']."\n".$val_query['contact']);
		//echo '<br/>'.$contact_fetch4['mo_no'];
		//$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $val_query['contact']);					
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $val_query['mail']);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $data_course_name['course_name']);		
		if($_SESSION['type']=='S')
		{
			$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
			$ptr_branch=mysql_query($sel_branch);
			$data_branch=mysql_fetch_array($ptr_branch);
			  
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $data_branch['branch_name']);						
		}
		/************************************item_description******************************************/	
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $data_names['name']);	
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $asssign_name);	
		/************************************po_qty******************************************/
						
		$enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_source']."'";
		$ptr_enq_src=mysql_query($enq_src);
		$data_enq_src=mysql_fetch_array($ptr_enq_src);	
				
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $data_enq_src['campaign_name']);			
							
				
			 
		 /************************************Item rate******************************************/
		if($val_query['response'] == "walk_in" || $val_query['response'] == "1")
		{
			$response="Walk in";
		}
		else if($val_query['response'] == "will_walkin" || $val_query['response'] == "2")
		{
			$response="Will walk in";
		}
		else if($val_query['response'] == "call_back_later" || $val_query['response'] == "3")
		{
			$response="Call Back Later";
		}
		else if($val_query['response'] == "call_not_pickup" || $val_query['response'] == "4")
		{
			$response="Call not pick up";
		}
		else if($val_query['response'] == "not_reachable" || $val_query['response'] == "5")
		{
			$response="Not reachable";
		}
		else if($val_query['response'] == "call_taken" || $val_query['response'] == "6")
		{
			$response="Call Taken";
		}				
						  
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $response);	
							
		/************************************Plan Date******************************************/
			
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_query['added_date']);
			
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $val_query['status']);	
		
				
		
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
$objWriter->save('excel_files/Inquiry_'.date('Y-m-d').'.xlsx');
//$objWriter->save('php://output');
ob_end_flush();

?>
<a href="manage_student.php">Back</a>
<script>
document.location.href='exports.php';
</script>
</html>

