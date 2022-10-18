<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM service_info where service_info_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
/*if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update servies set photo='' where service_id='".$record_id."'";
    echo $update_events;
    $db->query($update_news);

    if($row_record['photo'] && file_exists("../static_Page_photo/".$row_record['photo']))
        unlink("../static_Page_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Services Information</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
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
						   $total_service=@implode(",",$_POST['total_service']);
						   if($_POST['enroll_id']=='custom_student') 
						   {
							  $enroll_id=''; 
						   }
						   else
						   {
							  $enroll_id=$_POST['enroll_id']; 
						   }
                           
                           $cust_name=$_POST['cust_name'];
						   $membership=$_POST['membership'];
						   $vender_id=$_POST['vender_id'];
							
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
                                $data_record['enroll_id']=$enroll_id;
								$data_record['cust_name']=$cust_name;
								$data_record['membership']=$membership;
								$data_record['vender_id']=$vender_id;

                               if($record_id)
                                {
                                  
                                    $where_record=" service_info_id='".$record_id."'";
                                    $db->query_update("service_info", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("service_info", $data_record);
									
									for($i=0;$i<count($_POST['requirment_id']);$i++)
									{
									   $insert_service_ids=" insert into service_map (`service_info_id`,`service_id`) values('".$record_id."', '".$_POST['requirment_id'][$i]."')";
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
             <td width="12%">Select Customers</td>
             <td width="38%" >
                    <select name="enroll_id" id="enroll_id" class="validate[required]" onchange="add_new_student(this.value);" >  
                        <option value=""> Select Customers</option>
                        <?php
                            $select_category = "select enroll_id,name from enrollment order by enroll_id desc";
                            $ptr_category = mysql_query($select_category);
							
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['enroll_id'] == $row_record['enroll_id'])
                                    echo '<option value='.$data_category['enroll_id'].' selected="selected">'.$data_category['name'].'</option>';
                                else
                                    echo '<option value='.$data_category['enroll_id'].'>'.$data_category['name'].'</option>';
                            }
                            ?>
                            <option value="custom_student"> Add New Customer</option>        
                    </select>
                    </td> 
             
           </tr>
           
           <tr>
            <td colspan="2">
             <div id="add_student" style="display:none">
                  <table cellspacing="10" cellpadding="0" width="45%">
                    <tr>
                          <td>Customers Name:</td>
                          <td><input type="text"  name="cust_name" id="cust_name"/></td>
                          <td></td>
                     </tr>
                   </table>
             </div>
            </td>
           
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
								$sql_sub_cat = "select * from service_map where service_info_id='".$row_record['service_info_id']."' and service_id='".$data_service['service_id']."' ";
								$ptr_sub_cat = mysql_query($sql_sub_cat);
								if(mysql_num_rows($ptr_sub_cat))
								{
									
								   $class = 'selected="selected"';
									
								}
                                 
                                     echo '<option '.$class.' value="'.$data_service['service_id'].'" >'.$data_service['service_name'].'</option>';  
                            $i++;
							}
                            ?>  
                            <option value="custom_service"> Add New Service</option>       
                    </select>
                    </td> 
                <td width="40%"></td>
            </tr>
           
                
           <!--<tr>
            <td width="10%">Select Services<span class="orange_font">*</span></td>
            <td width="90%" >
            
           <?php /*?> <?php
            
            $sel_service = "select service_id,service_name from servies order by service_id asc";	 
			$query_service = mysql_query($sel_service);
			$i=1;
			$total_no = mysql_num_rows($query_service);
			$member_result='';
			echo '<table width="100%">';
			echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';
			echo  '<tr>';
			
			///-======= Existing course code===
			 if($record_id)
			   { 
				   $select_existing = " select service_id,service_info_id from service_map where service_info_id='$record_id' ";
				   $ptr_esxit = mysql_query($select_existing);
				   $service_array = array();
				   $service_info_array = array();
				   $j=0;
				   while( $data_exist = mysql_fetch_array($ptr_esxit))
				   {
						$service_array[$j]=$data_exist['service_id'];
						$service_info_array[$j]=$data_exist['service_info_id'];
						
						$j++;
					}
				}
			///=== Emd pf existing course code==
			
			
			while($row_member = mysql_fetch_array($query_service))
			   {
			   echo  '<td style="border:1px solid #999;">'; 
			  $checked= '';
			   if($record_id)
			   {
				   if(in_array($row_member['service_id'], $service_array))
				   {
					    $checked=" checked='checked'";
					}
			   }
			   
			   echo  "<input type='checkbox' name='requirment_id[]'  value='".$row_member['service_id']."' id='requirment_id$i'  onClick='showservice()' class='case' $checked /> ".$row_member['service_name']." ";
			   echo  '</td>';
			   if($i%7==0)
			   echo  '<tr></tr>';  
			   $i++;
				}
				echo' <input type="hidden" name="total_service" value="'.($i-1).'" id="total_service" />';
				echo '</table>';
            
            ?><?php */?>
                                       
                    </td> 
           </tr>-->
             
           
           
           
           
           <tr>
               <td width="15%">Membership:</td>
               <td><input type="radio" value="gold" name="membership" id="membership">Gold
                   <input type="radio" value="silver" name="membership" id="membership">Silver
                   <input type="radio" value="platinum" name="membership" id="membership">Platinum
               </td>
            
           </tr>
           
           <tr>
            <td width="15%">Select Vender</td>
            <td>
              <select name="vender_id" id="vender_id">
               <option value="" >Select Vender</option>
               <?php
			     $select_vender="select admin_id,name from site_setting where 1 order by admin_id asc";
				 $query_vender=mysql_query($select_vender);
				 while($fetch_vender=mysql_fetch_array($query_vender))
				 {
					 $selected='';
					 if($fetch_vender['admin_id']==$row_record['vender_id'])
					 {
						  $selected='selected="selected"';
					 }
					 
					 echo '<option value="'.$fetch_vender['admin_id'].'" '.$selected.'>'.$fetch_vender['name'].'</option>';
				 }
			   
                ?>
              </select>
            
            </td>
           
           </tr>
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Service Info" name="save_changes"  /></td>
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