<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT batch_time FROM  batch_time where batch_time_id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Batch Time</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
							$branch_name=$_POST['branch_name'];
                            $source_name=$_POST['batch_time'];
                            if($source_name =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter batch time ";
                            }  
                            if($record_id =='')  {
                                $select_exist_userTable = "SELECT batch_time FROM batch_time where batch_time='".$source_name."'";
                                if(mysql_num_rows($db->query($select_exist_userTable)))	
                                {
                                        $success=0;
                                        $errors[$i++]="This batch  time is already exists, please choose another one";
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
								
                                $data_record['batch_time'] =$source_name;
								$data_record['added_date'] = date('Y-m-d H:i:s');
//                                $data_record['country_id'] = $country_code;
								//===============================CM ID for Super Admin===============
								if($_SESSION['type']=='S')
								{
									$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									if(mysql_num_rows($ptr_branch))
									{
										$data_branch=mysql_fetch_array($ptr_branch);
										$cm_id=$data_branch['cm_id'];
										$data_record['cm_id'] =$cm_id;
									}
									else
									{
										?>
										<script>alert("You cant update ...! First create center manager for this branch or you can add new one record")</script>
										<?php
										exit();
									}
								}
								else
								{
									$branch_name1=$_SESSION['branch_name'];
									$cm_id=$_SESSION['cm_id'];
									$data_record['cm_id'] =$cm_id;
								}
								//====================================================================
                               if($record_id)
                                {
                                    $where_record=" batch_time_id ='".$record_id."'";
                                    $db->query_update("batch_time", $data_record,$where_record);
									
									"<br>".$sql_query= "SELECT batch_time FROM batch_time where batch_time_id ='".$record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_batch_time','Edit','Batch Time-".$fetch['batch_time']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("batch_time", $data_record);
									
									"<br>".$sql_query= "SELECT batch_time FROM batch_time where batch_time_id ='".$record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_batch_time','Add','Batch Time-".$fetch['batch_time']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        //United States USA
                          //  Canada CAN
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              <?php
            	if($_SESSION['type']=='S')
                {
                ?>
                      <tr>
                      	<td>Select Branch</td>
                        <td>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
							</option>
							<?php
						}
							echo '</select>';
							echo "</td></tr></table>";
							?>
						</td>
                	</tr>
       			<?php }
	   			else { ?>
       					<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
      			<?php }?>
              <tr>
                <td width="20%">Add Batch Time <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="batch_time" id="batch_time" value="<?php if($_POST['save_changes']) echo $_POST['batch_time']; else echo $row_record['batch_time'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
                            
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Batch Time" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
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