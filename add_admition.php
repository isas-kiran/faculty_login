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
<html xmlns="http://www.w3.org/1999/xhtml"><head>
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
    <script>
function show_subject(subject)
		{
			//alert(subject);
			var data1="show_subject=1&subject="+subject;
				 $.ajax({
            url: "show_subject_multiple.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				
				 document.getElementById('show_subject').innerHTML=html;
			}
			});
		}
		function show_fees(course_id)
		{
			var data1="show_fees=1&course_id="+course_id;
				 $.ajax({
            url: "show_fees.php", type: "post", data: data1, cache: false,
            success: function (retrive_func)
            {
				 document.getElementById('total_fees').innerHTML=retrive_func;
			}
			});
		}
		function show_batch(course_id)
		{
			var data1="show_batch=1&course_id="+course_id;
				 $.ajax({
            url: "show_batch.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				 document.getElementById('batches').innerHTML=html;
			}
			});
		}
		
	</script> 
    
    <script>
function counter_check(id)
{
	//alert(id);
	total_prices='total_prices';
	fee_id = 'fees_'+id;
	id= '#'+id;
	//$(id).attr('checked',true);
	previous = parseInt($('#total_checked_questions').val());
	//alert(previous);
	total_qution=document.getElementById('trotot').value;
	
	fees_value= parseInt(document.getElementById(fee_id).value);
	
	sub_fee= parseInt(document.getElementById('sub_fee').value);
	
	/*if(previous>=total_qution)
	$(id).removeAttr('checked');	
	else
	{	*/
	if($(id).is(':checked'))
	{
	previous=	previous+1;
	sub_fee = (sub_fee)+(fees_value);
	
	}
	else
	{
	previous= previous-1;
	sub_fee = (sub_fee)-(fees_value);
	}
	//}
	$('#total_checked_questions').val(previous);
	total_counter=($('#total_checked_questions').val());
	$('#total_checked_question').val(previous);
	$('#sub_fee').val(sub_fee);
	// document.getElementById(
	 //alert(total_counter);
	 toal_fees=$('#sub_fee').val();
	 total_pricess= parseInt(document.getElementById(total_prices).value);
	 if(total_pricess > toal_fees)
	 {
	  $('#toal_fees').val(toal_fees);
	 }
	 else
	 {
		  $('#toal_fees').val(total_pricess);
	 }
	 
	}
