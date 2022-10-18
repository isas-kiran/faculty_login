<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM bp_branche_worker where emp_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Employee </title>
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
	vars2='<input type="text" class="input_text" name="emp_name'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" />';return vars2;}
   
   function add_image_comment(value)
		{
	vars2='<input type="text" class="input_text" name="emp_contact'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" />';return vars2;}
   function add_degi(value)
		{
	vars3='<input type="text"  class="input_text" name="emp_degi'+value+'" onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" onKeyDown="positionChange(event);"  onblur="hideme();" />';return vars3;}
   
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
						var name = add_image(i);
						var contact= add_image_comment(i);
						var degisnation= add_degi(i);
						
					 	var value='<div id="'+i+'"><table width="100%" border="0" style="font-size:11px;"><tr><td align="left">'+name+'</td><td>'+contact+'</td><td>'+degisnation+'</td><td ><a href="#" title="Add Degree" onclick="javascript:add_degree('+next+');" class="text" >Add(+)</a></td><td ><a href="#" title="Delete Degree" onclick="javascript:del_degree('+i+');" class="text">Delete(-)</a></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=i;
						}
					 }
					 
					 function validte_name(form_name)
					{
						var name = form_name;
						
						if(name.gallery_id.options[name.gallery_id.selectedIndex].value=='0')
						{
							alert('Please select the Branch');
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
    <td class="top_mid" valign="bottom"><?php include "include/branches_menu.php"; ?></td>
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
                    <tr><td class="navigation_heading"><?php  echo "Add";?> Employee</td></tr>
                    <tr><td height="10"></td></tr>
                    <tr><td>
	  	
                     <?php
				if($_POST['submit'])
				{
							
							$data_record['emp_name']=$_POST['emp_name'];
							$data_record['emp_contact']=$_POST['emp_contact'];
							$data_record['emp_degi']=$_POST['emp_degi'];
							$data_record['branch_id']=$_POST['branch_id'];
							if($record_id)
							{
								    $where_record="emp_id='".$record_id."'";
                                    $db->query_update("branche_worker", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center>
									</div>';
							}
							else
							{
								    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("branche_worker", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									
								$no_of_extra= $_POST['no_of_extra'];
							    for($x=1;$x<=$no_of_extra;$x++)
							 {
								 
						    $data_record_extra['emp_name']=$_POST['emp_name'.$x];
							$data_record_extra['emp_contact']=$_POST['emp_contact'.$x];
							$data_record_extra['emp_degi']=$_POST['emp_degi'.$x];
							$data_record_extra['branch_id']=$_POST['branch_id'];
						    $data_record_extra['added_date']=date("Y-m-d H:i:s");
						    $record_id=$db->query_insert("branche_worker", $data_record_extra);
								//echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
							}
					}	}
				?>
				<form method="post" name="addEditRecord" enctype="multipart/form-data">
                  <table    border="0" style="font-size:11px;" >
				  <tr><td colspan="3"><?php echo $msg ;?></td></tr>
                   <tr>
                     <td  align="left" >Select Branche </td>
                     
                      <td align="left" >&nbsp; :
					  <select name="branch_id" class="input_select_login">
					  <option value="0"><==Select Branch==></option>
					   <?php
					  $select_names = "select * from  ".$GLOBALS["pre_db"]."banches";
					  $ptr= mysql_query($select_names);
					  while($data=mysql_fetch_array($ptr))
					  {
					  $sewlectes='';
					  if($_REQUEST['record_id']==$data['branch_id'])
					  $sewlectes = " selected='selected'";
					  ?>
					  <option value='<?php echo $data['branch_id'];?>' <?php echo $sewlectes; ?> ><?php echo $data['branch_name'];?></option>
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
					
					<tr><td align="left">Emloyee Name</td> <td align="left">Emloyee Contact No  </td><td align="left">Emloyee designation  </td>
			        <td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr>
					<td valign="top" align="left"><div align="left"><input type="text" class="input_text" name="emp_name" 
                     value="<?php if($_POST['save_changes']) echo $_POST['emp_name']; else echo $row_record['emp_name'];?>"
                    onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                    onKeyDown="positionChange(event);"  onblur="hideme();" /> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                    <img src="HindiMap.jpg" alt="Hindi letter map"></div></td>
					
                    <td valign="top" align="left"><div align="left"><input type="text" class="input_text" name="emp_contact" 
                      value="<?php if($_POST['save_changes']) echo $_POST['emp_contact']; else echo $row_record['emp_contact'];?>"
                    onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                    onKeyDown="positionChange(event);"  onblur="hideme();" /> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                    <img src="HindiMap.jpg" alt="Hindi letter map">
                    </div></td>
                     <td valign="top" align="left"><div align="left"><input type="text" name="emp_degi" class="input_text"
                     value="<?php if($_POST['save_changes']) echo $_POST['emp_degi']; else echo $row_record['emp_degi'];?>"
                    onKeyPress="if (!isEng){ return change(this,event);} else {return true;}" onFocus="changeCursor(this);showme();" onClick="changeCursor(this);" onKeyUp="changeCursor(this);" 
                    onKeyDown="positionChange(event);"  onblur="hideme();" /> <div style="display:none; position:absolute; padding-top:5%;padding-left:10%" id="hindi_images" >
                    <img src="HindiMap.jpg" alt="Hindi letter map">
                    </div></td>
                     
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
                        <input name="submit" type="submit"  value="Add Employee" class="input_btn" onClick="return validte_name(this.form);" />
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