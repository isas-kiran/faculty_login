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
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
                
              <tr>
                  <td width="20%" valign="top">Service Name<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class="input_text" name="service_name" id="service_name" value="<?php if($_POST['save_changes']) echo $_POST['service_name']; else echo $row_record['service_name'];?>" required/></td> 
                <td width="10%"></td>
              </tr>
             
             <tr>
                  <td width="20%" valign="top">Service Code</td>
                <td width="70%"><input type="text"  class=" input_text" name="service_code" id="service_code" value="<?php if($_POST['save_changes']) echo $_POST['service_code']; else echo $row_record['service_code'];?>" required/></td> 
                <td width="10%"></td>
             </tr>
             
             <tr>
                 <td>Select Category </td>
                      <td width="70%">
                        <select name="service_category_id" style="width:200px;" required>
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
                 <td width="20%" valign="top">Time required to finish<span class="orange_font">*</span></td>
                  <td width="70%">
                    <select name="service_time" style="width:200px;" required>
                    <option value="">Select Time</option> 
                    <?php 
					for($i=15;$i<=360;$i+=15)
					{
						
						//echo "<br/>".$i;

                           //echo date('H:i', mktime(0,$i));
						   //echo $hours = floor($i / 60);
						 // echo  $minutes = $i % 60;
						 
						 

                        $minutes = $i;
						$zero    = new DateTime('@0');
						$offset  = new DateTime('@' . $minutes * 60);
						$diff    = $zero->diff($offset);
						echo $diff->format('%h Hr, %i Min');
						
						$selecteds='';
						 if($i==$row_record['service_time'])
                          $selecteds = 'selected="selected"';
												
						echo '<option value="'.$i.'" '.$selecteds.'>'.$diff->format('%h Hr : %i Min').'</option> ';
						
					}
					?>
                      
                    
                    </select>
                
                 </td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                  <td width="20%" valign="top">Product Cost</td>
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
                  <td width="20%" valign="top">Visit Frequency</td>
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