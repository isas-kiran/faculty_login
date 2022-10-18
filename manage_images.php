<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM bp_gallery where gallery_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Photo Gallery</title>
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
    <script language="javascript">
	
	function add_image(value)
		{
	vars2='<input type="text" name="tag'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" />';return vars2;}
   
   function add_image_comment(value)
		{
	vars2='<input type="text" name="comment'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" />';return vars2;}
   
					 function del_degree(del)
					 {
					 	var j=del;
					 	document.getElementById(j).style.display='none'; 
						
					 }
					 function add_degree(no)
					 {
					 	var i=no;
						var next = i+1;
						if(document.getElementById(i).style.display=='none')
						{
							document.getElementById(i).style.display='block';
						}
						else
						{
						var tag = add_image(i);
						var comment= add_image_comment(i);
					 	var value='<div id="'+i+'"><table width="100%" border="0" style="font-size:11px;"><tr><td align="left">'+tag+'</td><td>'+comment+'</td><td  align="left"><input type="file" name="file'+i+'"/></td><td><input type="radio" name="icon" value="'+i+'" /></td><td ><a href="#" title="Add Degree" onclick="javascript:add_degree('+next+');" class="text" >Add(+)</a></td><td ><a href="#" title="Delete Degree" onclick="javascript:del_degree('+i+');" class="text">Delete(-)</a></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=i;
						}
					 }
					 
					 function validte_name(form_name)
					{
						var name = form_name;
						
						if(name.gallery_id.options[name.gallery_id.selectedIndex].value=='0')
						{
							alert('Please select the Gallery');
							name.gallery_id.focus();
							return false;
						}
						return true;
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
    <td class="top_mid" valign="bottom"><?php include "include/photo_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    
    <!-- Middle Start-->
		<table width="100%" align="center" style="text-align: left;" border="0">
        <tr>
            <td valign="top" class="contentLeft"></td>
            <td valign="top" class="contentRight">
            
            <table cellpadding="0" cellspacing="0" align="left" width="100%">
                    <tr><td class="navigation_heading">Manage Gallery Images </td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td><?php 
	$gallery_id=$_GET['gallery_id'];
	$msg="";
	if(isset($_GET['msg']) && $_GET['msg']!=="")
	{
		$msg=$_GET['msg'];
	}
	
	//=======Delete Profile=========/// 
	if($_GET['action']=="delete")
	{
		
		$id = $_GET['img_id'];
		$ok2 = mysql_query("DELETE FROM ".$GLOBALS["pre_db"]."gallery_images  WHERE img_id='$id'");
		if(mysql_affected_rows())
		{
		echo '<div id="msgbox" style="width: 30%;">Selected records deleted successfully</div>';
		}
	}
	
	
if($_POST['save'])
{
	 $total_images= $_POST['total_images'];
	 $icon = $_POST['icon'];
	 if($icon !='')
	 {
	 $update_icons= "update ".$GLOBALS["pre_db"]."gallery_images set icon='' where gallery_id='$gallery_id' ";
	 $ptr_reset= mysql_query($update_icons);
	 
	 
	 $update_icon= "update ".$GLOBALS["pre_db"]."gallery_images set icon='y' where img_id='$icon'";
	 $ptr_icon = mysql_query($update_icon);
	 }
	 for($j=1;$j<=$total_images;$j++)
	 {
		$img_id= $_POST[$j];
		$set_image='';
		if($_FILES['imge_name'.$j]['tmp_name'] !='')
		{
			                  $file=$_FILES['imge_name'.$j]["name"];
								$saved_file_name = time().basename($file);
								$upload = move_uploaded_file($_FILES['imge_name'.$j]['tmp_name'],"../photo_gallery/".$saved_file_name);
								$fname= "../photo_gallery/".$saved_file_name;
								  $image_info1 = getimagesize($fname) or die("no image");
								  $img_type=$image_info1[3]['mime'];
								  $image = new SimpleImage();
								  $image->load($fname);
								  if(($image_info1[0] > 1000) ||($image_info1[1] >1000))
								  {   	  	  	  
									if(($image_info1[0] > 1000) && ($image_info1[0] > $image_info1[1]))
									 $image->photo_galleryToWidth(1000);
									else
									 $image->photo_galleryToHeight(1000);	
								  }
								  $dir= "../photo_gallery/".$saved_file_name;
								  $image->save($dir);
								   
								 if(($image_info1[0] > 120) ||($image_info1[1] >120))
								  {   	  	  	  
									if(($image_info1[0] > 120) && ($image_info1[0] > $image_info1[1]))
									 $image->photo_galleryToWidth(120);
									else
									 $image->photo_galleryToHeight(120);	
								  }
								   $dirss= "../photo_gallery/thumb/".$saved_file_name;
								  $image->save($dirss);
								  
								  $set_image = " , imge_name='$saved_file_name' ";
								
								
		
		}
		
		
		 $update_imges= " update ".$GLOBALS["pre_db"]."gallery_images set  image_tag='".addslashes($_POST['image_tag'.$j])."' $set_image , img_comment='".addslashes($_POST['img_comment'.$j])."' where  img_id='$img_id' ";
		$ptr_update_tag = mysql_query($update_imges);
		if(mysql_affected_rows())
		{
		echo '<div id="msgbox" style="width: 30%;">Image Edited Successfuly.</font></div>';
		}
		
	 
	 }
	
	//echo  $msg;


}
?>


	
	  </td></tr>
                    <tr><td valign="middle">
                            <table width="100%" align="center" border="0">
                            <tr><td width="80%">
	    <form name="frm_site" action=""  enctype="multipart/form-data" method="post">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td height="15"></td>
										</tr>
										<tr>
											<td align="center" colspan="2" class="blue_hed">
											<?
												if($msg!=="")
												{
													echo $msg;
												}
											?>
											</td>
										</tr>
									<tr>
										<td width="35%" height="4">										</td>
									</tr>
									
									
									<tr>
              <td  valign="top" width="100%" bgcolor="#F8F8F8" align="center" class="text" >
			  
			  <?php

//$paging=new paging(10,10); // paging class object		


	 
$catqry="Select * from ".$GLOBALS["pre_db"]."gallery_images where gallery_id='$gallery_id' ";
$strSQL=$catqry;
$result=mysql_query($strSQL);
$count=mysql_num_rows($result);	
if($count==0)
{
	echo "No Image Exist..";
}
else
{

	
	echo("<table  align='center' width='99%' border='0'>");
	echo("<tr bgcolor=\"#dbdbdb\">");
	echo("<th width=\"132\">Sr No.</th>");
	echo("<th align='center'>Image Comment </th>");
	echo("<th width=\"132\" align='center'>Tag</th>");
	echo("<th width=\"132\" align='center'>Icon</th>");
	echo("<th width=\"132\" align='center'>Image</th>");
	
	 
	echo("<th width=\"132\" align='center'>New Image</th>");
	echo "<th  width=\"132\" align='center'>Delete</th>";
	echo("</tr>");
	$i=1;
	
	
	while($basic1 = mysql_fetch_array($result)) 
	{
	$img_id = $basic1['img_id'];
	$imge_name = $basic1['imge_name'];
	$img_comment = stripslashes($basic1['img_comment']);
	$image_tag = stripslashes($basic1['image_tag']);
	$icon= $basic1['icon'];
	
	if($i%2 ==0)
	$bgcolor="#EAECEC";
	else
	$bgcolor = "#FFFFFF";
	
	 
	echo("<tr bgcolor='".$bgcolor."'><td align='center'>$i</td>");
	echo("<td align='center'><input type='hidden' name='$i' value='$img_id' ><textarea name='img_comment$i' >$img_comment</textarea></td>");
	echo("<td  align='center'><textarea name='image_tag$i'>$image_tag</textarea></td>");
	if($icon=='y')
	
	echo("<td align='center'><input type='radio' name='icon' value='$img_id' checked='checked' /></td>");
	else
	echo("<td align='center'><input type='radio' name='icon' value='$img_id' /></td>");
	
	echo("<td align='center'><img src='../photo_gallery/$imge_name' border='0' width='100' height='100' /></td>");
		
	echo("<td align='center'><input type='file' name='imge_name$i'></td>");
	echo "<td align='center'><a href='manage_images.php?gallery_id=$gallery_id&img_id=$img_id&action=delete' onclick=\"return confirm('do you really want to delete this image');\"><img src='../images/delete.png' border='0' /></a></td>";
	echo("</tr>");
	$i++;
	}
	$total_imgsss= $i-1;
	echo "<input name='total_images' type='hidden' value='$total_imgsss'> ";
	echo("</table>");
}

?>

                
               
				</td>
            </tr>
			 <tr>
				    <td height="" align="center" valign="bottom" class="pagination" bgcolor="#FFFFFF"><input type="submit" name="save" value="Save" /> &nbsp;&nbsp;<input type="reset" value="Reset" />
						
					</td>
				  			</tr>
			
								  </table>
								  </form>
						</td></tr></table></td></tr></table>
            
                
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