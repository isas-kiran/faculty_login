<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT branch_name,branch_id,branch_address,gst_no FROM branch where branch_id ='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Branch</title>
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
							$branch_address=$_POST['branch_address'];
							$innocent_address=$_POST['innocent_address'];
							$frespa_address=$_POST['frespa_address'];
							$gst_no=$_POST['gst_no'];
							$capex_invest=$_POST['capex_invest'];
							
							if($branch_name =="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Branch Name ";
                            } 
							if(!$record_id)
							{
								$chek_ext="select setting_id, branch_name from general_settings where branch_name='".$branch_name."'";
								$quer_exit_chk=mysql_query($chek_ext);
								if(mysql_num_rows($quer_exit_chk))
								{
									$success=0;
                                    $errors[$i++]="Branch Name Already Exist ";
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
								$data_record['branch_name'] = $branch_name;
								$data_record['branch_address'] = $branch_address;
								$data_record['innocent_address'] = $innocent_address;
								$data_record['frespa_address'] = $frespa_address;
								$data_record['gst_no'] = $gst_no;
								$data_record['capex_invest'] = $capex_invest;
                               
                               if($record_id)
                                {
                                    $where_record=" branch_id ='".$record_id."'";
                                    $db->query_update("branch", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
									
                                }
                                else
                                {
                                    $record_id=$db->query_insert("branch", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              <tr>
                <td width="20%">Branch Name<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="input_text" name="branch_name" id="branch_name" value="<?php if($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_record['branch_name'];?>" /></td> 
                <td width="40%"></td>
              </tr>                
              <tr>
                <td width="20%">Isas Address</td>
                <td width="40%"><textarea name="branch_address" class="input_textarea"><?php echo $row_record['branch_address'] ?></textarea></td> 
                <td width="40%"></td>
              </tr>  
              <tr>
                <td width="20%">Innocent Address</td>
                <td width="40%"><textarea name="innocent_address" class="input_textarea"><?php echo $row_record['innocent_address'] ?></textarea></td> 
                <td width="40%"></td>
              </tr> 
			  <tr>
                <td width="20%">Frespa Address</td>
                <td width="40%"><textarea name="frespa_address" class="input_textarea"><?php echo $row_record['frespa_address'] ?></textarea></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td width="20%">GST No.</td>
                <td width="40%"><input type="text" class="input_text" name="gst_no" id="gst_no" value="<?php echo $row_record['gst_no'] ?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                    <td width="20%">CapEx Investment</td>
                    <td width="25%" class="customized_select_box"><input type="text" name="capex_invest" id="capex_invest" value="<?php if($_POST['capex_invest']) echo $_POST['capex_invest']; else echo $row_record['capex_invest']; ?>" >
                   </td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Branch" name="save_changes"  /></td>
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