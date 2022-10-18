<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM customer where cust_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Customer</title>
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
	function ValidateContactForm()
     {
		var x = document.forms["ContactForm"]["email"].value;
        var atpos = x.indexOf("@");
        var dotpos = x.lastIndexOf(".");
		 if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
			alert("Not a valid e-mail address");
			return false;
		  } 
		  
		  var a = document.ContactForm.mobile1.value;
		  
		  if(a !='')
		  {
			 if(isNaN(a))
				{
					alert("Enter the valid Mobile Number(Like : 9566137117)");
					document.ContactForm.mobile1.focus();
					return false;
				}
				
			 if((a.length < 1) || (a.length > 10) || (a.length < 10))
				{
					 
					 alert("Enter Valid Mobile Number 1");
					 document.ContactForm.mobile1.focus();
		             return false;
					 
				}
				
		 }
		 
		 var b = document.ContactForm.mobile2.value;
		  
		  if(b !='')
		  {
			 if(isNaN(b))
				{
					alert("Enter the valid Mobile Number(Like : 9566137117)");
					document.ContactForm.mobile2.focus();
					return false;
				}
				
			 if((b.length < 1) || (b.length > 10) || (b.length < 10))
				{
					 
					 alert("Enter Valid Mobile Number 2");
					 document.ContactForm.mobile2.focus();
		             return false;
					 
				}
				
		 }
		 
		/*var member= document.ContactForm.membership.value;
		//alert(member)
		if(member=='')
		{
			alert("please Select the Membership ");
		
		    return false;
		}*/
		 
	 }
	 
	 
	 /*function ValidateContactForm(form)
		{
			ErrorText= "";
			if ( ( form.membership[0].checked == false ) && ( form.membership[1].checked == false ) )
			{
			alert ( "Please choose your User Type" );
			return false;
			}
			
			if (ErrorText= "") { form.submit() }
		}*/
	
	</script>
    
    <script type="text/javascript">
        function show(membership) 
		{ 
		  if(membership=='yes')
			{
				document.getElementById('membership_div').style.display = 'block';		
				document.getElementById('node_div').style.display = 'none';
			
			}
			else
			{
				document.getElementById('membership_div').style.display = 'none';		
				document.getElementById('node_div').style.display = 'block';
			
			}
		 }
		 