</script>
<script>
function show_record()
{       
      concession=0; 
	  paid=0;
	  totals_fees=0;
	  balance=0;
	  totals_fees = document.getElementById('toal_fees').value;
	  concession = document.getElementById('concession').value;
	  paid = document.getElementById('paid').value;
	 
	 if(concession !='')
	 {
	total_bal_ava= parseInt(totals_fees)- parseInt(concession)- parseInt(paid);
	 }
	 else
	 {
		 concession=0;
		total_bal_ava= parseInt(totals_fees)- parseInt(concession)- parseInt(paid);
	 }
	//alert(total_bal_ava);
	document.getElementById('balance').value=total_bal_ava;
	  
	
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
                        $student_id=$_POST['student_id'];
                        $course_id = $_POST['course_id'];
						$subject_id=$_POST['subject_id']; 
						$batch_id=$_POST['batch_id'];  
                        $description=$_POST['description'];
						$total_sub_fee=$_POST['total_sub_fee']; 
                        $paid=$_POST['paid'];
                        $balance=$_POST['balance'];
						$concession=$_POST['concession']; 
					    $added_date=date('Y-m-d H:i:s'); 
						   
                        
                        if($student_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select Student";
                        }
						
                        if($course_id=="")
                        {
                                $success=0;
                                $errors[$i++]="Please Select course ";
                        }  
						 if($paid =="")
                        {
                                $success=0;
                                $errors[$i++]="Please Add Amount ";
                        }   
						/* if($total_fees =="")
                        {
                                $success=0;
                                $errors[$i++]="Please enter total fees";
                        }  */ 
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
                            $data_record['student_id'] =$student_id;
                            $data_record['course_id'] =$_POST['course_id'];
                            $data_record['batch_id'] =$_POST['batch_id'];
                            $data_record['description'] =$description;
                            $data_record['total_fees'] = $total_sub_fee;
                            $data_record['paid'] = $paid;
                            $data_record['balance'] = $balance;
							$data_record['concession'] = $concession;
							$data_record['added_date'] = $added_date;
                            
                            if($record_id)
                            {   
                                $where_record="stud_class_regi_id='".$record_id."'";                                
                                $db->query_update("stud_class_regi", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
								$total_sub=$_POST['total_checked_question'];
								$concat="";
								
								for($i=1;$i<=$total_sub;$i++)
								{
								$comma="";
								    $subject_id =$_POST['subject_id'.$i];
								  if($i < $total_sub)
                                    $comma= ",";
								 $concat.=$subject_id.$comma;
								}
								
								$data_record['subject_id']= $concat;
                                $stud_class_regi_id=$db->query_insert("stud_class_regi", $data_record);                                
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
            <tr>
            <td width="20%">Select Student <span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="student_id" id="student_id" class="validate[required] input_select">  
                        <option value=""> Select Student   </option>
                        <?php
                            $select_category = "select * from stud_regi order by student_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['student_id'] == $row_record['student_id'])
                                    echo '<option value='.$data_category['student_id'].' selected="selected">'.$data_category['name'].'</option>';
                                else
                                    echo '<option value='.$data_category['student_id'].'>'.$data_category['name'].'</option>';
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%" align="left"> </td>
            </tr>
            <tr>
            <td width="20%">Select Course<span class="orange_font">*</span></td>
            <td width="40%" >
                    <select name="course_id" id="course_id" class="validate[required] input_select" onchange="show_subject(this.value); show_fees(this.value); show_batch(this.value)" >  
                        <option value=""> Select Course </option>
                        <?php
                            $select_category = "select * from courses order by course_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['course_id'] == $row_record['course_id'])
                                    echo '<option value='.$data_category['course_id'].' selected="selected">'.$data_category['course_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['course_id'].'>'.$data_category['course_name'].'</option>';
                            }
                            ?>        
                    </select>
                    </td> 
                <td width="40%" align="left"> <div id=total_fees></div></td>
            </tr>
             <tr>
                <td width="20%"> Select Subject </td>
                <td width="40%" ><div id="show_subject"></div>   
                <input type="hidden"  name="total_checked_question" id="total_checked_question"  value="" /> </td> 
                <td width="40%"></td>
            </tr>
              <tr>
                <td width="20%"> Select Batch </td>
                <td width="40%" ><div id="batches"></div> </td> 
                <td width="40%"></td>
            </tr>
            <tr>
            <td width="22%" valign="top">Course Description <!--span class="orange_font">*</span --></td>
            <td colspan="2">
                    <?php
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('description') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['description']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['description']);
                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                            $oFCKeditor->Height		= "230";
                            $oFCKeditor->Create() ;
                     ?>
            </td> 
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Course Fees</div></td>
                <td width="38%"><div id="coursess" class="coursess" >
                <input type="text" class="input_text" name="total_fees" id="toal_fees" readonly="readonly" value="<?php if($_POST['save_changes']) echo $_POST['total_fees']; else echo $row_record['total_fees'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >concession  </div></td>
                <td width="38%"><div id="coursess" class="coursess" >
                <input type="text" class="input_text" name="concession" id="concession" value="<?php if($_POST['save_changes']) echo $_POST['concession']; else echo $row_record['concession'];?>" 
                onblur="show_record()"/>
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Paid Fees</td>
                <td width="38%">
                <input type="text" class="validate[required] input_text" name="paid" id="paid" value="<?php if($_POST['save_changes']) echo $_POST['paid']; else echo $row_record['paid'];?>"
                onblur="show_record()" />
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Available Fees</div></td>
                
                <td width="38%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="balance" readonly="readonly" id="balance" value="<?php if($_POST['save_changes']) echo $_POST['balance']; else echo $row_record['balance'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Take Adminsion " name="save_changes"  /></td>
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
<!--footer end-->
</body>
</html>
<?php $db->close();?>