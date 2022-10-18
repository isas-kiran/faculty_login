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
	$("#pcategory_id").chosen({allow_single_deselect:true});
		
});
</script>
<script>
function show_subcategory(pcategory_id,sub_id)
{
    //alert(sub_id);
    if(pcategory_id !='')
    {
     // var course="show_subcategory=1&pcategory_id="+pcategory_id+"&sub_id="+sub_id;
    	var data1="pcategory_id="+pcategory_id+"&sub_id="+sub_id;
           $.ajax({
           url: "get-subcategory.php", type: "post", data: data1, cache: false,
           success: function (html)
           {
           		document.getElementById('member_new').innerHTML=html;
				$("#sub_id").chosen({allow_single_deselect:true});
           }	   
           });
			
    }
}
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
		/*if(frm.vender.value=='')
		{
			 disp_error +='Select Vendor   \n';
			 document.getElementById('vender').style.border = '1px solid #f00';
			 frm.vender.focus();
			 error='yes';
	    }*/
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
                            $book_name=$_POST['book_name'];
                            $isbn_no=$_POST['isbn_no'];  
							$book_category_id=$_POST['book_category_id'];  
							$description=$_POST['description'];    
							$language=$_POST['language']; 
							$publisher=$_POST['publisher']; 
							$published_year=$_POST['published_year'];			
							$author=($_POST['author']) ? $_POST['author'] : "";	
							$rack_location=($_POST['rack_location']) ? $_POST['rack_location'] : "";
							$quantity=( ($_POST['quantity'])) ? $_POST['quantity'] : "";
							$price=( ($_POST['price'])) ? $_POST['price'] : "";
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
                                $data_record['book_name'] =$book_name;
								$data_record['category_id'] =$book_category_id;
                                $data_record['isbn_no'] =$isbn_no;				
								$data_record['description'] =$description;
								$data_record['language'] =$language;
								$data_record['publisher'] =$publisher;
								$data_record['published_year'] =$published_year;			
								$data_record['author']=$author;
								$data_record['rack_location']=$rack_location;
								$data_record['quantity']=$quantity;
								$data_record['admin_id']=$_SESSION['admin_id'];
								$data_record['price']=$price;
                               	if($record_id)
                                {
                                    $where_record=" book_id='".$record_id."'";
                                    $db->query_update("lb_book", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("lb_book", $data_record);
									$book_id=mysql_insert_id();
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_book','Add','".$book_name."','".$book_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  

									//=========================END GALLERY IMAGE===============================
                                    //echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Product Added esuccessfully</p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
                                                                 }
                                                });
                                                
                                            });
                                        setTimeout('document.location.href="lb_manage_book.php";',1000);
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
                <td width="20%" valign="top">Book Name<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="input_text" name="book_name" id="book_name" value="<?php if($_POST['save_changes']) echo $_POST['book_name']; else echo $row_record['book_name'];?>"  /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">ISBN no.<span class="orange_font">*</span></td>
                <td width="70%"><input type="text" class=" input_text" name="isbn_no" id="isbn_no" value="<?php if($_POST['save_changes']) echo $_POST['isbn_no']; else echo $row_record['isbn_no'];?>"  /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
            	<td>Book Category <span class="orange_font">*</span></td>
                <td width="70%">
                    <select name="book_category_id" style="width:200px;" id="book_category_id" onchange="show_subcategory(this.value,'');" >
                    <option value="">Select Category</option> 
                      <?php  
                      $sql_dest ="select * from lb_book_category where 1 order by category_id asc";//".$_SESSION['user_id']."
                      $ptr_edes = mysql_query($sql_dest);
                      while($data_dist = mysql_fetch_array($ptr_edes))
                      { 
                          $selecteds = '';
                          if($data_dist['category_id']==$row_record['category_id'])
                            $selecteds = 'selected="selected"';	                                 
                          echo "<option value='".$data_dist['category_id']."' ".$selecteds.">".$data_dist['category_name']."</option>";
                      }
                      ?>
                    </select>
                </td>
            </tr>
	        <tr>
            <td width="12%" valign="top">Description </td>
            <td colspan="2">
			 <script src="ckeditor/ckeditor.js"></script>
                <textarea name="description" id="description"><?php if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>
            <script>
                CKEDITOR.replace( 'description' );
            </script>
                </td> 
            </tr>
            <tr>
                <td width="20%" valign="top">Language<span class="orange_font">*</span></td>
                <td width="70%"><input type="text" style="width: 100px" class="input_text" name="language" id="language" value="<?php if($_POST['save_changes']) echo $_POST['language']; else echo $row_record['language'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Publisher</td>
                <td width="70%"><input type="text"  class=" input_text" name="publisher" id="publisher" value="<?php if($_POST['save_changes']) echo $_POST['publisher']; else echo $row_record['publisher'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Published Year</td>
                <td width="70%"><input type="text"  class=" input_text" name="published_year" id="published_year" value="<?php if($_POST['save_changes']) echo $_POST['published_year']; else echo $row_record['published_year'];?>" /></td> 
                <td width="10%"></td>
            </tr>      
            <tr>
 	        	<td width="20%" valign="top">Author<span class="orange_font">*</span></td>
     	        <td width="70%"><input type="text"  class=" input_text" name="author" id="author" value="<?php if($_POST['save_changes']) echo $_POST['author']; else echo $row_record['author'];?>"  /></td> 
                <td width="10%"></td>
            </tr>          
            <tr>
	        	<td width="20%" valign="top">Rack Location </td>
	            <td width="70%"><input type="text"  class=" input_text" name="rack_location" id="rack_location" value="<?php if($_POST['save_changes']) echo $_POST['rack_location']; else echo $row_record['rack_location'];?>"  /></td> 
	            <td width="10%"></td>
            </tr>
            <tr>
	        	<td width="20%" valign="top">Quantity</td>
	            <td width="70%"><input type="text"  class=" input_text" name="quantity" id="quantity" value="<?php if($_POST['save_changes']) echo $_POST['quantity']; else echo $row_record['quantity'];?>"  /></td> 
	            <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Price</td>
                <td width="70%"><input type="text" name="price" id="price" value="<?php if($_POST['save_changes']) echo $_POST['price']; else echo $row_record['price'];?>" /></td> 
                <td width="10%"></td>
           	</tr>
           	<tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Product" name="save_changes" /></td>
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