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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Kit</title>
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
                            $item_name=$_POST['item_name'];
							$item_price=$_POST['item_price'];
							$total_floor=$_POST['floor'];
							
                           
                            if($record_id =='')  {
                               
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
								
                                $data_record['item_name'] =$item_name;
								$data_record['item_price'] =$item_price;
								$data_record['added_date'] = date('Y-m-d H:i:s');
								
//                                $data_record['country_id'] = $country_code;
                               if($record_id)
                                {
                                    $where_record="item_id ='".$record_id."'";
                                    $db->query_update("items", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
									
									//=========================INSERT ITEM NAME============================
									///echo $total_floor;
									for($i=1;$i<=$total_floor;$i++)
									{
										if($_POST['item_name'.$i] !='')
										{
										$select_exist_userTable = "SELECT item_name FROM items where item_name='".$_POST['item_name'.$i]."'";
										if(mysql_num_rows($db->query($select_exist_userTable)))	
										{
												$success=0;
												$errors[$i++]="This '".$_POST['item_name'.$i]."' item is already exists, please choose another one";
										}
										else
										{
											$data_record['item_name'] =$_POST['item_name'.$i];
										$data_record['item_price'] =$_POST['item_price'.$i];
										//$data_record_gallery['added_date'] =date('Y-m-d H:i:s');
										//$record_id=$db->query_insert("event_gallary_image", $data_record_gallery);
										$insert_img="insert into items (`item_name`,`item_price`,`added_date`) values('".$data_record['item_name']."','".$data_record['item_price']."','".date('Y-m-d H:i:s')."')";
										$ptr_img=mysql_query($insert_img);
										}
										}
										
									}
									//=========================END ITEM NAME===============================
									
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
             <!-- <tr>
                <td width="20%">Kit Name <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="batch_time" id="batch_time" value="<?php if($_POST['save_changes']) echo $_POST['batch_time']; else echo $row_record['batch_time'];?>" /></td> 
                <td width="40%"></td>
              </tr> -->
              <tr><td colspan="3"> 
               <!--===========================================================NEW TABLE START===================================-->
                <table cellpadding="5" width="100%" >
                 <tr>
                 <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                 
                 <script language="javascript">
                            
                            function floors(idss)
                            {
                                
                                var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><td valign="top" width="10%" ><input type="text" name="item_name'+idss+'" id="item_name'+idss+'" /></td><td valign="top" width="10%" ><input type="text" name="item_price'+idss+'" id="item_price'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                document.getElementById('floor').value=idss;
                            return shows_data;
                            }
                            
                    </script>
                 
                 
                   <td><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
</td></tr>
                        <tr><td>  </td><td align="left"></td></tr>
                </table> 
                <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
<tr>
                    <td colspan="6">
                    <table cellspacing="3" id="tbl" width="100%">
                    <tr>
                    <td valign="top" width="10%" >Item Name</td>
                    <td valign="top" width="10%" >Item Price</td>
                     </tr></table>
                     <input type="hidden" name="floor" id="floor"  value="0" />
                    <div id="create_floor"></div>
                </td></tr></table>
                <!--============================================================END TABLE=========================================--> 
                </td>
                </tr>        
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Items" name="save_changes"  /></td>
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
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>