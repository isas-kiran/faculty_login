<?php
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
            $select_installments="select course_id from courses where course_name like '%".$keyword."%' ";
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
            $pre_keyword =" and (firstname like '%".$keyword."%' || middlename like '%".$keyword."%' || lastname like '%".$keyword."%' || username like '%".$keyword."%' || mobile1 like '%".$keyword."%' || mobile2 like '%".$keyword."%' ".$course_name_filter." || address like '%".$keyword."%' || email_id like '%".$keyword."%')";
        }                            
    else
        $pre_keyword="";
        
    $search_cm_id='';
    $branch_name='';
    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
        if($_REQUEST['end_date'] && $_REQUEST['end_date']!="0000-00-00" && $_REQUEST['end_date']!="To Date")
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
    $resps='';
    if($_REQUEST['response'])
    {
        $resp=$_REQUEST['response'];
        $response=" and response='".$resp."'";
    }
    else
    {
        //$resps=" and (response !='7' and response!='8' or response is NULL) ";
        $resps="";
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
    
    $record_cat_id='';
    if($_GET['record_id'] !='')
    {
        $record_cat_id="and inquiry_id='".$_GET['record_id']."' ";
    } 
    $c_id='';
    if($_GET['c_id'] !='')
    {
        $c_id="and campaign_id='".$_GET['c_id']."' ";
    } 
    $cm_ids=='';
    if($_SESSION['where'] !='')
    {
        $cm_ids="and cm_id='".$_SESSION['cm_id']."'";
    }
    
    $select_directory='order by inquiry_id desc';                      
        
    $sel_for_Num_rows="SELECT * FROM inquiry where 1 and campaign_type='lead_distribution' ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$resps." ".$response." ".$lead_grade_by." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$select_directory."";
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
$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($sharedStyle2, "A4:K4");

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
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth("35");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth("20");
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
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

//======================== Add some data======================

    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A4', 'Sr. No.' ,'5');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B4', 'Name','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C4', 'Contact No.','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D4', 'Email ID','6');
    
    if($_SESSION['type']=='S')
    {
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E4', 'Branch Name','6');
    }
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F4', 'Course Name','6');

    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G4', 'Assigned To','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H4', 'Added By','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I4', 'Enquiry Source','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J4', 'Followup','6');
    $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K4', 'Added Date','6');

	$select_directory='order by inquiry_id desc';                      
	$sql_query= "SELECT * FROM inquiry where 1 and campaign_type='lead_distribution' ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$resps." ".$response." ".$lead_grade_by." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$select_directory.""; 
		
	if($_GET['keyword']!='')
	{
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B2', 'Search by =>');
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C2', ''.$_GET['keyword'].'');
	}

	$query_order=mysql_query($sql_query);
	
	$i=1;
	$rowCount=6;
	$k=1;
	while($val_query=mysql_fetch_array($query_order))
	{
		
		$select_course = "select * from courses where course_id = '".$val_query['course_id']."'  ";
        $val_course= $db->fetch_array($db->query($select_course));
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('A'.$rowCount, $i);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('B'.$rowCount, $val_query['firstname'].' '.$val_query['middlename'].' '.$val_query['lastname']);
		//echo '<br/>'.$contact_fetch4['mo_no'];
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('C'.$rowCount, $val_query['mobile1']);					
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('D'.$rowCount, $val_query['email_id']);
		if($_SESSION['type']=='S')
		{
			$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
			$ptr_branch=mysql_query($sel_branch); 
			$data_branch=mysql_fetch_array($ptr_branch);
			$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('E'.$rowCount, $data_branch['branch_name']);						
		}
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('F'.$rowCount, $val_course['course_name']);		
		
		$sel_name="select name from site_setting where admin_id='".$val_query['employee_id']."'";
		$ptr_name=mysql_query($sel_name);
		$data_name=mysql_fetch_array($ptr_name);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('G'.$rowCount, $data_name['name']);	

        $sel_aname="select name from site_setting where admin_id='".$val_query['admin_id']."'";
		$ptr_aname=mysql_query($sel_aname);
		$data_aname=mysql_fetch_array($ptr_aname);
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('H'.$rowCount, $data_aname['name']);	

        $enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_source']."'";
        $ptr_enq_src=mysql_query($enq_src);
        if(mysql_num_rows($ptr_enq_src))
        {
            $data_enq_src=mysql_fetch_array($ptr_enq_src);
            $enq_source=$data_enq_src['campaign_name'];
        }
		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('I'.$rowCount, $enq_source);	

        if($val_query['followup_date']!='')
        {
            $followup_status='Yes';
        }
        else
            $followup_status='No';
        
        $objPHPExcel->setActiveSheetIndex(0)->SetCellValue('J'.$rowCount, $followup_status);

		$objPHPExcel->setActiveSheetIndex(0)->SetCellValue('K'.$rowCount, $val_query['added_date']);	
		
		$k++;
		$rowCount++;
		$i++;
}
// Miscellaneous glyphs, UTF-8
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="lead_report_'.date('Y-m-d').'.xls"');
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


