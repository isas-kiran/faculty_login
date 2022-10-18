<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
/*if($_REQUEST['record_id'])
{
	
    $record_id=$_REQUEST['record_id'];
	$record_id_course=$_REQUEST['course_batch_id'];
	
    $sql_record= "SELECT * FROM batch where batch_id='".$record_id."' ".$_SESSION['where_admin_id']."";
	
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}*/
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Course</title>
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
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
    </script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
    <td class="top_mid" valign="bottom"><?php include "include/sms_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['send'])
                    {
						$users=$_POST['users'];
						$message=$_POST['message'];
						$_SESSION['users']=$users;
						$_SESSION['message']=$message;
						$type = $_POST['type'];
						$branch=$_POST['branch_name'];
						
						$select_cm_id="select `branch_name`,`cm_id` from `site_setting` where `branch_name`='".$branch."' and `type`='A'";
						$ptr_cm_id=mysql_query($select_cm_id);
						$data_cm_id=mysql_fetch_array($ptr_cm_id);
						if($_SESSION['type']=='S')
						{
						$cm_id="and (cm_id='".$data_cm_id['cm_id']."')";
						}
						else
						{
							$cm_id="and (cm_id='".$_SESSION['cm_id']."')";
						}
						
						if($type=='all')
						{ 
							$sql_mobile="SELECT contact_phone,name,type,designation FROM site_setting where (type='A' or type='C' or type='B' or type='F') ".$cm_id." ";
							$result_mobile=mysql_query($sql_mobile);
							while($row_mobile=@mysql_fetch_array($result_mobile))
							{
								$mobilenumbers=$row_mobile['contact_phone'];
								echo "<br />".$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$row_mobile['name']."','".$mobilenumbers."','".$message."','".$row_mobile['designation']."','other','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//send_sms($row_mobile['contact_phone'],$message);
							}
						}
						if($type=='cm')
						{ 
							$sql_mobile="SELECT contact_phone,name,type,designation FROM site_setting where (type='A') ".$cm_id." ";
							$result_mobile=mysql_query($sql_mobile);
							while($row_mobile=@mysql_fetch_array($result_mobile))
							{
								$mobilenumbers=$row_mobile['contact_phone'];
								$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$row_mobile['name']."','".$row_mobile['contact_phone']."','".$message."','".$row_mobile['designation']."','other','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//send_sms($row_mobile['contact_phone'],$message);
							}
						}

						if($type=='councellor')
						{ 
							$sql_mobile="SELECT contact_phone,name,type,designation FROM site_setting where (type='C') ".$cm_id." ";
							$result_mobile=mysql_query($sql_mobile);
							while($row_mobile=@mysql_fetch_array($result_mobile))
							{
								$mobilenumbers=$row_mobile['contact_phone'];
								$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$row_mobile['name']."','".$row_mobile['contact_phone']."','".$message."','".$row_mobile['designation']."','other','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//send_sms($row_mobile['contact_phone'],$message);
							}
						}
if($type=='bop')
						{ 
							$sql_mobile="SELECT contact_phone,name,type,designation FROM site_setting where (type='B') ".$cm_id." ";
							$result_mobile=mysql_query($sql_mobile);
							while($row_mobile=@mysql_fetch_array($result_mobile))
							{
								$mobilenumbers=$row_mobile['contact_phone'];
								$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$row_mobile['name']."','".$row_mobile['contact_phone']."','".$message."','".$row_mobile['designation']."','other','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//send_sms($row_mobile['contact_phone'],$message);
							}
						}
						if($type=='faculty')
						{ 
							$sql_mobile="SELECT contact_phone,name,type,designation FROM site_setting where (type='F') ".$cm_id." ";
							$result_mobile=mysql_query($sql_mobile);
							while($row_mobile=@mysql_fetch_array($result_mobile))
							{
								$mobilenumbers=$row_mobile['contact_phone'];
								$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$row_mobile['name']."','".$row_mobile['contact_phone']."','".$message."','".$row_mobile['designation']."','other','".$_SESSION['cm_id']."','".date('Y-m-d H:i:s')."')";
								$ptr_sms=mysql_query($insert_sms);
								//send_sms($row_mobile['contact_phone'],$message);
							}
						}


						
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
                            
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form name="frmTakeAction" method="post" id="form1" >
	
	                    <div class="content-box">
				
				<div class="content-box-header">
					
					<h3>Send Message To Users</h3>
				</div> 
				
				<div class="content-box-content"> <br> 

<table width="100%" border="0" cellspacing="0" cellpadding="1" >
 <tr>
							<td colspan="2">	
		</td>							
		</tr>
        <?php
		if($_SESSION['type']=='S')
						{
		?>
    <tr>
    	<td><font color="red">*</font><b>BRANCH</b></td>
    	<td>
			<?php 
            $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
            $query_branch = mysql_query($sel_branch);
            $total_Branch = mysql_num_rows($query_branch);
            echo '<table width="100%"><tr><td>';
            echo ' <select id="branch_name" name="branch_name">';
            
            while($row_branch = mysql_fetch_array($query_branch))
            {
				$selected='';
				if($_POST['branch_name'] == $data_cm_id['branch_name'])
				{
					$selected='selected="selected"';
				}
                ?>
                <option value="<?php echo $row_branch['branch_name'];?>" <?php echo $selected;?> ><? echo $row_branch['branch_name']; ?> 
                </option>
                <?
            
            }
                echo '</select>';
                echo "</td></tr></table>";
                ?>
        </td>
    </tr> 
    <?php } ?>    
    <TR class="field">
    <TD><font color="red">*</font><b>USERS</b></td>
    <td>
    <select name="type">
    <option value="all" >Select All </option>
    <?php 
	if($_SESSION['type']=='S')
	{
		?>
        <option value="cm" >Center Manager </option>
        <?php
	}
	?>
    <option value="councellor">Councellor</option>
    <option value="bop"> BOP </option>
    <option value="faculty">Faculty </option>
    <option value="student"> Student </option>
    </select>
    </td>
    </TR>
<tr>
<td></td><td>
  <input type="hidden" name="formAction" id="formAction" value=""/>
<div id="user_div"></div>
</td></tr>
<tr>
<td></td><td>
<div id="another_div"></div>
</td></tr>
<TR class="field">
                <TD><font color="red">*</font><B>MESSAGE </B></TD>
                <TD><textarea name="message" rows="5" cols="40" class="text-input medium-input"><?php echo $_SESSION['message']; ?></textarea></TD>
                </TR>
                
                <TR class="field">
                <TD><input class="button" type="submit" value="Send" name="send"/></TD>
                <TD></TD>
                </TR>
                </TABLE>
                <div class="clear"></div><!-- End .clear -->
                </form>
         <?php
		if($record_id)
		{
			?>
        <script language="javascript"> 
		course_ajax(<?php echo $c; ?>);
		</script>
        <?php } ?>
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