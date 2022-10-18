<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM service_category where service_category_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='114'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Services Category</title>
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
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
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
                            $category_name=$_POST['category_name'];
							$total_floor=$_POST['floor'];
                            $sel_cat="select category_name from service_category where category_name ='".$category_name."' ";
							$ptr_cat=mysql_query($sel_cat);
							if(mysql_num_rows($ptr_cat))
							{
								$success=0;
								$errors[$i++]="Category Name already Exist.";
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
                               $data_record['category_name'] =$category_name;
							   //===============================CM ID for Super Admin===============
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
                                  
                                    $where_record=" service_category_id='".$record_id."'";
                                    $db->query_update("service_category", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                               }
                               else
                               {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $category_id=$db->query_insert("service_category", $data_record);
									//====================FOR Type1 INSERT=====================================
									for($j=1;$j<=$total_floor;$j++)
									{
										if($_POST['sub_name'.$j] !='')
										{
											$data_record_type1['category_id']=$category_id;
											$data_record_type1['sub_name'] = addslashes(trim($_POST['sub_name'.$j])); 
											$record_ids=$db->query_insert("service_subcategory",$data_record_type1);
											$sub_id=mysql_insert_id();  
                                         }
									}
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_service_category','Add','".$category_name."','".$category_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
               <?php
				if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
				?>
					<tr>
						<td align="center">Select Branch</td>
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
                  <td width="20%" valign="top">Service Category Name<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="validate[required] input_text" name="category_name" id="category_name" value="<?php if($_POST['save_changes']) echo $_POST['category_name']; else echo $row_record['category_name'];?>" /></td> 
                <td width="10%"></td>
              </tr>
             <tr>
                <td colspan="3">
                  <table  width="80%" style="border:0px solid gray; ">
                    <tr>
                        <td colspan="2">
                        <!--===========================================================NEW TABLE START===================================-->
                        <table cellpadding="5" width="100%" >
                         <tr>
                         <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                         
                         <script language="javascript">
                                    
                                    function floors(idss)
                                    {
                                        var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="80%"><tr><td style="width:10%;">Subcategory '+idss+'</td><td valign="top" width="10%" ><input type="text" name="sub_name'+idss+'" id="sub_name'+idss+'" required/></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                        document.getElementById('floor').value=idss;
                                        return shows_data;
                                    }
                                    
                            </script>
                         
                         
                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
  </td></tr>
                                <tr><td>  </td><td align="left"></td></tr>
                        </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
  <tr>
                            <td colspan="6">
                            <!--<table cellspacing="3" id="tbl" width="100%">
                            <tr>
                            <td valign="top" width="1%" align="center">Position</td>
                            <td valign="top" width="10%" align="center">Tag</td>
                            <td valign="top" width="10%" align="center" >Comment</td>
                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>
                             </tr></table>-->
                             <input type="hidden" name="floor" id="floor"  value="0" />
                            <div id="create_floor"></div>
                        </td></tr></table>
                        <!--============================================================END TABLE=========================================-->
                        </td>
                        </tr>
                                        
                                    </table>
                               
                 </td>
              </tr>
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Category" name="save_changes"  /></td>
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
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>