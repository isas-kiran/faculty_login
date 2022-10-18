<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT cat_name,show_for_app,show_for_website FROM course_domain_category where cat_id ='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Course Domain</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        <?php
		$errors=array(); $i=0;
		$success=0;
		if($_POST['save_changes'])
		{
			//$branch_name=$_POST['branch_name'];
			$category_name=$_POST['cat_name'];
			$show_for_app=$_POST['show_for_app'];
			$show_for_website=$_POST['show_for_website'];
			if($category_name =="")
			{
					$success=0;
					$errors[$i++]="Enter Course domain name ";
			}  
			if($record_id =='')
			{
				$select_exist_userTable = "SELECT cat_name FROM course_domain_category where cat_name='".$category_name."'";
				if(mysql_num_rows($db->query($select_exist_userTable)))	
				{
					$success=0;
					$errors[$i++]="This domain name is already exists, please choose another one";
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
				 </td></tr><br></br>  
				<?php
			}
			else
			{
				$success=1;
				$data_record['cat_name'] =$category_name;
				$data_record['show_for_app'] =$show_for_app;
				$data_record['show_for_website'] =$show_for_website;
				//===============================CM ID for Super Admin===============
				/*if($_SESSION['type']=='S')
				{
					$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_branch=mysql_query($sel_branch);
					$data_branch=mysql_fetch_array($ptr_branch);
					$cm_id=$data_branch['cm_id'];
				}	
				else
				{
					$branch_name1=$_SESSION['branch_name'];
					$cm_id=$_SESSION['cm_id'];
				}*/
				//====================================================================
				//$data_record['cm_id'] = $cm_id;
				if($record_id)
				{
					$where_record=" cat_id ='".$record_id."'";
					$db->query_update("course_domain_category", $data_record,$where_record);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else
				{
					$record_id=$db->query_insert("course_domain_category", $data_record);
					echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				}
			}
		}
		if($success==0)
		{
			?>
			
			<form method="post" id="jqueryForm" enctype="multipart/form-data">
				<table cellspacing="3" cellpadding="3" width="95%">
					<tr>
						<td colspan="3" class="orange_font">* Mandatory Fields</td>
					</tr>
					<tr>
						<td width="20%">Course Domain Name<span class="orange_font">*</span></td>
						<td width="40%"><input type="text"  class="validate[required] input_text" name="cat_name" id="cat_name" value="<?php if($_POST['save_changes']) echo $_POST['cat_name']; else echo $row_record['cat_name'];?>" /></td> 
						<td width="40%"></td>
					</tr>
                    <tr>
						<td width="20%">Show for app<span class="orange_font">*</span></td>
						<td width="40%">
                        <select name="show_for_app" id="show_for_app" class="input_select" style="width:50px">
                        	<option value="y" <?php if($_POST['show_for_app']=='y') echo 'selected="selected"'; else if($row_record['show_for_app']=='y') echo 'selected="selected"'; ?>>Y</option>
                            <option value="n" <?php if($_POST['show_for_app']=='n') echo 'selected="selected"'; else if($row_record['show_for_app']=='n') echo 'selected="selected"'; ?>>N</option>
                        </select>
                        </td> 
						<td width="40%"></td>
					</tr>
                    <tr>
						<td width="20%">Show for Website<span class="orange_font">*</span></td>
						<td width="40%">
                        <select name="show_for_website" id="show_for_website" class="input_select" style="width:50px">
                        	<option value="y" <?php if($_POST['show_for_website']=='y') echo 'selected="selected"'; else if($row_record['show_for_website']=='y') echo 'selected="selected"'; ?>>Y</option>
                            <option value="n" <?php if($_POST['show_for_website']=='n') echo 'selected="selected"'; else if($row_record['show_for_website']=='n') echo 'selected="selected"'; ?>>N</option>
                        </select>
                        </td> 
						<td width="40%"></td>
					</tr>  
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Domain" name="save_changes" /></td>
						<td></td>
					</tr>
				</table>
			</form>
			
			<?php
		}?>
	 
     	
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>