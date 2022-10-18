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
			
			//$pre_keyword =" and (name like '%".$keyword."%' || username like '%".$keyword."%' || contact like '%".$keyword."%' ".$cm_id_filter." ".$course_name_filter." ".$enquiry_added." || address like '%".$keyword."%' || mail like '%".$keyword."%' || status like '%".$keyword."%' || enquiry_source like '%".$keyword."%' || response like '%".$keyword."%')";
			$pre_keyword =" and (firstname like '%".$keyword."%' || middlename like '%".$keyword."%' || lastname like '%".$keyword."%' || username like '%".$keyword."%' || mobile1 like '%".$keyword."%' || mobile2 like '%".$keyword."%' ".$course_name_filter." || address like '%".$keyword."%' || email_id like '%".$keyword."%')";
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
			$search_cm_id_s=" and cm_id='".$data_cm_id['cm_id']."'";
			
		}
		else
		{
			$search_cm_id='';
			$search_cm_id_s='';
		}
	}
	$lead_grade_by='';
	if($_REQUEST['lead_grade_by'])
	{
		$lead_grade_by=" and lead_grade='".$_REQUEST['lead_grade_by']."'";
	}
	$status_type='';
	if($_REQUEST['status_type'])
	{
		
		$status_tp=$_REQUEST['status_type'];
		if($status_tp=='all_campaign')
		{
			$status_type=" and campaign_id!=''";
		}
		else if($status_tp=='all_enquiries')
		{
			$status_type=" and status = 'Enquiry'";
		}
		else if($status_tp=='all_enrolled')
		{
			$status_type=" and status = 'Enrolled'";
		}
		else if($status_tp=='all_closed')
		{
			$status_type=" and status = 'Cancelled'";
		}							
	}
	if($_REQUEST['date_by']=="followup_by")
	{
		if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="From Date")
		{
			 $frm_date=explode("/",$_REQUEST['start_date']);
			 $frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
			 
			$pre_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
		}
		else
		{
			$pre_from_date="";                            
		}
		if($_REQUEST['end_date'] && $_REQUEST['end_date']!=="0000-00-00" && $_REQUEST['end_date']!="To Date")
		{
			$to_date=explode("/",$_REQUEST['end_date']);
			$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
			 
			$pre_to_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
		}
		else
			$pre_to_date="";
	}
	else
	{						
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
	}
		
	
	$enquiry_added='';
	if($_REQUEST['enquiry_added'])
	{
		$enquiry_ad=$_REQUEST['enquiry_added'];
		$enquiry_added="and admin_id='".$enquiry_ad."'";
	}
	$assigned_to='';
	if($_REQUEST['assigned_to'])
	{
		$assigned=$_REQUEST['assigned_to'];
		$assigned_to="and employee_id='".$assigned."'";
	}
	
	$enquiry_src='';
	if($_REQUEST['enquiry_src'])
	{
		$enq_src=$_REQUEST['enquiry_src'];
		$enquiry_src=" and enquiry_source = '".$enq_src."'";
	}
	
		
	$response='';
	if($_REQUEST['response'])
	{
		$resp=$_REQUEST['response'];
		$response="and response='".$resp."'";
	}
	else
	{
		$response="and (response !='7' and response!='8' or response is NULL)";
	}
	
	$where_followup='';
	if($_REQUEST['followup_by'])
	{
		$followup_by=$_REQUEST['followup_by'];
		if($followup_by=="followup_pending")
		{
			$where_followup=' and followup_date IS NULL';
		}
		else if($followup_by=="followup_completed")
		{
			$where_followup=' and followup_date IS NOT NULL';
		}
	}
	
	$country='';
	if($_REQUEST['country'])
	{
		$country_id=$_REQUEST['country'];
		$country=" and country_id='".$country_id."'";
	}
	$state='';
	if($_REQUEST['state'])
	{
		$state_id=$_REQUEST['state'];
		$state=" and state_id='".$state_id."'";
	}
	$city='';
	if($_REQUEST['city'])
	{
		$city_id=$_REQUEST['city'];
		$city=" and city_id='".$city_id."'";
	}
	$area='';
	if($_REQUEST['area'])
	{
		$area_id=$_REQUEST['area'];
		$area=" and area_id='".$area_id."'";
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
		

$sel_for_Num_rows="SELECT * FROM inquiry where 1 ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$response." ".$lead_grade_by." ".$country." ".$state." ".$city." ".$area." ".$where_followup." ".$pre_from_date."".$pre_to_date." ".$c_id." order by inquiry_id desc ";
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
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle1, "M5:M$no_of_rows");

