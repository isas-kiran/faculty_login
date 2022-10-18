 <?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
	
    $sql_record= "SELECT * FROM add_group where group_id='".$record_id."' ".$_SESSION['where_admin_id']."";
	
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));

 $sql_record1= "SELECT * FROM add_group_detail where group_id='".$record_id."' ".$_SESSION['where_admin_id']."";
	
    if(mysql_num_rows($db->query($sql_record1)))
    $row_record1=$db->fetch_array($db->query($sql_record1));
    else
    $record_id=0;
    $record_id1=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($_REQUEST['record_id']) { echo "Edit"; } else { echo "Add"; }  ?> Group</title>
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
<!--End multiselect -->
   
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">
	jQuery(document).ready( function() 
	{
		$("#requirment_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	</script>
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
		
     
$(document).ready(function() {
    $("#send_to").change(function() {
        var selVal = $(this).val();
		//alert(selVal);
        $("#customise").html('');
		
        if(selVal=='student') 
		{
            $("#customise").append('<table width="100%"><tr><td width="245px">Select Type</td><td><select name="type" id="type" onChange="select_type();"><option value="">Select Type</option><option value="enquiry">Enquiry</option><option value="enrolled">Enrolled</option></select></td></tr></table>');
			
		}
		else{
		}
    });
});

	 </script>
    

 
   
<script type="text/javascript">
	
//Edit the counter/limiter value as your wish
var count = "160";   //Example: var count = "175";
function limiter(){
var tex = document.jqueryForm.text.value;
var len = tex.length;
if(len > count){
        tex = tex.substring(0,count);
        document.jqueryForm.text.value =tex;
        return false;
}
document.jqueryForm.limit.value = count-len;
}


</script> 
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "include/sms_mail_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                    $errors=array(); 
					$i=0;
                    $success=0;
                    if($_POST['save_changes'])
                    {
						$group_name = ( true == isset( $_POST['group_name'] )) ? $_POST['group_name'] : "";
					   	$send_to = ( true == isset( $_POST['send_to'] )) ? $_POST['send_to'] : "";                 
                        $branch_name=$_POST['branch_name'];
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    	<?php
                        }
                        else
                        {
                            $success=1;
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$branch_name1=$branch_name;
								$cm_id1=$data_branch['cm_id'];
								$data_record['cm_id'] =$cm_id1;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id1=$_SESSION['cm_id'];
								$data_record['cm_id'] =$cm_id1;
							}
							
                            $data_record['group_name'] =$group_name;
							$data_record['send_to'] = $send_to;
							$data_record['admin_id']=$_SESSION['admin_id'];
							$data_record['added_date']=date('Y-m-d H:i:s');
							
						//====================================================================
                        if($_REQUEST['record_id'])
						{
							  
							$where_record="group_id='".$record_id."'";                                
                            $db->query_update("add_group", $data_record,$where_record);    
						   
							$delete_query="delete from ".$GLOBALS["pre_db"]."add_group_detail where group_id='".$_REQUEST['record_id']."'";
                            $db->query($delete_query);
							$staff_privilege_id = $_POST['requirment_id'];
							for($h=0;$h<count($staff_privilege_id);$h++)
							{
								$insert_sms1="insert into add_group_detail (`group_id`,`id`) values('".$_REQUEST['record_id']."','".$staff_privilege_id[$h]."')";
								$ptr_sms1=mysql_query($insert_sms1);
							} 
							echo ' <br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div> <br></br>';									
						}
						else
						{
							"<br/>".$insert_sms="insert into add_group (`group_name`,`send_to`,`admin_id`,`cm_id`,`added_date`) values('".$group_name."','".$send_to."','".$_SESSION['admin_id']."','".$cm_id1."','".date('Y-m-d')."')";
							$ptr_sms=mysql_query($insert_sms);
							$id_test=mysql_insert_id();
							$staff_privilege_id = $_POST['requirment_id'];
							  
							for($h=0;$h<count($staff_privilege_id);$h++)
							{
								$insert_sms1="insert into add_group_detail (`group_id`,`id`) values('".$id_test."','".$staff_privilege_id[$h]."')";
						  		$ptr_sms1=mysql_query($insert_sms1);
							} 
							echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div> <br></br>';
						}	  
					}
				}
            	if($success==0)
            	{
                	?>
            		<tr><td>
        			<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" >
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
            		<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            		<?php 
					if($_SESSION['type']=='S')
					{
						?>
                        <tr>
                            <td>Select Branch</td>
                            <td>
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
                                echo ' <select id="branch_name" name="branch_name">';
                                while($row_branch = mysql_fetch_array($query_branch))
                                {
                                    ?>
                                    <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
                            
                                    </option>
                                    <?php
                                }
                                echo '</select>';
                                echo "</td></tr></table>";
                                ?>
                            </td>
                        </tr>
                        <?php 
					}  
					else 
					{ 	
						?>
						<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
					 	<?php 
					}?>                   
					<tr>
						<td width="20%">Group Name <span class="orange_font">*</span></td>
						<td width="40%" ><input type="text" class="input_text" name="group_name" id="group_name" value="<?php echo $row_record['group_name']; ?>"/></td>
					</tr>
                	<tr>
                    	<td height="43">Send To <span class="orange_font">*</span></td>
                    	<td>
                    	<select name="send_to" id="send_to" > <!--onChange="select_type();"-->
                    		<option value="">Select Option</option>
                    		<option value="student" <?php if($row_record['send_to']=='student') { echo 'selected';} else { echo ""; } ?>>Student</option>
                    		<option value="staff" <?php if($row_record['send_to']=='staff') { echo 'selected';} else { echo ""; } ?>>Staff</option>
                    	</select>
                    </td>
                	</tr>
			 		<tr>
						<td colspan="3"> <div id="customise"></div></td> 
		   			</tr>
					<?php if($_REQUEST['record_id']) 
					{
						?>
                        <tr>
            <td width="20%">Select Staff/Student<span class="orange_font">*</span></td>
			<td width="40%">
			<select  multiple="multiple" name="requirment_id[]" id="requirment_id" class="input_select" style="width:150px;">
			<?php 						
			if($row_record['send_to']=='student') 
			{
				echo '<optgroup label="Select Student">  ';
				$sel_child="select distinct enroll_id,name from enrollment where 1";
				$query_child=mysql_query($sel_child);
		
				while($fetch_child=mysql_fetch_array($query_child))
				{
			
					if($_REQUEST['record_id'])
					{
						 $sql_sub_cat = "select * from add_group_detail where enroll_id='".$fetch_child['id']."'";
						$ptr_sub_cat = mysql_query($sql_sub_cat);
						
						if(mysql_num_rows($ptr_sub_cat))
						{
						$class = 'selected="selected"';
						}
						else { $class = ''; }
					}
					echo '<option '.$class.' value="'.$fetch_child['enroll_id'].'" >'.$fetch_child['name'].'</option>';
					$i++;
				}
	    		echo '</optgroup>';  
			}
			else 
			{ 

				echo '<optgroup label="Select Staff">  ';
				$sel_child="select distinct contact_phone,name from site_setting where 1";
				$query_child=mysql_query($sel_child);
		
				while($fetch_child=mysql_fetch_array($query_child))
				{
					if($_REQUEST['record_id'])
					{
						$sql_sub_cat = "select * from add_group_detail where admin_id='".$fetch_child['id']."'";
						$ptr_sub_cat = mysql_query($sql_sub_cat);

						if(mysql_num_rows($ptr_sub_cat))
						{
							 $class = 'selected="selected"';
						}
						else { $class = ''; }
					}
					echo '<option '.$class.' value="'.$fetch_child['admin_id'].'" >'.$fetch_child['name'].'</option>';
					$i++;
				}
				echo '</optgroup>';  
 
			} ?>
		</select>
		</td> 
		<td width="40%"></td>
		</tr>	
<?php
} 
else 
{
?>
    <tr>
    <td width="20%">Select Staff/Student<span class="orange_font">*</span></td>
    <td width="40%" id="showdiv">
    <select  multiple="multiple" name="requirment_id[]" id="requirment_id" class="input_select" style="width:150px;">
    </select>
    </td> 
    <td width="40%"></td>
    </tr>
<?php 
} 
?>
            <tr>
                <td>&nbsp;</td>
                <td>
			
                <input type="submit" id="mySubmit" class="input_btn" value="<?php if($_REQUEST['record_id']) { echo "Edit"; } else { echo "Add"; }  ?> Record"  <?php echo $disbled; ?> name="save_changes"  />
              
                </td>
                <td></td>
            </tr>
        </table>
        </form>
        
        <script language="javascript"> 
		function select_type() 
		{
			var send_to = $("#send_to").val();
			var type = $("#type").val();
			var branch_name = $("#branch_name").val();
			if(send_to!='' && type!='')
			{
        		$.ajax({ 
				//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        	type: 'post',
            	url: 'select_type.php',
            	data: { send_to: send_to,type:type,branch_name:branch_name },
            
       			}).done(function(responseData) {
				//alert(responseData);
				//$("#requirment_id").multiselect().multiselectfilter();
				$("#showdiv").html(responseData);
        		}).fail(function() {
            	console.log('Failed');
        		});
			}

    	}
		</script>
       
        </td></tr>
<?php
                        }?>
	 
        </table></td>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>