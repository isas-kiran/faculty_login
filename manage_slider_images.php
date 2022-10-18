<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM bp_slider where slider_id='".$record_id."'";
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
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
Slider</title>
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
    
     <script type="text/javascript">        
        function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }
            
            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected records?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {
            window.location.href=value+value1;
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
    <td class="top_mid" valign="bottom"><?php include "include/slider_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    <!-- Middle Start-->
                <table cellpadding="0" cellspacing="0" align="left" width="100%">
                    <tr><td height="10"></td></tr>
                    <tr><td><?php 
	$gallery_id=$_GET['slider_id'];
	$msg="";
	if(isset($_GET['msg']) && $_GET['msg']!=="")
	{
		$msg=$_GET['msg'];
	}
	
	//=======Delete Profile=========/// 
	if($_GET['action']=="delete")
	{
		
		$id = $_GET['img_id'];
		
		 $qryv ="DELETE FROM ".$GLOBALS["pre_db"]."slideshow_new_images  WHERE img_id='$id'";
		$ok2 = mysql_query($qryv);
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
	 $update_icons= "update ".$GLOBALS["pre_db"]."slideshow_new_images set icon='' where slider_id='$gallery_id' ";
	 $ptr_reset= mysql_query($update_icons);
	 
	 
	 $update_icon= "update ".$GLOBALS["pre_db"]."slideshow_new_images set icon='y' where img_id='$icon'";
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
								$upload = move_uploaded_file($_FILES['imge_name'.$j]['tmp_name'],"../pictures/".$saved_file_name);
								$fname= "../pictures/".$saved_file_name;
								  $image_info1 = getimagesize($fname) or die("no image");
								  $img_type=$image_info1[3]['mime'];
								  $image = new SimpleImage();
								  $image->load($fname);
								  if(($image_info1[0] > 1000) ||($image_info1[1] >1000))
								  {   	  	  	  
									if(($image_info1[0] > 1000) && ($image_info1[0] > $image_info1[1]))
									 $image->resizeToWidth(1000);
									else
									 $image->resizeToHeight(1000);	
								  }
								  $dir= "../pictures/".$saved_file_name;
								  $image->save($dir);
								   
								 if(($image_info1[0] > 120) ||($image_info1[1] >120))
								  {   	  	  	  
									if(($image_info1[0] > 120) && ($image_info1[0] > $image_info1[1]))
									 $image->resizeToWidth(120);
									else
									 $image->resizeToHeight(120);	
								  }
								   $dirss= "../pictures/thumb/".$saved_file_name;
								  $image->save($dirss);
								  
								  $set_image = " , imge_name='$saved_file_name' ";
								
								
		
		}
		
		
		 $update_imges= " update ".$GLOBALS["pre_db"]."slideshow_new_images set  image_tag='".addslashes($_POST['image_tag'.$j])."' $set_image , img_comment='".addslashes($_POST['img_comment'.$j])."' where  img_id='$img_id' ";
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


	 
 $catqry="Select * from ".$GLOBALS["pre_db"]."slideshow_new_images where slider_id='".$_GET['gallery_id']."' ";
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
	echo("<td align='center'><input type='hidden' name='$i' value='$img_id' ><input type='text' name='img_comment$i' value='$img_comment'onKeyPress='if (!isEng){ return change(this,event);} else {return true;}' onFocus='changeCursor(this);showme();' onClick='changeCursor(this);' onKeyUp='changeCursor(this);' 
                    onKeyDown='positionChange(event);'  onblur='hideme();' /> <div style='display:none; position:absolute; padding-top:5%;padding-left:10%' id='hindi_images'>
                    <img src='HindiMap.jpg' alt='Hindi letter map'></div></td>");
	echo("<td  align='center'><input type='text' name='image_tag$i' value='$image_tag'  onKeyPress='if (!isEng){ return change(this,event);} else {return true;}' onFocus='changeCursor(this);showme();' onClick='changeCursor(this);' onKeyUp='changeCursor(this);' 
                    onKeyDown='positionChange(event);'  onblur='hideme();' /> <div style='display:none; position:absolute; padding-top:5%;padding-left:10%' id='hindi_images'>
                    <img src='HindiMap.jpg' alt='Hindi letter map'></div></td>");
	if($icon=='y')
	
	echo("<td align='center'><input type='radio' name='icon' value='$img_id' checked='checked' /></td>");
	else
	echo("<td align='center'><input type='radio' name='icon' value='$img_id' /></td>");
	
	echo("<td align='center'><img src='../pictures/$imge_name' border='0' width='100' height='100' /></td>");
	echo("<td align='center'><input type='file' name='imge_name$i'></td>");
	echo "<td align='center'><a href='manage_slider_images.php?gallery_id=".$_GET['gallery_id']."&img_id=$img_id&action=delete' onclick=\"return confirm('do you really want to delete this image');\"><img src='images/delete_icon.png' border='0' /></a></td>";
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
                        <!-- Middle end-->
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