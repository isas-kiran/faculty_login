<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
	$id1 = $_GET['menu_id'];
	$msg="";
	if(isset($_GET['msg']) && $_GET['msg']!=="")
	{
		$msg=$_GET['msg'];
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Page</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/menu_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td valign="top" class="contentRight">
                <table cellpadding="0" cellspacing="0" align="left" width="100%">
                    <tr>
                      <td class="navigation_heading">Manage Menu</td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td>
	  
			<script language="javascript">
		function show_select(menu_type)
			{
				var menu = menu_type;
				var menu_id = document.getElementById('id1').value;
	//alert(menu_id);
	var url="show_in_edit_menu.php";
    url=url+"?menu_type="+menu+"&menu_id="+menu_id;
	//alert(url);
	//document.getElementById('txtHint').innerHTML = "<p>Please Wait....</p>";
	loadXMLDocUserPaging(url);
}
function loadXMLDocUserPaging(url)
{
	if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChangeUserPaging;
		req.open("GET", url, true);
		req.send(null);
		// branch for IE/Windows ActiveX version
	}
	else if (window.ActiveXObject)
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req)
		{
			req.onreadystatechange = processReqChangeUserPaging;
			req.open("GET", url, true);
			req.send();
		}
	}
}

function processReqChangeUserPaging()
{
	// only if req shows "complete"
	
	if (req.readyState == 4)
	{
		// only if "OK"
	
		
		if (req.status == 200)
		{
		
			response = req.responseXML.documentElement;
			var urlpath='';
			
			////alert(response.getElementsByTagName('testingnode')[0].childNodes[x].data); inside for loop
			for(var x = 0; response.getElementsByTagName('urlpath')[0].childNodes[x]; x++ )
			
				 urlpath = urlpath.concat(response.getElementsByTagName('urlpath')[0].childNodes[x].data);			
	//alert(urlpath+"pramod");
			document.getElementById('textdis').innerHTML = urlpath;
		}
		else
		{
			alert("There was a problem retrieving the XML data:\n" + req.statusText);
		}
	}
}
	function alerted()
	{
		alert("Please select the menu position 'Main menu' or 'Other Menu'");
		
	}
	function showss(ids)
	{
	
		var  idss=ids;
	//	alert(idss);
		if(idss=="page_block")
		{
		document.getElementById(idss).style.display='block';
		document.getElementById("link_block").style.display='none';
		//document.getElementById("special_link_block").style.display='none';
		}
		if(idss=="link_block")
		{
		document.getElementById(idss).style.display='block';
		document.getElementById("page_block").style.display='none';
		//document.getElementById("special_link_block").style.display='none';
		}
		
		/*if(idss=="special_link_block")
		{
		document.getElementById(idss).style.display='none';
		document.getElementById("page_block").style.display='none';
		document.getElementById("special_link_block").style.display='block';
		
		
		}*/
		
		
	}	
	
	function validation()
	{
		var frm =document.form1;
		//alert(frm.top_menu.checked);
		if(frm.name.value=='')
		{
			alert("Menu Name should not blank..!");
			frm.name.focus();
			return false;
		}
		
		if((frm.menu_type[0].checked || frm.menu_type[1].checked)||frm.top_menu.checked )
		
		{
		
		if(frm.link_type[0].checked)
		{
			if(frm.page_id.options[frm.page_id.selectedIndex].value=='0')
			{
				alert('Please select the static page link');
				frm.page_id.focus();
				return false;
			}
		}
		else if(frm.link_type[1].checked)
		{
			if(frm.direct_link.value=='')
			{
				alert("Link Name is Blank ... Please Enter the Link as show in hint format..!");
				frm.direct_link.focus();
				return false;
			}
		}
	}
	else
	{
		alert("Please select from main menu or other menu or at least top menu");
		return false;
	}	
		
		return true;
	}	
			</script>
		
	  
	  
	  
	  	<?php
		
	
	 $errors=array(); $i=0;
     $success=0;
	if($_POST['save_menu'])
	{
	
		$name=addslashes($_POST['name']);
		$menu_type = $_POST['menu_type'];
		$top_menu = $_POST['top_menu'];
		$parent_menu_id = $_POST['menu_id'];
		
		
		
		
		if($top_menu=='')
		{
		$top_menu='n';
		}
		$menu_pos = $_POST['menu_pos'];
		$direct_link = $_POST['direct_link'];
		$target =$_POST['target'];
		$link_type= $_POST['link_type'];
		if($link_type=="page")
		{
			$direct_link='';
			$link_page_id = $_POST['page_id'];
		}
		else
		{
			$link_page_id='0';
		}
		
		if($direct_link=='')
		{
			$direct_link='#';
		}
		
		if($name=="")
		{
				$success=0;
				$errors[$i++]="Please enter Menu Name";
		}
		
		 if(count($errors))
		{
			?>
			<table align="left" width="60%" style="text-align:left;" class="alert">
			<tr><td class="text"><strong>Please correct the following errors</strong><ul>
					<?php
					for($k=0;$k<count($errors);$k++)
							echo '<li style="text-align:left;padding-top:5px;">'.$errors[$k].'</li>';?>
					</ul>
			</td></tr>
			</table>
			<?php
		}
		else
		{
		
		if($_GET['menu_id']=="" && $name !='')
		{
		
			 $sql_record_exist= "SELECT menu_id FROM ".$GLOBALS["pre_db"]."menu where name='".$name."'";
			  if(mysql_num_rows($db->query($sql_record_exist)))
			  {
			  
			   $success=0;
				$errors[$i++]="Page Title already exist";
			  }
		}
		
		
		if($_GET['menu_id'] && $_GET['action']='edit')
		{
		
		if($id1=="69" || $id1=="73")
		{
		$update_tender = "update ".$GLOBALS["pre_db"]."menu set name='".$name."',  menu_pos='$menu_pos' ,target='$target', top_menu ='$top_menu' , menu_type='$menu_type' where menu_id ='".$id1."'";
		$tender_msg ="<font color='green'>you can not edit the direct link for this menu element.. other fields are edited successfully..";
		}
		else
		{
		 	
			$update_tender = "update ".$GLOBALS["pre_db"]."menu set name='".$name."', direct_link= '$direct_link' , target='$target', link_page_id='$link_page_id' ,parent_menu_id='$parent_menu_id', menu_pos='$menu_pos' , top_menu ='$top_menu' , menu_type='$menu_type' where menu_id ='".$id1."'";
			
			echo '<div id="msgbox" style="width:40%;">Menu edited successfully</center></div>';
		 }
		 
		 }
		 else
		 {
		 	$update_tender = " insert into ".$GLOBALS["pre_db"]."menu values(0, '".$name."', '$parent_menu_id' , '$direct_link' , '$menu_pos', '$menu_type', '$top_menu','$link_page_id' , '".date('Y-m-d')."' , '$target')  ";
			//$tender_msg .= "<font color='green'>Menu Added successfully..!</font>";
			 echo '<div id="msgbox" style="width:40%;">Menu added successfully</center></div>';
		 }
		$up_tender_ptr = mysql_query($update_tender);
		
		$success=1;
		
	
	}
	
	}
	if($success==0)
                        {
                        
	
?>
	  
										
                  <table width="653" border="0.5">
                    <tr>
                      <td><?php
				   if($_GET['menu_id'])
				   {
					$basics = mysql_query('Select name,direct_link,menu_pos,menu_type,top_menu,link_page_id,target,parent_menu_id from '.$GLOBALS["pre_db"].'menu where menu_id='.$id1);
					$basic1 = mysql_fetch_array($basics);
					$name = stripslashes($basic1['name']);
					$direct_link = stripslashes($basic1['direct_link']);
					$menu_pos = $basic1['menu_pos'];
					$menu_type = $basic1['menu_type'];
					$top_menu =  $basic1['top_menu'];
					$link_page_id =  $basic1['link_page_id'];
					$target = $basic1['target'];
					$old_parent_menu = $basic1['parent_menu_id'];
					//$special_page  = $basic1['special_page'];
				   }
					///////======================== CODE FOR MENU DEtail===================////
					
					echo("
					 <div style=\"text-align: left; font-family:Arial, Verdana, Times New Roman\">
                        
                        <div style=\"color:#cc0033; font-weight:bold; font-size:20px\">
                            $name
                      </div>
                    				
					");
					echo"<fieldset><legend align='right'>Menu Detail</legend>";
					echo "<form  method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">";
                    echo("<table class=\"profileh\" border='0'>");
					echo "<tr><td colspan='2' align='center'>$tender_msg</td></tr>";
                    echo("<tr>");
					echo "<td valign='top' align='left'>
					<input type='hidden' id ='id1'  name='id1' value='".$id1."'>
					Name </td><td align='left' valign='top'>:</td><td valign='top' align='left'>";
					?>
					<input type='text' name='name' value="<?=$name?>" id='TypePad' 
                     onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                onKeyDown="positionChange(event);"  onblur="hideme();" /> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images">
				<img src="HindiMap.jpg" alt="Hindi letter map">
                    
					</td></tr>
					<tr>
					<td height="36" align="left" valign="top"> Menu Appear</td>
					<td width="11" valign="top" ><div align="left">:</div></td>
					<td align="left" valign="top" > <!--Left Menu 
					  <input type="radio" name="menu_type" value="main" <?php if($menu_type=='main') echo " checked='checked'"; ?> onclick="javascript:show_select(this.value);" />--> Bottom Menu <input type="radio" name="menu_type" value="other" <?php if($menu_type=='other') echo " checked='checked'"; ?>  onclick="javascript:show_select(this.value);"/>No Left/Bottom <input type="radio"name="menu_type" value=""  <?php if($menu_type=='') echo " checked='checked'"; ?> onclick="javascript:show_select(this.value);">
					
					 Top Menu <input type="checkbox" <?php if($top_menu=='y') echo " checked='checked'"; ?>  name="top_menu" value="y" />  <br />
                      <font color="#CC66FF" size="-1"> [hint: select menu position" ]</font></td>
					
					
					</tr>
					<tr>
                      <td width="207" valign="top" align="left">Select Parent Menu</td>
                    <td width="11" valign="top" ><div align="left">:</div></td>
                      <td width="400" align="left" valign="top" ><div id='textdis' style="width:200px;" align="left"><select name="menu_id" >
					  <option value="0"><==No Parent ==></option>
					 <?php
					  
					 	$select_names = "select menu_id,name from  ".$GLOBALS["pre_db"]."menu where parent_menu_id ='0'";
					 
					  $ptr= mysql_query($select_names);
					  if(mysql_num_rows($ptr) !=0)
					  {
					  	while($data=mysql_fetch_array($ptr))
					  	{      if( $data['menu_id'] !=$GET['menu_id'])
								{
									if($data['menu_id']==$old_parent_menu)
									{
											 
										echo  "<option value='".$data['menu_id']."' selected='selected'> ".$data['name']."</option>";
									}
									else
									{
										echo  "<option value='".$data['menu_id']."'> ".$data['name']."</option>";
									}	
								}
					 
					  	}
					  }
					 
					 ?>
					   					  </select>
					  
					</div>
                      <font color="#CC66FF" size="-1"> [hint: if do you want to create parent menu<br />
                       element, then please select "<==No Parent ==>" ]</font>
                      </td>
					 
					 
                    </tr>
					</table>
					<table width="100%" cellpadding="5" cellspacing="5">
					<tr>
					  <td width="183" align="left" valign="top">Do you want to change the link  </td>
					  <td width="11" valign="top"><div align="left">:</div></td>
					<td  align="left" valign="top">Static Page 
					  <input type="radio" name="link_type" value="page" onclick="showss('page_block');"  <?php if($link_page_id !='0'){?> checked="checked"<?php } ?> /> New Link <input type="radio" name="link_type" value="link" onclick="showss('link_block');"  <?php if($link_page_id =='0' ){?> checked="checked"<?php } ?> />  <!--Special Pages <input type="radio" name="link_type" value="special_link" onclick="showss('special_link_block');"  <?php //if($link_page_id =='0' && $special_page =='yes'){?> checked="checked"<?php //} ?> />--> <br />
					<font color="#CC66FF" size="-1"> [hint: if do you want to add no link to<br /> the menu
                       then please select "New Link" ]</font>
					</td>
					
					</tr>
					</table>
					<table width="100%" cellpadding="5" cellspacing="5" id='page_block' <?php if($link_page_id !='0'){?>style="display:block;"<?php } else{?>style="display:none;" <?php }?> >
					<tr><td width="183" align="left" valign="top">Select Static Page for link</td>
					<td width="11" valign="top" ><div align="left">:</div></td>
					  <td   align="left">
					 
					  <select name="page_id">
					  <option value="0" ><==No Link ==></option>
					   <?php
				 	 echo $select_pages = "select page_id,title from  ".$GLOBALS["pre_db"]."pages ";
					  $ptrs= mysql_query($select_pages);
					  $select_exist_only_link = "select * from ".$GLOBALS["pre_db"]."menu  where menu_id='".$id1."' and link_page_id ='".$datas['page_id']."'";
					  while($datas=mysql_fetch_array($ptrs))
					  {
					   
					    $select_exist_only_link = "select * from ".$GLOBALS["pre_db"]."menu  where menu_id='".$id1."' and link_page_id ='".$datas['page_id']."'";
					     $qu = mysql_query($select_exist_only_link);
						 if(mysql_num_rows($qu) !=0)
						 {
						 	?>
					  		<option value='<?php echo $datas['page_id'];  ?>' selected="selected"><?php echo stripslashes($datas['title']);?>
                            </option>
					  	<?php
						 }
						 
					    $check_link_exist = "select * from ".$GLOBALS["pre_db"]."menu  where link_page_id ='".$datas['page_id']."'";
						$ptr_link = mysql_query($check_link_exist);
						if(mysql_num_rows($ptr_link) ==0)
						{
					 	 ?>
					  		<option value='<?php echo $datas['page_id'];  ?>'><?php echo $datas['title'];?></option>
					  	<?php
					  }
					  }
					   ?>
					  </select></td>
					</tr>
                   
                  
					</table>
                   <!-- <table width="100%" cellpadding="5" cellspacing="5" id='special_link_block' <?php if($link_page_id !='0' && $special_page !=''){?>style="display:block;"<?php } else{?>style="display:none;" <?php }?> >
					<tr><td width="183" align="left" valign="top">Select Special Pages for link</td>
					<td width="11" valign="top" ><div align="left">:</div></td>
					  <td   align="left">
					 
					  <select name="direct_link">
					  <option value="0" ><==No Link ==></option>
					  
					  </select></td>
					</tr>
                   
                  
					</table>-->
                    
					<table width="100%" cellpadding="5" cellspacing="5" id="link_block" 
					<?php if($link_page_id !='0' ){?>style="display:none;"<?php } else{?>style="display:block;" <?php }?>>
					<tr><td width="183" align="left" valign="top">Enter Hyper Link</td>
					<td width="11" valign="top" ><div align="left">:</div></td>
					  <td width="398"  align="left" valign="top"><input type="text" name="direct_link" <?php 
					
					if($direct_link !='#')
					{ echo "value=\"$direct_link\""; }?> /><br />
					  								 <font color="#CC66FF" size="-1"> [hint: http://www.example.com/example.html<br />or "#" for No link only]</font>
					 </td>
					</tr>
					</table>
					<table width="100%" cellpadding="5" cellspacing="5">
					 <tr>
					   <td width="183" align="left" valign="top">Link Target </td>
					   <td width="11" valign="top"><div align="left">:</div></td>
					  <td  align="left" valign="top">
					  							<select name="target">
												<option value="_self"<?php if($target=='_self') echo "selected='selected'"; ?> >Self Window</option>
												<option value="_blank"<?php if($target=='_blank') echo "selected='selected'"; ?>>New Window</option>
					  									
					  							</select><br />
					  								 <font color="#CC66FF" size="-1"> [hint: Used for open in same page<br /> or new tab or window]</font>
					 </td></tr>
					 </table> 
					
					<table width="100%" cellpadding="5" cellspacing="5">
					
					<?php 
											
                    echo("<tr><td style=\"color: #003366;\" valign='top' align='left' width='183'>");
                    echo("Menu Position</td>");
					echo '<td width="11" valign="top"><div align="left">:</div></td>';
                    echo("<td  align='left' valign='top'>");
					
					
					//echo $menu_pos;
					
					$seleect_last_menu_id = " select menu_id from ".$GLOBALS['pre_db']."menu order by menu_id desc limit 0,1  ";
					$ptr_limit = mysql_query($seleect_last_menu_id);
					if(mysql_num_rows($ptr_limit))
					{
						$data_limit_last = mysql_fetch_array($ptr_limit);
						$last_id = $data_limit_last['menu_id'];
						$limit =$last_id+1;
						
					}
					else
					$limit=1;
					?> 
					<select name="menu_pos"><option value="<?php echo $limit; ?>">Position</option>
					<?php 
					
					
					for($i=1;$i<=$limit;$i++)
					{
					?>
					<option value='<?php echo $i;?>'<?php if($i==$menu_pos){echo "selected='selected'";}?>>
					<?php  echo $i ;?></option>
					
					<?php } ?>
					 </select>
					 
					 <br />
					<font color="#CC66FF" size="-1"> [hint: Appear In Menu List <br />
					using this position order]</font>
					<?php
                    echo(" : ");
					   
                    echo("</td><td></td><td></td></tr>");
                   
					
                            echo("</table>");
					
							
					
					
		////=====================END OF TENDERS===================////			
		
				
	echo "<br><center><input type='submit' name='save_menu' value='Save Menu'></center>
</form></fieldset>
</div><br//>";					
////=================END CODE FOR ACADEMIC PROFILE================////

					}?></table>
					
                   
                    </td></tr>
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