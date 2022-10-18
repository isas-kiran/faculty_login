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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Enrollment ";?>
 Form</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
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
		$("#user_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	jQuery(document).ready( function() 
	{
		$("#counc1_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		$("#inform_bop_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		$("#inform_counc_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
		
		$("#inform_faculty_id").multiselect().multiselectfilter();
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
								
								
								$arrage_date= explode('/',$_POST['sche_date'],3);     
									$date1= $arrage_date[2].'-'.$arrage_date[0].'-'.$arrage_date[1];
								
								$arrage_date= explode('/',$_POST['batch_date'],3);     
									$date= $arrage_date[2].'-'.$arrage_date[0].'-'.$arrage_date[1];
								
									
								$counc_id=@implode(",",$_POST['counc_id']); 
								$counc1_id=@implode(",",$_POST['counc1_id']); 
								
								$inform_bop_id=@implode(",",$_POST['inform_bop_id']); 
								$inform_counc_id=@implode(",",$_POST['inform_counc_id']);
								$inform_faculty_id=@implode(",",$_POST['inform_faculty_id']);
							 	$enroll_id=$record_id;
								
								$data_record['enroll_id'] =$enroll_id;
								$data_record['schedule_Induction'] =$sche_action;
								$data_record['batch_schedule'] =$batch_action;
								
								$data_record['schedule_date'] =$date1;
								$data_record['batch_date'] =$date;
								$data_record['schedule_councellor'] =$counc_id;
								$data_record['batch_councellor'] = $counc1_id;
								
								$data_record['inform_bop'] =$inform_bop_id;
								$data_record['inform_councellor'] =$inform_counc_id;
								$data_record['inform_faculty'] =$inform_faculty_id;
								$data_record['added_date'] =date('Y-m-d h:i:s');
								$data_record['admin_id']=$_SESSION['admin_id'];
								if($record_id)
								{
									
									
									$insert_into_invoice= "INSERT INTO `action_councellor` (`enroll_id`, `schedule_Induction`, `batch_schedule`, `schedule_date`, `batch_date`, `schedule_councellor`, `batch_councellor`, `inform_bop`,`inform_councellor`,`inform_faculty`,`added_date`, `admin_id`) VALUES ('".$data_record['enroll_id']."', '".$data_record['schedule_Induction']."', '".$data_record['batch_schedule']."', '".$data_record['schedule_date']."', '".$data_record['batch_date']."', '".$data_record['schedule_councellor']."', '".$data_record['batch_councellor']."','".$data_record['inform_bop']."','".$data_record['inform_councellor']."','".$data_record['inform_faculty']."', '".date('Y-m-d H:i:s')."','".$data_record['admin_id']."')";
									$ptr_isert_invp = mysql_query($insert_into_invoice);
									
								}
								else
								{
								 // $db->query_insert("pay_balace_bill_mapping", $data_college);
								 //  echo '<div id="msgbox" style="width:40%;">Supplier added successfully</center></div>';
								}
								$success=1;
                            	
                        	}
                                
                         	?>       
                                
                         
                      <?php
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
                               
									
                                $sql_records= "SELECT * FROM invoice 
								where enroll_id=".$record_id." ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status."  
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
                                                   <!-- <td width="70%" align="right"><a href="javascript:void(0);" onClick="window.open('csvcompany_manage.php','win1','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no'); return false;" ><img src="images/csv.png" border="0"/></a>
    
    <img src='images/view.jpeg' title='View Invoice' border='0' 
	onclick="window.open('invoice-generate-company.php')" style='cursor:pointer' > 
    <img src='images/print1.jpeg'
								onclick="window.open('invoice-generate-company.php?action=print','View Invoice')" style='cursor:pointer'title='Print Invoice' border='0'>
                                            </td>-->
                                                    <td height="2" align="right"></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    
                                    <tr>
                                    	<td valign="top" colspan="2">
                                       <table cellspacing="1"  cellpadding="5" style="width: 60%;" align="center">
										<?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
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
										
										?>
                                        <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Personal Details</strong></td></tr>
                                        <tr><td colspan="2">
										<table align="center" border="1px" width="100%" cellpadding="2" cellspacing="0"
                                        bgcolor="#EFEFEF" >
                                        
                        
                        	<tr>
                            	<td width="21%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Roll No</span></td><td width="24%" >#<?php echo $enroll_id; ?></td>
                                <td width="22%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Receipt No</span></td><td width="33%" >#<?php //echo $enroll_id; ?></td>
                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Service Tx No.</span></td><td>#<?php //echo $enroll_id; ?></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Invoice No.</span></td><td width="33%" >#<?php //echo $enroll_id; ?></td>
                            </tr>
                        </table>
                        </td>
                        </tr>
                        <?
										
										echo '<tr><td width="21%"><strong>Student Name</strong></td><td align="left" style="padding-left:5px;"><b>'.$data_select['name'].'</td></tr>';
										echo '<tr><td width="21%"><strong>Contact No. <img src="images/mobile-phone-8-16.ico"></strong></td><td align="left" style="padding-left:5px;">'.$data_select['contact'].' </td></tr>';
										echo '<tr><td width="21%"><strong>Email Id <img src="images/mail.png"></strong></td><td align="left" style="padding-left:5px;">'.$data_select['mail'].' </td></tr>';
										echo '<tr><td width="21%"><strong>Address</strong></td><td align="left" style="padding-left:5px;">'.$data_select['address'].' </td></tr>';
										echo '<tr><td width="21%"><strong>DOB</strong></td><td align="left" style="padding-left:5px;">'.$data_select['dob'].' </td></tr>';
										
                                       // echo '<tr><td><strong>Total</strong></td><td align="left">'.$data_select['course_fees'].'</td></tr>';
                                        //echo '<tr><td><strong>Discount</strong></td><td align="left">';
                                        	//echo $data_select['discount'];
                                        //echo '</td></tr>'; 
									    $paid=$data_select['paid'];
										/*$selectpaid="select sum(installment_amount) as amount_paid  from installment_history 
										where enroll_id=".$val_record['enroll_id']." "; 
										$ptr_selectpaid=mysql_query($selectpaid);
										if(mysql_num_rows($ptr_selectpaid))
										 {
										while($val_selectedpaid=mysql_fetch_array($ptr_selectpaid))
										{*/
									    //$totsss=$data_select['course_fees']-$data_select['discount'];
										//$bal_totas=$totsss-$data_select['paid']; 
										/*}
										}*/
										
										//echo '<tr><td><strong>Down Payment</strong></td><td align="left">'.$data_select['down_payment'].'</td></tr>'; 
										if($data_select['paid'] !='')
										{
									   	//	echo '<tr><td><strong>Paid</strong></td><td align="left">'.$data_select['paid'].'<input type="hidden" name="paid_amt" id="paid_amt" value="'.$data_select['paid'].'"</td></tr>'; 
										}
									  // echo '<tr><td><strong>Balance Amount</strong></td><td align="left">'.$data_select['balance_amt'].'<input type="hidden" name="balance_amount" 
                                	//			id="balance_amount" value="'.$data_select['balance_amt'].'" class="inputText"></td></tr>';
									//	
									//	echo '<tr><td><input type="hidden" name="bal_amt" id="bal_amt"/> </td></tr>'		
									   ?> 
										<!--<tr><td width="37%"><strong>Deposite Amount</strong></td><td width="63%" align="left"><input type="text" name="amount_paid" id="amount_paid"
												onkeyup="calculate_total(this.value)" value="" > </td></tr>-->
                                                <?php
                                                $sel_course="Select * from courses where course_id='".$data_select['course_id']."'";
												$ptr_course=mysql_query($sel_course);
												$dat_course=mysql_fetch_array($ptr_course);
												?>
                                                <tr><td height="46" colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Course Details</strong></td></tr>	
                                              <tr><td colspan="2">
										<table align="center" border="1px" width="100%" cellpadding="2" cellspacing="0"
                                        bgcolor="#EFEFEF" >
                        
                        	<tr>
                            	<td width="56%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Course Name</span></td>
                                <td width="18%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Course Fee</span></td>      
                                <td width="26%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Course Duration</span></td>

                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $dat_course['course_name']; ?> </span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><?php echo $dat_course['course_price']; ?></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $dat_course['course_duration']; ?></span></td>

                            </tr>
                        </table>
                        </td>
                        </tr>   
                        <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Fees Details</strong></td></tr>	
                                              <tr><td colspan="2">
										<table align="center" border="1px" width="100%" cellpadding="2" cellspacing="0"
                                        bgcolor="#EFEFEF" >
                        
                        	<tr>
                            	<td width="18%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Course Fee</span></td>
                                <td width="15%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Discount</span></td>      
                                <td width="15%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Paid Fee</span></td>
                                <td width="19%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Balance Fee</span></td>
                                <td width="18%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Installments</span></td>
                                <td width="15%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Status</span></td>

                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $dat_course['course_price']; ?> </span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><?php echo $data_select['discount']; ?></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_select['paid']; ?></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_select['balance_amt']; ?> </span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><?php echo $data_select['no_of_installment']; ?></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><?php echo $data_select['paid_status']; ?></span></td>

                            </tr>
                        </table>
                        </td>
                        </tr>  
                                <tr><td colspan="2" align="center" style=" font-size:12px; font-weight:bold"><strong>Do Action</strong></td></tr>
                                          
                                          <tr><td colspan="2">
										<table align="center" border="0px" width="100%" cellpadding="4" cellspacing="0">
                        
                        	<tr bgcolor="#EFEFEF">
                            	<td width="36%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Name</span></td>
                                <td width="19%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Action</span></td>      
                                <td width="18%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Date</span></td>
                                <td width="27%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Councellor Name</span></td>
                            </tr>
                            <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Schedule Induction</span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox" name="sche_action" value="Yes"/></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="sche_date"  class="datepicker" placeholder="Action date "/></span></td>
                                <td align="left"  style="padding-left:10px;">
                                 <select  multiple="multiple" name="counc_id[]" id="user_id" class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class = '';
                                            for($t=0;$t<count($implode_data);$t++)
                                            {  
                                            if($data_faculty['admin_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                            }
                                        if($class !='')                                    
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class.' >'.$data_faculty['name'].' </option>';     
                                        else
                                        echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].' </option>';  
                                        }
                                        ?>        
                                </select>
                                </td>
                                

                            </tr>
                             <tr>
                            	<td align="left"  style="padding-left:10px;"><span style="font-weight:bold">Batch schedule</span></td>
                                <td align="left"  style="padding-left:10px;"><span style=" font-weight:bold"><input type="checkbox" name="batch_action" value="Yes" /></span></td>
                                <td align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="text" name="batch_date"  class="datepicker" placeholder="Action date "/></span></td>
                               <td align="left"  style="padding-left:10px;">
                                 <select  multiple="multiple" name="counc1_id[]" id="counc1_id" class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class = '';
                                            for($t=0;$t<count($implode_data);$t++)
                                            {  
                                            if($data_faculty['admin_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                            }
                                        if($class !='')                                    
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class.' >'.$data_faculty['name'].' </option>';     
                                        else
                                        echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].' </option>';  
                                        }
                                        ?>        
                                </select>
                                </td>
                            </tr>
                        </table>
                        </td>
                        </tr>        
                        
                        	 <tr><td colspan="2">
										<table align="center" border="0px" width="100%" cellpadding="4" cellspacing="0">
                        
                        	<tr bgcolor="#EFEFEF">
                            	<td width="23%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Inform BOP</span></td>
                                <td width="44%" align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" name="inform_bop"  /></span></td>
                                <td width="33%" >
                                 <select  multiple="multiple" name="inform_bop_id[]" id="inform_bop_id" class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where type='B' ".$_SESSION['cm_id_councellor']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class = '';
                                            for($t=0;$t<count($implode_data);$t++)
                                            {  
                                            if($data_faculty['admin_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                            }
                                        if($class !='')                                    
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class.' >'.$data_faculty['name'].' </option>';     
                                        else
                                        echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].' </option>';  
                                        }
                                        ?>        
                                </select>
                                </td>
                                </tr>
                            <tr bgcolor="#EFEFEF">
                                <td width="23%" align="left"  style="padding-left:10px;"><span style="font-weight:bold">Inform Councellor</span></td>
                                <td width="44%" align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" name="inform_counc"  /></span></td>
                                 <td width="33%" >
                                 <select  multiple="multiple" name="inform_counc_id[]" id="inform_counc_id" class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where type='C' ".$_SESSION['cm_id_councellor']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class = '';
                                            for($t=0;$t<count($implode_data);$t++)
                                            {  
                                            if($data_faculty['admin_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                            }
                                        if($class !='')                                    
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class.' >'.$data_faculty['name'].' </option>';     
                                        else
                                        echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].' </option>';  
                                        }
                                        ?>        
                                </select>
                                </td
                            ></tr>
                            <tr bgcolor="#EFEFEF">
                            	<td width="23%" align="left"  style="padding-left:10px;"><span style=" font-weight:bold">Inform Faculty</span></td>
                                <td width="44%" align="left"  style="padding-left:10px;"><span style="font-weight:bold"><input type="checkbox" name="inform_faculty"  /></span></td>                              	 <td width="33%" >
                                 <select  multiple="multiple" name="inform_faculty_id[]" id="inform_faculty_id" class="input_select" style="width:150px;">                        
									<?php 
                                        $select_faculty = "select * from site_setting where type='F' ".$_SESSION['cm_id_councellor']."  order by cm_id asc";
                                        $ptr_faculty = mysql_query($select_faculty);
                                        while($data_faculty = mysql_fetch_array($ptr_faculty))
                                        { 
                                            $class = '';
                                            for($t=0;$t<count($implode_data);$t++)
                                            {  
                                            if($data_faculty['admin_id'] == $implode_data[$t])
                                            $class = 'selected="selected"';
                                            }
                                        if($class !='')                                    
                                        echo '<option value="'.$data_faculty['admin_id'].'" '.$class.' >'.$data_faculty['name'].' </option>';     
                                        else
                                        echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].' </option>';  
                                        }
                                        ?>        
                                </select>
                                </td					
                                ></tr>
                            </table>
                            </td>
                            </tr>
										<!--<tr><td colspan="2"><strong>Installments</strong></td></tr>		
                                        <tr>
                                        <td colspan="2">
                                        <table width="95%" align="center">
                                        	<tr>
                                        	<td >
                                        		<?php
												/*$sel_inst= "select * from installment where enroll_id=".$record_id." ";
												$ptr_query_inst=mysql_query($sel_inst);
												$i=$data_select['no_of_installment'];
												
												echo '<input type="hidden" name="no_of_installment" value="'.$i.'" id="no_of_installment" /><table width="60%" style="border:1px solid black">';
												echo'<tr><td width="30%"><b>Installments</b></td><td width="20%"><b>Inst Amt</b></td><td width="25%"><b>Inst Date</b></td><td>Paid Status</td></tr>';
											//	echo '<tr></tr>';
												$j=1;
												while($data_inst=mysql_fetch_array($ptr_query_inst))
												{
													 $col_paid ='<font color="#006600">';
													if($data_inst[status] =='not paid')
													$col_paid ='<font color="#FF3333">';
													echo '<input type="hidden" name="course_id" value="'.$data_inst['course_id'].'" id="course_id" />';
													
													echo'<tr><td width="15%"><b>Installment '.$j.'</b></td><td width="15%"><input type="hidden" name="inst_'.$j.'" id="inst_'.$j.'" value="'.$data_inst['installment_amount'].'"><span id=int_id_'.$j.'>'.$data_inst['installment_amount'].'</span></td><td width="15%"><input type="hidden" name="inst_date'.$j.'" id="inst_date'.$j.'" value="'.$data_inst['installment_date'].'">'.$data_inst['installment_date'].'</td>
													<td>'.$col_paid.$data_inst['status'].'</font></td></tr>';
													$j++;
													$i--;
												}
												echo '</table>';*/
												?>
                                                
                                        	</td>
                                        </tr>
                                        </table>
                                        </td>
                                        </tr>-->
                                        
								 		<!--<tr><td width="65%"><strong>Remaining </strong></td><td align="left"  width="35%"> <div id="avail_balance_show"><?php //echo $data_select['balance_amt']; ?></div><input type="hidden" name="avail_balance" id="avail_balance" /> </td></tr>-->
                               			
                                        <tr>
                                        	<td colspan="2" align="center"> <input type="submit" name="save_changes" value="Save"  /></td>
                                        </tr>
                                        <?
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
</body>
</html>
<?php $db->close();?>