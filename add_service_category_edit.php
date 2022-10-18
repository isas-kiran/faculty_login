<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
     $sql_record= "SELECT * FROM service_category where service_category_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
	{
        $row_record=$db->fetch_array($db->query($sql_record));
		
		$sql_point= "SELECT * FROM service_category where service_category_id='".$record_id."'";
        if(mysql_num_rows($db->query($sql_point)))
        $row_record_point=$db->fetch_array($db->query($sql_point));
	}
    else
	{
        $record_id=0;
	}
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Product category Edit</title>
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
    
<!-- <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
					    $pcategory_name=$_POST['pcategory_name'];
						$total_floor=$_POST['floor'];
                         
						if($pcategory_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Service";
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
                          
							$data_record['category_name'] =$pcategory_name;
							
                            $data_record['added_date'] = date('Y-m-d H:i:s');
							 
							 
                            if($record_id)
                            {
                                $where_record="service_category_id='".$record_id."'";   
                                $db->query_update("service_category", $data_record,$where_record); 
								
								 //==================================================For Type1=============================================================	                              
								 
                               		for($j=1;$j<=$total_floor;$j++)
									{ 
 												if($_POST['sub_name'.$j] !='' || $_POST['del_floor'.$j]=='yes')
												{
													 
													if($_POST['floor_id'.$j]!='' && $_POST['del_floor'.$j]=='yes' )
													{
														
														 $delete_row = " delete from  service_subcategory where sub_id='".$_POST['floor_id'.$j]."' ";
														$ptr_delete = mysql_query($delete_row);
														
													}
												} 
												 
											if($_POST['sub_name'.$j] !='' && $_POST['del_floor'.$j] !='yes')
											{ 
												    $data_record_type1['category_id']=$_GET['record_id'];  
													$data_record_type1['sub_name'] = addslashes(trim($_POST['sub_name'.$j])); 
													
												 '<br/>type1_id=>'.$_POST['floor_id'.$j];
												 if($_POST['floor_id'.$j]=='' && $data_record_type1['sub_name'] !='')
												   {
														  $type1_id=$db->query_insert("service_subcategory", $data_record_type1);
														  
												   }else
													{ 
													 
														$where_record="sub_id='".$_POST['floor_id'.$j]."'";
														$type1_id= $_POST['floor_id'.$j];
													   
														$db->query_update("service_subcategory", $data_record_type1,$where_record);
																
													 }
											 
											 unset($data_record_type1);
											
										 }
									   
									}
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_service_category','Edit','".$pcategory_name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
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
            
             <tr>
                	<td width="10%">Category Name</td>.
               		<td width="50%"><input type="text" name="pcategory_name" id="pcategory_name" class="validate[required] input_text" value="<?php if($_POST['save_changes']) echo $_POST['pcategory_name']; else echo $row_record['category_name'];?>" style="width:500px"></td>
                      
              </tr>
              
              <tr>
             	<td colspan="3">
                  <table  width="80%" style="border:0px solid gray; ">
                    <tr>
                    <td></td>
                    <td colspan="2">
                     <!--===========================================================NEW TABLE START===================================-->
                        <table cellpadding="5" width="100%" >
                        <tr><td ><b>Gallery Image</b> </td>
                        <script language="javascript">
						function floors(idss)
						{
							
							var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="80%"><tr><td style="width:12%;">Subcategory '+idss+'</td><td valign="top" width="10%" ><input type="text" name="sub_name'+idss+'" style="width:300px" id="sub_name'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
							document.getElementById('floor').value=idss;
						return shows_data;
						}
									
						</script>
                        
                         
                           <td align="right" width="9%"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
  </td></tr>
                                <tr><td>  </td><td align="left"></td></tr>
                        </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                        <tr>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        </tr>
  <!--<tr>
                            <td valign="top" width="1%" align="center">Position</td>
                            <td valign="top" width="4%" align="center">Tag</td>
                            <td valign="top" width="6%" align="center" >Comment</td>
                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>
                             </tr>
  <tr>-->
                            <td colspan="6">
                            
                             <?php
							$select_exc = "select * from service_subcategory where category_id='".$_GET['record_id']."' order by  sub_id  asc ";
							$ptr_fs = mysql_query($select_exc);
							$t=1;
							$total_conditions= mysql_num_rows($ptr_fs);
							while($data_exclusive = mysql_fetch_array($ptr_fs))
							{ 
								$pcategory_id= $data_exclusive['sub_id'];
							?> 
                            <div class="floor_div" id="floor_id<?php echo $t; ?>">
                            <table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
                            
                            <tr>
                            <td width="20%">Subcategory <?php echo $t; ?></td>
                            <td valign="top" width="40%" align=""><input type='text' style="width:300px" name='sub_name<?php echo $t ?>' id='sub_name<?php echo $t ?>' value='<?php echo $data_exclusive['sub_name'] ?>'/></td>
                           
                            <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['sub_id'] ?>" />
                            
                            <td width="9%"><input type="button" title="Delete Options(-)" onClick="delete_rec(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
                            <input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" /></td>
                             </tr></table>
                             </div>
							<?php
							$t++;
								}
							?>
                            <div id="create_floor"></div>
                             <input type="hidden" name="floor" id="floor"  value="0" />
                        </td></tr></table>
                        <?php echo "Total Floor".$total_conditions; ?>
                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
                        <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
                        <!--============================================================END TABLE=========================================-->
                        
                        </td>
                        </tr>
                                        
                                    </table>
                               
                 </td>
              </tr>
                
             <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> product category" name="save_changes"  /></td>
               
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
<script language="javascript">
if($("#no_of_floor").val()==0)
{
create_floor('add');
}
/*
if($("#type1").val()==0)
{
create_type1('add_type1');
}

if($("#type2").val()==0)
{
create_type2('add_type2');
}
*/</script>
<script language="javascript">
create_floor('add');
/*create_type1('add_type1');
create_type2('add_type2');*/

//create_floor_dependent();
</script>

</body>
</html>
<?php $db->close();?>