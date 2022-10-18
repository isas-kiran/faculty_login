<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_staff_event_management where event_name='".$record_id."'";
    $row_record=$db->fetch_array($db->query($sql_record));
 
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> Staff Event Management</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
			$("#staff_pre_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
       
    </script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
  <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
  <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
        {
			$('.staff').chosen({allow_single_deselect:true});
	
			<?php 
			if($_SESSION['type']=="S")
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
		});
	</script> 
    <script type="text/javascript">
     
        jQuery(document).ready( function() 
        {
           // $("#user_id").multiselect().multiselectfilter();
			$("#staff_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
		
		    $(document).ready(function()
        {            
			var pageName="add_user_edit.php";
            $('.datepicker').datepicker({ changeMonth: true,dateFormat:"dd/mm/yy",changeYear: true, showButtonPanel: true, closeText: 'Clear'});

            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
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
    <td class="top_mid" valign="bottom"><?php include "include/payroll_event_menu.php"; ?></td>
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
						
						$total_floor=( ($_POST['floor'])) ? $_POST['floor'] : "0";
						$branch_name=$_SESSION['branch_name'];
	
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    <?php
                        }
                        else
                        {
                            $success=1;
							
							
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record_type1['cm_id']=$data_branch['cm_id'];
									$data_record_type1['branch_name']=$branch_name;
									//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record_type1['cm_id']='0';
									$data_record_type1['branch_name']=$branch_name;
								}
							}	
							else
							{
								$data_record_type1['cm_id']=$_SESSION['cm_id'];
								$data_record_type1['branch_name']=$_SESSION['branch_name'];
							}
						 	
                            if($record_id)
                            {
								
								for($z=1;$z<=$total_floor;$z++)
				{
					 "Floor- ". $_POST['del_floor'.$z]."<br />";
					 "<br />floor_id- ".$_POST['floor_id'.$z];
					if($_POST['del_floor'.$z]=='yes')
					{
						if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
						{
							"<br />".$delete_row = "delete from pr_staff_event_management where staff_event_id='".$_POST['floor_id'.$z]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					if($_POST['del_floor'.$z] !='yes')
					{
					//$data_record_extra['product_id']=$record_id;   
					//$data_record_extra['title'] =ucfirst($_POST['title'.$z]);	
						$event_name=( ($_POST['event_name'])) ? $_POST['event_name'] : "";
						$event_location=( ($_POST['event_location'])) ? $_POST['event_location'] : "";
					//	$event_date_to=( (date("Y-m-d",strtotime($_POST['event_date_to'])))) ? date("Y-m-d",strtotime($_POST['event_date_to'])) : "";
						$ad_date=explode('/',$_POST['event_date_to'],3);
			            $event_date_to=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
						
						$ad_date1=explode('/',$_POST['event_date_from'],3);
			            $event_date_from=$ad_date1[2].'-'.$ad_date1[1].'-'.$ad_date1[0];
						
					//	$event_date_from=( (date("Y-m-d",strtotime($_POST['event_date_from'])))) ? date("Y-m-d",strtotime($_POST['event_date_from'])) : "";
										
										$data_record_type1['event_name']=$event_name;
                                        $data_record_type1['event_date_to']=$event_date_to;
							            $data_record_type1['event_date_from']=$event_date_from;
                                        $data_record_type1['event_location'] =$event_location;
					
					                        $data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['staff_id'] =addslashes(trim($_POST['staff'.$z]));      
											$data_record_type1['role'] =addslashes(trim($_POST['role'.$z]));
											$data_record_type1['amount'] =addslashes(trim($_POST['amount'.$z]));
											$data_record_type1['description'] =addslashes(trim($_POST['description'.$z]));
											$data_record_type1['added_date'] =date("Y-m-d H:i:s");
					
					if($_POST['floor_id'.$z]=='' && $_POST['staff'.$z] !='')
					{
						
						 $type1_id=$db->query_insert("pr_staff_event_management", $data_record_type1);
					}
					else
					{
						
						 $where_record="staff_event_id='".$_POST['floor_id'.$z]."'";
						 $floor_id= $_POST['floor_id'.$z];
						$db->query_update("pr_staff_event_management", $data_record_type1,$where_record);
						
					}
					unset($data_record_type1);
				   }
				}
				 echo ' <br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div> <br></br>';

							 }
                            else
                            {
							   

								//====================FOR Type1 INSERT======================================================
								for($j=1;$j<=$total_floor;$j++)
								{
										
										//$user_type = $_POST['user_type'];
						$event_name=( ($_POST['event_name'])) ? $_POST['event_name'] : "";
						$event_location=( ($_POST['event_location'])) ? $_POST['event_location'] : "";
						//$event_date_to=( (date("Y-m-d",strtotime($_POST['event_date_to'])))) ? date("Y-m-d",strtotime($_POST['event_date_to'])) : "";
						//$event_date_from=( (date("Y-m-d",strtotime($_POST['event_date_from'])))) ? date("Y-m-d",strtotime($_POST['event_date_from'])) : "";
						$ad_date=explode('/',$_POST['event_date_to'],3);
			            $event_date_to=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
						
						$ad_date1=explode('/',$_POST['event_date_from'],3);
			            $event_date_from=$ad_date1[2].'-'.$ad_date1[1].'-'.$ad_date1[0];				
										$data_record_type1['event_name']=$event_name;
                                        $data_record_type1['event_date_to']=$event_date_to;
							            $data_record_type1['event_date_from']=$event_date_from;
                                        $data_record_type1['event_location'] =$event_location;
										
											$data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['staff_id'] =addslashes(trim($_POST['staff'.$j]));      
											$data_record_type1['role'] =addslashes(trim($_POST['role'.$j]));
											$data_record_type1['amount'] =addslashes(trim($_POST['amount'.$j]));
											$data_record_type1['description'] =addslashes(trim($_POST['description'.$j]));
											$data_record_type1['added_date'] =date("Y-m-d H:i:s");
											$record_comission=$db->query_insert("pr_staff_event_management", $data_record_type1);
											$slab_id=mysql_insert_id();  
								         
								 }
								 
								 "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_user','Add','".$name."','".$admin_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
								
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                          }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            
                	   <tr>
                <td width="20%">Event Name<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="validate[required] input_text" name="event_name" id="event_name" value="<?php if($_POST['save_changes']) echo $_POST['event_name']; else echo $row_record['event_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
             <?php 
			 if($record_id)
			 {
				$ad_date=explode('-',$row_record['event_date_to'],3);
			            $event_date_to=$ad_date[2].'/'.$ad_date[1].'/'.$ad_date[0];
						
						$ad_date1=explode('-',$row_record['event_date_from'],3);
			            $event_date_from=$ad_date1[2].'/'.$ad_date1[1].'/'.$ad_date1[0];
			 }		
			 ?>
            <tr>
                <td width="20%">Event Date <span class="orange_font"></span></td>
                <td width="">
 <input style="width:42%;" type="text" class=" datepicker input_text" name="event_date_to" id="event_date_to" value="<?php if($_POST['save_changes']) echo $_POST['event_date_to']; else echo $event_date_to;?>" />
               <text>TO</text>
                    <input style="width:42%;" type="text" class=" datepicker input_text" name="event_date_from" id="event_date_from" value="<?php if($_POST['save_changes']) echo $_POST['event_date_from']; else echo $event_date_from;?>" />
                </td> 
                <td width=""></td>
            </tr>
			
			
            
            <tr>
                <td width="20%">Event Location</td>
                <td width="40%">
                    <input type="text" class="input_text" name="event_location" id="event_location" value="<?php if($_POST['save_changes']) echo $_POST['event_location']; else echo $row_record['event_location'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
              



             	<td colspan="3">



                  <table  width="90%" style="border:0px solid gray; ">



                    <tr>



                        <td colspan="2">



                        <!--===========================================================NEW TABLE START===================================-->



                        <table cellpadding="5" width="100%" bgcolor="#CCCCCC">



                         <tr>



                        
<?php
			if($record_id =='')
			{
				?>
				<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
				<?php 
			}?>
                         



                         <script language="javascript">

									function floors(idss)



									{
										
										
										$('.staff').chosen({allow_single_deselect:true});
                                        
										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td style="width:20%;">Select Staff</td><td valign="top" width="10%" ><select class="staff" id="staff'+idss+'" name="staff'+idss+'"><option value="">Select Staff</option><?php
								
										$sel_staff = "select attendence_id,name from site_setting where attendence_id!=''  ".$_SESSION['where']." order by attendence_id asc";	 
										$query_staff = mysql_query($sel_staff);
										if($total_staff=mysql_num_rows($query_staff))
										{
											while($data=mysql_fetch_array($query_staff))
											{
												echo '<option value="'.$data['attendence_id'].'">'.$data['name'].'</option>';
											}
										}
									
								
									 ?>
									</select></td><td style="width:10%;">Role</td><td valign="top" width="10%" ><input type="text" name="role'+idss+'" id="role'+idss+'" /></td><td style="width:10%;">Amount</td><td valign="top" width="10%" ><input type="text" name="amount'+idss+'" id="amount'+idss+'" value="500"/></td><td style="width:10%;">Description</td><td valign="top" width="10%;" ><input type="text" name="description'+idss+'" id="description'+idss+'" style="margin-right: 54px;" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';



										document.getElementById('floor').value=idss;

										

										return shows_data;

                                     

									}

</script>



                         

<hr style="margin-top:20px;color:#FFFFFF;">
                         



                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 



<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >



  </td></tr>



  <tr><td> <strong style="color:green;font-size:14px;">****Allowcate Staff ****</strong> </td><td align="left"></td></tr>
<tr>
                            <td colspan="7">
							<?php
							if($record_id)
							{
                            $select_exc = "select * from pr_staff_event_management where event_name='".$record_id."' ";
                            $ptr_fs = mysql_query($select_exc);
                            $t=1;
                            $total_comision= mysql_num_rows($ptr_fs);
                            $total_conditions= mysql_num_rows($ptr_fs);
                            while($data_exclusive = mysql_fetch_array($ptr_fs))
                            { 
                                $slab_id= $data_exclusive['customer_service_map_id'];
                            	?> 
                            	<div class="floor_div" id="floor_id<?php echo $t; ?>">
                            	<table bgcolor="#CCCCCC" cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
                            	<tr><td style="width:20%;">Select Staff</td><td valign="top" width="10%" ><select id="staff<?php echo $t; ?>" name="staff<?php echo $t; ?>"><?php
								$sel_staff = "select attendence_id,name from site_setting where attendence_id!='' order by attendence_id asc";	 
								$query_staff = mysql_query($sel_staff);
								if($total_staff=mysql_num_rows($query_staff))
								{
									while($data=mysql_fetch_array($query_staff))
									{
										$selected='';
										if($data_exclusive['staff_id'] ==$data['attendence_id'] )
										{
											$selected='selected="selected"';
										}
										echo '<option value="'.$data['attendence_id'].'" '.$selected.'>'.$data['name'].'</option>';
									}
								}
								?>
									 </select></td><td style="width:10%;">Role</td><td valign="top" width="10%" ><input type="text" name="role<?php echo $t; ?>" id="role<?php echo $t; ?>" value="<?php echo $data_exclusive['role']; ?>" /></td><td style="width:10%;">Amount</td><td valign="top" width="10%" ><input type="text" name="amount<?php echo $t; ?>" id="amount<?php echo $t; ?>" value="<?php echo $data_exclusive['amount']; ?>" /></td><td style="width:10%;">Description</td><td valign="top" width="10%" ><input type="text" name="description<?php echo $t; ?>" id="description<?php echo $t; ?>" value="<?php echo $data_exclusive['description']; ?>" /></td>
                                <td valign="top" width="10%" align="center">
                           		  <input type="button" title="Delete Options(-)" onClick="delete_staff(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
                            		<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
								
                        		</td>
								<td valign="top" width="2%" align="center">
						<?php
						if($record_id)
						{
							?>
							<input type="hidden" name="total_sales_product[]" id="total_sales_product<?php echo $t; ?>" />
							<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['staff_event_id'] ?>" />
						
					<?php } ?>   
						</td>
                             	</tr></table>
                             	</div>
                            	<?php
                            	$t++;
                			}
						}
                            ?>
                        </tr> 
								
								


                        </table> 



                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>


  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>



  <tr>



                            <td colspan="6">
                             <input type="hidden" name="floor" id="floor"  value="0" />



                            <div id="create_floor"></div>
 </td></tr></table>

                        </td>
                    </tr>
   </table>
   <?php
		if($record_id)
		{
			?>
			<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
			<input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
			<?php 
		} 
		?> 
     </td>
  </tr>  




           
		 

            <td><input type="submit" class="input_btn" onClick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Record" name="save_changes"  /></td>
   <td></td>
     </tr>
 </table>
 </form>
</td></tr>

<?php

 } ?>
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



<?php



if($_SESSION['type']=="S" && $record_id=='')



{



	?>



    <script>



	branch_name =document.getElementById("branch_name").value;



	//alert(branch_name);



	show_bank(branch_name);



	</script>



    <?php



	//exit();



}



?>







<script language="javascript">
function delete_staff(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#staff'+id).replaceWith(function(){
			
			return $('<select name="staff'+id+'" id="staff'+id+'" style="width:140px"><option value=""></option></select>', {html: $(this).html()});
		});
		$('#role'+id).replaceWith(function(){
			
			return $('<input type="text" name="role'+id+'" id="role'+id+'" value="" />', {html: $(this).html()});
		});
		$('#amount'+id).replaceWith(function(){
			
			return $('<input type="text" name="amount'+id+'" id="amount'+id+'" value="" />', {html: $(this).html()});
		});
		$('#description'+id).replaceWith(function(){
			
			return $('<input type="text" name="description'+id+'" id="description'+id+'" value="" />', {html: $(this).html()});
		});
		
		
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
					}
	}
}

create_floor('add');



//create_floor_dependent();



</script>



</body>



</html>



<?php $db->close();?>