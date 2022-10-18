<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding"  />
<title>View Student</title>
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
		
function select_branch(branch_name)
{
	var data1="action=inqury_details&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_details.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			sep=html.split("###");
			document.getElementById("added_by").innerHTML=sep[0];
			document.getElementById("assigned_by").innerHTML=sep[1];
			document.getElementById("source_by").innerHTML=sep[2];
		}
	},
       error:function(exception){alert('Exception:'+exception);}

	});
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
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
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
							   	$my_query=mysql_query($sql_query);
								if(mysql_num_rows($my_query))
								{                 
									"<br>".$sql_query= "SELECT name FROM stud_regi where student_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);    
																	
									$delete_query="delete from batch where batch_id='".$del_record_id."'";
									$dbs=mysql_query($delete_query);   
									                               
									$delete_query="delete from stud_regi where student_id='".$del_record_id."'";
									$db=mysql_query($delete_query);
									
									"<br/>".$delete_query1="delete from inquiry where inquiry_id='".$del_record_id."'";
									$db1=mysql_query($delete_query1); 
									
									$delete_query1781="delete from ".$GLOBALS["pre_db"]."followup_details where student_id='".$del_record_id."'";
									$db4567=mysql_query($delete_query1781); 
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
                                setTimeout('document.location.href="manage_student.php";',1000);
                            </script>
                            <?php                            
                     	}                       
                    }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_querys= "SELECT student_id FROM ".$GLOBALS["pre_db"]."stud_regi where student_id='".$del_record_id."'";
                        $my_querys=mysql_query($sql_querys);
						if(mysql_num_rows($my_querys))
						{     
							"<br>".$sql_query= "SELECT name FROM stud_regi where student_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_inquiry','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);    
												  
							$delete_query="delete from stud_regi where student_id='".$del_record_id."'";
							$db=mysql_query($delete_query);
							
							$delete_query1="delete from inquiry where inquiry_id='".$del_record_id."'";
							$db1=mysql_query($delete_query1);
							
							$delete_query11="delete from followup_details where student_id='".$del_record_id."'";
							$db2=mysql_query($delete_query11);

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
								setTimeout('document.location.href="manage_student.php";',1000);
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
    <td colspan="16">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                
                <td width="6%">
                        <select name="selAction" id="selAction" style="width:80px" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                        </select></td>
                       	<td width="4%"> <a href="export_inquiries.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
						<?php if($_SESSION['type']=='S')
						{
							?>
							<td width="8%">
							<select name="branch_name" id="branch_name" onchange="select_branch(this.value)"  class="input_select" >
								<option value="">Branch</option>
								<?php 
									$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($data_branch['branch_name']==$_GET['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
							</select>
							</td>
							<?php
						}
						?>
                        <!--<td width="8%" id="status_id">
                        <select name="status_type" class="input_select">
                        	<option value="">Type</option>
                            <option value="all_campaign" <?php //if($_REQUEST['status_type'] =='all_campaign') echo 'selected="selected"' ?>>Campaign Enquiries</option>
                            <option value="all_enquiries" <?php //if($_REQUEST['status_type'] =='all_enquiries') echo 'selected="selected"' ?>>All Enquiries</option>
                            <option value="all_enrolled" <?php //if($_REQUEST['status_type'] =='all_enrolled') echo 'selected="selected"' ?>>All Enrolled</option>
                            <option value="all_closed" <?php //if($_REQUEST['status_type'] =='all_closed') echo 'selected="selected"' ?>>Closed Enquiries</option>
                        </select>
                        </td>-->
                        <td width="12%" id="added_by">
                        <select name="enquiry_added" class="input_select">
                        	<option value="">Added by</option>
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
						<td width="12%" id="assigned_by">
                        <select name="assigned_to" class="input_select">
                        	<option value="">Assigned to</option>
                             <?php
								 $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and type='C' order by name asc"; 
								 $ptr_name=mysql_query($sle_name);
								 while($data_name=mysql_fetch_array($ptr_name))
								 {
									$selected='';
									if($data_name['admin_id'] == $_GET['assigned_to'])
									{
										$selected='selected="selected"';
									}
									 echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
								 }
							 ?>
                        </select>
                        </td>
                        <td width="10%" id="source_by">
							<select id="enquiry_src" name="enquiry_src" class="input_select">
							<option value="">Source by</option>
								<?php 
                                /*$course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                                $ptr_course_cat = mysql_query($course_category);
                                while($data_cat = mysql_fetch_array($ptr_course_cat))
                                {
                                    echo " <optgroup label='".$data_cat['branch_name']."'>";
                                    $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute'";
                                    $ptr_src=mysql_query($sel_source);
                                    while($data_src=mysql_fetch_array($ptr_src))
                                    {
                                        $sele_source="";
                                        if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
                                        {
                                            $sele_source='selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
                                        <?
                                    }
                                    echo " </optgroup>";
                                }*/
                                ?>
								<?php 
                                $course_category="select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                                $ptr_course_cat= mysql_query($course_category);
                                while($data_cat= mysql_fetch_array($ptr_course_cat))
                                {
                                    echo "<optgroup label='".$data_cat['branch_name']."'>";
                                    $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' order by campaign_name asc";
                                    $ptr_src=mysql_query($sel_source);
                                    while($data_src=mysql_fetch_array($ptr_src))
                                    {
                                        $sele_source="";
                                        if($data_src['campaign_id'] == $_REQUEST['enquiry_src'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
                                        {
                                            $sele_source='selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($_REQUEST['enquiry_src']) && $_REQUEST['enquiry_src'] == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
                                        <?
                                    }
                                    echo " </optgroup>";
                                }?>
							</select>
						</td>
                        <td width="10%"><select id="response" name="response" class="input_select">
                            <option value="">Response by</option>
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
                            <!--<td width="8%">
                                <select id="date_by" name="date_by" class="input_select">
                                    <option value="">Date by</option>
                                    <option value="inquiry_by" <?php //if($_REQUEST['date_by']=="inquiry_by") echo 'selected="selected"'; ?> >Inquiry Added</option>
                                    <option value="followup_by" <?php //if($_REQUEST['date_by']=="followup_by") echo 'selected="selected"'; ?>>Followup date</option>
                                </select>
                            </td>-->
                            <td width="10%">
                                <select id="followup_by" name="followup_by" class="input_select">
                                    <option value="">Followups</option>
                                    <option value="followup_pending" <?php if($_REQUEST['followup_by']=="followup_pending") echo 'selected="selected"'; ?>>Pending Followups</option>
                                    <option value="followup_completed" <?php if($_REQUEST['followup_by']=="followup_completed") echo 'selected="selected"'; ?>>Completed Followup</option>
                                </select>
                            </td>
							<td width="8%"><input type="text" class="input_text datepicker" name="start_date" placeholder="From" id="dob" value="<?php if($_POST['start_date']!="") echo $_POST['start_date']; else echo $_GET['start_date'];?>" /></td>
                            
							<td width="8%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="To" value="<?php if($_POST['end_date']!="") echo $_POST['end_date']; else echo $_GET['end_date'];?>"  /></td>
							<!--<td width="10%"><input type="submit" name="search" value="Search" class="input_Button"/></td>-->
							<td width="8%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                            <td width="5%" align="right"><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
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
                                $pre_keyword =" and (firstname like '%".$keyword."%' || middlename like '%".$keyword."%' || lastname like '%".$keyword."%' || username like '%".$keyword."%' || mobile1 like '%".$keyword."%' ".$cm_id_filter." ".$course_name_filter." ".$enquiry_added." || address like '%".$keyword."%' || email_id like '%".$keyword."%' || status like '%".$keyword."%' || enquiry_source like '%".$keyword."%' || response like '%".$keyword."%')";
                            }                            
                       	else
                            $pre_keyword="";
							
                        $search_cm_id='';
						$branch_name='';
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
						
						
						/*if($_REQUEST['date_by']=="followup_by")
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
						{*/						
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
						//}
							
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
							$assigned_to="and employee_id='".$assigned."' and employee_id!=''";
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
							if($resp=="not_intrested")
							{
								$response="and (response='7' or response='8')";
							}
							else if($resp=="walkedin")
							{
								$response="and (response='1' or lead_category_followup='walkin_followup')";
							}
							else
								$response="and response='".$resp."'";
						}
						
						
						$where_followup='';
						if($_REQUEST['followup_by'])
						{
                            $followup_by=$_REQUEST['followup_by'];
							if($followup_by=="followup_pending")
							{
								$where_followup=" and (followup_date IS NULL or followup_date='')";
							}
							else if($followup_by=="followup_completed")
							{
								$where_followup=" and (followup_date IS NOT NULL or followup_date!='')";
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
						echo "<br/>".$sql_query= "SELECT * FROM inquiry where 1 ".$status_type." ".$record_cat_id." ".$cm_ids." ".$search_cm_id." ".$pre_keyword." ".$enquiry_added." ".$assigned_to." ".$enquiry_src." ".$response." ".$where_followup." ".$pre_from_date." ".$pre_to_date." ".$c_id." ".$select_directory.""; 
						//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$branch_name.'&enquiry_added='.$enquiry_ad.'&assigned_to='.$_REQUEST['assigned_to'].'&enquiry_src='.$enq_src.'&response='.$response.'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'&status_type='.$_REQUEST['status_type'];
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
    <td width="10%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a>
    <td width="7%" align="center"><strong>Course Name</strong></td>
    <?php
	if($_SESSION['type']=="S")
	{
		?>
		<td width="5%" align="center"><strong>Branch Name</strong></td>
		<?php
	}
	?>
    <!--<td width="9%"><strong>Contact No  </strong></td>-->
    <td width="7%"  align="center"><strong>Added By</strong></td>
	<td width="7%" align="center"><strong>Assigned To</strong></td>
    <td width="6%"  align="center"><strong>Source</strong></td>
    <td width="6%"  align="center"><strong>Respose Category</strong></td>
    <td width="6%"  align="center"><strong>Enquiry Date</strong></td>
    <td width="40%" align="center"><strong>Followup Description</strong></td>
    <!--<td width="30%" align="center"></td>
    <td width="30%" align="center"></td>
    <td width="30%" align="center"></td>-->
	</tr>
    <!--<tr class="grey_td" >
    <td width="30%" align="center">Followup date</td>
    <td width="30%" align="center">Followup Desc</td>
    <td width="30%" align="center">Added Date</td>
    <td width="30%" align="center">Status</td>
	</tr>-->
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								/* $sel_inqury_id="select inquiry_id from inquiry where email_id='".$val_query['mail']."' and birth_date='".$val_query['dob']."' and address='".$val_query['address']."' and education='".$val_query['qualification']."'";
								$ptr_inquery_id=mysql_query($sel_inqury_id);
								$data_inquiry_id=mysql_fetch_array($ptr_inquery_id);
								 $inquiry_id=$data_inquiry_id['inquiry_id'];*/
								 
								/*"<br />".$sel_name_inq="select * from inquiry where inquiry_id='".$val_query['class_id']."'";
								$ptr_name_inq=mysql_query($sel_name_inq);
								$data_names_inq=mysql_fetch_array($ptr_name_inq);*/
								
								$sel_curse="select course_name from courses where course_id='".$val_query['course_id']."' ";
								$ptr_course=mysql_query($sel_curse);
								$data_course_name=mysql_fetch_array($ptr_course);
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_names=mysql_fetch_array($ptr_name);
								
								$asssign_name='';
								"<br />".$sel_name_assign="select name from site_setting where admin_id='".$val_query['employee_id']."'";
								$ptr_name_assign=mysql_query($sel_name_assign);
								if(mysql_num_rows($ptr_name_assign))
								{
									$data_names_assign=mysql_fetch_array($ptr_name_assign);
									$asssign_name=$data_names_assign['name'];
								}
								
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['inquiry_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
								
								if($val_query['response']=="7" || $val_query['response']=="8")
								{
									$bgcolor='style="background-color:#FA8072"';
								}
								
								if($val_query['status'] =="Enrolled")
								{
									$bgcolor='style="background-color: #58d68d "';
								}
                                
                                echo '<tr '.$bgcolor.' >';
								echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td align="left">';
								
								echo '<a href="followup_details.php?record_id='.$listed_record_id.'" target="_blank">'.$val_query['firstname']." ".$val_query['middlename']." ".$val_query['lastname'];
								if($val_query['mobile1'])
									echo'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['mobile1'];
								if($val_query['email_id'])
									echo '<br /> <img src="images/mail.png">'.$val_query['email_id'];
								if($val_query['address'])
									echo '<br /> <img src="images/address.png" height="18" width="18">'.$val_query['address'];
								
								echo'</a>';								
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
								/*echo '<td align="center">'.$val_query['mail'].'</td>';*/
								
								echo '<td align="center">'.$data_names['name'].'</td>';
								echo '<td align="center">'.$data_names_assign['name'].'</td>';
								
								//==================Change source tableto campaign table on 24-4-18====================
								$enq_source=$val_query['campaign_id'];
								"<br/>". $enq_src="select campaign_name from campaign where campaign_id='".$val_query['enquiry_source']."'";
								$ptr_enq_src=mysql_query($enq_src);
								if(mysql_num_rows($ptr_enq_src))
								{
									$data_enq_src=mysql_fetch_array($ptr_enq_src);
									$enq_source=$data_enq_src['campaign_name'];
								}
								echo '<td align="center">'.$enq_source.'</td>';
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
								else if($val_query['response'] == "7")
								{
									$response="Not Intrested";
								}
								else if($val_query['response'] == "8")
								{
									$response="Invalid";
								}
								else 
									$response=$val_query['response'];
								
								$sep_date=explode(" ",$val_query['added_date']);
								$inquiry_date=$sep_date[0];
								
								echo '<td align="center">'.$response.'</td>';
								//echo '<td align="center">'.$val_query['response'].'</td>';
								
								$sep_folldate=explode(" ",$val_query['followup_date']);
								$follow_date=$sep_folldate[0];
								echo '<td align="center">'.$inquiry_date.'</td>';
								
								//----------------------------------------------------------------------------
								echo '<td align="center">';
								$select_last_followup ="select * from followup_details where student_id='".$listed_record_id."' and followup_details!='' order by added_date asc ";
								$ptr_last_followup=mysql_query($select_last_followup);
								$total_foll=mysql_num_rows($ptr_last_followup);
								if($total_foll >0)
								{
									echo '<table width="100%">';
									$i=1;
									echo '<tr style="border-bottom:">';
									echo '<td><strong>Sr. No</strong></td>';
									echo '<td><strong>Call date</strong></td>';
									echo '<td><strong>Follwup Description</strong></td>';
									echo '<td><strong>Next Follwup date</strong></td>';
									echo '<td><strong>Status</strong></td>';
									echo '</tr>';
									$last_followup_date='';
									while($data_last_followup = mysql_fetch_array($ptr_last_followup))
									{
										$status='';
										$curdates=date('Y-m-d H:i:s');
										$a_date=explode(" ",$data_last_followup['added_date']);
										$added_date=$a_date[0];
										if($i!=1)
										{
											
											$datetime1 = new DateTime($added_date);
											$datetime2 = new DateTime($last_followup_date);
										
											if($datetime1 >$datetime2)
												$status='<strong><span style="color:red">Missed</span></strong>';
											else 
												$status='<strong><span style="color:green">Call</span></strong>';
										}
										else if($data_last_followup['followup_date']>$curdates)
											$status='<strong><span style="color:red">Missed</span></strong>';
										else
											$status='<strong><span style="color:blue">In Process</span><strong>';
											
										 
										echo '<tr>';
										echo '<td width="10%">';
											echo $i.".";
										echo '</td>';
										
										echo '<td width="30%">';
											echo $added_date;
										echo '</td>';
										echo '<td width="60%">';
											echo $data_last_followup['followup_details'];
										echo '</td>';
										echo '<td width="30%">';
											echo $data_last_followup['followup_date'];
										echo '</td>';
										echo '<td width="30%">';
											echo $status;
										echo '</td>';
										echo '</tr>';
										$last_followup_date=$data_last_followup['followup_date'];
										$i++;
									}
									echo '</table>';
								}
								else
									echo '<strong>Followup Not Taken</strong>';
									
								echo '</td>';
								//------------------------------------------------------------------------------
								
								//echo '<td style="" align="center">'.$val_query['followup_details'].'</td>';
								//------------------------------------------------------------------------------
								
								
                                echo '</tr>';
                                $bgColorCounter++;
                            }  
							?>
							 <tr class="grey_td" >
    <td colspan="5" align="center"><strong>Total Records</strong></td>
    
    <td colspan="5" align="left"><strong><?php echo $no_of_records;?></strong></td>
  
  </tr>
							  
                                
  
  
  <tr class="head_td">
    <td colspan="16">
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
<?php
/*if($_GET['branch_name']!='')
{
	?><script>select_branch('<?php echo $_GET['branch_name'];?>')</script><?php
*/
?>
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
