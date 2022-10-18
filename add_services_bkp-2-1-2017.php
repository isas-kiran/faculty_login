<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM servies where service_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Services</title>
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
    
    <script>
 
 function calculte_other_cost(val)
 {
	 //alert(val)
	 
	 var total=isNaN(parseInt(val * 2)) ? 0 :(val * 2)
	 $('#other_cost').val(total);
	 
	 var other_cost=document.getElementById("other_cost").value;
	 var total1=isNaN(parseInt((+val) + (+other_cost))) ? 0 :parseInt((+val) + (+other_cost))
	 $('#total_cost').val(total1);
	 
	 var total_cost=document.getElementById("total_cost").value;
	 var total2=isNaN(parseInt(total_cost * 4)) ? 0 :parseInt(total_cost * 4)
	 $('#service_price').val(total2);
 }
 
 
 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 
		
		 if(frm.service_name.value=='')
		 {
			 disp_error +='Enter Service Name\n';
			 document.getElementById('service_name').style.border = '1px solid #f00';
			 frm.service_name.focus();
			 error='yes';
	     }
		 
		  if(frm.service_code.value=='')
		 {
			 disp_error +='Enter Service Code \n';
			 document.getElementById('service_code').style.border = '1px solid #f00';
			 frm.service_code.focus();
			 error='yes';
	     }
		 
		 if(frm.service_category_id.value=='')
		 {
			 disp_error +='Select Category   \n';
			 document.getElementById('service_category_id').style.border = '1px solid #f00';
			 frm.service_category_id.focus();
			 error='yes';
	     }
		  
		 if(frm.service_time.value=='')
		 {
			 disp_error +='Please select Service Time \n';
			 document.getElementById('service_time').style.border = '1px solid #f00';
			 frm.service_time.focus();
			 error='yes';
	     }
		  
		
		  if(frm.product_cost.value=='')
		 {
			 disp_error +='Enter Product Cost \n';
			 document.getElementById('product_cost').style.border = '1px solid #f00';
			 frm.product_cost.focus();
			 error='yes';
	     }
		 
		
		  if(frm.visit_frequency.value=='')
		 {
			 disp_error +='Enter Visit Frequency  \n';
			 document.getElementById('visit_frequency').style.border = '1px solid #f00';
			 frm.visit_frequency.focus();
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
 <script>
	 function show_subcategory(pcategory_id,sub_id)
	 {
		if(pcategory_id !='')
		{
		  var data1="action=show_service&pcategory_id="+pcategory_id+"&sub_id="+sub_id;
				   //alert(data1);
					 $.ajax({
				url: "get-subcategory.php", type: "post", data: data1, cache: false,
				success: function (html)
					{
						
						 document.getElementById('member_new').innerHTML=html;
					}
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
                            $service_name=$_POST['service_name'];
                            $service_description=$_POST['service_description'];  
							$service_price=$_POST['service_price'];    
							$service_time=$_POST['service_time']; 
							$service_code=$_POST['service_code']; 
							$service_category_id=$_POST['service_category_id'];           
                            $product_cost=$_POST['product_cost'];
							$other_cost=$_POST['other_cost'];
							$total_cost=$_POST['total_cost'];
							$visit_frequency=$_POST['visit_frequency'];
							$notes=$_POST['notes'];
							$subcategory_id=$_POST['sub_id'];
							if($record_id=='')
							 {
								  $sel_service="select service_name from servies where service_name ='".$service_name."' ";
								  $ptr_service=mysql_query($sel_service);
								  if(mysql_num_rows($ptr_service))
								  {
									$success=0;
									$errors[$i++]="Service already Exist.";
								  }
								  
								  $sel_service_code="select service_code from servies where service_code ='".$service_code."' ";
								  $ptr_service_code=mysql_query($sel_service_code);
								  if(mysql_num_rows($ptr_service_code))
								  {
									$success=0;
									$errors[$i++]="Service Code already Exist.";
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
                                $data_record['service_name'] =$service_name;
                                $data_record['service_description'] =$service_description;
								$data_record['service_price'] =$service_price;
								$data_record['service_time'] =$service_time;
								$data_record['service_code'] =$service_code;
								$data_record['service_category_id'] =$service_category_id;
								$data_record['product_cost']=$product_cost;
								$data_record['other_cost']=$other_cost;
								$data_record['total_cost']=$total_cost;
								$data_record['visit_frequency']=$visit_frequency;
								$data_record['notes']=$notes;
								$data_record['subcategory_id']=$subcategory_id;
                               if($record_id)
                                {
                                  
                                    $where_record=" service_id='".$record_id."'";
                                    $db->query_update("servies", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("servies", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                </tr>
              <tr>
                  <td width="20%" valign="top">Service Name <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="input_text" name="service_name" id="service_name" value="<?php if($_POST['save_changes']) echo $_POST['service_name']; else echo $row_record['service_name'];?>" /></td> 
                <td width="10%"></td>
              </tr>
             <tr>
                  <td width="20%" valign="top">Service Code <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text" name="service_code" id="service_code" value="<?php if($_POST['save_changes']) echo $_POST['service_code']; else echo $row_record['service_code'];?>" /></td> 
                <td width="10%"></td>
             </tr>
             <tr>
                 <td>Select Category <span class="orange_font">*</span></td>
                      <td width="70%">
                        <select name="service_category_id" id="service_category_id" style="width:200px;" onchange="show_subcategory(this.value,'');" >
                         <option value="">Select Category</option> 
                          <?php  
                            $sql_dest = " select category_name, service_category_id from service_category order by service_category_id asc";
                            $ptr_edes = mysql_query($sql_dest);
                            while($data_dist = mysql_fetch_array($ptr_edes))
                            { 
                                    $selecteds = '';
                                    if($data_dist['service_category_id']==$row_record['service_category_id'])
                                    $selecteds = 'selected="selected"';	
                                       
                                echo "<option value='".$data_dist['service_category_id']."' ".$selecteds.">".$data_dist['category_name']."</option>";
                            }

                            ?>
                        </select>
                      </td>
                            
            </tr>
            <?php
			  if($record_id)
			  { ?>
              <script>
				  show_subcategory(<?php echo $row_record['service_category_id'] ?>,'<?php echo $row_record['subcategory_id'] ?>')
				  </script>
			  <?php 
			  }
			  ?>
           <tr><td width="50%" colspan="3"><div id="member_new"> </div></td></tr> 
           <tr>
            <td width="12%" valign="top">Service Description </td>
            <td colspan="2">
                   
			 <script src="ckeditor/ckeditor.js"></script>
                <textarea name="service_description" id="service_description"><?php if ($_POST['service_description']) echo stripslashes($_POST['service_description']); else echo $row_record['service_description']; ?></textarea>
            <script>
                CKEDITOR.replace( 'service_description' );
            </script>
                </td> 
            </tr>
            <tr>
                 <td width="20%" valign="top">Time required to finish <span class="orange_font">*</span></td>
                  <td width="70%">
                   <?php 
					/*for($i=15;$i<=360;$i+=15)
					{
                        $minutes = $i;
						$zero    = new DateTime('@0');
						$offset  = new DateTime('@' . $minutes * 60);
						$diff    = $zero->diff($offset);
						 $diff->format('%h Hr, %i Min');
						
						$selecteds='';
						 if($i==$row_record['service_time'])
                          $selecteds = 'selected="selected"';
												
						echo '<option value="'.$i.'" '.$selecteds.'>'.$diff->format('%h Hr : %i Min').'</option> ';
					}*/
					?>
                    <select name="service_time" id="service_time" style="width:200px;" >
                    <option value="">Select Time</option> 
                    <option value="">Select Time</option>
                    <option value="15">0 Hr : 15 Min</option>
                    <option value="30">0 Hr : 30 Min</option>
                    <option value="45">0 Hr : 45 Min</option>
                    <option value="60">1 Hr : 0 Min</option>
                    <option value="75">1 Hr : 15 Min</option>
                    <option value="90">1 Hr : 30 Min</option>
                    <option value="105">1 Hr : 45 Min</option>
                    <option value="120">2 Hr : 0 Min</option>
                    <option value="135">2 Hr : 15 Min</option>
                    <option value="150">2 Hr : 30 Min</option>
                    <option value="165">2 Hr : 45 Min</option>
                    <option value="180">3 Hr : 0 Min</option>
                    <option value="195">3 Hr : 15 Min</option>
                    <option value="210">3 Hr : 30 Min</option>
                    <option value="225">3 Hr : 45 Min</option>
                    <option value="240">4 Hr : 0 Min</option>
                    <option value="255">4 Hr : 15 Min</option>
                    <option value="270">4 Hr : 30 Min</option>
                    <option value="285">4 Hr : 45 Min</option>
                    <option value="300">5 Hr : 0 Min</option>
                    <option value="315">5 Hr : 15 Min</option>
                    <option value="330">5 Hr : 30 Min</option>
                    <option value="345">5 Hr : 45 Min</option>
                    <option value="360">6 Hr : 0 Min</option>
                    </select>
                 </td> 
                <td width="10%"></td>
            </tr>
              
           	<tr>
                <td width="20%" valign="top">Product Cost <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text" name="product_cost" id="product_cost" value="<?php if($_POST['save_changes']) echo $_POST['product_cost']; else echo $row_record['product_cost'];?>" onkeyup="calculte_other_cost(this.value)" /></td> 
                <td width="10%"></td>
           	</tr>
            <tr>
                <td width="20%" valign="top">Other Cost</td>
                <td width="70%"><input type="text"  class=" input_text" name="other_cost" id="other_cost" value="<?php if($_POST['save_changes']) echo $_POST['other_cost']; else echo $row_record['other_cost'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="20%" valign="top">Total Cost</td>
                <td width="70%"><input type="text"  class=" input_text" name="total_cost" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td> 
                <td width="10%"></td>
              </tr>
            <tr>
                <td width="20%" valign="top">Service Price</td>
                <td width="70%"><input type="text"  class="input_text" name="service_price" id="service_price" value="<?php if($_POST['save_changes']) echo $_POST['service_price']; else echo $row_record['service_price'];?>" /></td> 
                <td width="10%"></td>
              </tr>
            <tr>
                <td width="20%" valign="top">Visit Frequency (in days) <span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="input_text" name="visit_frequency" id="visit_frequency" value="<?php if($_POST['save_changes']) echo $_POST['visit_frequency']; else echo $row_record['visit_frequency'];?>" /></td> 
                <td width="10%"></td>
            </tr>
            <tr>
            	<td width="12%" valign="top">Notes </td>
            	<td colspan="2">
			 	<script src="ckeditor/ckeditor.js"></script>
                	<textarea name="notes" id="notes"><?php if ($_POST['notes']) echo stripslashes($_POST['notes']); else echo $row_record['notes']; ?></textarea>
            	<script>
                	CKEDITOR.replace( 'notes' );
            	</script>
                </td> 
            </tr>
            <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Service" name="save_changes"  /></td>
                  <td></td>
            </tr>
        </table>
        </form>
        </td></tr>
<?php }   ?>
	 
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