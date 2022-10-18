<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT slider_id FROM slider where slider_id='".$record_id."'";
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
    
     <script language="javascript">
	function add_image(value)
		{
	vars2='<input type="text" name="tag'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" class="input_text"  />';return vars2;}
   
   function add_image_comment(value)
		{
	vars2='<input type="text" name="comment'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" class="input_text" />';return vars2;}
   
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
						
						
						if(name.slideshow_id.options[name.slideshow_id.selectedIndex].value=='0')
						{
							alert('Please select the Slideshow');
							name.slideshow_id.focus();
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
    <td class="top_mid" valign="bottom"><?php include "include/slider_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        
        
        
      <table cellpadding="0" cellspacing="0" align="left" width="100%">
                    <tr>
                      <td class="navigation_heading"><?php  echo "Add";?>
                  Slideshow</td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td>
                     <?php
				if($_POST['submit'])
				{
							
							$gallery_id = $_POST['slider_id'];
							$_FILES['file']['name'];
							 $icon = $_POST['icon'];
							$this_icon='';
							
							if($icon !='')
							{
							
								$update_icon= " update  ".$GLOBALS["pre_db"]."slideshow_new_images set icon='' where slider_id = '$gallery_id' ";
								$ptr_update= mysql_query($update_icon);
								
							}
							
							if($_FILES['file']['tmp_name'] !="")
							{
								
												if($icon=='0')
												{
													$this_icon='y';
												}
								//$check_exist = "select * from gallery_images where comment= "
								$file=$_FILES["file"]["name"];
								$saved_file_name = time().basename($file);
								$upload = move_uploaded_file($_FILES['file']['tmp_name'],"../pictures/".$saved_file_name);
								$insert_pdf_query ="insert into ".$GLOBALS["pre_db"]."slideshow_new_images values(0,'$gallery_id','".$_POST['comment']."','".$_POST['tag']."','$saved_file_name','$this_icon')";
								$ptr_pdf=mysql_query($insert_pdf_query);
								$fname= "../pictures/".$saved_file_name;
								  $image_info1 = getimagesize($fname) or die("no image");
								  
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
								
								
								
								$extra_pdf = $_POST['no_of_extra'];
								for($i=1;$i<=$extra_pdf;$i++)
								{
									$this_icon='';
									if($_FILES['file'.$i]['tmp_name'] !="")
									{
										if($icon==$i)
												{
													$this_icon='y';
												}
									
										$file_more=$_FILES["file".$i]["name"];
										$saved_more_file_name = time().basename($file_more);
										$upload = move_uploaded_file($_FILES['file'.$i]['tmp_name'],"../pictures/".$saved_more_file_name);
										$insert_extra_pdf = "insert into ".$GLOBALS["pre_db"]."slideshow_new_images values(0,'$gallery_id','".$_POST['comment'.$i]."','".$_POST['tag'.$i]."','$saved_more_file_name','$this_icon')";
										$ptr_extra_pdf=mysql_query($insert_extra_pdf);
									  $fnames= "../pictures/".$saved_more_file_name;
									  $image_info1 = getimagesize($fnames) or die("no image");
									 
									  $image = new SimpleImage();
									  $image->load($fnames);
									  if(($image_info1[0] > 450) ||($image_info1[1] >450))
									  {   	  	  	  
										if(($image_info1[0] > 450) && ($image_info1[0] > $image_info1[1]))
										 $image->resizeToWidth(450);
										else
										 $image->resizeToHeight(450);	
									  }
									  $dir= "../pictures/".$saved_more_file_name;
									  $image->save($dir);
									 if(($image_info1[0] > 120) ||($image_info1[1] >120))
									  {   	  	  	  
										if(($image_info1[0] > 120) && ($image_info1[0] > $image_info1[1]))
										 $image->resizeToWidth(120);
										else
										 $image->resizeToHeight(120);	
									  }
									  $dir= "../pictures/thumb/".$saved_more_file_name;
									  $image->save($dir);
									
									}
								}
							
								$msg= "<center><font color='green'> Images(s) Added Successfully...!</font></center>";
							}	
							else
							{
							
								$msg= "<center><font color='red'>No Image Added...</font></center>";
							}
					}	
				?>
                      
	  
			   	
	  
	    		
				<form method="post" name="addEditRecord" enctype="multipart/form-data">
                  <table    border="0" style="font-size:11px;" >
				  <tr><td colspan="3"><?php echo $msg ;?></td></tr>
                   <tr>
                     <td  align="left" >Select Slideshow </td>
                     
                      <td align="left" >&nbsp; 
					  <select name="slider_id" class="input_select_login">
					  <option value="0">==Select Slideshow==</option>
					   <?php
					  $select_names = "select slider_id,title from  ".$GLOBALS["pre_db"]."slider";
					  $ptr= mysql_query($select_names);
					  while($data=mysql_fetch_array($ptr))
					  {
					  $sewlectes='';
					  if($_REQUEST['record_id']==$data['slider_id'])
					  $sewlectes = " selected='selected'";
					  ?>
					  <option value='<?php echo $data['slider_id'];?>' <?php echo $sewlectes; ?> ><?php echo $data['title'];?></option>
					  <?php
					  }
					   ?>
					  </select>
                     </td>
					  <td>					  </td>
                    </tr>
				    <tr>
                      <td ></td>
                      <td>&nbsp;</td>
                      <td ></td>
					  <td></td>
                    </tr>
					</table>
					<table width="100%"  border="0" style="font-size:11px;">
					
					<tr><td align="left">Tag</td><td align="left">Comment</td>
					<td valign="top" align="left">Upload Image              <br />
					  <font color="#CC66FF" size="-2">[.jpeg or .gif only size=1000kb Dimentions: 954 X 338 ]</font></td><td align="center"> Icon </td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr>
					<td valign="top" align="left"><div align="left"><input type="text"  name="tag" class="input_text" 
                     onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                    onKeyDown="positionChange(event);"  onblur="hideme();" /> </div><div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                    <img src="HindiMap.jpg" alt="Hindi letter map"></div></td>
                    
					<td valign="top" align="left"><div align="left"><input type="text" name="comment" class="input_text"    onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                    onKeyDown="positionChange(event);"  onblur="hideme();" /></div> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                    <img src="HindiMap.jpg" alt="Hindi letter map"></div></td>
                      
                      
                      <td valign="top" align="left"><div align="left">
                        <input type="file" name="file" >
						
      
                      </div></td><td align="center"><input type="radio" name="icon" value="0" /></td>
					  <td  align="left" class="text"><a href="#" title="Add Degree" onClick="javascript:add_degree(1);" class="text" >Add(+)</a>  </td>
					 <td  align="left"><a href="#" title="Delete Degree" onClick="javascript:del_degree(1);" class="text" >Delete(-)</a></td>
                    </tr>
					</table>
					 <input type="hidden" name="no_of_extra" id="extra" />
					 <div id='1'>
					 </div>
					<table width="100%">
					<tr><td>&nbsp;</td></tr>
					
                    <tr>
                      
                      
					  <td><div align="left"></div></td>
                      <td  align="right">
                        <input name="submit" type="submit"  value="Add Images" onClick="return validte_name(this.form);" />
                      </td>
					  <td>&nbsp;</td>
					  <td><div align="left"></div></td>
                    </tr>
					
                  </table>
                  <p>&nbsp;</p>
                </form> <!-- Middle end-->
    </td>
   
    </tr>
    
</table>  
        
        
        
        
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