<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Student</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
	
	<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">
      
    $(document).ready(function()
	{  
		var currentDate = new Date();
	
		$('.datepicker').datepicker({ changeMonth: true, changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
	});
	</script>
    <script type="text/javascript">
         function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }

            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected record(s)?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {           
            //alert(value);
           // alert(value1);
            window.location.href=value+value1;
        }

        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
    </script>
	
</head>

<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT student_id FROM ".$GLOBALS["pre_db"]."stud_regi where student_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                {                 
									"<br>".$sql_query= "SELECT name FROM stud_regi where student_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);    
																	
									$delete_query="delete from ".$GLOBALS["pre_db"]."batch where batch_id='".$del_record_id."'";
									$db->query($delete_query);   
									                               
									$delete_query="delete from ".$GLOBALS["pre_db"]."stud_regi where student_id='".$del_record_id."'";
									$db->query($delete_query);
									
									$delete_query1="delete from ".$GLOBALS["pre_db"]."inquiry where inquiry_id='".$del_record_id."'";
									$db->query($delete_query1); 
									
									$delete_query11="delete from ".$GLOBALS["pre_db"]."followup_details where student_id='".$del_record_id."'";
									$db->query($delete_query11); 
                                 }
                             }
                             ?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                                    <script type="text/javascript">
                                    // $("#statusChangesDiv").dialog();
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                    modal: true,
                                                    buttons: {
                                                                Ok: function() { $( this ).dialog( "close" );}
                                                             }
                                            });
                                        });
                                    </script>
                            <?php                            
                                }                       
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT student_id FROM ".$GLOBALS["pre_db"]."stud_regi where student_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {     
						
						"<br>".$sql_query= "SELECT name FROM stud_regi where student_id ='".$del_record_id."' ";              
						$query=mysql_query($sql_query);
						$fetch=mysql_fetch_array($query);
						
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);    
											  
                        $delete_query="delete from ".$GLOBALS["pre_db"]."stud_regi where student_id='".$del_record_id."'";
                        $db->query($delete_query);
						
						$delete_query1="delete from ".$GLOBALS["pre_db"]."inquiry where inquiry_id='".$del_record_id."'";
                        $db->query($delete_query1);
						
						$delete_query11="delete from ".$GLOBALS["pre_db"]."followup_details where student_id='".$del_record_id."'";
                        $db->query($delete_query11);

                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                            </script>
                            <?php
                        }
                    }
                    ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="98%">
    
  <?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>  
  <tr class="head_td">
    <td colspan="15">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                        </select></td>
                        <td> <a href="excel.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
                        <td width="20%">
                        <select name="enquiry_added">
                        	<option value="">Enquiry added by</option>
                             <?php
								 $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and type='C' order by name asc"; 
								 $ptr_name=mysql_query($sle_name);
								 while($data_name=mysql_fetch_array($ptr_name))
								 {
									$selected='';
									if($data_name['admin_id'] == $_GET['enquiry_added'])
									{
										$selected='selected="selected"';
									}
									 echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
								 }
							 ?>
                        </select>
                        </td>
                        <td width="15%"><select id="enquiry_src" name="enquiry_src">
                        <option value="">Select Enquiry Source</option>
                        <?php 
						$sel_source="SELECT * FROM source where 1 ".$_SESSION['where']." order by source_name asc ";
						$ptr_src=mysql_query($sel_source);
						while($data_src=mysql_fetch_array($ptr_src))
						{
							$sele_source="";
								if($data_src['source_id'] == $_GET['enquiry_src'])
								{
									$sele_source='selected="selected"';
								}
						?>
							<option <?php echo $sele_source?> value = "<?php echo $data_src['source_id']?>"> <?php echo $data_src['source_name'] ?> </option>
						<?
						}
							
						?>
                          </select></td>
                          <td width="15%"><select id="response" name="response">
                        
                            <option value="">Select Resonse</option>
							<?php
							$sel_resp="select * from responce_category ";
							$ptr_resp=mysql_query($sel_resp);
							while($data_resp=mysql_fetch_array($ptr_resp))
							{
								?>
								<option value="<?php echo $data_resp['responce_id'];  ?>" <?php if($_GET['response'] == $data_resp['responce_id']) echo 'selected="selected"'; ?>><?php echo $data_resp['respnce_category_name'];  ?></option>	
								<?php
							}
							?>
                           	                           
                          </select></td>
						  <td width="15%"><input type="text" class="input_text datepicker" name="start_date" placeholder="Start Date" id="dob" /><td>
						  <td width="15%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="End Date"  /></td>
                          <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    
    
    <?php
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
							
                        $enquiry_added='';
						if($_REQUEST['enquiry_added'])
						{
                            $enquiry_ad=$_REQUEST['enquiry_added'];
							$enquiry_added="and admin_id='".$enquiry_ad."'";
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
							
						/*$start_date='';
						if($_REQUEST['start_date'])
						{
                            $start_date=$_REQUEST['start_date'];
							$start_date=" and added_date >='".$start_date."'";
						}
						$end_date='';
						if($_REQUEST['end_date'])
						{
                            $end_date=$_REQUEST['end_date'];
							$end_date=" and added_date <='".$end_date."'";
						}*/
						$enquiry_added='';
						if($_REQUEST['enquiry_added'])
						{
                            $enquiry_ad=$_REQUEST['enquiry_added'];
							$enquiry_added="and admin_id='".$enquiry_ad."'";
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
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and student_id='".$_GET['record_id']."' ";
							
						} 
                        $select_directory='order by student_id desc';    
						$sql_query= "SELECT student_id,status,name,cm_id,contact,address,mail,added_date,course_id,admin_id,enquiry_source,response,qualification,dob,class_id FROM stud_regi where 1 ".$record_cat_id." ".$_SESSION['where']." ".$pre_keyword." ".$enquiry_added." ".$enquiry_src." ".$response." ".$pre_from_date."".$pre_to_date." ".$select_directory.""; 
						//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
							// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
    <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="3%" align="center"><strong>Sr. No.</strong></td>
    <td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>
    <td width="9%" align="center"><strong>Course Name</strong></td>
    <? if($_SESSION['type']=='S')
	{ ?>
    <td width="7%" align="center"><strong>Branch Name</strong></td>
    <? }?>
    <!--<td width="9%"><strong>Contact No  </strong></td>-->
      <td width="9%" align="center"><strong>Address </strong></td>
   
    
    <td width="12%" align="center"><strong>Enquiry Added By</strong></td>
	<td width="12%" align="center"><strong>Enquiry Assigned To</strong></td>
    <td width="8%" align="center"><strong>Enquiry Source</strong></td>
     <td width="8%" align="center"><strong>Respose Category</strong></td>
    <td width="5%" align="center"><strong>Date</strong></td>
    <td width="5%" align="center"><strong>Status</strong></td>
    <td width="7%" align="center"><strong>Followup</strong></td>
    <td width="8%" align="center"><strong>Enrollment</strong></td>
	<?php
	if($_SESSION['type']=='S' )
	{?>
		<td width="6%" class="centerAlign" align="center"><strong>Action</strong></td>
	<?php } ?>
	</tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								/* $sel_inqury_id="select inquiry_id from inquiry where email_id='".$val_query['mail']."' and birth_date='".$val_query['dob']."' and address='".$val_query['address']."' and education='".$val_query['qualification']."'";
								$ptr_inquery_id=mysql_query($sel_inqury_id);
								$data_inquiry_id=mysql_fetch_array($ptr_inquery_id);
								 $inquiry_id=$data_inquiry_id['inquiry_id'];*/
								 
								 "<br />".$sel_name_inq="select * from inquiry where inquiry_id='".$val_query['class_id']."'";
								$ptr_name_inq=mysql_query($sel_name_inq);
								$data_names_inq=mysql_fetch_array($ptr_name_inq);
								
								$sel_curse="select course_name from courses where course_id='".$val_query['course_id']."' ";
								$ptr_course=mysql_query($sel_curse);
								$data_course_name=mysql_fetch_array($ptr_course);
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$data_names_inq['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_names=mysql_fetch_array($ptr_name);
								
								
								"<br />".$sel_name_assign="select name from site_setting where admin_id='".$data_names_inq['employee_id']."'";
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
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['student_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td align="left">';
								if($val_query['status']=='Enrolled')
								echo $val_query['name'].'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mail.png">'.$val_query['mail'].'';
								else
								echo '<a href="add_student.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mail.png">'.$val_query['mail'].'</a>';
								echo'</td>';
								echo '<td align="center">'.$data_course_name['course_name'].'</td>';
								  if($_SESSION['type']=='S')
								  {
									  $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
									  $ptr_branch=mysql_query($sel_branch);
									  $data_branch=mysql_fetch_array($ptr_branch);
									   echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								  }
                               /* echo '<td align="center">'.$val_query['contact'].'</td>';*/
                                echo '<td align="center">'.$val_query['address'].'</td>';
								/*echo '<td align="center">'.$val_query['mail'].'</td>';*/
								
								echo '<td align="center">'.$data_names['name'].'</td>';
								echo '<td align="center">'.$data_names_assign['name'].'</td>';
								$enq_src="select source_name from source where source_id='".$val_query['enquiry_source']."'";
								$ptr_enq_src=mysql_query($enq_src);
								$data_enq_src=mysql_fetch_array($ptr_enq_src);
								
								
								
								echo '<td align="center">'.$data_enq_src['source_name'].'</td>';
								
								$response='';
								
								if($val_query['response'] == "1")
								{
									$response="Walk in";
								}
								else if($val_query['response'] == "2")
								{
									$response="Will walk in";
								}
								else if($val_query['response'] == "3")
								{
									$response="Call Back Later";
								}
								else if($val_query['response'] == "4")
								{
									$response="Call did not pick up";
								}
								else if($val_query['response'] == "5")
								{
									$response="Not reachable";
								}
								else if($val_query['response'] == "6")
								{
									$response="Call Taken";
								}
								
								echo '<td align="center">'.$response.'</td>';
								//echo '<td align="center">'.$val_query['response'].'</td>';
								echo '<td align="center">'.$val_query['added_date'].'</td>';
								if($val_query['status']=='Enrolled')
								{
								echo '<td style="color:#00CC00" align="center">'.$val_query['status'].'</td>';
								}
								else
								echo '<td style="color:#FF0000" align="center">'.$val_query['status'].'</td>';
								
								
								
								if($val_query['status']=='Enrolled')
								{
								echo '<td style="color:#FF0000" align="center"><img title="Followup Completed" src="images/enroll_cmpleted.png" height="30" width="30"></td>';
								}
								else
								echo '<td style="color:#FF0000" align="center"><a href="followup_details.php?record_id='.$listed_record_id.'" ><img title="Followup" src="images/followup.png" height="30" width="30"></a></td>';
								
								
								if($val_query['status']=='Enrolled')
								{
								echo '<td style="color:#FF0000" align="center"><img src="images/enroll_cmpleted.png" title="Enrollment Completed" height="30" width="30"></td>';
								}
								else
								echo '<td style="color:#FF0000" align="center"><a href="add_student_gst.php?record_id='.$listed_record_id.'" ><img src="images/enrolls.png" title="Enrollment" height="30" width="30"></a></td>';
								if($_SESSION['type']=='S' )
								{
								echo '<td align="center">';
								if($val_query['status']!='Enrolled')
								echo'<a href="inquiry.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>
								&nbsp;&nbsp;';
								
                                    echo ' <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								
                                echo '</td>';
								}
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }  
							?>
							 <tr class="grey_td" >
    <td width="6%" colspan="3" align="center"><strong>Total Records</strong></td>
    
    <td width="10%" colspan="11" align="left"><strong><?php echo $no_of_records;?></strong></td>
  
  </tr>
							  
                                
  
  
  <tr class="head_td">
    <td colspan="14">
       <table cellspacing="0" cellpadding="0" width="100%" >
            <tr>
                <?php
                      if($no_of_records>10)
                            {
                                echo '<td width="3%" align="left">Show</td>
                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                $show_records=array(0=>'10',1=>'20','50','100');
                                for($s=0;$s<count($show_records);$s++)
                                {
                                    if($_SESSION['show_records']==$show_records[$s])
                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                    else
                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                }
                                echo'</td></select>';
                            }
                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                         
                 ?>
                                    
            </tr>
        </table>
 
    
                                    
                                       
                               
    </td>
    </tr></form>
      <?php } 
	  
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
</table>

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
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>
