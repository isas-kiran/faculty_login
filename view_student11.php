<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
     $sql_record= "SELECT * FROM stud_regi where student_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
        unlink("../student_photos/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
student</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
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
						
                        $invoice_no= $_POST['invoice_no'];
						$inquiry_date= $_POST['inquiry_date'];
						$id_card= $_POST['id_card'];
						$source= $_POST['source'];
						$admission_remark= $_POST['admission_remark'];
						$course= $_POST['course'];
						$costomize_courses= $_POST['costomize_courses'];
						$fees= $_POST['fees'];
						$discount= $_POST['discount'];
						$final_fees= $_POST['final_fees'];
						$net_fees= $_POST['net_fees'];
						$total_fees= $_POST['total_fees'];
						$service_tax= $_POST['service_tax'];
						$down_payment= $_POST['down_payment'];
						$first_installment= $_POST['first_installment'];
						$second_installment= $_POST['second_installment'];
						$final_amt= $_POST['final_amt'];
						//$dob=$tan_date[2].'-'.$tan_date[0].'-'.$tan_date[1];
                       
						//$added_date=date('Y-m-d H:i:s');                    
                        
						 if($source =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Student Contact No";
                        }
						if($admission_remark =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter User Name";
                        }
						if($costomize_courses =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter PassWord";
                        }
                       $uploaded_url="";
                            if(count($errors)==0 && $_FILES['photo']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update stud_regi set photo='' where student_id='".$record_id."'";
                                    $db->query($update_news);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                    if($row_record['photo'] && file_exists("../student_photos/".$row_record['photo']))
                                        unlink("../student_photos/".$row_record['photo']);
                                }
                                $uploaded_url=time().basename($_FILES['photo']["name"]);
                                $newfile = "../teacher_photo/";

                                $filename = $_FILES['photo']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['photo']['type'];// type of file being uploaded
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['photo']['tmp_name'];
                                $target_path1 = $newfile.$uploaded_url;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../teacher_photo/".$uploaded_url;
                                        copy($target_path1,$thump_target_path);

                                        list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                        //echo $width.$height;
                                        if($width<=170 && $height<=170)
                                        {
                                            $file_uploaded=1;
                                        }
                                        else
                                        {
                                            //------------resize the image----------------
                                            $obj_img1 = new thumbnail_images();
                                            $obj_img1->PathImgOld = $thump_target_path;
                                            $obj_img1->PathImgNew = $thump_target_path;
                                            $obj_img1->NewWidth = 150;
                                            $obj_img1->NewHeight = 171;
                                            if (!$obj_img1->create_thumbnail_images())
                                            {
                                                $file_uploaded=0;
                                                unlink($target_path1);
                                                $success=0;
                                                $errors[$i++]="There are some errors while uploading image, please try again";
                                            }
                                            else
                                            {
                                                $file_uploaded=1;
                                               /* list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                                //echo $width.$height;
                                                if($height>100)
                                                {
                                                    //------------resize the image----------------
                                                    $obj_img1 = new thumbnail_images();
                                                    $obj_img1->PathImgOld = $thump_target_path;
                                                    $obj_img1->PathImgNew = $thump_target_path;
                                                    $obj_img1->NewHeight = 100;
                                                    if (!$obj_img1->create_thumbnail_images())
                                                    {
                                                        $file_uploaded=0;
                                                        unlink($target_path1);
                                                        $uploaded_url="";
                                                    }                                                    
                                                }
                                                */
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $file_uploaded=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading image, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded=0;
                                    $success=0;
                                    $errors[$i++]="Location image: Only image files allowed";
                                }
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
							$data_record['student_id']=$_REQUEST['record_id'];
							$data_record['invoice_no']='STD0'.$_REQUEST['record_id'];
							$data_record['inquiry_date']=$inquiry_date;
							$data_record['id_card']=$id_card;
							$data_record['source']=$source;
							$data_record['admission_remark']=$admission_remark;
                            $data_record['course']=$course;
                            $data_record['costomize_courses']=$costomize_courses;
                            $data_record['fees']=$fees;
							$data_record['discount']=$discount;
                            $data_record['final_fees']=$final_fees;
                            $data_record['net_fees']=$net_fees;
							$data_record['total_fees']=$total_fees;
						    $data_record['service_tax']=$service_tax;
                            $data_record['down_payment']=$down_payment;
							$data_record['first_installment']=$first_installment;
							$data_record['second_installment']=$second_installment;
							$data_record['final_amt']=$final_amt;
							$data_record['status']='Enrolled';
							$data_record_en['status']='Enrolled';
                            if($record_id)
                            {
                                $data_record['added_date'] = date('Y-m-d H:i:s');
                                echo $courses_id=$db->query_insert("enrollment", $data_record);  
							    $student_id= mysql_insert_id();
								
								$where_record="student_id='".$record_id."'";                                
                                $db->query_update("stud_regi", $data_record_en,$where_record); 
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
								 $where_record="student_id='".$record_id."'";                                
                                $db->query_update("stud_regi", $data_record,$where_record); 
							   
								
							$privilege_ids = $_POST['privilege_id'];
                            for($i=0;$i<count($privilege_ids);$i++)
                            {
                            $insert_for_prevelgegeis = "insert into admin_previleges values(0,'".$privilege_ids[$i]."','',
							'".$staff_id."')";
                            $ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
						    }  
							            
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
               $sql_sub_cat = "select * from stud_regi where student_id='".$row_record['student_id']."' ";
			   $my_query=mysql_query($sql_sub_cat);
			   $row= mysql_fetch_array($my_query);
			   //$implode_data = explode(",",$data_sub_cat['course_author']);
			
            ?>
            
                            <tr>
                                          <td width="20%">Addmission date<span class="orange_font">*</span></td>
                                          <td width="40%"><input type="text" class="validate[required] input_text" name="date" value="<?php echo date('d-m-Y'); ?>" /></td>
                            </tr> 
                            <tr>
                                          <td width="20%" contenteditable="true">Invoice No.<span class="orange_font">*</span></td>
                                          <td width="40%"><input type="text" class="validate[required] input_text" name="invoice_no"  value="<?php if($_POST['save_changes']) echo $_POST['student_id']; else echo 'STD0'.$row_record['student_id']; ?>" /> </td>
                            </tr>            
                            <tr>
                                                  <td width="20%"  contenteditable="true">Enquiry date<span class="orange_font">*</span></td>
                                                  <td 40%><input type="text" class="validate[required] input_text" name="inquiry_date"  value="<?php if($_POST['save_changes']) echo $_POST['added_date']; else echo $row_record['added_date'];?>" /></td>
                            </tr>   
                            <tr>
                                          <td width="20%">Student Name<span class="orange_font">*</span></td>
                                          <td width="40%">
                                          <input type="text" class="validate[required] input_text"  name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST[                        'name']; else echo $row_record['name'];?>" />
											
                            </td> 
                            </tr> 
                            <tr>
                                          <td width="20%">Contact No<span class="orange_font"></span></td>
                                          <td width="40%">
                    <input type="text" class="validate[required] input_text" name="contact" id="contact" value="<?php if($_POST['save_changes']) echo $_POST['contact']; else echo $row_record['contact'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                <td width="20%">Email Id<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text"  class="input_text" name="mail" id="mail" value="<?php if($_POST['save_changes']) echo $_POST['mail']; else echo $row_record['mail'];?>" />
                </td> 
                <td width="40%"></td>
              </tr>  
              <tr>
                <td width="20%">Address<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="address" id="address" value="<?php if($_POST['save_changes']) echo $_POST['address']; else echo $row_record['address'];?>" />   
                </td> 
                
              </tr> 
              <tr>
                     <td width="20%">Identity card No.<span class="orange_font">*</span></td>
                     <td width="40%"><input type="text" class="input_text" name="id_card" id="id_card" value="<?php if($_POST['save_changes']) echo $_POST['id_card']; else echo $row_record1['id_card'];?>" /></td>  <?php echo $row_record1['id_card']; ?>
              </tr>
              <tr>
                <td width="20%">Date Of Birth<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text datepicker" name="dob" id="dob" 
                    value="<?php if($_POST['save_changes']) echo $_POST['dob']; else 
				$arrage_date= explode('-',$row_record['dob'],3);     
				echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
					// $row_record['staff_dob'];
					?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
            <tr>
                   <td width="20%">Source<span class="orange_font">*</span></td>
                   <td><input type="text"  class="validate[required] input_text" name="source"  value="<?php if($_POST['save_changes']) echo $_POST['source']; else echo $row_record['source'];?>" /></td>
            </tr>             
            <tr>
                   <td width="20%">Admission remark<span class="orange_font">*</span></td>
                                            
                   <td><input type="text" class="validate[required] input_text" name="admission_remark"  value="<?php if($_POST['save_changes']) echo $_POST['admission_remark']; else echo $row_record['admission_remark'];?>" /></td>
            </tr>                                         
            <tr>
                                            <td width="20%" class="heading">Course<span class="orange_font">*</span></td>
                                            <td><select name="course" class="input_text">
                                            <option >select</option>
                                            <?php
											echo $query="select course_name from courses order by course_id"; 
											$query2 =mysql_query($query);
											
												while($records=mysql_fetch_array($query2))
												{
												  $records['course_name'];
												
												
											?>
                                            
                                            <option value= "<?php echo $records['course_name']; ?>"> <?php echo ($records['course_name']) ?>
                                            
                                            <?php } ?>
                                            </option>
                                            </select>
                                            </td>
                                            </tr>
                                            <tr>
                                                  <td width="20%" class="heading">Costomize Courses<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="costomize_courses"  value="<?php if($_POST['save_changes']) echo $_POST['costomize_courses']; else echo $row_record['costomize_courses'];?>" /></td>
                                            </tr>
                                            
                                            <tr>
                                                  <td width="20%" class="heading">Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="fees" id="fees" value="<?php if($_POST['save_changes']) echo $_POST['fees']; else echo $row_record1['fees'];?>" />  
                                                  </td>
                                            </tr>  
                                            <tr>
                                                  <td width="20%" class="heading">Discount<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="discount" /><?php if ($_post['discount'])
												  echo $_POST['discount'];?></td>
                                            </tr>   
                                            <tr>
                                                  <td width="20%" class="heading">Final Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="final_fees" /><?php if ($_post['final_fees'])
												  echo $_POST['final_fees'];?></td>
                                            </tr>  
                                            <tr>
                                                  <th width="20%" class="heading">Fee breakup </th>
                                            </tr>  
                                            <tr>    
                                                  <td width="20%" class="heading">Net Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="net_fees" /><?php if ($_post['net_fees'])
												  echo $_POST['net_fees'];?></td>
                                            </tr>
                                            <tr>      
                                                  <td width="20%" class="heading">Service Tax 14%<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="service_tax" /><?php if ($_post['tax'])
												  echo $_POST['tax'];?></td>
                                            </tr>
                                            <tr>      
                                                  <td width="20%" class="heading">Total Fees<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="total_fees"/><?php if ($_post['total_fees'])
												  echo $_POST['total_fees'];?></td>
                                            </tr>      
                                             <tr>
                                                  <th width="20%" class="heading">Installment</th>
                                             </tr>
                                             <tr>     
                                                  <td width="20%" class="validate[required]">Number of Installment </td>
                                                  <td width="20%" class="validate[required]"> 2</td>
                                                  
                                            </tr>   
                                            <tr>
                                                  <td width="20%" class="heading">Down Payment(Including tax)<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="down_payment" /><?php if ($_post['down_payment'])
												  echo $_POST['down_payment'];?></td>
                                            </tr>         
                                            <tr>
                                                  <td width="20%" class="heading">First Installment<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="first_installment" /><?php if ($_post['first_installment'])
												  echo $_POST['first_installment'];?></td>
                                            </tr>
                                            <tr>
                                                  <td width="20%" class="heading">Second Installment<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="second_installment" /><?php if ($_post['second_installment'])
												  echo $_POST['second_installment'];?></td>
                                            </tr>      
                                            <tr>
                                                  <td width="20%" class="heading">Final Amount<span class="orange_font">*</span></td>
                                                  <td><input type="text" class="validate[required] input_text" name="final_amt" /><?php if ($_post['final_amount'])
												  echo $_POST['final_amount'];?></td>
                                            </tr>
                                      
                                            
                                            
        </table>
        <center>
        <input type="submit" value="Generate Receipt" name="save_changes" /> </center>   
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
</body>
</html>
<?php $db->close();?>