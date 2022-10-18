<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM membership where membership_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='120'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Membership</title>
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
        });
		
		
		
    </script>
 
 
<script type = "text/javascript">
function isNumber(evt) 
	{
    	evt = (evt) ? evt : window.event;
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
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
                            $membership_name=$_POST['membership_name'];
                            $validity=$_POST['validity'];  
							$price=$_POST['price']; 
							$discount=$_POST['discount'];  
							$loyality_point=$_POST['loyality_point'];
							
							if($record_id=='')
							 {
								  $sel_cat="select membership_name from membership where membership_name ='".$membership_name."' ";
								  $ptr_cat=mysql_query($sel_cat);
								  if(mysql_num_rows($ptr_cat))
								  {
									$success=0;
									$errors[$i++]="Membership Name already Exist.";
								  }
							 }
							
                            if(count($errors))
                            {
                                ?>
                                <tr>
                                    <td> <br></br>
                                    <table align="left" style="text-align:left;" class="alert">
                                    <tr><td ><strong>Please correct the following errors</strong><ul>
                                            <?php
                                            for($k=0;$k<count($errors);$k++)
                                                    echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                            </ul>
                                    </td></tr>
                                    </table>
                                    </td>
                                </tr>   <br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
                                $data_record['membership_name'] =$membership_name;
                                $data_record['validity'] =$validity;
								$data_record['price'] =$price;
								$data_record['discount'] =$discount;
								$data_record['loyality_point']=$loyality_point;
								//===============================CM ID for Super Admin===============
								if($_SESSION['type']=='S')
								{
									$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id=$data_branch['cm_id'];
									$data_record['cm_id'] =$cm_id;
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
                                  
                                    $where_record=" membership_id='".$record_id."'";
                                    $db->query_update("membership", $data_record,$where_record);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_membership','Edit','".$membership_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);  
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("membership", $data_record);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_membership','Add','".$membership_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
   <form method="post" id="jqueryForm" name="ContactForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
				 <?php
                if($_SESSION['type']=='S')
                {
                ?>
                    <tr>
                        <td >Select Branch</td>
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
                  <td width="15%" valign="top">Membership Name<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class=" input_text" name="membership_name" id="membership_name" value="<?php if($_POST['save_changes']) echo $_POST['membership_name']; else echo $row_record['membership_name'];?>" required/></td> 
                  <td width="10%"></td>
              </tr>
             
             
           <tr>
            <td width="15%" valign="top">Validity(in days) <span class="orange_font">*</span></td>
             <td width="70%"><input type="text"  class=" input_text" name="validity" id="validity" onKeyPress="return isNumber(event)" value="<?php if($_POST['save_changes']) echo $_POST['validity']; else echo $row_record['validity'];?>" required/></td> 
              <td width="10%"></td>

            </tr>
            
            <tr>
            <td width="15%" valign="top">Price (Non Taxable)<span class="orange_font">*</span></td>
             <td width="70%"><input type="text"  class=" input_text" name="price" id="price" value="<?php if($_POST['save_changes']) echo $_POST['price']; else echo $row_record['price'];?>" required/></td> 
              <td width="10%"></td>

            </tr>
            
            <tr>
            <td width="15%" valign="top">Loyality Point</td>
             <td width="70%"><input type="text"  class=" input_text" name="loyality_point" id="loyality_point" value="<?php if($_POST['save_changes']) echo $_POST['loyality_point']; else echo $row_record['loyality_point'];?>" /></td> 
              <td width="10%"></td>

            </tr>
            
             <tr>
                  <td width="20%" valign="top">Discount(in %)</td>
                <td width="70%"><input type="text"  class=" input_text" name="discount" id="discount" value="<?php if($_POST['save_changes']) echo $_POST['discount']; else echo $row_record['discount'];?>"/></td> 
                <td width="10%"></td>
              </tr>
              
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Membership" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
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