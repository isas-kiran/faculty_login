<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
.hr_line { border: 0; border-bottom: 1px dashed #ccc; background: #999; }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Action Form</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    <script>
	
	jQuery(document).ready( function() 
	{
		//$("#user_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	jQuery(document).ready( function() 
	{
		//$("#counc1_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		//$("#inform_bop_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		//$("#inform_counc_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		//$("#inform_faculty_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	
</script>
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
    </script>
   	<script>
	function calculate_grade(course_id,ids)
	{
		alert(course_id);
		/*var theory_mark=document.getElementById('theory_grade_'+course_id+'_'+ids+'').value;
		var practical_mark=document.getElementById('practical_grade_'+course_id+'_'+ids+'').value;
		if(theory_mark!='' && practical_mark!='')
		{
			var data12="action=basic_course&course_id="+course_id+"&ids="+ids+"&theory_mark="+theory_mark+"&practical_mark="+practical_mark;
			alert(data12);
			$.ajax({
				url: "get_grade_calculation.php", type: "post", data: data12, cache: false,
				success: function (html)
				{
					alert(html);
				}
			});
		}
		else
		{
			alert("Please Enter Theory Mark and Practical Mark");
		}*/
	}
   </script>
    </head>
<body>
<?php include "include/header.php";?>
<div id="info"> 
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
	<?php
    if($_POST['save_changes'])
    {
        $sche_action=$_POST['sche_action'];
        $batch_action=$_POST['batch_action'];
        $logsheet_action=$_POST['logsheet_action'];
        
        $name=$_POST['name'];
        if($_POST['logsheet_date'] !='')
        {
            $logsheet_dates= explode('/',$_POST['logsheet_date'],3);     
            $logsheet_date= $logsheet_dates[2].'-'.$logsheet_dates[1].'-'.$logsheet_dates[0];
        }
        if($_POST['sche_date'] !='')
        {
            $arrage_sche_date= explode('/',$_POST['sche_date'],3);     
            $arrage_sche_dates= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
        }
        if($_POST['batch_date'] !='')
        {
            $arrage_dates= explode('/',$_POST['batch_date'],3);     
            $date= $arrage_dates[2].'-'.$arrage_dates[1].'-'.$arrage_dates[0];
        }
        $counc_id=$_POST['counc_id']; 
        $counc1_id=$_POST['counc1_id'];
        $logsheet_councellor=$_POST['logsheet_councellor']; 
        
        //$inform_bop=$_POST['inform_bop'];
        $inform_counc=$_POST['inform_counc'];
        $inform_faculty=$_POST['inform_faculty'];
        
        //$inform_bop_id=$_POST['inform_bop_id']; 
        $inform_counc_id=$_POST['inform_counc_id'];
        $inform_faculty_id=$_POST['inform_faculty_id'];
        $enroll_id=$record_id;
        
        $data_record['enroll_id'] =$enroll_id;
        $data_record['schedule_Induction'] =$sche_action;
        $data_record['batch_schedule'] =$batch_action;
        $data_record['logsheet_schedule'] =$logsheet_action;
        
        $data_record['schedule_date'] =$date1;
        $data_record['batch_date'] =$date;
        $data_record['logsheet_date'] =$logsheet_date;
        
        $data_record['schedule_councellor'] =$counc_id;
        $data_record['batch_councellor'] = $counc1_id;
        $data_record['logsheet_councellor'] =$logsheet_councellor;
        
        //$data_record['inform_bop'] =$inform_bop_id;
        $data_record['inform_councellor'] =$inform_counc_id;
        $data_record['inform_faculty'] =$inform_faculty_id;
        $data_record['added_date'] =date('Y-m-d h:i:s');
        $data_record['admin_id']=$_SESSION['admin_id'];
        if($record_id)
        {
            $delete_cnc="delete from action_councellor where enroll_id='".$data_record['enroll_id']."'";
            $ptr_del=mysql_query($delete_cnc);
            
            $delete_cer="delete from action_certificate where enroll_id='".$data_record['enroll_id']."'";
            $ptr_del_cer=mysql_query($delete_cer);
            
            $delete_final="delete from action_final where enroll_id='".$data_record['enroll_id']."'";
            $ptr_del_final=mysql_query($delete_final);
            
            $schedule_date= explode('/',$data_record['schedule_date'],3);     
            $schedule_date= $schedule_date[2].'-'.$schedule_date[1].'-'.$schedule_date[0];
            
            "<br/>".$insert_into_councellor= "INSERT INTO `action_councellor` (`enroll_id`, `schedule_Induction`, `batch_schedule`, `schedule_date`,`batch_date`,`schedule_councellor`,`batch_councellor`,`logsheet_schedule`,`logsheet_date`,`logsheet_councellor`,`added_date`,`action_by_status`, `admin_id`) VALUES ('".$data_record['enroll_id']."', '".$data_record['schedule_Induction']."','".$data_record['batch_schedule']."', '".$arrage_sche_dates."', '".$data_record['batch_date']."', '".$data_record['schedule_councellor']."', '".$data_record['batch_councellor']."','".$logsheet_action."','".$logsheet_date."','".$data_record['logsheet_councellor']."', '".date('Y-m-d H:i:s')."','done','".$data_record['admin_id']."')";
            $ptr_isert_invp = mysql_query($insert_into_councellor);
            
            $total_main_course=$_POST['total_main_course']; //============Total Main Course======
            
            //==================================================ACTION CERTIFICATE=================================================
            for($i=1;$i<=$total_main_course;$i++)
            {
                $total_sub_course=$_POST['total_course_'.$i.''];
                if($total_sub_course > 0)
                {
                    echo "<br/>".$ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`, `theory_grade`, `practical_grade`, `course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['course_id_'.$i.'']."','0','".$_POST['course_status_'.$i.'']."','".$_POST['theory_grade_'.$i.'']."','".$_POST['practical_grade_'.$i.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                    $ptr_certificate=mysql_query($ins_certificate);
                    $main_course_ids=mysql_insert_id();
                    for($j=1;$j<=$total_sub_course;$j++)
                    {
                        if($_POST['course_status_date_'.$i.'_'.$j.''] !='')
                        {
                            $sep_dates= explode('/',$_POST['course_status_date_'.$i.'_'.$j.''],3);     
                            $course_status_date= $sep_dates[2].'-'.$sep_dates[1].'-'.$sep_dates[0];
                        }
                        "<br/>".$ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`, `theory_grade`, `practical_grade`, `course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['course_id_'.$i.'_'.$j.'']."','".$_POST['course_id_'.$i.'']."','".$_POST['course_status_'.$i.'_'.$j.'']."','".$_POST['theory_grade_'.$i.'_'.$j.'']."','".$_POST['practical_grade_'.$i.'_'.$j.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                        $ptr_certificate=mysql_query($ins_certificate);
                    }
                }
                else
                {
                    if($_POST['course_status_date_'.$i.''] !='')
                    {
                        $sep_dates= explode('/',$_POST['course_status_date_'.$i.''],3);     
                        $course_status_date= $sep_dates[2].'-'.$sep_dates[1].'-'.$sep_dates[0];
                    }
                    "<br/>".$ins_certificate="INSERT INTO `action_certificate`(`enroll_id`, `course_id`,`ref_course_id`,`status`, `theory_grade`, `practical_grade`, `course_status_date`,`cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['course_id_'.$i.'']."','0','".$_POST['course_status_'.$i.'']."','".$_POST['theory_grade_'.$i.'']."','".$_POST['practical_grade_'.$i.'']."','".$course_status_date."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                    $ptr_certificate=mysql_query($ins_certificate);
                }
            }
            //=====================================================END==========================================================================
            //=====================================================ACTION SAVE DATES============================================================
            for($i=1;$i<=$total_main_course;$i++)
            {
                //$total_sub_course=$_POST['total_course_'.$i.''];
                $complition_date='';
                if($_POST['complition_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['complition_date_'.$i.''],3);     
                    $complition_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $payment_complition_date='';
                if($_POST['payment_complition_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['payment_complition_date_'.$i.''],3);     
                    $payment_complition_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $logbook_date='';
                if($_POST['logbook_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['logbook_date_'.$i.''],3);     
                    $logbook_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $print_certificate_date='';
                if($_POST['print_certificate_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['print_certificate_date_'.$i.''],3);     
                    $print_certificate_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                $certificate_issue_date='';
                if($_POST['certificate_issue_date_'.$i.''] !='')
                {
                    $arrage_sche_date= explode('/',$_POST['certificate_issue_date_'.$i.''],3);     
                    "<br/>".$certificate_issue_date= $arrage_sche_date[2].'-'.$arrage_sche_date[1].'-'.$arrage_sche_date[0];
                }
                
                $certificate_issue_staff_id=( ($_POST['certificate_issue_staff_id_'.$i.''])) ? $_POST['certificate_issue_staff_id_'.$i.''] : "0";
                
                 "<br/>".$sel_final="INSERT INTO `action_final`(`enroll_id`,`course_id`, `completion_date`, `payment_cleared_date`, `payment_cleared_action`, `logbook_completed_date`, `logbook_completed_action`, `certificate_print_date`, `print_certificate_action`,`certificate_type`, `certificate_issue_date`, `issue_certificate_action`, `certificate_by_staff`, `cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['course_id_'.$i.'']."','".$complition_date."','".$payment_complition_date."','".$_POST['payment_cleared_'.$i.'']."','".$logbook_date."','".$_POST['logbook_action_'.$i.'']."','".$print_certificate_date."','".$_POST['certificate_printed_'.$i.'']."','".$_POST['certificate_type_'.$i.'']."','".$certificate_issue_date."','".$_POST['certificate_issued_'.$i.'']."','".$certificate_issue_staff_id."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
                $ptr_certificate=mysql_query($sel_final);
                //'".$_POST['google_testominal']."','".$_POST['justdial_testominal']."','".$_POST['video_taken']."',
            }//`google_action`, `justdial_Action`, `video_action`, 
            //==========================================================END===================================================================
            //==========================================================TESTOMINAL============================================================
            $ins_testo="INSERT INTO `action_testominal`(`enroll_id`,`google_action`, `justdial_action`, `video_action`,`staff_id`, `cm_id`, `admin_id`, `added_date`) VALUES ('".$data_record['enroll_id']."','".$_POST['google_testominal']."','".$_POST['justdial_testominal']."','".$_POST['video_taken']."','".$_POST['staff_ids']."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
            $ptr_testominal=mysql_query($ins_testo);
            //==========================================================END===================================================================
        }
        else
        {
            //$db->query_insert("pay_balace_bill_mapping", $data_college);
            //echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
        }
        $success=1;
    }                               

	if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$pre_from_date=" and date_format(added_date,'%Y-%m-%d')>='".date('Y-m-d',strtotime($_REQUEST['from_date']))."'";
        /*$sql_previos_total= "SELECT sum(amount) as credits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Credit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
        $row_previos_total=$db->fetch_array($db->query($sql_previos_total));
        $sql_previos_total1= "SELECT sum(amount) as debits FROM dd_user_payement where status='Active' and user_id='".$_SESSION['user_id']."' and debit_credit='Debit' and added_date<'".$_REQUEST['from_date']." 00:00:00'";
        $row_previos_total1=$db->fetch_array($db->query($sql_previos_total1));
	    $balance=$row_previos_total['credits']-$row_previos_total1['debits'];*/
    }
	else
    {
    	$balance=0;
    	$pre_from_date="";                            
    }
	$sql_records= "SELECT * FROM invoice where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  
	order by invoice_id desc limit 0,1 ";
	$all_records = mysql_query($sql_records);
	$no_of_records=mysql_num_rows($db->query($sql_records));
	if($no_of_records)
	{    
		$bgColorCounter=1;
		if(!$_SESSION['showRecords'])
			$_SESSION['showRecords']=10;
		?>
        <form method="post" name="frmTakeAction">
        <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr><td valign="middle" align="right">
        	<table width="100%" cellpadding="0" callspacing="0" border="0">
            	<tr>
                <?php
                if($no_of_records>10)
                {
                    echo '<td width="3%" align="left">Show</td>
                    <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                    for($s=0;$s<count($show_records);$s++)
                    {
                        if($_SESSION['show_records']==$show_records[$s])
                            echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                        else
                            echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                    }
                    echo'</td></select>';
                }
                ?>
                <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no, toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>

                <img src='images/view.jpeg' title='View Invoice' border='0' onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
                <img src='images/print1.jpeg' onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                </td>-->
                <td height="2" align="right"></td>
                </tr>
            </table>
			</td>
        </tr>
        <tr><td height="10"></td></tr>
        <tr>
        <td valign="top" colspan="2">
        <table cellspacing="1"  cellpadding="5" style="width: 100%;" align="center">
        <?php
		while($val_record=mysql_fetch_array($all_records))
		{
			$invoice_no= $val_record['invoice_id'];
			if($bgColorCounter%2==0)
				$bgcolor='class="grey_td"';
			else
				$bgcolor=""; 
			 $enroll_id=$val_record['enroll_id'];
			 $paid_totas=0;
			/*if($bgColorCounter%2==0)
				$bgclass="tr-sub_white1";
			else
				$bgclass="tr-sub1";*/
			include "include/paging_script.php";
			echo '<tr class="'.$bgclass.'">';
			//echo '<td align="center">'.$sr_no.'</td>';
			
			$name ='';
			$email_id = '';
			$phone_no ='';

			$select_firstname = " select * from enrollment where enroll_id='".$record_id."' ";
			$ptr_query=mysql_query($select_firstname);
			$data_select = mysql_fetch_array($ptr_query);
			//$invoice= $data_select['invoice_no'];
			?>
			<tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Personal Details</strong></td></tr>
			<!--<tr>
			<td colspan="2">
				<table align="center" width="100%" cellpadding="5" cellspacing="0"
				bgcolor="#EFEFEF" >
				<tr>
					<td width="21%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Roll No</span></td><td width="24%"><?php //echo $enroll_id;?></td>
					<td width="22%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Receipt No</span></td><td width="33%"><?php //echo $invoice_no; ?></td>
				</tr>
				<tr>
					<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">GST No.</span></td><td>27AADFI5575R1ZK</td>
					<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Invoice No.</span></td><td width="33%" ><?php //echo $invoice_no; ?></td>
				</tr>
				</table>
			</td>
			</tr>-->
			<?php
			$date_new=explode("-",$data_select['added_date']);
			$admission_date=$date_new[2].'/'.$date_new['1'].'/'.$date_new['0'];
			echo '<tr><td width="21%"><strong>Admission Date</strong></td><td align="left" style="padding-left:5px;"><b>'.$admission_date.'<input type="hidden" name="name" value="'.$data_select['name'].'" ></td></tr>';
            echo '<tr><td width="21%"><strong>Enrooment No.</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['installment_display_id'].'<input type="hidden" name="name" value="'.$data_select['name'].'" ></td></tr>';
			echo '<tr><td width="21%"><strong>Student Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'<input type="hidden" name="name" value="'.$data_select['name'].'" ></td></tr>';
            echo '<tr><td width="21%"><strong>Contact No.</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['contact'].'</b></td></tr>';
            echo '<tr><td width="21%"><strong>Email Id </strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['mail'].'</b></td></tr>';
            echo '<tr><td width="21%"><strong>Address</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['address'].'</b></td></tr>';
            echo '<tr><td width="21%"><strong>DOB</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['dob'].'</b></td></tr>';
            $paid=$data_select['paid'];
            //echo '<tr><td><strong>Down Payment</strong></td><td align="left">'.$data_select['down_payment'].'</td></tr>'; 
            if($data_select['paid'] !='')
            {
            }
            ?> 
            <!--<tr><td width="37%"><strong>Deposite Amount</strong></td><td width="63%" align="left"><input type="text" name="amount_paid" id="amount_paid" onkeyup="calculate_total(this.value)" value="" > </td></tr>-->
			
                <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Outstanding Details</strong></td></tr>	
               
                <tr>
                    <td colspan="2">
                        <table align="center" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF" >
                        <tr bgcolor="#A8A8A8">
                            <td width="20%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Outstanding Type</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style=" font-weight:bold">Category/Invoice no.</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Total Amount</span></td> 
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Paid Amount</span></td>
                            <td width="20%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Remaining Amount</span></td>
                            <td width="45%" align="left" style="padding-left:10px;"><span style="font-weight:bold">Reason/Description</span></td>
                        </tr>
                        <?php
						$sel_outstand="select * from enroll_outstanding where enroll_id='".$record_id."' and remaining_amount>0";
						$ptr_outstand=mysql_query($sel_outstand);
						if(mysql_num_rows($ptr_outstand))
						{
							while($data_outstand=mysql_fetch_array($ptr_outstand))
							{
								?>
                            	<tr>
                                	<td align="left" style="padding-left:10px;"><span style="font-weight:bold">Debit/Credit Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_outstand['type']); ?> </span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['payble_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style=" font-weight:bold"><?php echo intval($data_outstand['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_outstand['reason']; ?></span></td>    
                                </tr>
                             	<?php
							}
						}
						?>
                        <?php
						$sel_prod_out="select * from sales_product where customer_id='".$record_id."' and type='Student' and remaining_amount>0";
						$ptr_prod_out=mysql_query($sel_prod_out);
						if(mysql_num_rows($ptr_prod_out))
						{
							while($data_prod_out=mysql_fetch_array($ptr_prod_out))
							{
								?>
                                <tr>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold">Product Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['sales_product_id']); ?> </span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['total_price']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['payable_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_prod_out['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_prod_out['reason']; ?></span></td>    
                                </tr>
                                <?php
							}
						}
						?>
                        <?php
						$sel_serv_out="select * from customer_service where customer_id='".$record_id."' and type='Student' and remaining_amount>0";
						$ptr_serv_out=mysql_query($sel_serv_out);
						if(mysql_num_rows($ptr_serv_out))
						{
							while($data_serv_out=mysql_fetch_array($ptr_serv_out))
							{
								?>
                                <tr>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold">Product Outstanding</span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['customer_service_id']); ?> </span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['payable_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo intval($data_serv_out['remaining_amount']); ?></span></td>
                                    <td align="left" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_serv_out['followup_desc']; ?></span></td>    
                                </tr>
                                <?php
							}
						}
						?>
                        </table>
                    </td>
                </tr>
                
                        <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Action (Enrollment Related)</strong></td></tr>
                                          
                            <tr><td colspan="2">
							<table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
                        
                        	<tr bgcolor="#A8A8A8">
                            	<td width="36%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Name</span></td>
                                <td width="19%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>      
                                <td width="18%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                <td width="27%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Councellor Name</span></td>
                            </tr>
                            
                            <?php 
							$schedule_date='';
							$batch_date='';
							$logsheet_date='';
							$batch_councellor='';
							$schedule_councellor='';
							$logsheet_councellor='';
							$inform_bop='';
							
							$sel="select * from action_councellor where enroll_id=".$record_id."";
							$ptr_sel= mysql_query($sel);
							if(mysql_num_rows($ptr_sel))
							{
								$data_sel=mysql_fetch_array($ptr_sel);
								$schedule_date=date("d/m/Y", strtotime($data_sel['schedule_date']));
								$batch_date=date("d/m/Y", strtotime($data_sel['batch_date']));
								$logsheet_date=date("d/m/Y", strtotime($data_sel['logsheet_date']));
								
								$schedule_councellor=$data_sel['schedule_councellor'];
								$batch_councellor=$data_sel['batch_councellor'];
								$logsheet_councellor=$data_sel['logsheet_councellor'];
								$inform_bop=$data_sel['inform_bop'];
							}
							
							?>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Logsheet</span></td>
								<?php
								if($_SESSION['type']=="S" && $data_sel['logsheet_schedule']=="yes")
								{
									?>
									<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="logsheet_action"  <?php if($data_sel['logsheet_schedule']=='yes') {echo 'checked="checked"' ;} ?>  value="yes" /></span></td>
									<?php
								}
								else if($data_sel['logsheet_schedule']=="yes")
								{
									?>
									<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="hidden"  name="logsheet_action" value="yes" /><?php if($data_sel['logsheet_schedule']=='yes') {echo '<img src="images/active_icon.png" border="0" width="30px" height="30px" title="Verified">' ;} ?></span></td>
									<?php
								}
								else
								{
									?>
									<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="logsheet_action"  <?php if($data_sel['logsheet_schedule']=='yes') {echo 'checked="checked"' ;} ?>  value="yes" /></span></td>
									<?php
								}
								?>
                                
								
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="logsheet_date" value="<?php if($_POST['logsheet_date']) echo $logsheet_date; else if($logsheet_date !='') echo $logsheet_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date "/></span></td>
								<td align="left"  style="padding-left:10px;">
                                 <select name="logsheet_councellor" id="logsheet_councellor" class="input_select" style="width:150px;">                        
									<?php 
									$select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";
									$ptr_faculty = mysql_query($select_faculty);
									while($data_faculty = mysql_fetch_array($ptr_faculty))
									{ 
										$class3 = '';
										if($logsheet_councellor !='')
										{
											if($data_faculty['admin_id'] == $logsheet_councellor)
											{  
												$class3 = 'selected="selected"';
											}
										}
										else
										{
											if($data_faculty['admin_id'] == $_SESSION['admin_id'])
											{  
												$class3 = 'selected="selected"';
											}
										}
										echo '<option value="'.$data_faculty['admin_id'].'" '.$class3.' >'.$data_faculty['name'].' </option>';     
									}
                                      ?>        
                                </select>
                                </td>
                            </tr>
							<?php 
							$disabled="disabled";
							if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=="C")
							{
								$disabled="";
							}
							?>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Schedule Induction (Only For Councelor & Admin)</span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox"  name="sche_action" <?php if($data_sel['schedule_Induction']=='yes') {echo 'checked="checked"' ;}  echo $disabled; ?> value="yes"/></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" value="<?php if($_POST['sche_date']) echo $_POST['sche_date']; else if($arrage_sche_dates !='') echo $arrage_sche_dates; else echo date('d/m/Y'); ?>" <?php echo $disabled; ?> name="sche_date"  class="datepicker" placeholder="Action date "/></span></td>
                                <td align="left"  style="padding-left:10px;">
                                <select  name="counc_id" id="counc_id" class="input_select" style="width:150px;" <?php echo $disabled; ?> >                        
								<?php 
                                    $select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";//select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc
                                    $ptr_faculty = mysql_query($select_faculty);
                                    while($data_faculty = mysql_fetch_array($ptr_faculty))
                                    { 
                                        $class1 = '';
                                        if($schedule_councellor!='')
                                        {
                                            if($data_faculty['admin_id'] == $schedule_councellor)
                                            {  
                                                $class1 = 'selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            if($data_faculty['admin_id'] == $_SESSION['admin_id'])
                                            {  
                                                $class1 = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class1.' >'.$data_faculty['name'].' </option>';     
                                    }
                                ?>        
                                </select>
                                </td>
                                

                            </tr>
							<?php 
							$disabled_cm="disabled";
							if($_SESSION['type']=="S" || $_SESSION['type']=="A" )
							{
								$disabled_cm="";
							}
							?>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Batch schedule (Only For Admin)</span></td>
                            	<td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox" <?php echo $disabled_cm; ?> name="batch_action"  <?php if($data_sel['batch_schedule']=='yes') {echo 'checked="checked"' ;} ?>  value="yes" /></span></td>
                               	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="batch_date" <?php echo $disabled_cm; ?> value="<?php if($_POST['batch_date']) echo $_POST['batch_date']; else if($batch_date !='') echo $batch_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Action date "/></span></td>
                               	<td align="left"  style="padding-left:10px;">
                               	<select name="counc1_id" id="counc1_id" <?php echo $disabled_cm; ?> class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class2 = '';
											if($batch_councellor !='')
											{
												if($data_faculty['admin_id'] == $batch_councellor)
												{  
													$class2 = 'selected="selected"';
												}
											}
											else
											{
												if($data_faculty['admin_id'] ==$_SESSION['admin_id'])
												{  
													$class2 = 'selected="selected"';
												}
											}
                                        	echo '<option value="'.$data_faculty['admin_id'].'" '.$class2.' >'.$data_faculty['name'].' </option>';     
                                      	}
                                      ?>        
                               	</select>
                               	</td>
                            </tr>
                            
                        </table>
                        </td>
                        </tr> 
                        <tr bgcolor="#EFEFEF">
                        	<td colspan="3" align="center" style="font-size:12px"><strong>Student Kit Issued</strong></td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                                <table align="center"  width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF" >
                                    <tr bgcolor="#A8A8A8">
                                        <td width="5%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Sr. No</span></td>
                                        <td width="20%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Product Issued</span></td>      
                                        <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Quantity</span></td>
                                        <td width="16%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                        <td width="18%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Staff</span></td>
                                        <td width="5%" align="center"  style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>
                                    </tr>
                                    
									<?php
                                    $sql_query1 = "select * from student_kit_map where enroll_id='".$record_id."' ".$_SESSION['where']." order by student_kit_id asc ";
                                    $ptr_querys1=mysql_query($sql_query1);
									if($total=mysql_num_rows($ptr_querys1))
									{
										$s=1;
										while($data_queries1=mysql_fetch_array($ptr_querys1))
										{
											$sel_tel = "select product_id,product_name,quantity from product where 1 and product_id='".$data_queries1['product_id']."' ".$_SESSION['where']." order by product_id asc";	
											$query_tel = mysql_query($sel_tel);
											$data=mysql_fetch_array($query_tel);
											$names=$data['product_name'];
											
											"<br/>".$sele_admin="select name from site_setting where admin_id='".$data_queries1['admin_id']."' ";
											$ptr_admin=mysql_query($sele_admin);
											$data_name=mysql_fetch_array($ptr_admin);
											
											$dates=explode(" ",$data_queries1["added_date"]);
											$new_date=explode("-",$dates[0]);
											$kit_date=$new_date[2]."/".$new_date[1]."/".$new_date[0];
											$disabled='';
											if($_SESSION['type']!="S"  || $_SESSION['type']!="A")
											{
												$disabled="disabled";
											}
											echo '<tr><td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$s.'</span></td>';
											echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$names.'</span></td>';
											echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$data_queries1["product_qty"].'</span></td>';
											echo '<td align="center" style="padding-left:10px;"><input type="text" name="kit_issue_date" '.$disabled.' id="kit_issue_date" class="datepicker" value="'.$kit_date.'" /></td>';
											echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold">'.$data_name["name"].'</span></td>';
											echo '<td align="center" style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" '.$disabled.' checked name="kit_action[]" id="kit_action'.$i.'"</span></td></tr>';
											$s++;
										}
									}
									?>
                                    
                                </table>
                            </td>
                        </tr>       
                        	<!--<tr><td colspan="2">
							<table align="center" border="0px" width="100%" cellpadding="4" cellspacing="0">
                        	<tr bgcolor="#EFEFEF">
                            	<td width="32%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Inform BOP for kit</span></td>
                                <td width="44%" align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" name="inform_bop" <?php //if($data_sel['inform_bop']!='') {echo 'checked="checked"' ;}?> value="inform_bop" /></span></td>
                                <td width="33%" >
                                 <select name="inform_bop_id " id="inform_bop_id" class="input_select" style="width:150px;">                        
									<?php 
                                        /* $select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class4 = '';
											if($inform_bop !='')
											{
												if($data_faculty['admin_id'] == $inform_bop)
												{  
													$class4 = 'selected="selected"';
												}
											}
											else 
											{
												if($data_faculty['admin_id'] == $_SESSION['admin_id'])
												{  
													$class4 = 'selected="selected"';
												}
											}
                                        	echo '<option value="'.$data_faculty['admin_id'].'" '.$class4.' >'.$data_faculty['name'].' </option>';     
                                        } */
                                        ?>        
                                </select>
                                </td>
                                </tr>
                           		
                            </table>
                            </td>
                            </tr>-->
							<tr>
								<td colspan="2" style=" font-size:12px; font-weight:bold" align="center">Action (Certificate Related)</td>
							</tr>
                            
							<tr>
								<td colspan="2">
									<table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
                                    <!--<tr>
                                        <td height="46" colspan="8" align="center" style=" font-size:12px; font-weight:bold"><strong>Course Details</strong></td>
                                    </tr>-->
									<!--<tr bgcolor="#A8A8A8">
										<td width="5%" align="center"><span style="font-weight:bold">Sr. No</span></td>
										<td width="30%" align="center"><span style="font-weight:bold">Course Name</span></td>
										<td width="10%" align="center"><span style="font-weight:bold">Date</span></td>
										<td width="35%" align="center"><span style="font-weight:bold">Status</span></td>  
										<td width="10%" align="center"><span style="font-weight:bold">Theory Grade</span></td>  
										<td width="10%" align="center"><span style="font-weight:bold">Practical Grade</span></td>  
									</tr>-->
									<?php
									$sel_courses="SELECT * FROM enrollment where 1 and ref_id='".$record_id."' or enroll_id='".$record_id."' ".$_SESSION['where']." ";
									$ptr_courses=mysql_query($sel_courses);
									$tot_course=mysql_num_rows($ptr_courses);
									$c=1;
									while($data_course=mysql_fetch_array($ptr_courses))
									{
										$select_name="select course_name,course_id,is_parent from courses where course_id='".$data_course['course_id']."'";
										$ptr_name=mysql_query($select_name);
										$s=1;
										$data_name=mysql_fetch_array($ptr_name);
										//if($data_name['is_parent']!='')
										?>
                                        <tr bgcolor="#A8A8A8">
                                            <td width="30%" colspan="2" align="center" style="padding-left:10px;"><span style=" font-weight:bold">Course Name</span></td>
                                            <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Course Fee</span></td>      
                                            <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Paid Fee</span></td>
                                            <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Balance Fee</span></td>
                                            <td width="30%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Installments</span></td>
                                            <td width="10%" align="center" style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2" style="padding-left:10px;"><span style="font-weight:bold; font-size:15px"><?php echo $c.'. '.$data_name['course_name']; ?></span></td><input type="hidden" name="course_id_<?php echo $c ;?>" id="course_id_<?php echo $c ;?>" value="<?php echo $data_name['course_id']; ?>" >
                                            <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['net_fees']; ?></span></td>
                                            <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['paid']; ?></span></td>
                                            <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['balance_amt']; ?> </span></td>
                                            <td align="center" style="padding-left:10px;"><span style="font-weight:bold">
                                            <?php
                                            $sel_inst="SELECT * FROM `installment` where enroll_id ='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."'  ";
                                            $ptr_ins=mysql_query($sel_inst);
                                            if(mysql_num_rows($ptr_ins))
                                            {
                                                while($data_inst=mysql_fetch_array($ptr_ins))
                                                {
                                                    $col_paid ='<font color="#006600">';
                                                    if($data_inst['status'] =='not paid')
                                                        $col_paid ='<font color="#FF3333">';
                                                    echo $data_inst['installment_amount'].'/- '.$data_inst['installment_date'].' : '.$col_paid.$data_inst['status']."</font><br>";	
                                                }
                                            }
                                            else
                                            {
                                            }
                                            $sel_inv="SELECT * FROM invoice where enroll_id=".$data_course['enroll_id']." and status='paid'";
                                            $ptr_inv=mysql_query($sel_inv);
                                            while($data_inv=mysql_fetch_array($ptr_inv))
                                            {
                                                $col_paid_inv ='';
                                                $col_paid ='<font color="#FF3333">';
                                                $date_i=explode(" ",$data_inv['added_date']);
                                                $date_invs=$date_i[0];
                                                echo $data_inv['amount'].'/- '.$date_invs.' :<font color="#006600"> '.$data_inv['status'].'</font><br>';	
                                            }
                                            ?>
                                            </span>                                  
                                            </td>
                                            <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_course['added_date']; ?></span></td>
                                        </tr>
                                        
                                        <?php
										
										echo '<tr>';
										$sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_name['course_id']."'";
										$ptr_seldata=mysql_query($sel_data);
										$data_crs=mysql_fetch_array($ptr_seldata);
										
										if($data_crs['status']=="not_started")
											$not_started='checked="checked"';
										else if($data_crs['status']=="started")
											$started='checked="checked"';
										else if($data_crs['status']=="halted")
											$halted='checked="checked"';
										else if($data_crs['status']=="cancelled")
											$cancelled='checked="checked"';
										else if($data_crs['status']=="restart")
											$restart='checked="checked"';
										else if($data_crs['status']=="finished")
											$finished='checked="checked"';
										
										$theory_grade=$data_crs['theory_grade'];
										$practical_grade=$data_crs['practical_grade'];
										if($data_name['is_parent']!='y')
										{
											$crc_id=$data_name['course_id'];
											$course_status_date='';
											if(mysql_num_rows($ptr_seldata))
											{
												$course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
											}
											if($_POST['course_status_date_'.$c.'']) { $course_status_date=$_POST['course_status_date_'.$c.''];} else if($course_status_date !='') { $course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y'); }
											echo '<td><input type="text" name="course_status_date_'.$c.'" id="course_status_date_'.$c.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
											
											echo '<td><table width="100%"><tr>';
											echo '<input type="hidden" name="total_sub_course_'.$c.'" id="total_sub_course_'.$c.'" value="'.$tot_course.'" >';
										
											echo '<td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="not_started" '.$not_started.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="started" '.$started.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="cancelled" '.$cancelled.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="restart"'.$restart.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="finished" '.$finished.' ></td><tr>
											<tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td>
											</tr></table>';
											echo '</td>';
											
											$disabled_grades="disabled";
											if($data_crs['status']=="finished" && ($_SESSION['type']=="S" || $_SESSION['type']=="A") )
											{
												$disabled_grades="";
											}
											echo '<td><strong>Theory Grade</strong></td>';
											echo '<td><input type="text" name="theory_grade_'.$data_name['course_id'].'_'.$c.'" id="theory_grade_'.$data_name['course_id'].'_'.$c.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
											echo '<td><strong>Practical Grade</strong></td>';
											echo '<td><input type="text" name="practical_grade_'.$data_name['course_id'].'_'.$c.'" id="practical_grade_'.$data_name['course_id'].'_'.$c.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
											echo '<td><input type="button" name="calculate_grade" value="Calculate Grade" id="calculate_grade" onClick="calculate_grade('.$crc_id.','.$c.')"></td>';
										}
										else
										{
											//echo '<td><strong>Theory Grade</strong></td>';
											//echo '<td><input type="text" name="theory_grade_'.$c.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
											//echo '<td><strong>Practical Grade</strong></td>';
											//echo '<td><input type="text" name="practical_grade_'.$c.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
										}
										echo '<tr><td colspan="8"><hr class="hr_line"></td></tr>';
										echo'</tr>';
										
										
										$sel_child="select course_name,course_id,is_parent from courses where parent_id='".$data_name['course_id']."'";
										$ptr_child=mysql_query($sel_child);
										if($totals_course=mysql_num_rows($ptr_child))
										{
											$ch=1;
											while($data_child=mysql_fetch_array($ptr_child))
											{
												$crc_ids=$data_child['course_id'];
												"<br/>".$sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_child['course_id']."'";
												$ptr_seldata=mysql_query($sel_data);
												$data_crs=mysql_fetch_array($ptr_seldata);
												$course_status_date='';
												//echo "is parent-".$data_child['is_parent'];
												$select_child_name="select course_name,course_id,is_parent from courses where course_id='".$data_child['course_id']."'";
												$ptr_child_name=mysql_query($select_child_name);
												$data_chile_course_name=mysql_fetch_array($ptr_child_name);
												
												if(mysql_num_rows($ptr_seldata))
												{
													$course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
												}
												
												if($data_crs['status']=="not_started")
													$not_started='checked="checked"';
												else if($data_crs['status']=="started")
													$started='checked="checked"';
												else if($data_crs['status']=="halted")
													$halted='checked="checked"';
												else if($data_crs['status']=="cancelled")
													$cancelled='checked="checked"';
												else if($data_crs['status']=="restart")
													$restart='checked="checked"';
												else if($data_crs['status']=="finished")
													$finished='checked="checked"';
												
												$theory_grade=$data_crs['theory_grade'];
												$practical_grade=$data_crs['practical_grade'];
												
												//=====================Check Diploma Level================================
												if($data_child['is_parent']!='y')
												{
													//$c=1;
													$course_status_date='';
													if(mysql_num_rows($ptr_seldata))
													{
														$course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
													}
													echo '<td></td>';
													echo '<td colspan="2"><span style="padding-left:15px;font-size:13px;font-weight:bold">'.$ch.'. '.$data_chile_course_name['course_name'].'</span><input type="hidden" name="course_id_'.$c.'_'.$ch.'" id="course_id_'.$c.'_'.$ch.'" value="'.$data_chile_course_name['course_id'].'" ><br/></td>';
													if($_POST['course_status_date_'.$c.'']) { $course_status_date=$_POST['course_status_date_'.$c.''];} else if($course_status_date !='') { $course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y'); }
													echo '<td><input type="text" name="course_status_date_'.$c.'" id="course_status_date_'.$c.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
													
													echo '<td><table width="100%"><tr>';
													echo '<input type="hidden" name="total_sub_course_'.$c.'" id="total_sub_course_'.$c.'" value="'.$tot_course.'" >';
												
													echo '<td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="not_started" '.$not_started.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="started" '.$started.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="cancelled" '.$cancelled.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="restart"'.$restart.' ></td><td><input type="radio" name="course_status_'.$c.'" '.$disabled_cm.' value="finished" '.$finished.' ></td><tr>
													<tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td>
													</tr></table>';
													echo '</td>';
													
													//$disabled_grades="disabled"; //10-10-19
													if($data_crs['status']=="finished" && ($_SESSION['type']=="S" || $_SESSION['type']=="A") )
													{
														$disabled_grades="";
													}
													
													echo '<td><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crc_ids.'_'.$ch.'" id="theory_grade_'.$crc_ids.'_'.$ch.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
													
													echo '<td><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crc_ids.'_'.$ch.'" id="practical_grade_'.$crc_ids.'_'.$ch.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
													echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calculate_grade('.$crc_ids.','.$ch.')"></td>';
												}
												else
												{
													$select_child_name="select course_name,course_id,is_parent from courses where course_id='".$data_child['course_id']."'";
													$ptr_child_name=mysql_query($select_child_name);
													$s=1;
													$data_child_name=mysql_fetch_array($ptr_child_name);
													$crs_child_id=$data_child_name['course_id'];
													?>
                                                    
                                                    <tr>
                                                    	<td></td>
                                                        <td align="left" colspan="2" style="padding-left:10px;"><span style="font-weight:bold; font-size:13px"><?php echo $ch.'. '.$data_child_name['course_name']; ?></span></td>
                                                        <input type="hidden" name="course_id_<?php echo $c ;?>" id="course_id_<?php echo $c ;?>" value="<?php echo $data_child_name['course_id']; ?>" >
                                                        <?php
														echo '<td align="center"><input type="text" placeholder="Theory Grade" name="theory_grade_'.$crs_child_id.'_'.$ch.'" id="theory_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
														echo '<td align="center"><input type="text" placeholder="Practical Grade" name="practical_grade_'.$crs_child_id.'_'.$ch.'" id="practical_grade_'.$crs_child_id.'_'.$ch.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
														echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calculate_grade('.$crs_child_id.','.$ch.')"></td>';
														
														?>                                                        
                                                        <!--<td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['net_fees']; ?></span></td>
                                                        <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['paid']; ?></span></td>
                                                        <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['balance_amt']; ?> </span></td>
                                                        <td align="center" style="padding-left:10px;"><span style="font-weight:bold">-->
                                                        <?php
                                                        /*$sel_inst="SELECT * FROM `installment` where enroll_id ='".$data_course['enroll_id']."' and course_id='".$data_course['course_id']."'  ";
                                                        $ptr_ins=mysql_query($sel_inst);
                                                        if(mysql_num_rows($ptr_ins))
                                                        {
                                                            while($data_inst=mysql_fetch_array($ptr_ins))
                                                            {
                                                                $col_paid ='<font color="#006600">';
                                                                if($data_inst['status'] =='not paid')
                                                                    $col_paid ='<font color="#FF3333">';
                                                                echo $data_inst['installment_amount'].'/- '.$data_inst['installment_date'].' : '.$col_paid.$data_inst['status']."</font><br>";	
                                                            }
                                                        }
                                                        else
                                                        {
                                                        }
                                                        $sel_inv="SELECT * FROM invoice where enroll_id=".$data_course['enroll_id']." and status='paid'";
                                                        $ptr_inv=mysql_query($sel_inv);
                                                        while($data_inv=mysql_fetch_array($ptr_inv))
                                                        {
                                                            $col_paid_inv ='';
                                                            $col_paid ='<font color="#FF3333">';
                                                            $date_i=explode(" ",$data_inv['added_date']);
                                                            $date_invs=$date_i[0];
                                                            echo $data_inv['amount'].'/- '.$date_invs.' :<font color="#006600"> '.$data_inv['status'].'</font><br>';	
                                                        }*/
                                                        ?>
                                                        <!--</span>                                  
                                                        </td>
                                                        <td align="center" style="padding-left:10px;"><span style="font-weight:bold"><?php //echo $data_course['added_date']; ?></span></td>-->
                                                    </tr>
                                                    
                                                    <?php
													/*echo '<td><strong>Theory Grade</strong></td>';
													echo '<td><input type="text" name="theory_grade_'.$c.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
													echo '<td><strong>Practical Grade</strong></td>';
													echo '<td><input type="text" name="practical_grade_'.$c.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';*/
												}
												//========================================================================
												$sel_sub_child="select course_name,course_id,is_parent from courses where parent_id='".$data_child['course_id']."'";
												$ptr_sub_child=mysql_query($sel_sub_child);
												if($totals_child_course=mysql_num_rows($ptr_sub_child))
												{
													$subch=1;
													while($data_sub_child=mysql_fetch_array($ptr_sub_child))
													{
														$crc_sub_id=$data_sub_child['course_id'];
														"<br/>".$sel_data="select status,theory_grade,practical_grade,course_status_date from action_certificate where course_id='".$data_sub_child['course_id']."'";
														$ptr_seldata=mysql_query($sel_data);
														$data_crs=mysql_fetch_array($ptr_seldata);
														$course_status_date='';
														if(mysql_num_rows($ptr_seldata))
														{
															$course_status_date=date("d/m/Y", strtotime($data_crs['course_status_date']));
														}
														
														if($data_crs['status']=="not_started")
															$not_started='checked="checked"';
														else if($data_crs['status']=="started")
															$started='checked="checked"';
														else if($data_crs['status']=="halted")
															$halted='checked="checked"';
														else if($data_crs['status']=="cancelled")
															$cancelled='checked="checked"';
														else if($data_crs['status']=="restart")
															$restart='checked="checked"';
														else if($data_crs['status']=="finished")
															$finished='checked="checked"';
														
														$theory_grade=$data_crs['theory_grade'];
														$practical_grade=$data_crs['practical_grade'];
														
														echo '<tr>';
														echo '<td></td>';
														echo '<td></td>';
														echo '<td><span style="padding-left:15px">'.$subch.') '.$data_sub_child['course_name'].'</span><input type="hidden" name="course_id_'.$c.'_'.$ch.'" id="course_id_'.$c.'_'.$ch.'" value="'.$data_sub_child['course_id'].'" ><br/></td>';
														if($_POST['course_status_date_'.$c.'_'.$ch.'']) { $course_status_date=$_POST['course_status_date_'.$c.'_'.$ch.''];} else if($course_status_date !='') { $course_status_date=$course_status_date;} else {$course_status_date=date('d/m/Y'); }
														
														echo '<td><input type="text" name="course_status_date_'.$c.'_'.$ch.'" id="course_status_date_'.$c.'_'.$ch.'" value="'.$course_status_date.'" class="datepicker" placeholder="course status date"/></td>';
														
														echo '<td><table width="100%"><tr>';
														echo '<td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="not_started" '.$not_started.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="started" '.$started.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="halted" '.$halted.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="cancelled" '.$cancelled.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="restart" '.$restart.'></td><td><input type="radio" name="course_status_'.$c.'_'.$ch.'" value="finished" '.$finished.'></td><tr>
														<tr><td>Not Started</td><td>Started</td><td>Halted</td><td>Cancelled</td><td>Restart</td><td>Finished</td></tr></table>';
														echo '</td>';
														
														//$disabled_grades="disabled"; //10-10-19
														if($data_crs['status']=="finished" && ($_SESSION['type']=="S" || $_SESSION['type']=="A") )
														{
															$disabled_grades="";
														}
														
														echo '<td align="center"><input type="text" name="theory_grade_'.$crc_sub_id.'_'.$subch.'" id="theory_grade_'.$crc_sub_id.'_'.$subch.'" '.$disabled_grades.' value="'.$theory_grade.'" /></td>';
														echo '<td align="center"><input type="text" name="practical_grade_'.$crc_sub_id.'_'.$subch.'" id="practical_grade_'.$crc_sub_id.'_'.$subch.'" '.$disabled_grades.' value="'.$practical_grade.'" /></td>';
														echo '<td><input type="button" name="calculate_grade" id="calculate_grade" value="Calculate Grade" onClick="calculate_grade('.$crc_sub_id.','.$subch.')"></td>';
														echo '</tr>';
														$subch++;
													}
												}
												$ch++;
											}
										}
										echo'<input type="hidden" name="total_course_'.$c.'" id="total_course_'.$c.'" value="'.$totals_course.'" >';
										echo '<tr><td colspan="8"><hr class="hr_line"></td></tr>';
										$sel_final="select * from action_final where enroll_id=".$record_id." and course_id='".$data_course['course_id']."' order by action_final_id desc";
										$ptr_sel_final= mysql_query($sel_final);
										if(mysql_num_rows($ptr_sel_final))
										{
											$data_final=mysql_fetch_array($ptr_sel_final);
											$completion_date='';
											if($data_final['completion_date']!='')
											{
												$completion_date=date("d/m/Y", strtotime($data_final['completion_date']));
											}
											$payment_cleared_date='';
											if($data_final['payment_cleared_date'])
											{
												$payment_cleared_date=date("d/m/Y", strtotime($data_final['payment_cleared_date']));
											}
											$logbook_completed_date='';
											if($data_final['logbook_completed_date'])
											{
												$logbook_completed_date=date("d/m/Y", strtotime($data_final['logbook_completed_date']));
											}
											$certificate_print_date='';
											if($data_final['certificate_print_date'])
											{
												$certificate_print_date=date("d/m/Y", strtotime($data_final['certificate_print_date']));
											}
											$certificate_issue_date='';
											if($data_final['certificate_issue_date'])
											{
												$certificate_issue_date=date("d/m/Y", strtotime($data_final['certificate_issue_date']));
											}
											$payment_cleared_action=$data_final['payment_cleared_action'];
											$logbook_completed_action=$data_final['logbook_completed_action'];
											$print_certificate_action=$data_final['print_certificate_action'];
											$issue_certificate_action=$data_final['issue_certificate_action'];
											$certificate_by_staff=$data_final['certificate_by_staff'];
											$certificate_type=trim($data_final['certificate_type']);
											
										}
										?>
										<tr>
											<td colspan="8">
											<table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
												<tr>
													<td width="20%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Date of Completion</span></td>
													<td width="20%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">All Payment Cleared</span></td>
													<td width="20%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Logbook Completed</span></td>
													<td width="20%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Print Certificate</span></td>
													<td width="20%" align="center"  style="padding-left:10px;"><span style=" font-weight:bold">Issued Certificate</span></td>
												</tr>
												<tr>
													<td width="20%" align="center"  style="padding-left:10px;"><input type="text" name="complition_date_<?php echo $c; ?>" value="<?php if($_POST['complition_date']) echo $_POST['complition_date']; else if($completion_date !='') echo $completion_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Completion date "/></td>   
													<?php
													$disable_ac='disabled="disabled"';
													if($_SESSION['type']=="AC" || $_SESSION['type']=="S")
													{
														$disable_ac="";
													}
													?>
													<td width="20%" align="center"  style="padding-left:10px;"><input type="checkbox" name="payment_cleared_<?php echo $c; ?>" <?php if($payment_cleared_action=='yes') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php echo $disable_ac;?> name="payment_complition_date_<?php echo $c; ?>" value="<?php if($_POST['payment_complition_date']) echo $_POST['payment_complition_date']; else if($payment_cleared_date !='') echo $payment_cleared_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Payment Completion date "/></td>
													
													<td width="20%" align="center"  style="padding-left:10px;"><input type="checkbox"  name="logbook_action_<?php echo $c; ?>" <?php if($logbook_completed_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" name="logbook_date_<?php echo $c; ?>" value="<?php if($_POST['logbook_date']) echo $_POST['logbook_date']; else if($logbook_completed_date !='') echo $logbook_completed_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Logbbok date "/>
													</td>      
													<?php
													$disable_certificate='disabled="disabled"';
													if($payment_cleared_action=='yes' && $logbook_completed_action!='' && ($_SESSION['type']=="A" ||$_SESSION['type']=="AC" || $_SESSION['type']=="S"))
													{
														$disable_certificate="";
													}
													?>
													<td width="20%" align="center"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_certificate; ?> name="certificate_printed_<?php echo $c; ?>" <?php if($print_certificate_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php echo $disable_certificate; ?> name="print_certificate_date_<?php echo $c; ?>" value="<?php if($_POST['print_certificate_date']) echo $_POST['print_certificate_date']; else if($certificate_print_date !='') echo $certificate_print_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Print Certificate date "/><br/>
                                                    <select name="certificate_type_<?php echo $c; ?>" id="certificate_type_<?php echo $c; ?>" <?php //echo $disabled_cm; ?> class="input_select" style="width:150px;">
                                                    <option value="" >Select Certificate</option>
                                                    <option <?php if($certificate_type=="certificate_level") echo 'selected="selected";' ?> value="certificate_level" >Certificate level/Diploma level</option>
                                                    <option <?php if($certificate_type=="DIC") echo 'selected="selected"'; ?> value="DIC" >DIC</option>
                                                    <option <?php if($certificate_type=="PGDC") echo 'selected="selected"'; ?> value="PGDC" >PGDC</option>
                                                    <option <?php if($certificate_type=="MIC") echo 'selected="selected"'; ?> value="MIC" >MIC</option>
                                                    <option <?php if($certificate_type=="Event") echo 'selected="selected"'; ?> value="Event" >Event</option>
                                                    <option <?php if($certificate_type=="Workshop") echo 'selected="selected"'; ?> value="Workshop" >Workshop</option>
													<option <?php if($certificate_type=="Biotop_hair_workshop_Participation") echo 'selected="selected"'; ?> value="Biotop_hair_workshop_Participation" >Biotop Hair Workshop Participation</option>
													<option <?php if($certificate_type=="makeup_workshop_participation") echo 'selected="selected"'; ?> value="makeup_workshop_participation" >Makeup Workshop Participation</option>
													<option <?php if($certificate_type=="keratine_treatment_seminar_participation") echo 'selected="selected"'; ?> value="keratine_treatment_seminar_participation" >Keratine Treatment Participation</option>
													<option <?php if($certificate_type=="rica_wax_workshop_participation") echo 'selected="selected"'; ?> value="rica_wax_workshop_participation" >Richa Wax Workshop Participation</option>
                                                    </select>
                                                    </td>
													<?php
													$disable_issue_certificate='disabled="disabled"';
													if($print_certificate_action =='yes' && $certificate_type!='' && ($_SESSION['type']=="A" ||$_SESSION['type']=="AC" || $_SESSION['type']=="S"))
													{
														$disable_issue_certificate="";
													}
													?>
													<td width="20%" align="center"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_issue_certificate; ?> name="certificate_issued_<?php echo $c; ?>" <?php if($issue_certificate_action!='') {echo 'checked="checked"' ;}?> value="yes" /><br/><input type="text" <?php echo $disable_issue_certificate; ?> name="certificate_issue_date_<?php echo $c; ?>" value="<?php if($_POST['certificate_issue_date']) echo $_POST['certificate_issue_date']; else if($certificate_issue_date !='') echo $certificate_issue_date; else echo date('d/m/Y');?>" class="datepicker" placeholder="Logbbok date "/>
													<br/>
													<select name="certificate_issue_staff_id_<?php echo $c; ?>" id="certificate_issue_staff_id_<?php echo $c; ?>" <?php echo $disable_issue_certificate; ?> class="input_select" style="width:150px;">
													<?php 
													$select_faculty = "select * from site_setting where 1 ".$_SESSION['where']." order by cm_id asc";
													$ptr_faculty = mysql_query($select_faculty);
													while($data_faculty = mysql_fetch_array($ptr_faculty))
													{ 
														$class4 = '';
														if($certificate_by_staff !='')
														{
															if($data_faculty['admin_id'] == $certificate_by_staff)
															{  
																$class4 = 'selected="selected"';
															}
														}
														else
														{
															if($data_faculty['admin_id'] == $_SESSION['admin_id'])
															{
																$class4 = 'selected="selected"';
															}
														}
														echo '<option value="'.$data_faculty['admin_id'].'" '.$class4.' >'.$data_faculty['name'].' </option>';     
													}
													?>        
													</select>
													</td>
												</tr>
											</table>
											</td>
										</tr>
										<tr>
											<td colspan="8" align="center"><input type="button" name="print certificate" <?php //echo $disable_issue_certificate; ?> value="Print Certificate" onclick="get_url();"></td>
										</tr>
										<?php
										//echo '<tr><td colspan="8"><hr/></td></tr>';
										echo '<input type="hidden" name="c" id="c" value="'.$c.'">';
										$c++;
									}
									?>
								<input type="hidden" name="total_main_course" id="total_main_course" value="<?php echo $tot_course; ?>" >
								
								</table>
							</td>
							</tr>
							<tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Action (Testominal)</strong></td></tr>
							<tr>
								<td colspan="8">
									<?php
									$sel_testo="select * from action_testominal where enroll_id=".$record_id." order by testominal_id desc";
									$ptr_testo= mysql_query($sel_testo);
									if(mysql_num_rows($ptr_testo))
									{
										$data_testo=mysql_fetch_array($ptr_testo);
										$google_action=$data_testo['google_action'];
										$justdial_action=$data_testo['justdial_action'];
										$video_action=$data_testo['video_action'];
										$staff_id=$data_testo['staff_id'];
									}
									?>
									<table align="center" border="0px" width="100%" cellpadding="5" cellspacing="0" bgcolor="#EFEFEF">
									<?php
										$disable_testomianl='disabled="disabled"';
										if($issue_certificate_action =='yes' && ($_SESSION['type']=="A" ||$_SESSION['type']=="AC" || $_SESSION['type']=="S"))
										{
											$disable_testomianl="";
										}
										?>
										<tr>
											<td width="30%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Google</span></td>
											<td width="20%" align="left"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="google_testominal" <?php if($google_action!='') {echo 'checked="checked"' ;}?> value="yes" /></td>  
											<td align="left" width="30%"  style="padding-left:10px;" rowspan="3">
												<select name="staff_ids" id="staff_ids" class="input_select" style="width:150px;">                        
													<?php 
														$select_faculty = "select * from site_setting where 1 ".$_SESSION['where']."  order by cm_id asc";
														$ptr_faculty = mysql_query($select_faculty);
														while($data_faculty = mysql_fetch_array($ptr_faculty))
														{ 
															$class3 = '';
															if($staff_id !='')
															{
																if($data_faculty['admin_id'] == $staff_id)
																{  
																	$class3 = 'selected="selected"';
																}
															}
															else
															{
																if($data_faculty['admin_id'] == $_SESSION['admin_id'])
																{  
																	$class3 = 'selected="selected"';
																}
															}
															echo '<option value="'.$data_faculty['admin_id'].'" '.$class3.' >'.$data_faculty['name'].' </option>';     
														}
													  ?>        
												</select>
											</td>											
										</tr>
										<tr>
											<td width="36%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Justdial</span></td>
											<td width="20%" align="left"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="justdial_testominal" <?php if($justdial_action!='') {echo 'checked="checked"' ;}?> value="yes" /></td>      
										</tr>
										<tr>
											<td width="36%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Video taken</span></td>
											<td width="20%" align="left"  style="padding-left:10px;"><input type="checkbox" <?php echo $disable_testomianl;?> name="video_taken" <?php if($video_action!='') {echo 'checked="checked"' ;}?> value="yes" /></td>      
										</tr>
								 	</table>
								</td>
							</tr>
                               			<?php 
										//if($data_select['action_status']=='') 
										{
										?>
                                        <tr>
                                        	<td colspan="2" align="center"> <input type="submit" name="save_changes" value="Save"  /></td>
                                        </tr>
                                        <?
										}
                                       $bgColorCounter++;
                                    }
                                  
                                    ?>
                                    
                                        </table>
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                    <td align="right"></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    </form><?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
                            ?>
                            
                            </td>
                            <td class="mid_right"></td>
                          </tr>
                           <tr>
    							<td class="bottom_left"></td>
    							<td class="bottom_mid"></td>
    							<td class="bottom_right"></td>
  							</tr>
                         </table>
                     </div>
<!--right end-->
</div>
<!--info end-->
<div class="clearit"></div> 
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script>
function get_url()
{
	var c = $("#c").val();
	//alert(c);
	for(var i=1;i<=c;i++)
	{
	var certificate_type = $("#certificate_type_"+i).val();
	var record_id = $("#record_id").val();
	var course_id = $("#course_id_"+i).val();
	
	
	//alert(course_id);
	if(certificate_type=="certificate_level") window.open('certificate_details_level.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	
	else if(certificate_type=="DIC") window.open('certificate_details_dic.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	
	else if(certificate_type=="PGDC") window.open('certificate_details_pgdc.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');

	else if(certificate_type=="MIC") window.open('certificate_details_mic.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	
	else if(certificate_type=="Event") window.open('certificate_details_event.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	else if(certificate_type=="Workshop") window.open('certificate_details_workshop.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	else if(certificate_type=="Biotop_hair_workshop_Participation") window.open('certificate_details_biotop.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	else if(certificate_type=="makeup_workshop_participation") window.open('certificate_details_makeup.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	else if(certificate_type=="keratine_treatment_seminar_participation") window.open('certificate_details_keratine.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	else if(certificate_type=="rica_wax_workshop_participation") window.open('certificate_details_rica.php?record_id=<?php echo $_REQUEST['record_id']; ?>&course_id='+course_id, '_blank');
	}
}
</script>
</body>
</html>
<?php $db->close();?>