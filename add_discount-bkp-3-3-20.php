<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
if($_REQUEST['record_id'])
{
	
    $record_id=$_REQUEST['record_id'];
	
    $sql_record= "SELECT name,code,discount,start_date,end_date,status FROM discount_coupon where discount_coupon_id='".$record_id."'";
	
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Discount</title>
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
<!--End multiselect -->
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            /*$("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});*/
        });
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        
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
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
		
      </script>
    
<script>
$(document).ready(function() {
    $("#batch_id").change(function() {
        var selVal = $(this).val();
		//alert(selVal);
        $("#customise").html('');
		
        if(selVal == 'new_batch') 
		{
            $("#customise").append('<table width="40%"><tr><td width="50%" class="heading">Add Batch Name</span></td><td width="38%" colspan=2"><input type="text"            class="input_text" name="batch_name"/></td></tr></table>');
		}
		else{}
    });
});

function del_not(enroll_id, i)
{
	
	//alert(enroll_id);
	
				 var el = 'requirment_id'+i;
				
				//alert(document.getElementById(el).checked);
				if( document.getElementById(el).checked)
				
					document.getElementById("del_enroll_"+i).value='';
				
				else
				document.getElementById("del_enroll_"+i).value=enroll_id;
				
				
				//alert (document.getElementById("del_enroll_"+i).value);
	
}

</script>

 <script>
 
			
			function course_ajax(course_id) 
			 {
        		var selVal = course_id;
				
				<?php 
				$concsts ='';
				if($record_id)
				{
					$concsts= "+'&batch_id=$record_id'";
				}
				?>
			var data1="course_id="+selVal<?php echo $concsts; ?>;
                //alert(data1);
                 $.ajax ({
            url: "get_student.php", type: "post", data: data1, cache: false,
            success: function (html)
				{
					document.getElementById('student_div').innerHTML=html;
					//alert(html);
				  $(".multiselect").multiselect();
				}
            });
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php"; ?></td>
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
						$branch_name=$_POST['branch_name'];
						$arrage_date= explode('/',$_POST['start_date'],3);     
							 $start_date= $arrage_date[2].'-'.$arrage_date[0].'-'.$arrage_date[1];
								
						$arrage_date= explode('/',$_POST['end_date'],3);     
							 $end_date= $arrage_date[2].'-'.$arrage_date[0].'-'.$arrage_date[1];
								
						$name=$_POST['name'];
						$code=$_POST['code'];
                        
                        $discount=$_POST['discount'];                        
                       	$status=$_POST['status'];
						
                        if($name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter name";
                        }
                        if($start_date =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Start Date";
                        }
                        if($end_date =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter End Date";
                        }
						if($code =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter code";
                        }
                        if($discount =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter discount";
                        }    
                       
                       
                        
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
                            $data_record['start_date'] =$start_date;
							$data_record['end_date'] = $end_date;
                            $data_record['name'] = $name;
                            $data_record['code'] =$code;
							$data_record['discount']=$discount;
							$data_record['added_date']=date('Y-m-d H:i:s');
							$data_record['status']=$status;
							
							//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$data_record['cm_id'] =$cm_id;
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record['cm_id'] =$cm_id;
							}
							//====================================================================
                            if($record_id)
                            {
								
                                $where_record=" "; 
								 $update_discount = "  update discount_coupon set name='".$name."', start_date='".$start_date."', end_date='".$end_date."', code='".$code."', discount= '".$discount."',status='".$status."',cm_id='".$cm_id."' where discount_coupon_id='".$record_id."' ";
								$ptr_update_discount = mysql_query($update_discount);
								
								"<br>".$sql_query= "SELECT name FROM discount_coupon where discount_coupon_id ='".$record_id."' ";              
								$query=mysql_query($sql_query);
								$fetch=mysql_fetch_array($query);
								
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_discount','Edit','".$fetch['name']."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
									
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
								$disc_id=$db->query_insert("discount_coupon", $data_record);  
								
								"<br>".$sql_query= "SELECT name FROM discount_coupon where discount_coupon_id ='".$disc_id."' ";              
								$query=mysql_query($sql_query);
								$fetch=mysql_fetch_array($query);
								
								"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_discount','Add','".$fetch['name']."','".$disc_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
								$query=mysql_query($insert);
									
                               	echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                            
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            
             <?php
            	if($_SESSION['type']=='S')
                {
                ?>
                      <tr>
                      	<td>Select Branch</td>
                        <td>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
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
      			<?php }?>
             <tr>
            <td width="20%">Name<span class="orange_font">*</span></td>
            <td width="40%" class="customized_select_box">
           		<input type="text" name="name" id="name" value="<?php if($_POST['name']) echo $_POST['name']; else echo $row_record['name'];?>"  />
             </td> 
            </tr>
            
            <tr>
                <td width="22%">Code<span class="orange_font">*</span></td>
                <td width="38%" >
                    <input type="text" name="code" id="code" value="<?php if($_POST['code']) echo $_POST['code']; else echo $row_record['code'];?>"/>
                    </td> 
                
            </tr>
             <tr>
                <td width="22%">Discount(in %)<span class="orange_font">*</span></td>
                <td width="38%" >
                    <input type="text" name="discount" id="discount" value="<?php if($_POST['discount']) echo $_POST['discount']; else echo $row_record['discount'];?>"/>
                    </td> 
                
            </tr>
            <tr>
                <td height="43">Start Date</td>
                <td>
                <input type="text" class="validate[required] input_text datepicker" name="start_date" placeholder="Start Date" id="start_date" readonly="true" 
                value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else{ 
				$arrage_date= explode('-', $row_record['start_date'],3); echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
				}?>" />
                </td>
            </tr>
          
            <tr>
                 <td>End Date</td>
                 <td>
                 <input type="text" class="validate[required] input_text datepicker" name="end_date" placeholder="End Date" id="end_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['end_date'];else{ 
				$arrage_date= explode('-', $row_record['end_date'],3); echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
				}?>" />
                 </td>
            </tr>
            
            <tr>
                <td width="22%">Status<span class="orange_font">*</span></td>
                <td width="38%">
                   Active<input type="radio" name="status"  value="Active" checked="checked" <?php if($_POST['status']) echo $_POST['status']; else if( $row_record['status']=='Active') echo 'checked="checked"' ;?> >
                  Inactive<input type="radio" name="status"  value="Inactive" <?php if($_POST['status']) echo $_POST['status']; else if( $row_record['status']=='Inactive') echo 'checked="checked"' ;?> />
                </td> 
                
           </tr>   
              
            <tr>
                <td>&nbsp;</td>
                <td>
			
                <input type="submit" id="mySubmit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Discount"  name="save_changes"  />
               
                </td>
                <td></td>
            </tr>
        </table>
        </form>
         <?php
		if($record_id)
		{
			?>
        <script language="javascript"> 
		course_ajax(<?php echo $c; ?>);
		</script>
        <?php } ?>
        </td></tr>
<?php
                        }?>
	 
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