$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:M4");

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
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth("30");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
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
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M1:M'.$objPHPExcel->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true); 

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
if($_SESSION['type']=='S')
{
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Branch Name','5');
}
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Name','5');
 
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Contact No.','6');
// $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Email ID','6');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Course Name','5');

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Enquiry Added By','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Enquiry Assigned By','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Enquiry Source','5');

$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Respose Category','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Date','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Status','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L4', 'Description','5');
$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M4', 'Followup Date','5');
//$select_directory='order by student_id desc';                      

		
if($_GET['keyword']!='' || $_GET['keyword']!="Keyword")
{
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
}
if($_SESSION['type']=="S")
{
	if($_REQUEST['branch_name']!='')
	{
		$branch_name=$_REQUEST['branch_name'];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D2', 'Branch by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D3', ''.$branch_name.'');
	}
}
if($_GET['enquiry_added'] !="")
{
	$sel_name="select name from site_setting where admin_id='".$_GET['enquiry_added']."'";
	$ptr_name=mysql_query($sel_name);
	$data_names=mysql_fetch_array($ptr_name);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E2', 'Enquiry added by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E3', ''.$data_names['name'].'');
}
if($_GET['assigned_to'] !="")
{
	$sel_name="select name from site_setting where admin_id='".$_GET['assigned_to']."'";
	$ptr_name=mysql_query($sel_name);
	$data_names=mysql_fetch_array($ptr_name);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F2', 'Assigned to =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F3', ''.$data_names['name'].'');
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
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G2', 'Enquiry source by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G3', ''.$enq_source.'');
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
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H2', 'Response by =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H3', ''.$response.'');
}
if($_GET['start_date']!='')
{
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J2', 'From Date =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K2', ''.$_GET['start_date'].'');
}
if($_GET['end_date']!='')
{
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J3', 'End Date =>');
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K3', ''.$_GET['end_date'].'');
}

$sql_query= "SELECT * FROM inquiry where 1 ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$response." ".$lead_grade_by." ".$country." ".$state." ".$city." ".$area." ".$where_followup." ".$pre_from_date."".$pre_to_date." ".$c_id." order by inquiry_id desc "; 
$query_order=mysql_query($sql_query);
$i=1;
$rowCount=5;
$k=1;

//$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L3', $sql_query);
while($val_query=mysql_fetch_array($query_order))
{
	$sel_curse="select course_name from courses where course_id='".$val_query['course_id']."' ";
	$ptr_course=mysql_query($sel_curse);
	$data_course_name=mysql_fetch_array($ptr_course);
	"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
	$ptr_name=mysql_query($sel_name);
	$data_names=mysql_fetch_array($ptr_name);
	
	$asssign_name=='';
	"<br />".$sel_name_assign="select name from site_setting where admin_id='".$val_query['employee_id']."'";
	$ptr_name_assign=mysql_query($sel_name_assign);
	if(mysql_num_rows($ptr_name_assign))
	{
		$data_names_assign=mysql_fetch_array($ptr_name_assign);
		$asssign_name=$data_names_assign['name'];
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
	if($_SESSION['type']=='S')
	{
		$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		  
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $data_branch['branch_name']);						
	}
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['firstname']." ".$val_query['middlename']." ".$val_query['lastname']);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['mobile1']);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $data_course_name['course_name']);		
	
	//************************************item_description******************************************
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $data_names['name']);	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $asssign_name);	
	//************************************po_qty******************************************
					
	$enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_source']."'";
	$ptr_enq_src=mysql_query($enq_src);
	$data_enq_src=mysql_fetch_array($ptr_enq_src);	
				
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $data_enq_src['campaign_name']);
	//************************************Item rate******************************************
	$response='';
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
	else 
		$response=$val_query['response'];	  
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $response);						
	//************************************Plan Date******************************************
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $val_query['added_date']);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_query['status']);	
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('L'.$rowCount, $val_query['followup_details']);
	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('M'.$rowCount, $val_query['followup_date']);	
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
header('Content-Disposition: attachment;filename="Inquiry_reprot_'.date('Y-m-d').'.xls"');
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