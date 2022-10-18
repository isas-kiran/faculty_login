<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM assets_type where asset_type_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Assets</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->

<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var pageName="add_product";
jQuery(document).ready( function() 
{
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
     <!-- Multiselect -->
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
<!--<link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />-->
<script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
<!--<script type="text/javascript" src="multifilter/assets/prettify.js"></script>-->
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
	//$("#brand").chosen({allow_single_deselect:true});
		
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
		/*if(frm.size.value=='')
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
	    }*/
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
    <td class="top_mid" valign="bottom"><?php include "include/asset_menu.php"; ?></td>
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
			$product_name=$_POST['product_name'];
			$product_code=$_POST['product_code'];  					
			$hsn_code=$_POST['hsn_code'];  
			$pcategory_id=$_POST['pcategory_id'];    
			$sub_id=$_POST['sub_id']; 
			$description=$_POST['description']; 
			$size=$_POST['size'];						
			$unit=( ($_POST['units'])) ? $_POST['units'] : "0";
			$quantity=( ($_POST['quantity'])) ? $_POST['quantity'] : "0";					
			$quantity_shelf=( ($_POST['quantity_in_shelf'])) ? $_POST['quantity_in_shelf'] : "0";
			$quantity_cons=( ($_POST['quantity_in_consumable'])) ? $_POST['quantity_in_consumable'] : "0";
			//$commission=$_POST['commission'];
			$price=( ($_POST['price'])) ? $_POST['price'] : "0";
			$vender=$_POST['vender'];
			$type=$_POST['type'];
			$total_floor=$_POST['floor'];
			$non_tax=$_POST['non_tax'];
			$vendor_idss=$_POST['requirment_id']; 
			$image_folder_path="../product_photo/";
			//$brand=$_POST['brand'];
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
				  "<br/>".$sel_product="select asset_name from assets_type where asset_name ='".$product_name."' and cm_id='".$cm_id."' ";
				  $ptr_product=mysql_query($sel_product);
				  if(mysql_num_rows($ptr_product))
				  {
					$success=0;
					$errors[$i++]="Asset already Exist.";
				  }
				  $sel_product_code="select asset_code from assets_type where asset_code ='".$product_code."' and cm_id='".$cm_id."' ";
				  $ptr_product_code=mysql_query($sel_product_code);
				  if(mysql_num_rows($ptr_product_code))
				  {
					$success=0;
					$errors[$i++]="Asset Code already Exist.";
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
				$data_record['asset_name'] =$product_name;
				$data_record['asset_code'] =$product_code;					
				$data_record['hsn_code'] =$hsn_code;
				$data_record['category_id'] =$pcategory_id;
				//$data_record['sub_id'] =$sub_id;
				$data_record['description'] =$description;
				$data_record['size'] =$size;
				$data_record['unit'] =$unit;					
				$data_record['quantity']=$quantity;
				$data_record['quantity_in_shelf']=$quantity_shelf;
				$data_record['quantity_in_consumable']=$quantity_cons;
				//$data_record['commission']=$commission;
				$data_record['price']=$price;
				$data_record['vendor']=$vender;
				$data_record['type']=$type;
				$data_record['non_tax']=$non_tax;				 
				//$data_record['brand']=$brand;
				$data_record['admin_id']=$_SESSION['admin_id'];
				if($record_id)
				{
					$where_record="asset_type_id='".$record_id."'";
					$db->query_update("assets_type", $data_record,$where_record);
					
					$delete_assets="delete from assets_vendor_map where asset_type_id='".$record_id."'";
					$ptr_del_ass=mysql_query($delete_assets);
					
					for($x=0;$x<count($_POST['requirment_id']);$x++)
					{
					   if($_POST['requirment_id'][$x]!='')
					   {
							$insert_vendor_ids="insert into assets_vendor_map (`asset_type_id`,`vendor_id`) values('".$record_id."','".$_POST['requirment_id'][$x]."')";
							$query_insert=mysql_query($insert_vendor_ids);
					   }
					}
					
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
				}
				else
				{
					$data_record['status']="Active";
					$data_record['added_date'] =date("Y-m-d H:i:s");
					$record_id=$db->query_insert("assets_type", $data_record);
					$product_id=mysql_insert_id();
					for($x=0;$x<count($_POST['requirment_id']);$x++)
					{
					   if($_POST['requirment_id'][$x]!='')
					   {
							$insert_vendor_ids="insert into assets_vendor_map (`asset_type_id`,`vendor_id`) values('".$record_id."','".$_POST['requirment_id'][$x]."')";
							$query_insert=mysql_query($insert_vendor_ids);
					   }
					}
					/*for($i=1;$i<=$total_floor;$i++)
					{
						$uploaded_url_gallery="";
						if(count($errors)==0 && $_FILES['image'.$i]["name"])
						{
							$uploaded_url_gallery=time().basename($_FILES['image'.$i]["name"]);
							$newfile_gallery= "../product_photo/";
							$filename_gallery =$filetype_gallery =$filesize_gallery = $source1_gallery = $target_path1_gallery ='';
							$filename_gallery = $_FILES['image'.$i]['tmp_name']; // File being uploaded.
							$filetype_gallery = $_FILES['image'.$i]['type'];// type of file being uploaded
							$filesize_gallery = filesize($filename_gallery); // File size of the file being uploaded.
							$source1_gallery= $_FILES['image'.$i]['tmp_name'];
							$target_path1_gallery = $newfile_gallery.$uploaded_url_gallery;
							list($width1, $height1, $type1, $attr1) = getimagesize($source1_gallery);
							if(strtolower($filetype_gallery) == "image/jpeg" || strtolower($filetype_gallery) == "image/pjpeg" || strtolower($filetype_gallery) == "image/GIF" || strtolower($filetype_gallery) == "image/gif" || strtolower($filetype_gallery) == "image/png")
							{
								if(move_uploaded_file($source1_gallery, $target_path1_gallery))
								{
									$file_uploaded_gallery=1;
								}
								else
								{
									$file_uploaded_gallery=0;
									$success=0;
									$errors[$i++]="There are some errors in ".$uploaded_url_gallery." while uploading image, please try again";
								}
							}
							else
							{
								$file_uploaded_gallery=0;
								$success=0;
								$errors[$i++]="Location image: Only image files allowed";
							}
						}
						$data_record_gallery['image'] =$uploaded_url_gallery; 
						$data_record_gallery['added_date'] =date('Y-m-d H:i:s');
					}*/
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_asset','Add','".$product_name."','".$product_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
					//setTimeout('document.location.href="add_product.php";',1000);
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
                	<td width="20%" valign="top">Asset Name<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text"  class="input_text" name="product_name" id="product_name" value="<?php if($_POST['save_changes']) echo $_POST['product_name']; else echo $row_record['asset_name'];?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	<tr>
                	<td width="20%" valign="top">Asset Code<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text" class=" input_text" name="product_code" id="product_code" value="<?php if($_POST['save_changes']) echo $_POST['product_code']; else echo $row_record['asset_code'];?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	<tr>
                	<td width="20%" valign="top">HSN Code<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text" class=" input_text" name="hsn_code" id="hsn_code" value="<?php if($_POST['save_changes']) echo $_POST['hsn_code']; else echo $row_record['hsn_code'];?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	<tr>
					<td>Asset Category <span class="orange_font">*</span></td>
                    <td width="70%">
                        <select name="pcategory_id" style="width:200px;" id="pcategory_id" >
                        <option value="">Select Category</option> 
                          <?php  
                          $sql_dest ="select asset_category_id,name from assets_category where 1 ".$_SESSION['where']." order by asset_category_id asc";
                          $ptr_edes = mysql_query($sql_dest);
                          while($data_dist = mysql_fetch_array($ptr_edes))
                          { 
	                          $selecteds = '';
                              if($data_dist['asset_category_id']==$row_record['category_id'])
                              $selecteds ='selected="selected"';	                                 
                              echo "<option value='".$data_dist['asset_category_id']."' ".$selecteds.">".$data_dist['name']."</option>";
                          }
                          ?>
                        </select>
                     </td>
              	</tr>
              	<tr><td width="50%" colspan="3"><div id="member_new"> </div></td></tr>
              	<tr>
            		<td width="12%" valign="top">Product Description </td>
            		<td colspan="2">
			 		<script src="ckeditor/ckeditor.js"></script>
                	<textarea name="description" id="description"><?php if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>
            		<script>
                	CKEDITOR.replace( 'description' );
            		</script>
                	</td> 
            	</tr>
            	<tr>
                	<td width="20%" valign="top">Size<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text" style="width: 100px" class=" input_text" name="size" id="size" value="<?php if($_POST['save_changes']) echo $_POST['size']; else echo $row_record['size'];?>" />  Unit: <input type="text" style="width: 100px" class="input_text" name="units" id="units" value="<?php if($_POST['save_changes']) echo $_POST['units']; else echo $row_record['unit'];?>" /></td> 
                	<td width="10%"></td>
            	</tr>
              	<!--<tr>
                  	<td width="20%" valign="top">Commission (in %)</td>
                	<td width="70%"><input type="text"  class=" input_text" name="commission" id="commission" value="<?php //if($_POST['save_changes']) echo $_POST['commission']; else echo $row_record['commission'];?>" /></td> 
                	<td width="10%"></td>
              	</tr>-->           
              	<tr>
                	<td width="20%" valign="top">Non Tax Price  <span class="orange_font">*</span></td>
                	<td width="70%"><input type="text"  class=" input_text" name="price" id="price" value="<?php if($_POST['save_changes']) echo $_POST['price']; else echo $row_record['price'];?>"  /></td> 
                	<td width="10%"></td>
              	</tr>          
              	<!--<tr>
	               	<td width="20%" valign="top">Brand </td>
    	          	<td width="70%">
              		<select name="brand" style="width:200px;" id="brand" >
                  		<option value="">Select Brand</option> 
                      	<?php  
                      	/*$sql_dest ="select * from product_brand where 1 ".$_SESSION['where']." order by brand_id asc";//".$_SESSION['user_id']."
                      	$ptr_edes =mysql_query($sql_dest);
                      	while($data_dist =mysql_fetch_array($ptr_edes))
                      	{ 
                      	    $selecteds = '';
                      	    if($data_dist['brand_id']==$row_record['brand'])
                      	    $selecteds = 'selected="selected"';	                                 
                      	    echo "<option value='".$data_dist['brand_id']."' ".$selecteds.">".$data_dist['brand_name']."</option>";
                      	}*/
                      	?>
                  	</select>
                  	</td> 
	              <td width="10%"></td>
              	</tr>-->
	          	<tr>
					<td width="20%">Select Vendor </td>
		            <td width="40%" >
	                <select  multiple="multiple" name="requirment_id[]" id="vendor_id" class="input_select" style="width:150px;" >
                    <?php 
	                $select_vendor = "select vendor_id,name from vendor where 1 ".$_SESSION['where']." order by vendor_id asc";
    	            $query_vendor = mysql_query($select_vendor);
					$i=0;
                    while($data_vendor = mysql_fetch_array($query_vendor))
                    { 
        	            $class = '';
						if($record_id)
						{
							$sql_sub_cat="select * from assets_vendor_map where asset_type_id='".$row_record['asset_type_id']."' and vendor_id='".$data_vendor['vendor_id']."' ";
							$ptr_sub_cat = mysql_query($sql_sub_cat);
							if(mysql_num_rows($ptr_sub_cat))
							{
								$class ='selected="selected"';
							}
						}
                        echo '<option '.$class.' value="'.$data_vendor['vendor_id'].'" >'.$data_vendor['name'].'</option>';  
                       	$i++;
					}
                    ?>  
                    </select>
                    </td> 
                	<td width="40%"></td>
            	</tr>
            	<tr>
                	<td width="20%" valign="top">Type</td>
                	<td width="70%">
                	<input type="radio" name="type" id="type" value="solid" <?php if($row_record['type']=='solid') echo 'checked="checked"'; ?> >Solid
                    <input type="radio" name="type" id="type" value="powder" <?php if($row_record['type']=='powder') echo 'checked="checked"'; ?> >Powder
                	<input type="radio" name="type" id="type" value="liquid" <?php if($row_record['type']=='liquid') echo 'checked="checked"'; ?> >Liquid
                	<input type="radio" name="type" id="type" value="creamy" <?php if($row_record['type']=='creamy') echo 'checked="checked"'; ?> >Creamy
                	</td> 
                	<td width="10%"></td>
           		</tr>
           		<!--<tr>
              		<td colspan="2">
                 	<table  width="100%" style="border:1px solid gray; ">
                    	<tr>
                        	<td colspan="2">
                        	
                        	<table cellpadding="5" width="100%" >
                         		<tr>
                         		<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                         		<script language="javascript">
									function floors(idss)
									{
										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="10%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><input type="file" name="image'+idss+'" id="image'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
										document.getElementById('floor').value=idss;
										return shows_data;
									}
								</script>
                           		<td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" > </td></tr>
                           		<tr><td>  </td><td align="left"></td></tr>
                        	</table> 
                        	<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                            <tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
							<tr><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
							<tr>
	                            <td colspan="6">
		                            <table cellspacing="3" id="tbl" width="100%">
			                           <tr>
			                           
			                           <td valign="top" width="10%"  align="center">Upload Image</td>
			                           </tr>
                                    </table>
			                        <input type="hidden" name="floor" id="floor"  value="0" />
			                        <div id="create_floor"></div>
		                       </td>
                           	</tr>
                            </table>
							
						</td>
					</tr>
              	</table>
			</td>
        </tr>-->
        <tr>
		    <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Product" name="save_changes" /></td>
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
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>