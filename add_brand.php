<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM product_brand where brand_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;

}
?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='290'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Brand</title>
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
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
         });
		
  
      </script>
      

     <script language="javascript" src="js/script.js"></script>
     <script language="javascript" src="js/conditions-script.js"></script>
     
      <style>	
					 
	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
	.inactive{ background-color:#FFF;cursor:pointer; color:#000}
	.active{ background-color:#699;cursor:pointer; color:#FFF}
	.hidden{ display:none; width:0px; height:0px;}	
	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
	.pointer{ cursor:pointer;}
	</style>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
					    $brand_name=$_POST['brand_name'];
						$company_name=$_POST['company_name'];
						$inc_percentage=$_POST['inc_percentage'];
						$total_floor=$_POST['floor'];
						
						if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
						
						if($brand_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Product Brand Name";
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
							//$action=$_POST['chooseone'];
							$data_record['brand_name'] =addslashes($brand_name);
                            $data_record['company_name'] =$company_name;
							$data_record['inc_percenage'] =$inc_percentage;
                            $data_record['added_date'] = date('Y-m-d H:i:s');
							$data_record['admin_id']=$_SESSION['admin_id'];
                            if($record_id)
                            {
                                $where_record="brand_id='".$record_id."'";
                                $db->query_update("product_brand", $data_record,$where_record);
								
								$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_product_brand','Edit','".$brand_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else 
                            {
								$record_id=$db->query_insert("product_brand", $data_record);
																								 
								$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_product_brand','Add','".$brand_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
									
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
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <?php 
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
					<?php }  
					else { ?>
					   <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
					 <?php 
			}?>
            <tr>
            <tr>
             	<td width="10%">Brand Name <span class="orange_font">*</span></td>
               	<td width="50%"><input type="text" name="brand_name" id="brand_name" class="validate[required] input_text" value="<?php if($_POST['save_changes']) echo $_POST['brand_name']; else echo $row_record['brand_name'];?>" style="width:500px" required></td>
            </tr>
            <tr>
				<td width="20%" valign="top">Incentive in Percentage<span class="orange_font"> *</span></td>
            	<td><input type="text" name="inc_percentage" id="inc_percentage" class="validate[required] input_text" value="<?php if($_POST['save_changes']) echo $_POST['inc_percentage']; else echo $row_record['inc_percenage'];?>" style="width:500px" /></td>
			</tr>
			<tr>
				<td width="20%" valign="top">Company Name<span class="orange_font"> *</span></td>
            	<td><input type="text" name="company_name" id="company_name" class="validate[required] input_text" value="<?php if($_POST['save_changes']) echo $_POST['company_name']; else echo $row_record['company_name'];?>" style="width:500px" /></td>
			</tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Brand" name="save_changes"  /></td>
            </tr>
        </table>
        </form>
        </td></tr>
		<?php
      }
?>
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
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>

</body>
</html>
<?php $db->close();?>