function show_member(membership_id)
 {
			
    //alert(membership_id);
	 
	if(membership_id !='')
	{
	 
	  var data1="membership_id="+membership_id;
               //alert(data1);
                 $.ajax({
            url: "get-member.php", type: "post", data: data1, cache: false,
            success: function (html)
				{
					
					 document.getElementById('price').value=html;
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
							$cust_id=$_POST['cust_id'];
                            $cust_name=$_POST['cust_name'];
                            $mobile1=$_POST['mobile1'];  
							$mobile2=$_POST['mobile2']; 
							$email=$_POST['email'];  
							$address=$_POST['address'];                
                            $membership=$_POST['membership'];
                            $gender=$_POST['gender'];
							$birth_date=$_POST['birth_date'];
							$anniversary_date=$_POST['anniversary_date'];
							
							$marketing_email=$_POST['marketing_email'];
							$transaction_email=$_POST['transaction_email'];
							$dnd_sms=$_POST['dnd_sms'];
							
							 $membership_id=$_POST['membership_id'];
							 $start_date=$_POST['start_date'];
							 $end_date=$_POST['end_date'];
							 $memberships=$_POST['memberships'];
							 $price=$_POST['price'];
							 $notes=$_POST['notes'];
							 
							 if($record_id=='')
							 {
								  $sel_cat="select email from customer where email ='".$email."' ";
								  $ptr_cat=mysql_query($sel_cat);
								  if(mysql_num_rows($ptr_cat))
								  {
									$success=0;
									$errors[$i++]="Email already Exist.";
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
								$data_record['customer_id'] =$cust_id;
                                $data_record['cust_name'] =$cust_name;
                                $data_record['mobile1'] =$mobile1;
								$data_record['mobile2'] =$mobile2;
								$data_record['email'] =$email;
								$data_record['address'] =$address;
								$data_record['membership']=$membership;
								$data_record['gender']=$gender;
								$data_record['birth_date']=$birth_date;
								$data_record['anniversary_date']=$anniversary_date;
								$data_record['marketing_email']=$marketing_email;
								$data_record['transaction_email']=$transaction_email;
								$data_record['dnd_sms']=$dnd_sms;
								 
								 $data_record['membership_id']=$membership_id;
								 $data_record['start_date']=$start_date;
								 $data_record['end_date']=$end_date;
								 $data_record['memberships']=$memberships;
								 $data_record['price']=$price;
								$notes=$_POST['notes'];
								 

                               if($record_id)
                                {
                                  
                                    $where_record=" cust_id='".$record_id."'";
                                    $db->query_update("customer", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("customer", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
						
						$rowSQL = mysql_query("SELECT MAX(cust_id) as max FROM `customer`" );
						$row = mysql_fetch_array( $rowSQL );
						$largestNumber = $row['max']+1;
                        ?>
            <tr><td>
   <form method="post" id="jqueryForm" name="ContactForm" enctype="multipart/form-data" onsubmit="return ValidateContactForm();">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
                <tr>
                  <td width="15%" valign="top">Customer ID<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="validate[required] input_text" name="cust_id" id="cust_id" value="<?php if($_POST['save_changes']) echo $_POST['cust_id']; else if($row_record['customer_id'] !='') echo $row_record['customer_id']; else echo $largestNumber;?>" /></td> 
                  <td width="10%"></td>
              </tr>
              <tr>
                  <td width="15%" valign="top">Customer Name<span class="orange_font">*</span></td>
                  <td width="70%"><input type="text"  class="validate[required] input_text" name="cust_name" id="cust_name" value="<?php if($_POST['save_changes']) echo $_POST['cust_name']; else echo $row_record['cust_name'];?>" /></td> 
                  <td width="10%"></td>
              </tr>
              
              <tr>
               <td width="15%" valign="top">Gender</td>
               <td>
                <input type="radio" value="male" name="gender" id="gender" <?php if($row_record['gender']=='male') echo 'checked="checked"'; ?> >Male
                <input type="radio" value="female" name="gender" id="gender" <?php if($row_record['gender']=='female') echo 'checked="checked"'; ?>>Female
               
               </td>
              
              </tr>
              
           <tr>
            <td width="15%" valign="top">Birth Date</td>
             <td width="70%"><input type="text"  class=" input_text datepicker" name="birth_date" id="birth_date" value="<?php if($_POST['save_changes']) echo $_POST['birth_date']; else echo $row_record['birth_date'];?>" /></td> 
              <td width="10%"></td>

            </tr>
             
            <tr>
            <td width="15%" valign="top">Anniversary Date</td>
             <td width="70%"><input type="text"  class=" input_text datepicker" name="anniversary_date" id="anniversary_date" value="<?php if($_POST['save_changes']) echo $_POST['anniversary_date']; else echo $row_record['anniversary_date'];?>" /></td> 
              <td width="10%"></td>

            </tr>
             
           <tr>
            <td width="15%" valign="top">Mobile 1</td>
             <td width="70%"><input type="text"  class=" input_text" name="mobile1" id="mobile1" value="<?php if($_POST['save_changes']) echo $_POST['mobile1']; else echo $row_record['mobile1'];?>" /></td> 
              <td width="10%"></td>

            </tr>
            
            <tr>
            <td width="15%" valign="top">Mobile 2</td>
             <td width="70%"><input type="text"  class=" input_text" name="mobile2" id="mobile2" value="<?php if($_POST['save_changes']) echo $_POST['mobile2']; else echo $row_record['mobile2'];?>" /></td> 
              <td width="10%"></td>

            </tr>
            
             <tr>
                  <td width="20%" valign="top">Email</td>
                <td width="70%"><input type="text"  class=" input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>"/></td> 
                <td width="10%"></td>
              </tr>
              
              <tr>
                <td width="20%" valign="top">Address</td>
                <td width="70%"><textarea name="address" id="address" style="width:50%"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?></textarea></td>
              </tr>
              
              <tr>
                <td width="20%" valign="top">DND</td>
                <td width="70%">
                  <input type="checkbox" name="marketing_email"  value="yes" <?php if($row_record['marketing_email']=='yes') echo 'checked="checked"' ?> >Receive Marketing Email
                  &emsp;<input type="checkbox" name="transaction_email"  value="yes" <?php if($row_record['transaction_email']=='yes') echo 'checked="checked"' ?>>Transaction Email
                  &emsp;<input type="checkbox" name="dnd_sms"  value="yes" <?php if($row_record['dnd_sms']=='yes') echo 'checked="checked"' ?>>SMS
                </td>
               
              </tr>
              
               <tr>
                <td width="20%" valign="top">If Membership</td>
                <td width="70%">
                  <input type="radio" name="membership" id="membership" value="yes" <?php if($row_record['membership']=='yes') echo 'checked="checked"' ?> onClick="show('yes');">Yes
                  <input type="radio" name="membership" id="membership" value="no" <?php if($row_record['membership']=='no') echo 'checked="checked"' ?> onClick="show('no');">No
                </td>
               
              </tr>
              
              <tr>
              <td colspan="3">
               <div id="membership_div" <?php  if($row_record['membership']=='yes' || $_POST['membership'] =='yes') echo ' style="display:block"'; else echo ' style="display:none"'; ?>> 
                    <table border="0" cellspacing="15" cellpadding="0" width="80%">
                        <tr>
                            <td>Select Membership </td>
                            <td width="70%">
                            <select name="membership_id" style="width:200px;" onChange="show_member(this.value);">
                             <option value="0">Select Membership</option> 
                              <?php  
							    $sql_dest = " select membership_name, membership_id from membership order by membership_id asc";
								$ptr_edes = mysql_query($sql_dest);
								while($data_dist = mysql_fetch_array($ptr_edes))
								{ 
										$selecteds = '';
										if($data_dist['membership_id']==$row_record['membership_id'])
										$selecteds = 'selected="selected"';	
										   
									echo "<option value='".$data_dist['membership_id']."' ".$selecteds.">".$data_dist['membership_name']."</option>";
								}
	
	                            ?>
                            </select>
                            
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
                           <td >Membership</td>
                           <td width="70%"><input type="radio" value="gold" name="memberships" id="memberships" <?php if($row_record['memberships']=='gold') echo 'checked="checked"' ?>>Gold
                               <input type="radio" value="silver" name="memberships" id="memberships" <?php if($row_record['memberships']=='silver') echo 'checked="checked"' ?>>Silver
                               <input type="radio" value="platinum" name="memberships" id="memberships" <?php if($row_record['memberships']=='platinum') echo 'checked="checked"' ?>>Platinum
                           </td>
                        
                       </tr>
                       <tr>
                       		<td width="25%">Amount :</td>
							<td width="40%"><input type="text" name="price" class="validate[required] input_text" id="price" value="<?php if($_POST['price']) echo $_POST['price']; else echo $row_record['price'];?>" /></td>
                        </tr>
                  
                        
                    </table>
                  </div>
              </td> 
              </tr>
              <tr>
                <td width="20%" valign="top">Notes</td>
                <td width="70%"><textarea name="notes" id="notes" style="width:50%"><?php if($_POST['notes']) echo $_POST['notes']; else echo $row_record['notes'];?></textarea></td>
              </tr>
               <tr>
												
              <td colspan="3">
               <div id="node_div" <?php  if($row_record['membership']=='no' || $_POST['membership'] =='no') echo ' style="display:none"'; else echo ' style="display:none"'; ?>> 
                     <table border="0" cellspacing="15" cellpadding="0" width="80%">
                                                
                                                     
                                                    
                     </table>
                  </div>
              </td> 
             </tr>
             
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Customer" name="save_changes"  /></td>
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