<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM class where calss_id='".$record_id."'";
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Class</title>
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
            $("#user_id").multiselect().multiselectfilter();
			//alert($("#user_id"));
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
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
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
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
    
     <script type="text/javascript">   
     function calculate_total()   // caloculate the total of sell
  {
	var   avail=document.getElementById('balance_amount').value;
	var   paid_balance=document.getElementById('paid_balance').value;
	//alert(avail);
	//alert(add_avail);
	   
		if(avail !='' && paid_balance !='' )
			avail_balance_id = parseInt(avail) - parseInt(paid_balance);
		else
			avail_balance_id=0;				
		document.getElementById('avail_balance').value=avail_balance_id;		
		document.getElementById('avail_balance_show').innerHTML = avail_balance_id;
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
    <td class="top_mid" valign="bottom"><?php include "include/admition_menu.php"; ?></td>
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
                        $stud_class_regi_id=$_GET['stud_class_regi_id'];
						$student_id=$_GET['student_id'];
                        $course_id = $_GET['course_id'];
                        $amount_paid=$_POST['amount_paid'];
                        $balance=$_POST['balance'];
					    $date_time=date('Y-m-d H:i:s'); 
						   
                        if($amount_paid =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Amount ";
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
                            $data_record['stud_class_regi_id'] =$stud_class_regi_id;
                            $data_record['student_id'] =$_GET['student_id'];
                            $data_record['course_id'] =$course_id;
                            $data_record['amount_paid'] = $amount_paid;
                            $data_record['balance'] = $balance;
							$data_record['date_time'] = $date_time;
                            if($record_id)
                            {   
                                $where_record="paid_id='".$record_id."'";                                
                                $db->query_update("pay_fees_mapping", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
								
                                $paid_id=$db->query_insert("pay_fees_mapping", $data_record);                                
                               // echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
								echo '<script>
								alert("Fees Added Successfully ")
							       document.location.href ="stud_admition_details.php?student_id='.$_GET['student_id'].'";
								</script>';
                            }
                        }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
        <?php
		$selct_query=mysql_query("select * from  stud_class_regi where course_id = '".$_GET['course_id']."' and student_id = '".$_GET['student_id']."' ");
		$val_recordss=mysql_fetch_array($selct_query);
		
		$selct_queryss=mysql_query("select * from  courses where course_id = '".$_GET['course_id']."'");
		$val_recordssss=mysql_fetch_array($selct_queryss);
		
		?>
        
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
              <td width="22%">Course Name</td>
              <td width="40%">
                <input type="text" class="input_text" name="" id=""  readonly="readonly" value="<?php echo $val_recordssss['course_name'] ?>" />
                </td>                
              <td width="40%"></td>
            </tr>
            <tr>
              <td width="22%"> Total Fees</td>
              <td width="40%">
                <input type="text" class="input_text" name="total_fees" id="total_fees"  readonly="readonly" value="<?php echo $val_recordss['total_fees'] ?>" />
                </td>                
              <td width="40%"></td>
            </tr>
            <tr>
              <td width="22%">Paid Fees</td>
              <td width="40%">
                <input type="text" class="validate[required] input_text" name="paid" id="paid" readonly="readonly" value="<?php echo $val_recordss['paid']; ?>"
                onblur="show_record()" />
                </td>                
              <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Available Fees</div></td>
                
                <td width="40%">
                    <input type="text" class="input_text" name="balance_amount" readonly="readonly" 
                    value="<?php  echo $val_recordss['balance'];  ?>"   id="balance_amount" onkeyup="calculate_total()"   />
            
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Paid balance Fees</div></td>
                
                <td width="40%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="amount_paid" id="paid_balance"  onkeyup="calculate_total()"  />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Available Balance   Fees</div></td>
                
                <td width="40%">
                    <input type="text" class="input_text" name="balance"  id="avail_balance"  readonly="readonly"/>
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?>  Fees " name="save_changes"  /></td>
                <td></td>
            </tr>
        </table>
        </form>
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
<script>
calculate_total();
</script>
<!--footer end-->
</body>
</html>
<?php $db->close();?>