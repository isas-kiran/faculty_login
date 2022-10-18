<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
	$book_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM lb_book where book_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Book</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready( function() 
{
	// binds form submission and fields to the validation engine
	jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
     <!-- Multiselect -->
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
<script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
<script type="text/javascript" src="multifilter/assets/prettify.js"></script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{            
	$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
	$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
	{
		res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
	}
	$("#cust_type").chosen({allow_single_deselect:true});
	$("#book_id").chosen({allow_single_deselect:true});
	$("#customer_id").chosen({allow_single_deselect:true});
});
</script>
<script>
function validme()
{
		frm = document.jqueryForm;
		error='';
		disp_error = 'Clear The Following Errors : \n\n';
		if(frm.product_name.value=='')
		{
			 disp_error +='Enter Product Name\n';
			 document.getElementById('product_name').style.border = '1px solid #f00';
			 frm.product_name.focus();
			 error='yes';
	    }
		if(frm.product_code.value=='')
		{
			 disp_error +='Enter Product Code \n';
			 document.getElementById('product_code').style.border = '1px solid #f00';
			 frm.product_code.focus();
			 error='yes';
	    }
		if(frm.pcategory_id.value=='')
		{
			 disp_error +='Please select a Category \n';
			 document.getElementById('pcategory_id').style.border = '1px solid #f00';
			 frm.pcategory_id.focus();
			 error='yes';
	    }
		if(frm.size.value=='')
		{
			 disp_error +='Enter Size \n';
			 document.getElementById('size').style.border = '1px solid #f00';
			 frm.size.focus();
			 error='yes';
	    }
		if(frm.units.value=='')
		{
			 disp_error +='Enter Unit \n';
			 document.getElementById('units').style.border = '1px solid #f00';
			 frm.units.focus();
			 error='yes';
	    }
		if(frm.price.value=='')
		{
			 disp_error +='Enter Price  \n';
			 document.getElementById('price').style.border = '1px solid #f00';
			 frm.price.focus();
			 error='yes';
	    }
		
		if ((frm.type[0].checked == false ) && ( frm.type[1].checked == false ) && ( frm.type[2].checked == false ))
		{
		 	//alert ( "Please Select Type" );
		 	disp_error +='Please Select Type   \n';
		 	//document.getElementById('type').style.border = '1px solid #f00';
			//frm.type.focus();
			error='yes';
		}
		if(error=='yes')
		{
			 alert(disp_error);
			 return false;
		}
		else
		return true;
	 }

function show_data(id)
{
	//var record_id= document.getElementById('record_id').value;
	var data1="action=show_data&action_page=issue_book&id="+id; //+'&record_id='+record_id
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$('#show_type').html(html);
		$("#realtxt").chosen({allow_single_deselect:true});
		$("#customer_id").chosen({allow_single_deselect:true});
		
	}
	});
}
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
 <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#vendor_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
	function selectalls() 
	{
		if($("#selectall").attr("checked")==true){
		$('.case').each(function() {
		$(this).attr('checked','checked');
		showservice();
		});
		}else{
		$('.case').each(function() {
		$(this).attr('checked','');
		showservice();
		});
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
    <td class="top_mid" valign="bottom"><?php include "include/library_menu.php"; ?></td>
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
							$user_type=($_POST['cust_type']) ? $_POST['cust_type'] : "";
                            $book_id=($_POST['book_id']) ? $_POST['book_id'] : "0";
                            $customer_id=($_POST['customer_id']) ? $_POST['customer_id'] : "0";
							$days=($_POST['days']) ? $_POST['days'] : "0";
							$branch_name=$_POST['branch_name'];
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record['cm_id']=$cm_id;
							}
							if($record_id=='')
							{
								  $sel_product="select book_id from lb_book_category where book_name ='".$book_name."' and cm_id='".$cm_id."' ";
								  $ptr_product=mysql_query($sel_product);
								  if(mysql_num_rows($ptr_product))
								  {
									$success=0;
									$errors[$i++]="Book name already exist.";
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
                                $data_record['user_type'] =$user_type;
								$data_record['book_id'] =$book_id;
                                $data_record['issue_to'] =$customer_id;				
								$data_record['issue_days'] =$days;
								$data_record['status'] ='active';
								$data_record['admin_id']=$_SESSION['admin_id'];
                               	if($record_id)
                                {
									$data_record['added_date'] =date("Y-m-d H:i:s");
                                    $where_record=" book_issue_id ='".$record_id."'";
                                    $db->query_update("lb_book_issue", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['issue_date'] =date("Y-m-d H:i:s");
									$data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("lb_book_issue", $data_record);
									$book_id=mysql_insert_id();
									
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Issue_book','Add','issue book','".$book_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  

									//=========================END GALLERY IMAGE===============================
                                    //echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Book Issue Successfully</p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
                                                                 }
                                                });
                                                
                                            });
                                        setTimeout('document.location.href="lb_manage_issue_book.php";',1000);
                                        </script>
         
                                    <?php
                                }
                            }
                        }
                        if($success==0)
                        {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data" name="jqueryForm" onSubmit="return validme()">
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
				<td width="14%" >Select Type<span class="orange_font">*</span></td>
				<td>
				<select id="cust_type" name="cust_type" onChange="show_data(this.value)" style="width:200px">
				<option value="">Select</option>
				<option value="Student" <?php if($row_record['type']=="Student") echo 'selected="selected"'; ?>>Student</option>
				<option value="Employee" <?php if($row_record['type']=="Employee") echo 'selected="selected"'; ?>>Employee</option>
				<option value="Customer" <?php if($row_record['type']=="Customer") echo 'selected="selected"'; ?>>Customer</option>
				
				</select>
				</td>
			</tr> 
            <tr>
                <td colspan="3">
                	<div id="show_type"></div>
                </td>
            </tr>
            <tr>
                <td>Select Book<span class="orange_font">*</span></td>
                <td width="70%">
                <select name="book_id" style="width:200px;" id="book_id" >
                    <option value="">Select Book</option> 
                      <?php  
                      $sql_dest ="select * from lb_book where 1 ".$_SESSION['where']." order by book_name asc";//".$_SESSION['user_id']."
                      $ptr_edes = mysql_query($sql_dest);
                      while($data_dist = mysql_fetch_array($ptr_edes))
                      { 
                          $selecteds = '';
                          if($data_dist['book_id']==$row_record['book_id'])
                            $selecteds = 'selected="selected"';	                                 
                          echo "<option value='".$data_dist['book_id']."' ".$selecteds.">".$data_dist['book_name']."</option>";
                      }
                      ?>
                </select>
                </td>
            </tr>
	       
            <tr>
                <td width="20%" valign="top">Days<span class="orange_font">*</span></td>
                <td width="70%"><input type="text" style="width: 100px" class="input_text" name="days" id="days" value="<?php if($_POST['save_changes']) echo $_POST['days']; else echo $row_record['days'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            
           	<tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="Save" name="save_changes" /></td>
                  <td></td>
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