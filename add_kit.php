<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT kit_id,kit_name, cm_id FROM  kit where kit_id ='".$record_id."'";
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
 <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	pageName="add_kit";
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
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
	
	 <script language="javascript" src="js/script.js"></script>
      <script language="javascript" src="js/conditions-script.js"></script>
	
  <script type="text/javascript">
  
function getqty(product_id,ids)
{
//alert(product_id);
//alert(ids);
var data1="product_id="+product_id;
 //alert(data1)
  $.ajax({
            url: "kit_product_qty.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				
				var exit_disc=document.getElementById("tot_prod_qty"+ids).value = html;
				<?php if(!$record_id)
				{ ?>
				var exit_qty=document.getElementById("product_qty"+ids).value = 1;
		  <?php } ?>
		}
  });
}

function validation(product_qty,idsss)
{
	//alert(product_qty)
	tot_prod_qty=document.getElementById("tot_prod_qty"+idsss).value;
	//alert(tot_prod_qty)
	
	if(product_qty > tot_prod_qty )
	{
		alert("Quantity is not Greater than Total Quantity");
		document.getElementById("product_qty"+idsss).value=1;
		return false;
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
							$kit_name=$_POST['kit_name'];
							
							$branch_name=$_POST['branch_name'];
                              
						   if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
								
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
								
							}
                            $total_floor=$_POST['floor'];
							
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
								
								$data_record['kit_name'] =$kit_name;
								$total_floor=$_POST['no_of_floor'];
								$data_record['added_date'] = date('Y-m-d H:i:s');
								
                               if($record_id)
                                {
                                    $where_record="kit_id ='".$record_id."'";
                                    $db->query_update("kit", $data_record,$where_record);
									
									for($z=1;$z<=$total_floor;$z++)
									{
										
										if($_POST['del_floor'.$z]=='yes')
										{
											if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
											{
												 $delete_row = " delete from kit_items_map where kit_prod_map_id='".$_POST['floor_id'.$z]."' ";
												$ptr_delete = mysql_query($delete_row);
											}
										}
										if($_POST['del_floor'.$z] !='yes')
										{
											$data_record_kit['kit_id'] =$record_id; 
											$data_record_kit['product_id'] =$_POST['product_id'.$z];
											$data_record_kit['product_qty'] =$_POST['product_qty'.$z];
											$data_record_kit['added_date'] = date('Y-m-d H:i:s');
											
											if($_POST['floor_id'.$z]=='' && $_POST['product_id'.$z] !='')
											{
											 	$type1_id=$db->query_insert("kit_items_map", $data_record_kit);
												
											}
											else
											{
												$where_record="kit_prod_map_id='".$_POST['floor_id'.$z]."'";
												$floor_id= $_POST['floor_id'.$z];
												$db->query_update("kit_items_map", $data_record_kit,$where_record);
											}
											unset($data_record_kit);
									   	}
									}
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("kit", $data_record);
									$kit_id=mysql_insert_id();
									
									for($i=1;$i<=$total_floor;$i++)
									{
										$data_record_kit['kit_id'] =$kit_id; 
										$data_record_kit['product_id'] =$_POST['product_id'.$i];
										$data_record_kit['product_qty'] =$_POST['product_qty'.$i];
										$data_record_kit['added_date'] = date('Y-m-d H:i:s');
										
										$kit_prod_id=$db->query_insert("kit_items_map", $data_record_kit);
										
										
									}
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
        <form method="post" id="jqueryForm" enctype="multipart/form-data" onSubmit="return validme();">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              
              <?php if($_SESSION['type']=='S')
					{
					?>
					  <tr>
						<td>Select Branch</td>
						<td>
						<?php 
						if($_REQUEST['record_id'])
						{
							$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A' ";
							$ptr_query=mysql_query($sel_cm_id);
							$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo ' <select id="branch_name" name="branch_name" >';
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

				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?> 
              
              <tr>
                <td width="20%">Kit Name <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="kit_name" id="kit_name" value="<?php if($_POST['save_changes']) echo $_POST['kit_name']; else echo $row_record['kit_name'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
			  
     <tr>
          <td colspan="3">
          
          <table width="100%" >
          <tr>
            	<td width="18%">Select Product<span class="orange_font">*</span></td>
            	<td width="70%" colspan="2">
                <table  width="75%" style="border:1px solid gray; ">
                    <tr>
                    <td colspan="2">
                    <!--===========================================================NEW TABLE START===================================-->
                    <table cellpadding="5" width="100%" >
                     <tr>
                     
                     <?php
					 if($record_id =='')
					 {
						?>
                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                        <?php 
					 }?>
                     <script language="javascript">
                                
                                function floors(idss)
                                {
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="4%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:200px" onChange="getqty(this.value,'+idss+')"><option value="">Select Product</option><?php
									 $sel_tel = "select product_id,product_name,quantity from product where quantity > 0 ".$_SESSION['where']." order by product_id asc";	 
									$query_tel = mysql_query($sel_tel);
									if($total=mysql_num_rows($query_tel))
									{
										while($data=mysql_fetch_array($query_tel))
										{
											echo '<option value="'.$data['product_id'].'">'.$data['product_name'].'&emsp;( Qty-> '.$data['quantity'].' )</option>';
										}
									} 
									 ?>
									 </select></td><td width="3%" align="center"><input type="text" name="tot_prod_qty'+idss+'" id="tot_prod_qty'+idss+'" style=" width:100px" readonly="readonly"/></td><td width="3%" align="center"><input type="text" name="product_qty'+idss+'" id="product_qty'+idss+'" style=" width:100px" onkeyup="validation(this.value,'+idss+')"/></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       <td align="right"><input type="button"  name="Add"s class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
    <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
    </td></tr>
                            <tr><td>  </td><td align="left"></td></tr>
                    </table> 
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    <tr>
                        <td colspan="7">
                        <table cellspacing="3" id="tbl" width="100%">
                        <tr>
                        <td valign="top" width="33%" align="center">Product Name</td>
                        <td valign="top" width="20%"  align="center">Total Quantity</td>
						<td valign="top" width="20%"  align="center">Quantity</td>
                        
                        </tr>
                        <tr>
                            <td colspan="7">
							<?php
                              $select_exc = "select * from kit_items_map where kit_id='".$record_id."' order by kit_prod_map_id asc ";
                            $ptr_fs = mysql_query($select_exc);
                            $t=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs)) 
                            { 
                                 $slab_id= $data_exclusive['kit_prod_map_id'];  
                            ?> 
                             <div class="floor_div" id="floor_id<?php echo $t; ?>">
                             <table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
                              <tr>
                                <td width="34%" align="center"><table cellspacing="5" id="tbl<?php echo $t; ?>2" width="100%">
                                  <tr>
                                    <td valign="top" width="32%" align="center">
                                    <select name="product_id<?php echo $t; ?>" id="product_id<?php echo $t; ?>" style="width:200px" onChange="getqty(this.value,'<?php echo $t; ?>')"> 
                                      <option value="">Select Product</option>
                                      <?php
										 $sel_tel = "select product_id,product_name,quantity from product where quantity > 0 ".$_SESSION['where']." order by product_id asc";	 
										$query_tel = mysql_query($sel_tel);
										if($total=mysql_num_rows($query_tel))
											{
												while($data=mysql_fetch_array($query_tel))
												{
													$selected='';
													if($data_exclusive['product_id'] ==$data['product_id'] )
													{
														$selected='selected="selected"';
													}
													echo '<option value="'.$data['product_id'].'" '.$selected.'>'.$data['product_name'].'</option>';
												}
											}
													
										 ?>
                                    </select></td>
                                    <td width="34%" align="center"><input type="text" name="tot_prod_qty<?php echo $t; ?>" id="tot_prod_qty<?php echo $t; ?>" readonly="readonly" style=" width:100px"  /></td>
                                     <td width="20%" align="center"><input type="text" name="product_qty<?php echo $t; ?>" id="product_qty<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['product_qty'] ?>" onkeyup="validation(this.value,<?php echo $t; ?>)"/></td> 
                                    <td valign="top" width="34%" align="center"><?php
								 	if($record_id)
								 	{
										?>
                                        <input type="hidden" name="total_product[]" id="total_product<?php echo $t; ?>" />
                                        <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['kit_prod_map_id'] ?>" />
                                        <input type="button" title="Delete Options(-)" onClick="delete_rec(<?php echo $t; ?>,'floor');" class="delBtn" name="del" />
                                        <input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
                               <?php } ?>
                                   	</td>
                                 </tr>
                                </table></td>
                              </tr>
                              </table>
                            </div>
                            <?php
                            $t++;
                           }
                            ?>
                        </tr> 
                        </table>
                         <input type="hidden" name="floor" id="floor"  value="0" />
                        <div id="create_floor"></div>
                    </td></tr></table>
                     <?php
					 if($record_id)
					 {
						?>
                    <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
                    <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
                    <?php } ?> 
                    <!--============================================================END TABLE=========================================-->
                    </td>
                    </tr>
                </table>
             </td>
             </tr>
             </table>
             
             </td>
         </tr>
			  
			
                   
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Kit" name="save_changes"  /></td>
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

<script language="javascript">
//create_floor('add');
//create_floor_dependent();
</script>
</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<?php if($record_id)
{ ?>

<script language="javascript">

var total_product= document.getElementsByName("total_product[]");
totals=total_product.length;
//alert(totals)

     for(i=1; i<=totals;i++)
		{
			product_ids=document.getElementById("product_id"+i).value;
			//alert(product_ids)
		     getqty(product_ids,i);
		}
</script>
<?php } ?>
</body>
</html>
<?php $db->close();?>