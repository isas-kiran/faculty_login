<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>
    <?php if($record_id) echo "Edit"; else echo "Student";?>
    Form</title>
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
                    if($_POST['submit'])
                    {
                                            $firstname=$_POST['firstname'];
											$middlename=$_POST['middlename'];
											$lastname=$_POST['lastname'];
											$birth_date=$_POST['dob'];
											$gender=$_POST['gender'];
											$maritalstatus=$_POST['maritalstatus'];
											$address=$_POST['address'];
                                            $mobile1=$_POST['mobile1'];
											$mobile2=$_POST['mobile2'];
											$landline_no=$_POST['landline_no'];
					                        $email_id=$_POST['email_id'];
									        $education=$_POST['education'];
                                            $course_interested=trim($_POST['course_interested']);
                                            $customised_course=trim($_POST['customised_course']);
											if($course_interested =='custome')
											$course_interested=$customised_course;
											
                                            $enquiry_date=date('y-m-d');
                                            $duration_studies=$_POST['duration_studies'];
                                            $total_fees=$_POST['total_fees'];
                                            $batch=$_POST['batch'];
                                            $enquiry_src=$_POST['enquiry_src'];
                                            $enquiry_taken=$_SESSION['admin_id'];
                                            $remark=$_POST['remark'];
                                            $company=$_POST['company'];
                                            $inquiry_for=$_POST['inquiry_for'];
                                            $address=$_POST['address'];
                                       
											if($birth_date !='//')
											{
											
												$sep_date = explode('/',$birth_date);
												$birth_date = $sep_date[2].'-'.$sep_date[0].'-'.$sep_date[1];
											}
                                           if($firstname=="")
                                            {
                                                $success=0;
                                                $errors[$i++]="Enter your firstname";
                                            }
											 if($lastname=="")
                                            {
                                                $success=0;
                                                $errors[$i++]="Enter your lastname";
                                            }
											 											
											
											 
											 if($mobile1=="")
                                            {
                                                $success=0;
                                                $errors[$i++]="Enter mobile no.";
                                            }
											 											
											
											if($course_interested=="")
                                            {
                                                $success=0;
                                                $errors[$i++]="Enter your course_interested";
                                            }
                                           
                                            
											
											if($total_fees=="")
                                            {
                                                $success=0;
                                                $errors[$i++]="Enter total fees";
                                            }
											
											
                                            if(count($errors))
                                            {
                                                ?>
                <table width="90%" align="left" class="alert">
                <tr>
                    <td align="left"><strong>Please correct the following errors</strong>
                    <div style=" border: 1px solid #F00 ; padding-left:20px; background-color:#FC9">
                        <?php
                                                        for($k=0;$k<count($errors);$k++)
                                                                echo '<div style="text-align:left;padding:5px;">'.$errors[$k].'</div>';?>
                      </div></td>
                  </tr>
              </table>
                <br clear="all">
                <?php
                                            }
											
                                            else
                                            {
                                                $success=1;
												$data_record['firstname'] = $firstname;
												$data_record['middlename'] = $middlename;
												$data_record['lastname'] = $lastname;
											    $data_record['birth_date'] = $birth_date; 
												$dta_record['gender'] = $gender;
												$data_record['maritalstatus'] = $maritalstatus;
												$data_record['adress'] = $address;
												$data_record['mobile1'] = $mobile1;
											    $data_record['mobile2'] = $mobile2;
											    $data_record['landline_no'] = $landline_no;
                                                $data_record['email_id'] = $email_id;
												$data_record['education'] = $education;
												$data_record['course_interested'] = $course_interested;	
												$data_record['total_fees'] = $total_fees;
                                                $data_record['enquiry_date'] = $enquiry_date;
												$data_record['duration_studies'] = $duration_studies;
												$data_record['batch'] = $batch;
												$data_record['enquiry_source'] = $enquiry_src;
												$data_record['enquiry_taken'] = $enquiry_taken;
												$data_record['remark'] = $remark;  
                                                $data_record['inquiry_for'] = $inquiry_for;
												$data_record['not_status']='signs_on';
                                                $data_record['added_date'] =date('Y-m-d H:i:s');
												if($course_interested !='')
												{
													 $select_existing_course_id = " select course_id,course_name from courses where course_name='$course_interested' ";
													$ptr_course_id = mysql_query($select_existing_course_id);
													
													if(mysql_num_rows($ptr_course_id))
													{
													$data_course_id = mysql_fetch_array($ptr_course_id);
													 $course_id = $data_course_id['course_id'];
													 $course_interested = $data_course_id['course_name'];
													}
													else
													{
													 $insert_new_course = " insert into courses(`admin_id`,`course_name`,`course_price`,`course_duration`,`added_date`)values('".$_SESSION['admin_id']."','".addslashes($customised_course)."', '$total_fees','$duration_studies','".date('Y-m-d H:i:s')."' ) ";
													 $ptr_insert= mysql_query($insert_new_course);
													 $course_id = mysql_insert_id();
													}
												}
												
  
                                       
	 $insert= "INSERT INTO inquiry (`firstname`,`middlename`,`lastname`,`birth_date`,`gender`,`maritalstatus`,`address`,`mobile1`,`mobile2`,`landline_no`,
		`email_id`,`education`,`course_interested`,`course_id`,`total_fees`,`enquiry_date`,`duration_studies`  
		,`batch`,`enquiry_source`,`enquiry_taken`,`remark`,`inquiry_for`,`added_date`,`cm_id`) 
		VALUES ('$firstname','$middlename','$lastname','$birth_date','$gender','$maritalstatus','$address','$mobile1','$mobile2','$landline_no','$email_id','$education','$course_interested','$course_id','$total_fees','".date('Y-m-d H:i:s')."','$duration_studies','$batch',
'$enquiry_src','$enquiry_taken','$remark','$inquiry_for','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."')";
$ptr_query=mysql_query($insert);
 
 $insert_regi = "INSERT INTO `stud_regi` (`admin_id`, `name`,  `dob`, `address`, `contact`, `mail`, `qualification`,  `added_date`, `status` ,`not_status`) VALUES ('$enquiry_taken', '".$firstname." ".$lastname."', '$birth_date', '".$address."', '$mobile1', '".$email_id."', '$education', '".date('Y-m-d H:i:s')."', 'Enquiry','signs_on')";
 $ptr_reg = mysql_query($insert_regi);



                                                /*------------send a mail to admin about this---------------------*/
                                                $subject = "Enquiry from ".$firstname.' '.$lastname." on ".$siteUrlName."";
                                                $message= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
												 <tr>
                                                    <td width="35%"><strong>Firstname</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$firstname.'</td>
                                                </tr>';
												
                                                $message= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
                                                <tr>
                                                    <td width="35%"><strong>Middlename</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$middlename.'</td>
                                                </tr>';
                                               
												 
                                                $message= '
                                                <table cellpadding="3" align="left" cellspacing="3" width="75%">
                                                <tr>
                                                    <td width="35%"><strong>Lastname</strong></td>
                                                    <td>:</td>
                                                    <td width="65%">'.$lastname.'</td>
                                                </tr>';
												if($birth_date)
												$message.= '
												<tr>
												    <td><strong>Birth Date</strong></td>
													<td>:</td>
													<td>'.$birth_date.'<td>
												</tr>';
												if($gender)
												$message.= '
												<tr>
												    <td><strong>Gender</strong></td>
													<td>:</td>
													<td>'.$gender.'<td>
												</tr>';
												if($maritalstatus)
												$message.= '
												<tr>
												    <td><strong>Marital Status</strong></td>
													<td>:</td>
													<td>'.$maritalstatus.'<td>
												</tr>';
												if($address)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Address</strong></td>
                                                    <td>:</td>
                                                    <td>'.$address.'</td>
                                                </tr>';
												if($mobile1)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Mobile1</strong></td>
                                                    <td>:</td>
                                                    <td>'.$mobile1.'</td>
                                                </tr>';
												if($mobile2)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Mobile2</strong></td>
                                                    <td>:</td>
                                                    <td>'.$mobile2.'</td>
                                                </tr>';
												
                                                /*if($company)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Company</strong></td>
                                                    <td>:</td>
                                                    <td>'.$company.'</td>
                                                </tr>';*/
                                                
                                                if($landline_no)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Landline no</strong></td>
                                                    <td>:</td>
                                                    <td>'.$landline_no.'</td>
                                                </tr>';
												if($email_id)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Email</strong></td>
                                                    <td>:</td>
                                                    <td>'.$email_id.'</td>
                                                </tr>';
												 if($education)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Education</strong></td>
                                                    <td>:</td>
                                                    <td>'.$education.'</td>
                                                </tr>';
												 if($course_interested)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Course Interested</strong></td>
                                                    <td>:</td>
                                                    <td>'.$course_interested.'</td>
                                                </tr>';
												 if($customised_course)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Customised Course</strong></td>
                                                    <td>:</td>
                                                    <td>'.$customised_course.'</td>
                                                </tr>';
												 if($enquiry_date)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Enquiry Date</strong></td>
                                                    <td>:</td>
                                                    <td>'.$enquiry_date.'</td>
                                                </tr>';
												if($duration_studies)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Duration For Studies</strong></td>
                                                    <td>:</td>
                                                    <td>'.$duration_studies.'</td>
                                                </tr>';
												if($total_fees)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Total Fees</strong></td>
                                                    <td>:</td>
                                                    <td>'.$total_fees.'</td>
                                                </tr>';
												if($batch)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Prefer Batch</strong></td>
                                                    <td>:</td>
                                                    <td>'.$batch.'</td>
                                                </tr>';
												if($enquiry_source)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Enquiry Source</strong></td>
                                                    <td>:</td>
                                                    <td>'.$enquiry_source.'</td>
                                                </tr>';
												if($enquiry_taken)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Enquiry Taken By</strong></td>
                                                    <td>:</td>
                                                    <td>'.$enquiry_taken.'</td>
                                                </tr>';
												
                                                
                                                if($remark)
                                                $message.= '
                                                <tr>
                                                    <td><strong>Remark</strong></td>
                                                    <td>:</td>
                                                    <td>'.$remark.'</td>
                                                </tr>';
												
												if($contact_for)
                                                $message.= '
                                                <tr>
                                                    <td><strong>contact For</strong></td>
                                         
										            <td>:</td>
                                                    <td>'.$contact_for.'</td>
                                                </tr>';
                                                $message.='<tr><td>Enquiry form filled from  </td><td>:</td><td>Admin Panel<td></tr>
                                                </table>';
												
													$sendMessage=$GLOBALS['box_message_top'];
													$sendMessage.=$message;
													$sendMessage.=$GLOBALS['box_message_bottom'];
													$from_id='support<support@'.$GLOBALS['siteUrlName'].'>';
													$headers= 'MIME-Version: 1.0' . "\n";
													$headers.='Content-type: text/html; charset=utf-8' . "\n";
													$headers.='From:'.$from_id;
													//echo $to.$sendMessage;
													if($_SERVER['HTTP_HOST']!="localhost" && $_SERVER['HTTP_HOST']!="localhost:81")//|| $_SERVER['HTTP_HOST']=="hindavi-1"
   													 {
													if(mail('sudhir.pawar@waakan.com', $subject, $sendMessage, $headers))
													{
														//echo 'sent';	
													}
													}
   		                                             //echo $message;
                                               // if($row_record['email_id'])
                                                   //$mailSent=sendAdminMail('sachin.khedkar@waakan.com',$subject,$message,"");//e.g(to,subject,message,from email) defined in include/functions.php.
                                              ////  else
                                                //  $mailSent=sendAdminMail("sudhirwithu@gmail.com",$subject,$message,"");//e.g(to,subject,message,from email) defined in include/functions.php.
                                                /*-------------------------------------------------------------------------*/
												echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                                ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Inquity added successfully</p></center></div>
                            <script type="text/javascript">
                            // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                            modal: true,
                                            buttons: {
                                                        Ok: function() { $( this ).dialog( "close" );}
                                                     }
                                    });
                                });
                            </script>
 
                <?php
                                                
                                            }
                                        }
							
                    if($success==0)
                    {
                        ?>
                <tr>
                <td><form method="post" id="jqueryForm" enctype="multipart/form-data">
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                      </tr>
                    <tr>
                        <td width="20%">Firstname<span class="orange_font">*</span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="inputText" name="firstname" id="firstname"
                                            value="<?php if($_POST['firstname']) echo $_POST['firstname']; else echo $row_record['firstname'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%" contenteditable="true">Middlename<span class="orange_font">*</span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="inputText" name="middlename" id="middlename"
                                            value="<?php if($_POST['middlename']) echo $_POST['middlename']; else echo $row_record['middlename'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%"  contenteditable="true">Lastname<span class="orange_font">*</span></td>
                        <td 40% style="box-shadow:3px 3px 3px #888888;"><input type="text" class="inputText" name="lastname" id="lastname"
                                            value="<?php if($_POST['lastname']) echo $_POST['lastname']; else echo $row_record['lastname'];
											?>"/></td>
                      </tr>
                    <tr>
                        <td width="20%">Birth Date<span class="orange_font"></span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="input_text datepicker" name="dob" id="dob" 
                                    value="<?php if($_POST['save_changes']) echo $_POST['dob']; else 
									$arrage_date= explode('-',$row_record['dob'],3);     
									echo $arrage_date[1].'/'.$arrage_date[2].'/'.$arrage_date[0]; 
										// $row_record['staff_dob'];
										?>" /></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">Marital Status<span class="orange_font">*</span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><select id="maritalstatus" name="maritalstatus" class="input_text">
                            <option    value="---Select---">---Select---</option>
                            <option    value="Married">Married</option>
                            <option   value="Unmarried">Unmarried</option>
                          </select></td>
                      </tr>
                    <tr>
                        <td width="20%">Gender<span class="orange_font"></span></td>
                        <td width="40%"> Female
                        <input type="radio" name="gender" value="female" style="width:50px !important"/>
                        <br/>
                        Male
                        <input type="radio" name="gender" value="male" style="width:76px !important" /></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">Address<span class="orange_font"></span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><textarea name="address" id="address" class=" textarea"><?php if($_POST['address']) echo $_POST['address']; else echo $row_record['address'];?>
</textarea></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">Mobile 1<span class="orange_font">*</span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="inputText" name="mobile1" id="mobile1" value="<?php if($_POST['mobile1']) echo 			                                                     $_POST['mobile1']; else echo $row_record['mobile1'];?>"/></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%"> Mobile 2 </td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class=" inputText" name="mobile2" id="mobile2" value="<?php if($_POST['mobile2']) echo                                                      $_POST['mobile2']; else echo $row_record['mobile2'];?>"/></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">Landline No</td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="inputText" name="landline_no" id="landline_no" value="<?php if($_POST['landline_no'                                                     ]) echo $_POST['landline_no']; else echo $row_record['landline_no'];?>"/></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">E-Mail</td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class=" inputText" name="email_id" id="email_id" value="<?php if(                                                    $_POST['email_id']) echo $_POST['email_id']; else echo $row_record['email_id'];?>"/></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%">Education<span class="orange_font"></span></td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><select name="education" id="education"  class="inputText">
                            <option  value="">----Select----</option>
                            <option  value="SSC">SSC</option>
                            <option  value="HSC">HSC</option>
                            <option value="Under Graduation">Under Graduation</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Post Graduation">Post Graduation</option>
                          </select></td>
                      </tr>
                    <tr>
                        <td width="20%">Course Interested<span class="orange_font">*</span></td>
                        <td class="customized_select_box" style="box-shadow: 3px 3px 3px #888888;"><select id="course_interested" name="course_interested" onChange="ajax_course(this.value);">
                            <option value="select">Select</option>
                            <?php
														   $course_category = " select category_name,category_id from course_category ";
														   
														   $ptr_course_cat = mysql_query($course_category);
														   while($data_cat = mysql_fetch_array($ptr_course_cat))
														   {
															   echo " <optgroup label='".$data_cat['category_name']."'>";
														
                                        					$get="SELECT course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
										 					$myQuery=mysql_query($get);
										 					while($row = mysql_fetch_assoc($myQuery))
															{
																
															?>
                            <option value = "<?php echo $row['course_name']?>" > <?php echo $row['course_name'] ?> </option>
                            <?php }
													echo " </optgroup>";
														   }
													?>
                            <option value="custome">Customised Course</option>
                          </select></td>
                      </tr>
                    <tr>
                        <td colspan="3" width="100%"><div id="custome_div" style="display:none">
                            <table width="100%">
                            <tr>
                                <td width="26%">Customised Course<span class="orange_font">*</span></td>
                                <td width="40%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class="inputText" name="customised_course" id="customised_course" 			                                                     value="<?php if($_POST['customised_course']) echo $_POST['customised_course']; else echo $row_record['customised_course'];?>"/></td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                          </table>
                          </div></td>
                      </tr>
                    <tr>
                        <td width="20%"> Duration For Studies </td>
                        <td width="40%" style="box-shadow: 3px 3px 3px #888888;" ><div id="show_subject"></div>
                        <input type="text" class="inputText" name="duration_studies" id="duration_studies" value="<?php if($_POST['duration_studies'])echo $_POST['duration_studies']; else echo $row_record['duration_studies'];?>" /></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="22%">Total Fees</td>
                        <td width="38%" style="box-shadow: 3px 3px 3px #888888;"><input type="text" class=" inputText" name="total_fees" id="total_fees" 
                value="<?php if($_POST['total_fees'])echo $_POST['total_fees']; else echo $row_record['total_fees'];?>"/></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="22%">Prefer Batch </td>
                        <td width="38%" style="box-shadow: 3px 3px 3px #888888;"><select id="batch" name="batch">
                            <option value="">----Select----</option>
                            <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                          </select></td>
                        <td width="40%"></td>
                      </tr>
                    <tr>
                        <td width="20%" class="heading">Enquiry Source<span class="orange_font">*</span></td>
                        <td style="box-shadow: 3px 3px 3px #888888;"><select id="batch" name="enquiry_src">
                            <option value="">----Select----</option>
                            <option value="By Email">By Email</option>
                            <option  value="Newspaper">Newspaper </option>
                          </select></td>
                      </tr>
                    <!-- <tr>      
                                                  <td width="20%" class="heading">Enquiry Taken By <span class="orange_font">*</span></td>
                                                  <td><input type="text" class=" inputText" name="enquiry_taken" id="enquiry_taken" /></td>
                                            </tr>-->
                    <tr>
                        <td width="20%" class="heading">Remark<span class="orange_font">*</span></td>
                        <td style="box-shadow: 3px 3px 3px #888888;"><textarea name="remark" id="remark" ></textarea></td>
                      </tr>
                    <tr>
                        <td width="20%" >Enquiry For </td>
                        <td style="box-shadow: 3px 3px 3px #888888;" width="20%"  ><textarea name="inquiry_for" id="inquiry_for" ></textarea></td>
                      </tr>
                    <!--<tr>
                                                  <td width="30%" class="heading">Security Image)<span class="orange_font">*</span></td>
                                                  <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          				
                                         				<tr><td>
                   												<img src="captcha/captcha.php" id="captcha" height="40px"/><img onClick="document.getElementById('captcha')
                   												.src='captcha/captcha.php?'+Math.random();" id="change-image" style="cursor: pointer;" src="captcha/refresh.png" />
                                                         	</td>
                                                            <td >&nbsp;</td>
                                                        </tr>
                                                        <tr><td width="30%"><input type="text"  name="captcha" id="captcha-form"/></td>
                                            				
                                            			</tr>
                                           			</table></td>
                                            </tr> -->
                    <tr>
                        
                        <td><input type="reset" class="input_btn" onClick="document.contactUs.reset();"/></td>
                        &nbsp;
                        <td><input type="submit" class="input_btn" value="Submit" name="submit"/></td>
                        
                      </tr>
                  </table>
                  </form>
                    <script type="text/javascript">
                        $(function() 
                        {
                            $(".custom_cuorse_submit").click(function(){
                                var course_name = $("#course_name").val();
                                var category_id = $("#category_id").val();
                                var course_duration = $("#course_duration").val();
                                var course_desc = $("#course_desc").val();
                                var course_fee = $("#course_fee").val();
                                if(course_name == "" || course_name == undefined)
                                {
                                    alert("Eneter the course name.");
                                    return false;
                                }
                                if(category_id == "" || category_id == undefined)
                                {
                                    alert("Select the category.");
                                    return false;
                                }
                                if(course_duration == "" || course_duration == undefined)
                                {
                                    alert("Eneter the course duration.");
                                    return false;
                                }
                                var data1 = 'action=custome_course_submit&course_name='+course_name+'&course_duration='+course_duration+'&course_desc='+course_desc+'&course_fee='+course_fee+'&category_id='+category_id
                                $.ajax({
                                    url: "ajax.php", type: "post", data: data1, cache: false,
                                    success: function (html)
                                    {
                                        $(".customized_select_box").html(html);
                                        $("#duration_studies").val(course_duration);
                                        $("#total_fees").val(course_fee);
                                        $('.new_custom_course').dialog( 'close');
                                    }
                                });
                            });
                        });
                    </script>
                    <div class="new_custom_course" style="display: none;">
                        <form method="post" id="jqueryForm" enctype="multipart/form-data">
                            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                                <tr>
                                    <td colspan="3" class="orange_font">* Mandatory Fields</td>
                                </tr>
                                <tr>
                                    <td width="20%">Course Name<span class="orange_font">*</span></td>
                                    <td width="40%"><input type="text" class="inputText" name="course_name" id="course_name"/></td>
                                </tr>
                                <tr>
                                    <td>Course Category<span class="orange_font">*</span></td>
                                    <td>
                                        <select name="category_id" id="category_id" class="validate[required] input_select" >  
                                            <option value=""> Select Category</option>
                                            <?php
                                                $select_category = "select * from course_category ".$_SESSION['where_admin_id_2']." order by category_id asc";
                                                $ptr_category = mysql_query($select_category);
                                                                            /*$data_c=mysql_fetch_array($ptr_category);
                                                                            $corse_name=$data_c['category_id'];*/
                                                while($data_category = mysql_fetch_array($ptr_category))
                                                {
                                                    if($data_category['category_id'] == $row_record['category_id'])
                                                        echo '<option value='.$data_category['category_id'].' selected="selected">'.$data_category['category_name'].'</option>';
                                                    else
                                                        echo '<option value='.$data_category['category_id'].'>'.$data_category['category_name'].'</option>';
                                                }
                                                ?>        
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Course Duration<span class="orange_font">*</span></td>
                                    <td><input type="text" class="inputText" name="course_duration" id="course_duration"></td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>Course Description<span class="orange_font"></span></td>
                                    <td><textarea name="course_desc" id="course_desc"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Course Fee<span class="orange_font"></span></td>
                                    <td><input type="text" class="inputText" name="course_fee" id="course_fee"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                                        <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </td>
              </tr>
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
    <div id="footer">
      <? require("include/footer.php");?>
    </div>
    <!--footer end-->
</body>
</html>
<?php $db->close();?>