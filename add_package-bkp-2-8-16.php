<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM package where package_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Package</title>
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
    
    <!-- Multiselect -->
    
     <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    

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
    
    <script>

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
	
	function showservice()
{
	total_service =  document.getElementById("total_service").value;
	contact ='';
	
	for(i=1; i<=total_service;i++)
	{
		id="requirment_id"+i;
		if(document.getElementById(id).checked)
			{
				contact +=document.getElementById(id).value;
				contact +=',';
			}
	}
	
 	  
}

function add_new_student(student)
{
	var a=student;
	if(a=='custom_student')
	{
	  //alert(a);
	  document.getElementById('add_student').style.display='block';
	  
	}
	else
	{
		document.getElementById('add_student').style.display='none';
	}
}

	</script>
    
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#service_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
                           $service_ids=$_POST['requirment_id']; 
						   //$total_service=@implode(",",$_POST['total_service']);
						   
                           $package_name=$_POST['package_name'];
						   $package_code=$_POST['package_code'];
						   $description=$_POST['description'];
						   $start_date=$_POST['start_date'];
						   $end_date=$_POST['end_date'];
						   $cost_to_center=$_POST['cost_to_center'];
						   $commision=$_POST['commision'];
						   $membership=$_POST['membership'];
							
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
                                $data_record['package_name']=$package_name;
								$data_record['package_code']=$package_code;
								$data_record['description']=$description;
								$data_record['start_date']=$start_date;
								 $data_record['end_date']=$end_date;
								$data_record['cost_to_center']=$cost_to_center;
								$data_record['commision']=$commision;
								$data_record['membership']=$membership;

                               if($record_id)
                                {
                                  
                                    $where_record=" package_id='".$record_id."'";
                                    $db->query_update("package", $data_record,$where_record);
									
									 "<br />".$del_ex_section="delete from package_service_map where package_id='".$record_id."'";
                                      $ptr_del_section=mysql_query($del_ex_section);
									  
									  for($i=0;$i<count($_POST['requirment_id']);$i++)
										{
										   $insert_service_ids=" insert into package_service_map (`package_id`,`service_id`) values('".$record_id."', '".$_POST['requirment_id'][$i]."')";
										   $query_insert=mysql_query($insert_service_ids);
										}
									  
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("package", $data_record);
									
									for($i=0;$i<count($_POST['requirment_id']);$i++)
									{
									   $insert_service_ids=" insert into package_service_map (`package_id`,`service_id`) values('".$record_id."', '".$_POST['requirment_id'][$i]."')";
									   $query_insert=mysql_query($insert_service_ids);
									}
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
                
                
           <tr>
            
                  <td>Package Name:</td>
                  <td><input type="text"  name="package_name" class=" input_text"  id="package_name" value="<?php if($_POST['save_changes']) echo $_POST['package_name']; else echo $row_record['package_name'];?>"/></td>
                   
           </tr>
           
            <tr>
            
                  <td>Package Code:</td>
                  <td><input type="text"  name="package_code" class=" input_text"  id="package_code" value="<?php if($_POST['save_changes']) echo $_POST['package_code']; else echo $row_record['package_code'];?>"/></td>
                   
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
                <td>Start Date</td>
                <td width="70%"><input type="text" name="start_date"  class=" input_text datepicker" 
                value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $row_record['start_date'];?>"/></td>
            </tr>
            
            <tr>
                <td>End Date</td>
                <td width="70%"><input type="text" name="end_date"  class="datepicker input_text" 
                value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $row_record['end_date'];?>"/></td>
            </tr>
           
           <tr>
            <td width="20%">Select Services </td>
            <td width="40%" >
                <select  multiple="multiple" name="requirment_id[]" id="service_id" class="input_select" style="width:150px;">                        
                        <?php 
                            $select_service = "select service_id,service_name from servies order by service_id asc";
                            $query_service = mysql_query($select_service);
							$i=0;
                            while($data_service = mysql_fetch_array($query_service))
                            { 
                                $class = '';
								$sql_sub_cat = "select * from package_service_map where package_id='".$row_record['package_id']."' and service_id='".$data_service['service_id']."' ";
								$ptr_sub_cat = mysql_query($sql_sub_cat);
								if(mysql_num_rows($ptr_sub_cat))
								{
									
								   $class = 'selected="selected"';
									
								}
                                 
                                     echo '<option '.$class.' value="'.$data_service['service_id'].'" >'.$data_service['service_name'].'</option>';  
                            $i++;
							}
                            ?>  
                              
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
           
            <tr>
                <td width="25%">Cost to Center :</td>
                <td width="40%"><input type="text" name="cost_to_center" class="input_text" id="cost_to_center" value="<?php if($_POST['save_changes']) echo $_POST['cost_to_center']; else echo $row_record['cost_to_center'];?>" /></td>
            </tr>
            
            <tr>
                <td width="25%">Commision :</td>
                <td width="40%"><input type="text" name="commision" class="input_text" id="commision" value="<?php if($_POST['save_changes']) echo $_POST['commision']; else echo $row_record['commision'];?>" /></td>
            </tr>
           
           <tr>
               <td width="15%">Membership:</td>
               <td><input type="radio" value="gold" name="membership" id="membership" <?php if($row_record['membership']=='gold') echo 'checked="checked"' ?>>Gold
                   <input type="radio" value="silver" name="membership" id="membership" <?php if($row_record['membership']=='silver') echo 'checked="checked"' ?>>Silver
                   <input type="radio" value="platinum" name="membership" id="membership" <?php if($row_record['membership']=='platinum') echo 'checked="checked"' ?>>Platinum
               </td>
            
           </tr>
           
           
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Package" name="save_changes"  /></td>
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
</body>
</html>
<?php $db->close();?>