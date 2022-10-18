<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
$cm_id='';
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
	$book_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM lb_return_book where book_return_id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
	$cm_id=$row_record['cm_id'];
}
$book_issue_id='';
if($_REQUEST['book_issue_id']!='')
{
	$book_issue_id=$_REQUEST['book_issue_id'];
	$sel_book_issue="select * from lb_book_issue where book_issue_id='".$book_issue_id."'";
	$ptr_issue=mysql_query($sel_book_issue);
	$data_book_issue=mysql_fetch_array($ptr_issue);
	
	$cm_id=$data_book_issue['cm_id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Return Book</title>
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
	//alert(bank_id);
	var data1="action=show_data&id="+id;
	$.ajax({
	url: "get_books.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$('#show_type').html(html);
		$("#realtxt").chosen({allow_single_deselect:true});
		$("#customer_id").chosen({allow_single_deselect:true});
	}
	});
}
function show_books(cust_id)
{
	var data1="action=get_returned_book&id="+cust_id;
	//alert(data1);
	$.ajax({
	url: "get_books.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html!='')
		{
			$('#get_returned_book').html(html);
			$("#book_id").chosen({allow_single_deselect:true});
		}
		else
		{
			alert("There is no book for returned");
		}
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
							$days=($_POST['extra_days']) ? $_POST['extra_days'] : "0";
							$fine=($_POST['fine']) ? $_POST['fine'] : "0";
							$book_issue_id=($_POST['book_issue_id']) ? $_POST['book_issue_id'] : "0";
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
                                $data_record['return_by'] =$customer_id;				
								$data_record['extra_days'] =$days;
								$data_record['fine'] =$fine;
								if($days >0)
									$data_record['status'] ="Ontime";
								else
									$data_record['status'] ="Delayed";
								$data_record['admin_id']=$_SESSION['admin_id'];
								$data_record['book_issue_id']=$book_issue_id;
								$data_record['return_date']=date('Y-m-d H:i:s');
                               	if($record_id)
                                {
									$data_record['added_date'] =date("Y-m-d H:i:s");
                                    $where_record=" book_return_id ='".$record_id."'";
                                    $db->query_update("lb_book_return", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
									$data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("lb_book_return", $data_record);
									$ins_return_id=mysql_insert_id();
									
									$update_query="update lb_book_issue set status='inactive' where book_issue_id='".$book_issue_id."' and book_id='".$book_id."' and issue_to='".$customer_id."'";
									$ptr_update=mysql_query($update_query);
									
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Issue_book','Add','return book','".$ins_return_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);

									//=========================END GALLERY IMAGE===============================
                                    //echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Book Return successfully</p></center></div>
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
							if($cm_id)
							{
								$sel_cm_id="select branch_name from site_setting where cm_id=".$cm_id." ";
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
                <td>Select Type<span class="orange_font">*</span></td>
                <td width="70%">
                <select name="cust_type" style="width:200px;" id="cust_type" onChange="show_data(this.value)" >
                	<option value="">Select Type</option> 
                  	<option value="Student" <?php if($data_book_issue['user_type']=="Student") echo 'selected="selected"' ?>>Student</option>
					<option value="Employee" <?php if($data_book_issue['user_type']=="Employee") echo 'selected="selected"' ?>>Staff</option> 
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <input type="hidden" name="book_issue_id" id="book_issue_id" value="<?php echo $book_issue_id ?>"  />
                	<div id="show_type">
                    <?php
					if($data_book_issue['user_type']=="Student")
					{
						?>
                        <table>
                            <tr>
                                <td style="width:23%;">Select Student<span class="orange_font">*</span></td>
                                <td width="33%" id="sel_cust" class="customized_select_box">
                                <select name="customer_id" id="customer_id" style="width:200px;" onChange="show_books(this.value)" >
                                <option value="">Select Student</option> 
                                <?php  
                                $sql_cust = "select name, enroll_id from enrollment where 1 ".$_SESSION['where']." order by enroll_id asc";
                                $ptr_cust = mysql_query($sql_cust);
                                while($data_cust = mysql_fetch_array($ptr_cust))
                                {
									$selecteds='';
									if($data_book_issue['issue_to']==$data_cust['enroll_id'])
										$selecteds='selected="selected"';
										
                                    echo "<option value='".$data_cust['enroll_id']."' ".$selecteds.">".$data_cust['name']."</option>";
                                }
                                ?>
                                
                                </select>
                                <td width="10%"></td>
                            </tr>
                        </table>
                        <?php
					}
					else if($data_book_issue['user_type']=="Employee")
					{
						?>
                        <table>
                            <tr>
                                <td style="width:23%;">Select Employee<span class="orange_font">*</span></td>
                                <td width="33%" id="sel_cust" class="customized_select_box">
                                    <select name="customer_id" id="customer_id" style="width:200px;" onChange="show_books(this.value)" >
                                    <option value="">Select Employee</option> 
                                    <?php  
                                    $sql_cust = "select name, admin_id from site_setting where 1 ".$_SESSION['where']." order by admin_id asc";
                                    $ptr_cust = mysql_query($sql_cust);
                                    while($data_cust = mysql_fetch_array($ptr_cust))
                                    {
										$selecteds='';
										if($data_book_issue['issue_to']==$data_cust['admin_id'])
											$selecteds='selected="selected"';
                                        echo "<option value='".$data_cust['admin_id']."' ".$selecteds.">".$data_cust['name']."</option>";
                                    }
                                    ?>
                                    
                                    </select>
                                <td width="10%"></td>
                            </tr>
                         </table>
                        <?php
					}
					?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Select Book<span class="orange_font">*</span></td>
                <td width="70%" id="get_returned_book">
                <select name="book_id" style="width:200px;" id="book_id" >
                    <option value="">Select Book</option> 
                      <?php  
                      $sql_dest ="select * from lb_book where 1 ".$_SESSION['where']." order by book_name asc";//".$_SESSION['user_id']."
                      $ptr_edes = mysql_query($sql_dest);
                      while($data_dist = mysql_fetch_array($ptr_edes))
                      {
                          $selecteds = '';
                          if(($data_dist['book_id']==$row_record['book_id']) || ($data_book_issue['book_id']==$data_dist['book_id']))
                            $selecteds = 'selected="selected"';	                                 
                          echo "<option value='".$data_dist['book_id']."' ".$selecteds.">".$data_dist['book_name']."</option>";
                      }
                      ?>
                </select>
                </td>
            </tr>
            <tr>
                <td width="20%" valign="top">Extra Days<span class="orange_font">*</span></td>
                <td width="70%"><input type="text" style="width: 100px" class="input_text" name="extra_days" id="extra_days" value="<?php if($_POST['save_changes']) echo $_POST['extra_days']; else echo $row_record['extra_days'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Fine<span class="orange_font">*</span></td>
                <td width="70%"><input type="text" style="width: 100px" class="input_text" name="fine" id="fine" value="<?php if($_POST['save_changes']) echo $_POST['fine']; else echo $row_record['fine'];?>" /></td> 
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