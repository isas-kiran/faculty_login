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
<title>Followup Summery</title>
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
		
function date()
 {
 var followup_date= document.getElementById('followup_date');
 alert (followup_date)
 var date = new Date();
 if(followup_date < Date())
 {
	alert("Followup Date should Be Greater than Todays Date");
	document.getElementById('followup_date').style.border = '1px solid #f00';
 }
 }
 
 
 function validme()
	 {
		 frm = document.frmTakeAction;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 if(frm.followup_date.value=='')
		 {
			 disp_error +='Enter followup date  \n';
			 document.getElementById('followup_date').style.border = '1px solid #f00';
			 frm.followup_date.focus();
			 error='yes';
	     }
		 else
		 {
			 
			if(isFeatureDate(frm.followup_date.value))
	 	 		{
		 		}
			 else
			 {
				 disp_error +='Enter Valid Follow (feature) up Date\n';
				  document.getElementById('followup_date').style.border = '1px solid #f00';
				 error='yes';
			 }
		 }
		 
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
		 
	 }
	 
	 
	 
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
		
		
		function show_staff(branch_id)
{
	//var record_id= document.getElementById("record_id").value;
	var bank_data="action=enrollment&branch_id="+branch_id;
	//alert(bank_data);
	$.ajax({
	url: "show_councellor.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		//alert(retbank);
		document.getElementById("employee_id").innerHTML=retbank;
	}
	}); 
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
  <?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT followup_id FROM ".$GLOBALS["pre_db"]."followup_details where followup_id ='".$del_record_id."'";
								$my_query=mysql_query($sql_query);
								
                                if(mysql_num_rows($my_query))
                                    {       
										$data_delete=mysql_fetch_array($my_query);         
										                                
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."followup_details where followup_id='".$del_record_id."'";
                                        $db->query($delete_query);      
										
										
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
                        $sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
                        $db->query($delete_query);
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
    <td class="mid_mid">
    
    							<?php
    						if($_POST['save_changes'])
                        	{
								$lead_category_followup=$_POST['lead_category_followup'];
								$lead_grade=$_POST['lead_grade'];
								$followup_date1=$_POST['followup_date'];
								$followup_details=$_POST['followup_details'];
								$student_id=$record_id;	
								$cm_id= $_POST['cm_id'];
								if($followup_date1 !='//' )
								{
								
									$sep_date = explode('/',$followup_date1);
									$followup_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];
									
								}
								else
								{
									if($followup_date1 <= date('(Y-m-d)') )
									{
										$success=0;
										$errors[$i++]="Invalid Followup Date";
									}
									 
									$success=0;
									$errors[$i++]="Enter your Followup Date";
								}	
								if(count($errors))
                                {
                                	?>
                                    <table width="90%" align="left" class="alert">
                                    <tr>
                                        <td align="left"><strong>Please correct the following errors</strong>
                                        <div style=" border: 1px solid #F00 ; padding-left:20px; background-color:#FC9">
                                            <?php
                                                                            for($k=0;$k<count($errors);$k++)
                                                                                    echo '<div style="text-align:left;padding:5px;">'.$errors[$k].'</div>';?>
                                          </div></td>
                                    </tr>
                                    </table>
                                    <br clear="all">
									<?php
                                }
								else
                                {
                                	$success=1;
									$insert_followup = "INSERT INTO `followup_details` (`student_id`,`lead_category_followup`,  `followup_date`, `lead_grade`,`followup_details`, `added_date`,`cm_id`,`admin_id`) VALUES ('$student_id','$lead_category_followup', '$followup_date', '$lead_grade','$followup_details', '".date('Y-m-d H:i:s')."','".$cm_id."','".$_SESSION['admin_id']."')";
 									$ptr_followup = mysql_query($insert_followup);
									$update_rec="update inquiry set followup_date='".$followup_date."' where inquiry_id='$student_id'";
									$ptr_update=mysql_query($update_rec);
									?>
                                	<script>
									alert("Record Successfully Updated");
									document.location.href="followup_summery.php?record_id=<?php echo $record_id; ?> ";
									</script>
									<?php
								}
                        	}
							$sql_records= "select inquiry_id,firstname,middlename,lastname,mobile1,email_id,course_id,enquiry_date, followup_date,lead_category_followup , lead_grade from inquiry where inquiry_id='".$record_id."' ".$pre_transcation_id." ".$pre_from_date." ".$pre_to_date." ".$pre_status." order by inquiry_id desc";
							$no_of_records=mysql_num_rows($db->query($sql_records));
							if($no_of_records)
							{
								$bgColorCounter=1;
								if(!$_SESSION['showRecords'])
									$_SESSION['showRecords']=10;
								$query_string.="&show_records=".$showRecord;
								$pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
								$all_records= $pager->paginate();                                   
							}
							else
							{
							?>
 <!-- ================================================Start Table=============================================================================================-->

<table cellspacing="0" cellpadding="0" class="table" width="97%">
	<tr class="head_td">
    <td colspan="11">
        <form method="get" name="search">
			<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              	<tr>
                	<td class="width5"></td>
                	<!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                       	<td width="15%">
                        <select name="lead_grade" id="lead_grade" class="input_select_login" >
                        <option value="">- Lead Gtrade -</option>
                        <option value="very_hot"<?php if($_REQUEST['lead_grade']=="very_hot") echo "selected";  ?>>Very Hot</option>
                        <option value="hot"<?php if($_REQUEST['lead_grade']=="hot") echo "selected"; ?> >Hot</option>
                        <option value="warm"<?php if($_REQUEST['lead_grade']=="warm") echo "selected"; ?>>Warm</option>
                        <option value="nutral"<?php if($_REQUEST['lead_grade']=="nutral") echo "selected";  ?>>Neutral</option>
                        <option value="cold"<?php if($_REQUEST['lead_grade']=="cold") echo "selected"; ?>>Cold</option>
						</select>
                        </td>
						<?php 
						if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{ ?>
							<td width="20%">
							<?php 
							if($_REQUEST['record_id'])
							{
								$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
								$ptr_query=mysql_query($sel_cm_id);
								$data_branch_nmae=mysql_fetch_array($ptr_query);
							}
							$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
							$query_branch = mysql_query($sel_branch);
							$total_Branch = mysql_num_rows($query_branch);
							echo '<table width="100%"><tr><td>';
							echo ' <select id="branch_name" name="branch_name" onchange="show_staff(this.value)">';
							while($row_branch = mysql_fetch_array($query_branch))
							{
								?>
								<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_REQUEST['branch_name'] ==$row_branch['branch_name']) echo 'selected'; else echo ''; ?> /><?php echo $row_branch['branch_name']; ?> 
								</option>
								<?php
							}
							echo '</select>';
							echo "</td></tr></table>";
							?>
							</td>
							<?php
						} 
						else 
						{
							?>
                       		<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       		<?php 
						}?>
						
                        <td width="20%"> 
                        <?php 
						if($_REQUEST['employee_id']!='')
						{ 
							?>
							<select id="employee_id" name="employee_id">
							<option value="">--Select Staff--</option>
							<?php 
							$sel_branch = "SELECT * FROM site_setting where 1 and branch_name='".$_REQUEST['branch_name']."' order by admin_id asc ";	 
							$query_branch = mysql_query($sel_branch);
							$total_Branch = mysql_num_rows($query_branch);
							while($row_branch = mysql_fetch_array($query_branch))
							{
								?>
								<option value="<?php echo $row_branch['admin_id'];?>" <?php if ($_REQUEST['employee_id'] ==$row_branch['admin_id']) echo 'selected'; else echo ''; ?> /><?php echo $row_branch['name']; ?> 
								</option>
								<?php
							} ?>
							</select>	
							<?php 
						} 
						else 
						{	
							?>
                       		<select id="employee_id" name="employee_id">
							<option value="">--Select Staff--</option>
							</select>
							<?php 
						} ?>
                        </td>
                        <td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
                        <td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>
                         
                        <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                		<td class="rightAlign" > 
                    		<table border="0" cellspacing="0" cellpadding="0" align="right">
              					<tr>
              						<td></td>
              						<td class="width5"></td>
                					<!--<td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                					<td class="width2"></td>
                					<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>-->
              					</tr>
                    		</table>	
                		</td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    
    
    <?php
						
						
						if($_REQUEST['from_date'] || $_REQUEST['start_date'])
						{
							if($_REQUEST['from_date'])
							{
								$frm_date=explode("/",$_REQUEST['from_date']);
							}
							else if($_REQUEST['start_date'])
							{
								$frm_date=explode("/",$_REQUEST['start_date']);
							}
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							 
						  	$pre_from_date=" and followup_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date="";                            
						}
						if($_REQUEST['to_date'] || $_REQUEST['end_date'])
						{
							if($_REQUEST['to_date'])
							{
								$to_date=explode("/",$_REQUEST['to_date']);
							}
							else
							{
								$to_date=explode("/",$_REQUEST['end_date']);
							}
							
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							 
							$pre_to_date=" and followup_date<='".date('Y-m-d',strtotime($to_dates))."'";						
						}
						else
							$pre_to_date="";
							
						
						
                        if($_REQUEST['lead_grade'] && $_REQUEST['lead_grade']!="lead_grade" && $_REQUEST['lead_grade']!="")
                            $lead_grade=trim($_REQUEST['lead_grade']);
                        if($lead_grade)
						{                            
							$pre_lead_grade =" and lead_grade like '".$lead_grade."' ";
						}                            
                        else
                            $pre_lead_grade="";
							
                        if($_REQUEST['employee_id'] && $_REQUEST['employee_id']!="" )
						{
							 //$cm_id=trim($_REQUEST['consultant']);
							$consultant="and admin_id='".$_REQUEST['employee_id']."' ";
						}
						else
						{
							$consultant="";
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

                        if($_GET['orderby']=='followup_date' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='followup_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
						
                        $query_pm='student_id';
						if($_REQUEST['stack_report']=='1')
						{
							$query_pm=' DISTINCT(student_id)';
						}
						$response='';
						if($_REQUEST['response'])
						{
							$response=" and response='".$_REQUEST['response']."'";
						}
						
                        $select_directory='order by followup_id asc';                      
                       $sql_query= "select ".$query_pm." from followup_details where 1 ".$response." ".$_SESSION['where']." ".$pre_keyword." ".$pre_from_date." ".$pre_to_date." ".$pre_lead_grade." ".$consultant." ".$select_directory." "; 
                       //echo $sql_query;
					   	$db=mysql_query($sql_query);
                        $no_of_records=mysql_num_rows($db);
						
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword+'&stack_report='.$_REQUEST['stack_report'].'&employee_id='.$_REQUEST['employee_id'].'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&response='.$_REQUEST['response'].'&lead_grade='.$_REQUEST['lead_grade'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
   <!-- <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="15%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=followup_date".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>
    <td width="15%" align="center"><strong>Course Name</strong></td>
    <td width="10%" align="center"><strong>Contact No  </strong></td>
    <td width="10%" align="center"><strong>Followup Date</strong></td>
    <td width="15%" align="center"><strong>Lead Category </strong></td>
    <td width="10%" align="center"><strong>Lead Grade</strong></td>
    <td width="15%" align="center"><strong>Comment</strong></td>
    <td width="15%" align="center"><strong>Followup by</strong></td>
    <td width="15%" align="center"><strong>Status</strong></td>
     <td width="10%" align="center"><strong>Added Date</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								$sele_latest_rec="select inquiry_id,firstname,middlename,lastname, course_id, mobile1, followup_date,admin_id from inquiry where 1 and inquiry_id='".$val_query['student_id']."' ".$_SESSION['where']."  "; //and  followup_date >= '".date('Y-m-d')."'
								$ptr_select_letest_rec=mysql_query($sele_latest_rec);
								$val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);
															
								$select_course_id="select * from  courses where course_id='".$val_select_letest_rec['course_id']."' ";
								$ptr_select_course_id=mysql_query($select_course_id);
								$val_select_course=mysql_fetch_array($ptr_select_course_id);
								
								$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_name=mysql_fetch_array($ptr_name);
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['student_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
                                if($val_query['lead_category_followup']=='walkin_followup')
								$lead_cat= "Walk-in Followup";
								else
								$lead_cat= "Phone Followup";
								
								if($val_query['lead_grade']=="very_hot")
								{
									$lead_grade="Very Hot";
									$bgcolr="#980000";
									$color="#fff";
								}
								else if($val_query['lead_grade']=="hot")
								{
									$lead_grade="Hot";
									$bgcolr="#FF0000";
									$color="#fff";
								}
								else if($val_query['lead_grade']=="warm")
								{
									$lead_grade="Warm";
									$bgcolr="#F58F09";
									$color="#000";
								}
								else if($val_query['lead_grade']=="Nutral")
								{
									$lead_grade="Neutral";
									$bgcolr="#FFFF66";
									$color="#000";
								}
								else if($val_query['lead_grade']=="cold")
								{
									$lead_grade="Cold";
									$bgcolr="#377A07";
									$color="#000";
								}
								
                                echo '<tr '.$bgcolor.' >
                                     </td>'; // <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td align="center">';
								echo ' '.$val_select_letest_rec['firstname'].' ' .$val_select_letest_rec['lastname'].'';
								echo'</td>';
								echo '<td align="center">'.$val_select_course['course_name'].'</td>';  
                                echo '<td align="center">'.$val_select_letest_rec['mobile1'].'</td>';
                                echo '<td align="center">'.$val_select_letest_rec['followup_date'].'	</td>';
								echo '<td align="center">'.$lead_cat.'</td>';
								echo '<td align="center" bgcolor='.$bgcolr.' style="color:'.$color.'">'.$lead_grade.'</td>';
								echo '<td align="center">'.$val_select_letest_rec['followup_details'].'</td>';
								echo '<td align="center">'.$data_name['name'].'</td>';
								echo '<td align="center">'.$val_select_letest_rec['status'].'</td>';
								echo '<td align="center">'.$val_select_letest_rec['added_date'].'</td>';
								
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }  
							  
                                ?>
  
  
  <tr class="head_td">
    <td colspan="11">
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
<?

	//==========================================================END Table========================================================================================================
								}
								
								
                                    //echo'<center><br><div id="alert" style="width:30%">No Record history here</div><br></center>';
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
