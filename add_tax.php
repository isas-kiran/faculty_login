<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT service_tax,installment_course_percentage,cgst,sgst,igst,branch_name,tax_type FROM  general_settings where setting_id ='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Tax</title>
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
    <script>
	function change_tax_type(taxType)
	{
		if(taxType=='GST')
		{
			document.getElementById("gst_div").style.display="block";
			document.getElementById("service_tax_div").style.display="none";
		}
		else
		{
			document.getElementById("service_tax_div").style.display="block";
			document.getElementById("gst_div").style.display="none";
		}
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
							$tax_type=$_POST['tax_type'];
                            $service_tax=$_POST['service_tax'];
							//$installment_course=$_POST['installment_course'];
							$cgst=$_POST['cgst'];
							$sgst=$_POST['sgst'];
							$igst=$_POST['igst'];
							$installment_course_percentage=$_POST['installment_course_percentage'];
							
							$branch_name=$_POST['branch_name'];
							$rec_edit='';
							if($record_id)
							{
								$rec_edit="and setting_id !='".$record_id."'";
							}
							
							$chek_ext="select setting_id,branch_name from general_settings where branch_name='".$branch_name."' ".$rec_edit." ";
							$quer_exit_chk=mysql_query($chek_ext);
							if(mysql_num_rows($quer_exit_chk))
							{
								$success=0;
								$errors[$i++]="Tax Already Exist";
							}
							
							
                            /* if($service_tax =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Service Tax ";
                            }  */
							/* if($installment_course =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Installment in % ";
                            }   */
                           
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
								</td></tr><br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
								$data_record['tax_type'] =$tax_type;
								$data_record['cgst'] =$cgst;
								$data_record['sgst'] =$sgst;
								$data_record['igst'] =$igst;
								$data_record['branch_name'] = $branch_name;
								$data_record['admin_id'] = $_SESSION['admin_id'];
                                $data_record['service_tax'] =$service_tax;
								$data_record['installment_course_percentage'] =$installment_course_percentage;
								
                                //$data_record['installment_course_percentage'] = $installment_course;
								$data_record['added_date_time'] = date('Y-m-d H:i:s');
                               if($record_id)
                                {
                                    $where_record=" setting_id ='".$record_id."'";
                                    $db->query_update("general_settings", $data_record,$where_record);
																		
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_tax','Edit','tax','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									$_SESSION['service_tax']=$service_tax;
                					$_SESSION['installment_tax']=$installment_course;
									
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
									
                                }
                                else
                                {
                                    $record_id=$db->query_insert("general_settings", $data_record);
									
																		
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_tax','Add','tax','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									$_SESSION['service_tax']=$service_tax;
                					$_SESSION['installment_tax']=$installment_course;
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
                    
                    $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                    $query_branch = mysql_query($sel_branch);
                    $total_Branch = mysql_num_rows($query_branch);
                    echo '<table width="100%"><tr><td>'; 
                    echo ' <select id="branch_name" name="branch_name" >';
                    while($row_branch = mysql_fetch_array($query_branch))
                    {
                        ?>
                        <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$row_record['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
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
            <!--<tr>
                <td>Select Branch</td>
                <td>
                <?php 
                /*$sel_branch = "SELECT branch_name FROM branch where 1 order by branch_id asc ";	 
                $query_branch = mysql_query($sel_branch);
                $total_Branch = mysql_num_rows($query_branch);
                echo '<table width="100%"><tr><td>';
                echo ' <select id="branch_name" name="branch_name">';
                while($row_branch = mysql_fetch_array($query_branch))
                {
                    ?>
                    <option value="<? if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name']; ?>"><? echo $row_branch['branch_name']; ?> 
                    </option>
                    <?
                }
                echo '</select>';
                echo "</td></tr></table>";*/
            
                ?>
                </td>
            </tr>-->
            <tr>
                <td width="20%">Tax Type<span class="orange_font">*</span></td>
                <td width="40%"><input type="radio" class="validate[required] " name="tax_type" id="GST" value="GST" <?php if($_POST['tax_type']=='GST') echo 'checked="checked"'; else if($row_record['tax_type']=='GST') echo 'checked="checked"';?> onclick="change_tax_type(this.value)" /> GST<input type="radio" class="validate[required]" name="tax_type" id="service_tax" value="service_tax" <?php if($_POST['tax_type']=='service_tax') echo 'checked="checked"'; else if($row_record['tax_type']=='service_tax') echo 'checked="checked"';?> onclick="change_tax_type(this.value)" /> Service Tax</td> 
                <td width="40%"></td>
            </tr>
            <tr>
				<td colspan="3">
                	<table width="100%" id="service_tax_div" <?php if($row_record['tax_type']=='service_tax') echo 'style="display:block"'; else echo'style="display:none"' ?>>
                    	<tr>
                        	<td width="60%">Service Tax(in %) <span class="orange_font">*</span></td>
                            <td ><input type="text" width="200px" class="validate[required] input_text" name="service_tax" id="service_tax" value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td> 
                       	</tr>
                    </table>
                    <table width="100%" id="gst_div" <?php if($row_record['tax_type']=='GST') echo 'style="display:block"'; else echo'style="display:none"' ?>>
                      	<tr>
                        	<td width="60%">CGST(in %) <span class="orange_font">*</span></td>
                        	<td ><input type="text" class="validate[required] input_text" width="200px" name="cgst" id="cgst" value="<?php if($_POST['cgst']) echo $_POST['cgst']; else echo $row_record['cgst'];?>" /></td> 
                      	</tr>  
                      	<tr>
                        	<td width="60%">SGST(in %) <span class="orange_font">*</span></td>
                        	<td ><input type="text" class="validate[required] input_text" width="200px" name="sgst" id="sgst" value="<?php if($_POST['sgst']) echo $_POST['sgst']; else echo $row_record['sgst'];?>" /></td> 
                      	</tr>
                      	<tr>
                        	<td width="60%">IGST(in %) <span class="orange_font">*</span></td>
                        	<td ><input type="text"  class="validate[required] input_text" width="200px" name="igst" id="igst" value="<?php if($_POST['igst']) echo $_POST['igst']; else echo $row_record['igst'];?>" /></td> 
                      	</tr>
                    </table>
				</td>
            </tr>
            <!--<tr>
            	<td width="20%">Installment on Course(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="installment_course" id="installment_course" value="<?php //if($_POST['installment_course']) echo $_POST['installment_course']; else echo $row_record['installment_course_percentage'];?>" /></td> 
                <td width="40%"></td>
            </tr>-->                
			<tr>
            	<td width="20%">Installment On Course(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="installment_course_percentage" id="installment_course_percentage" value="<?php if($_POST['installment_course_percentage']) echo $_POST['installment_course_percentage']; else echo $row_record['installment_course_percentage'];?>" /></td>
                <td width="40%"></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Tax" name="save_changes"  /></td>
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