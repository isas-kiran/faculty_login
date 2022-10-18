<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM wb_great_things where id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
if($record_id && $_REQUEST['img_id'] && $_REQUEST['deleteThumbnail'])
{
	$where_img="";
	$img="";
	if($_REQUEST['img_id']=='1')
	{
		$where_img=" image1='' ";
		$img=$row_record['image1'];
	}
	else if($_REQUEST['img_id']=='2')
	{
		$where_img=" image2='' ";
		$img=$row_record['image2'];
	}
	else if($_REQUEST['img_id']=='3')
	{
		$where_img=" image3='' ";
		$img=$row_record['image3'];
	}
	
    $update_img="update wb_great_things set ".$where_img." where id='".$record_id."'";
    $db->query($update_img);
	
    if($img && file_exists("images/website/".$img))
        unlink("images/website/".$img);
    $row_record=$db->fetch_array($db->query($sql_record));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Great Things</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var pageName="add_product";
jQuery(document).ready( function() 
{
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
    <td class="top_mid" valign="bottom"><?php include "include/website_menu.php"; ?></td>
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
			$event_name=addslashes($_POST['event_name']);
			$category_id=$_POST['category_id'];  					
			$description=addslashes($_POST['description']); 
			$fb_link=addslashes($_POST['fb_link']);						
			$google_link=addslashes($_POST['google_link'] ? $_POST['google_link'] : "");
			/*if($_SESSION['type']=='S')
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
			}*/
			//==========1=============
			$uploaded_url1="";
			if(count($errors)==0 && $_FILES['image1']["name"])
			{
				if($record_id)
				{
					$update_news="update wb_great_things set image1='' where id='".$record_id."'";
					$db->query($update_news);
					if($row_record['image1'] && file_exists("images/website/".$row_record['image1']))
						unlink("images/website/".$row_record['image1']);
					if($row_record['image1'] && file_exists("images/website/".$row_record['image1']))
						unlink("images/website/".$row_record['image1']);
				}
				$uploaded_url1=time().basename($_FILES['image1']["name"]);
				$newfile = "images/website/";
				$filename = $_FILES['image1']['tmp_name']; // File being uploaded.
				$filetype = $_FILES['image1']['type'];// type of file being uploaded
				$filesize = filesize($filename); // File size of the file being uploaded.
				$source1 = $_FILES['image1']['tmp_name'];
				$target_path1 = $newfile.$uploaded_url1;
				list($width1, $height1, $type1, $attr1) = getimagesize($source1);
				if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
				{
					if(move_uploaded_file($source1, $target_path1))
					{
						$thump_target_path="images/website/".$uploaded_url1;
						copy($target_path1,$thump_target_path);
						list($width, $height, $type, $attr) = getimagesize($thump_target_path);
						$file_uploaded1=1;
						//echo $width.$height;
						/*if($width<=1000 && $height<=667)
						{
							$file_uploaded1=1;
						}
						else
						{
							//------------resize the image----------------
							$obj_img1 = new thumbnail_images();
							$obj_img1->PathImgOld = $thump_target_path;
							$obj_img1->PathImgNew = $thump_target_path;
							$obj_img1->NewWidth = 1000;
							$obj_img1->NewHeight = 667;
							if (!$obj_img1->create_thumbnail_images())
							{
								$file_uploaded1=0;
								unlink($target_path1);
								$success=0;
								$errors[$i++]="There are some errors while uploading image, please try again";
							}
							else
							{
								$file_uploaded1=1;
							   
							}
						}*/
					}
					else
					{
						$file_uploaded1=0;
						$success=0;
						$errors[$i++]="There are some errors while uploading image, please try again";
					}
				}
				else
				{
					$file_uploaded1=0;
					$success=0;
					$errors[$i++]="Location image: Only image files allowed";
				}
			}
			//=========2=============
			$uploaded_url2="";
			if(count($errors)==0 && $_FILES['image2']["name"])
			{
				if($record_id)
				{
					$update_news="update wb_great_things set image2='' where id='".$record_id."'";
					$db->query($update_news);
					if($row_record['image2'] && file_exists("images/website/".$row_record['image2']))
						unlink("images/website/".$row_record['image2']);
					if($row_record['image2'] && file_exists("images/website/".$row_record['image2']))
						unlink("images/website/".$row_record['image2']);
				}
				$uploaded_url2=time().basename($_FILES['image2']["name"]);
				$newfile = "images/website/";
				$filename = $_FILES['image2']['tmp_name']; // File being uploaded.
				$filetype = $_FILES['image2']['type'];// type of file being uploaded
				$filesize = filesize($filename); // File size of the file being uploaded.
				$source1 = $_FILES['image2']['tmp_name'];
				$target_path1 = $newfile.$uploaded_url2;
				list($width1, $height1, $type1, $attr1) = getimagesize($source1);
				if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
				{
					if(move_uploaded_file($source1, $target_path1))
					{
						$thump_target_path="images/website/".$uploaded_url2;
						copy($target_path1,$thump_target_path);
						list($width, $height, $type, $attr) = getimagesize($thump_target_path);
						//echo $width.$height;
						$file_uploaded2=1;
						/*if($width<=1000 && $height<=667)
						{
							$file_uploaded2=1;
						}
						else
						{
							//------------resize the image----------------
							$obj_img1 = new thumbnail_images();
							$obj_img1->PathImgOld = $thump_target_path;
							$obj_img1->PathImgNew = $thump_target_path;
							$obj_img1->NewWidth = 1000;
							$obj_img1->NewHeight = 667;
							if (!$obj_img1->create_thumbnail_images())
							{
								$file_uploaded2=0;
								unlink($target_path1);
								$success=0;
								$errors[$i++]="There are some errors while uploading image, please try again";
							}
							else
							{
								$file_uploaded2=1;
							}
						}*/
					}
					else
					{
						$file_uploaded2=0;
						$success=0;
						$errors[$i++]="There are some errors while uploading image, please try again";
					}
				}
				else
				{
					$file_uploaded2=0;
					$success=0;
					$errors[$i++]="Location image: Only image files allowed";
				}
			}
			//=========3============
			$uploaded_url3="";
			if(count($errors)==0 && $_FILES['image3']["name"])
			{
				if($record_id)
				{
					$update_news="update wb_great_things set image3='' where id='".$record_id."'";
					$db->query($update_news);
					if($row_record['image3'] && file_exists("images/website/".$row_record['image3']))
						unlink("images/website/".$row_record['image3']);
					if($row_record['image3'] && file_exists("images/website/".$row_record['image3']))
						unlink("images/website/".$row_record['image3']);
				}
				$uploaded_url3=time().basename($_FILES['image3']["name"]);
				$newfile = "images/website/";
				$filename = $_FILES['image3']['tmp_name']; // File being uploaded.
				$filetype = $_FILES['image3']['type'];// type of file being uploaded
				$filesize = filesize($filename); // File size of the file being uploaded.
				$source1 = $_FILES['image3']['tmp_name'];
				$target_path1 = $newfile.$uploaded_url3;
				list($width1, $height1, $type1, $attr1) = getimagesize($source1);
				if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
				{
					if(move_uploaded_file($source1, $target_path1))
					{
						$thump_target_path="images/website/".$uploaded_url3;
						copy($target_path1,$thump_target_path);
						list($width, $height, $type, $attr) = getimagesize($thump_target_path);
						//echo $width.$height;
						$file_uploaded3=1;
						/*if($width<=1000 && $height<=667)
						{
							$file_uploaded3=1;
						}
						else
						{
							//------------resize the image----------------
							$obj_img1 = new thumbnail_images();
							$obj_img1->PathImgOld = $thump_target_path;
							$obj_img1->PathImgNew = $thump_target_path;
							$obj_img1->NewWidth = 1000;
							$obj_img1->NewHeight = 667;
							if (!$obj_img1->create_thumbnail_images())
							{
								$file_uploaded3=0;
								unlink($target_path1);
								$success=0;
								$errors[$i++]="There are some errors while uploading image, please try again";
							}
							else
							{
								$file_uploaded3=1;
							}
						}*/
					}
					else
					{
						$file_uploaded3=0;
						$success=0;
						$errors[$i++]="There are some errors while uploading image, please try again";
					}
				}
				else
				{
					$file_uploaded3=0;
					$success=0;
					$errors[$i++]="Location image: Only image files allowed";
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
				$data_record['event_name'] =$event_name;
				$data_record['category_id'] =$category_id;					
				$data_record['description'] =$description;
				$data_record['fb_link'] =$fb_link;
				$data_record['google_link'] =$google_link;					
				$data_record['admin_id']=$_SESSION['admin_id'];
				if($record_id)
				{
					if($file_uploaded1)
						$data_record['image1'] = $uploaded_url1;
					if($file_uploaded2)
						$data_record['image2'] = $uploaded_url2;
					if($file_uploaded3)
						$data_record['image3'] = $uploaded_url3;
						
					$where_record="id='".$record_id."'";
					$db->query_update("wb_great_things", $data_record,$where_record);
					echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
					
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
					//setTimeout('document.location.href="wb_manage_great_things.php";',1000);
					</script>  
				   <?php
				}
				else
				{
					$data_record['status']="Active";
					$data_record['added_date'] =date("Y-m-d H:i:s");
					
					if($file_uploaded1)
						$data_record['image1'] = $uploaded_url1;
					if($file_uploaded2)
						$data_record['image2'] = $uploaded_url2;
					if($file_uploaded3)
						$data_record['image3'] = $uploaded_url3;
					
					$record_id=$db->query_insert("wb_great_things", $data_record);
					$product_id=mysql_insert_id();
					
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_great_things','Add','".$product_name."','".$product_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
					setTimeout('document.location.href="wb_manage_great_things.php";',1000);
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
              	<tr>
                	<td width="20%" valign="top">Event Name<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text"  class="input_text" name="event_name" id="event_name" value="<?php if($_POST['save_changes']) echo $_POST['event_name']; else echo $row_record['event_name'];?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	<tr>
					<td>Event Category<span class="orange_font">*</span></td>
                    <td width="70%">
                        <select name="category_id" style="width:200px;" id="category_id" >
                            <option value="">Select Category</option> 
                            <option value="1" <?php if($_POST['category_id']=='1') echo 'selected="selected"'; else if($row_record['category_id']=='1') echo 'selected="selected"'; ?>>Events</option> 
                            <option value="2" <?php if($_POST['category_id']=='2') echo 'selected="selected"'; else if($row_record['category_id']=='2') echo 'selected="selected"'; ?>>Student Post</option> 
                            <option value="3" <?php if($_POST['category_id']=='3') echo 'selected="selected"'; else if($row_record['category_id']=='3') echo 'selected="selected"'; ?>>Ceremoney & Awards</option> 
                            <option value="4" <?php if($_POST['category_id']=='4') echo 'selected="selected"'; else if($row_record['category_id']=='4') echo 'selected="selected"'; ?>>Latest News</option> 
                        </select>
                     </td>
              	</tr>
              	<tr>
            		<td width="12%" valign="top">Event Description </td>
            		<td colspan="2">
			 		<script src="ckeditor/ckeditor.js"></script>
                	<textarea name="description" id="description"><?php if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>
            		<script>
                	CKEDITOR.replace( 'description' );
            		</script>
                	</td> 
            	</tr>
                <tr>
                	<td width="20%" valign="top">Facebook Post Link<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text" class=" input_text" name="fb_link" id="fb_link" value="<?php if($_POST['save_changes']) echo $_POST['fb_link']; else if($row_record['fb_link']!='') echo $row_record['fb_link']; else echo 'https://www.facebook.com/isas.pune/posts/'; ?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	<tr>
                	<td width="20%" valign="top">Google Post Link<span class="orange_font">*</span></td>
                	<td width="70%"><input type="text" class="input_text" name="google_link" id="google_link" value="<?php if($_POST['save_changes']) echo $_POST['google_link']; else echo $row_record['google_link'];?>"  /></td> 
                	<td width="10%"></td>
            	</tr>
            	
                <tr>
                    <td width="20%">Image 1</td>
                    <td width="40%"><?php
                        if($record_id && $row_record['image1'] && file_exists("images/website/".$row_record['image1']))
                       		echo '<img height="77px" width="77px" src="images/website/'.$row_record['image1'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&img_id=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                        else
                            echo '<input type="file" name="image1" id="image1" class="input_text"></td>';?></td> 
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="20%">Image 2</td>
                    <td width="40%"><?php
                        if($record_id && $row_record['image2'] && file_exists("images/website/".$row_record['image2']))
                            echo '<img height="77px" width="77px" src="images/website/'.$row_record['image2'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&img_id=2&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                        else
                            echo '<input type="file" name="image2" id="image2" class="input_text"></td>';?></td> 
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="20%">Image 3</td>
                    <td width="40%"><?php
                        if($record_id && $row_record['image3'] && file_exists("images/website/".$row_record['image3']))
                            echo '<img height="77px" width="77px" src="images/website/'.$row_record['image3'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&img_id=3&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                        else
                            echo '<input type="file" name="image3" id="image3" class="input_text"></td>';?></td> 
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Event" name="save_changes" /></td>
                    <td></td>
                </tr>
            </table>
		</form>
	</td>
</tr>

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