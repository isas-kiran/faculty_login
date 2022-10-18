<?php session_start();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
//echo $_REQUEST['record_id'];
if($_REQUEST['record_id'])
{
	
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM courses where course_id='".$record_id."' ".$_SESSION['where_admin_id']."";
	
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
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Course</title>
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
		
  
     function del_degree(del)  // for delete the degree
					 {
						var i=parseInt(document.getElementById('extra').value);
						if(i !=0)
						{
							document.getElementById(i).style.display='none';
							document.getElementById('extra').value=parseInt((i-1));
						}
					 	//document.getElementById(j).style.display='none'; 
						
					 }
					 function add_degree(no) //for add a degree
					 {
					 	var i=parseInt(document.getElementById('extra').value);
						i=i+1;
						
						var next = i+1;
						if(document.getElementById(i).style.display=='none')
						{
							document.getElementById(i).style.display='block';
						}
						else
						{
							//var dealer= select_dealer(i); 
							//var  product     = select_product(i);
					 	var value='<div id="'+i+'"><table class="table_class" width="58%"  cellspacing="0" cellpadding="2"> <tr style="text-align:center;"><td align="center" ></td><td align="center"><input type="text" name="batch_name'+i+'"  class="input_text" /></td><td><input type="text" name="batch_time'+i+'"  class="input_text" /></td></tr></table></div> <div id="'+next+'"></div>';
						document.getElementById(i).innerHTML= value;
						document.getElementById('extra').value=i;
						}
					 }  
	
      </script>
      <script>
function show_subject(subject)
		{
			//alert(subject);
			var data1="show_subject=1&subject="+subject;
				 $.ajax({
            url: "show_topic_multiple.php", type: "post", data: data1, cache: false,
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

	
	<script type="text/javascript">
        jQuery(document).ready( function() {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>


    <style type="text/css">
        .multiselect {
            width: 460px;
            height: 200px;
        }
    </style>
     <link type="text/css" href="js/multiselect/css/ui.multiselect.css" rel="stylesheet" />
     <link type="text/css" href="js/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" />
    <script type="text/javascript" src="js/multiselect/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
    <script type="text/javascript" src="js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="js/multiselect/js/ui.multiselect.js"></script>
    <script type="text/javascript">
        $(function(){
                $.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
                $(".multiselect").multiselect();
        });
    </script>
  
    <script>
function alls()
{
total_selected = document.jqueryForm.sel2.length;
//cities_selected
last_counter = total_selected-1;
appended = '';
for(x=0;x<total_selected;x++)
{
//alert(document.jqueryForm.sel2.options[x].value);
appended += document.jqueryForm.sel2.options[x].value
if(x !=last_counter)
{
	appended += ",";
}
document.getElementById('cities_selected').value= appended;
}
//alert(document.getElementById('cities_selected').value);
return true;
}


var NS4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) < 5);

function addOption(theSel, theText, theValue)
{
  var newOpt = new Option(theText, theValue);
  var selLength = theSel.length;
  theSel.options[selLength] = newOpt;
}

function deleteOption(theSel, theIndex)
{ 
  var selLength = theSel.length;
  if(selLength>0)
  {
    theSel.options[theIndex] = null;
  }
}

function moveOptions(theSelFrom, theSelTo, operations)
{
  
  var selLength = theSelFrom.length;
  var selectedText = new Array();
  var selectedValues = new Array();
  var selectedCount = 0;
  
  var i;
  
  // Find the selected Options in reverse order
  // and delete them from the 'from' Select.
  z='no';
  for(i=selLength-1; i>=0; i--)
  {
    if(theSelFrom.options[i].selected)
    {
		if(confirm("do you really wanto to "+operations+" " +theSelFrom.options[i].text +" city?"))
		 { selectedText[selectedCount] = theSelFrom.options[i].text;
		  selectedValues[selectedCount] = theSelFrom.options[i].value;
		  deleteOption(theSelFrom, i);
		  z='yes';
		 }
      selectedCount++;
    }
  }
  
  // Add the selected text/values in reverse order.
  // This will add the Options to the 'to' Select
  // in the same order as they were in the 'from' Select.
  if(z=='yes')
  {
  for(i=selectedCount-1; i>=0; i--)
  {
    addOption(theSelTo, selectedText[i], selectedValues[i]);
  }
  }
  if(NS4) history.go(0);
}

</script>
<script>
function myfunction()
	    {
		x = document.getElementById('member_contact');
		//alert(x);
		x.value=''; 
		}
function selectalls() 
	{
		if($("#selectall").attr("checked")==true){
		$('.case').each(function() {
		$(this).attr('checked','checked');
		showUser();
		});
		}else{
		$('.case').each(function() {
		$(this).attr('checked','');
		showUser();
		});
		}
	}
						
function showUser()
{
	total_mbr =  document.getElementById("total_subject").value;
	contact ='';
	
	for(i=1; i<=total_mbr;i++)
	{
		id="requirment_id"+i;
		if(document.getElementById(id).checked)
			{
				contact +=document.getElementById(id).value;
				contact +=',';
			}
	}
	
 	var data1="subject_ids="+contact;	
	
        $.ajax({
            url: "get_subject.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				 
				  document.getElementById('topic_list').innerHTML=html;
				  $(".multiselect").multiselect();
            }
            });
}</script>

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
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
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
                        $course_name=$_POST['course_name'];
                        $course_description = $_POST['course_description'];
                        $course_duration=$_POST['course_duration'];
                        $course_level=$_POST['course_level'];
                        $course_video=$_POST['course_video'];
                        $course_pdf=$_POST['course_pdf'];                        
                        $staff_idsss=@implode(",",$_POST['staff_id']);                        
                        $course_duration=$_POST['course_duration'];
						//$course_id = $_POST['course_id'];
                        $category_id = $_POST['category_id'];
                        $free_course = $_POST['free_course'];
                        $course_price = $_POST['course_price'];
                        $subject=@implode(",",$_POST['requirment_id']); 
						$total_subject=@implode(",",$_POST['total_subject']);
						
                        $discountss=$_POST['discount'];                        
                        $start_date=$_POST['start_date'];
                        $end_date=$_POST['end_date'];
                          
                        $topics = $_POST['topics'];
						  
                        $status=$_POST['status'];
                        
                        if($course_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course name";
                        }
                        if($course_duration =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter course duration";
                        }   
                       
                        $uploaded_url="";
                            if(count($errors)==0 && $_FILES['course_video']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update courses set course_video='' where course_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                    if($row_record['course_video'] && file_exists("../UploadedData/".$row_record['course_video']))
                                        unlink("../UploadedData/".$row_record['course_video']);
                                }
                                $path = "../UploadedData/";
                                $valid_formats = array("wmv", "flv","mp4","mov","3gp","3ga","avi","mpg","3gpp","gsm","mpeg","m4v","cmp","mpe","movie","swf");
                                $name = $_FILES['course_video']['name'];
                                $size = $_FILES['course_video']['size'];
                                
                                    list($txt, $ext) = explode(".", $name);
                                    if($name) 
                                        {
                                        $lowercase = strtolower($ext);
                                            if(in_array($lowercase,$valid_formats))
                                                { 
                                                    $uploaded_url = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                                                    $tmp = $_FILES['course_video']['tmp_name'];                                    
                                                    $newfile = "../UploadedData/";

                                                    $explodeName = explode(".",$uploaded_url);

                                                    $thumbfile = $explodeName[0] . ".jpg";
                                                    $thumbfileswf = $explodeName[0] . ".flv";
                                                    $thumbfileMp4 = $explodeName[0] . ".mp4";

                                                     //ffmpeg -i sample.3gp -ar 44100  sample3gp.swf 
                                                    // ffmpeg -i Nikon_Coolpix_S3000.AVI -r 24 nikon.mp4

                                                    $options = "-an -y -f mjpeg -ss 2 -s 180x150 -vframes 1 ";
                                                    $optionsSWF = "-ar 44100";
                                                    $optionsMP4 = "-r 24";

                                                    $thumbpath = "../UploadedData/".$thumbfile;  
                                                    $thumbpathSWf = "../UploadedData/".$thumbfileswf; 
                                                    $thumbpathMpp = "../UploadedData/".$thumbfileMp4; 

                                                    $target_path1 = $newfile.$uploaded_url;
                                                    if(move_uploaded_file($tmp, $path.$uploaded_url))
                                                        {
                                                            $thump_target_path="../UploadedData/".$uploaded_url;                                            
                                                            $file_uploaded = 1;
                                                            exec("ffmpeg -i " . $thump_target_path . " " . $options . " " . $thumbpath, $output);                                            
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsSWF." ".$thumbpathSWf, $outputs);
                                                            exec("ffmpeg -i ".$thump_target_path." ".$optionsMP4." ".$thumbpathMpp, $outputss);
                                                            //print_r($output); 
                                                        }
                                                    else
                                                    {
                                                        $file_uploaded=0;
                                                        $success=0;
                                                        $errors[$i++]="There are some errors while uploading video, please try again";                                                        
                                                    }
                                                }
                                            else
                                                {
                                                    $file_uploaded=0;
                                                    $success=0;
                                                    $errors[$i++]="Invalid file format..";
                                                    
                                                }
                                        }
                            }
                            
                            $uploaded_url1="";
                            if(count($errors)==0 && $_FILES['course_pdf']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update courses set course_pdf='' where course_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                    if($row_record['course_pdf'] && file_exists("../UploadedData/".$row_record['course_pdf']))
                                        unlink("../UploadedData/".$row_record['course_pdf']);
                                }
                                $uploaded_url1=time().basename($_FILES['course_pdf']["name"]);
                                $newfile1 = "../UploadedData/";

                                $filename = $_FILES['course_pdf']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['course_pdf']['type'];// type of file being uploaded
                                //echo $filetype;exit;
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['course_pdf']['tmp_name'];
                                $target_path1 = $newfile1.$uploaded_url1;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "application/pdf")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../UploadedData/".$uploaded_url1;
                                        copy($target_path1,$thump_target_path);
                                        $file_uploaded1=1;
                                    }
                                    else
                                    {
                                        $file_uploaded1=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading pdf, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded1=0;
                                    $success=0;
                                    $errors[$i++]="Location pdf: Only pdf files allowed";
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
                           
                            // echo $_POST['course_url'];
                            if($_POST['course_url'] != '')
                            {
                               if(strpos($_POST['course_url'],"<iframe")!==false)
                               {
                                  // echo '1'.'<br />';
                                   $ex=explode("/", $_POST['course_url']);
                                   $ex1=explode('"', $ex[4]);
                                   $data_record['course_url']= $ex1[0];   //$data_record1['course_url'] =   nl2br($_POST['course_url']);
                               }
                               else if(strpos($_POST['course_url'],"http://")!==false || strpos($_POST['course_url'],"https://")!==false)
                               {
                                   $ex=explode("/", $_POST['course_url']);                              
                                   if($ex[2]=='youtu.be')
                                   {
                                       //echo 'sub 1'.'<br />';
                                        $data_record['course_url']= $ex[3];                                    
                                   }
                                   else
                                   {                                   
                                        //echo 'sub 2<br />';
                                        $ex1=explode('=', $ex[3]);
                                        $data_record['course_url']=$ex1[1];
                                   }
                               }
                            }
                            $data_record['admin_id'] = $_SESSION['admin_id'];
                            $data_record['course_url_img']=$thumbfile;
                            $data_record['course_name'] =$course_name;
							$data_record['course_description'] = $course_description;
                            $data_record['course_duration'] = $course_duration;
                            $data_record['category_id'] =$category_id;
                            $data_record['free_course'] = $free_course;
                            $data_record['course_price'] = $course_price;
							$data_record['added_date'] = date('Y-m-d H:i:s');
							
							$data_record['subject_id']=$subject;
							
							/*$data_record_batch['batch_name']=$_POST['batch_name'];
							$data_record_batch['batch_time']=$_POST['batch_time'];
							$data_record_batch['course_id']=$courses_id;*/
							/*$data_record_topic['course_id']=$courses_id;
							$data_record_topic['subject_id']=$course_id;
							$data_record_topic['topic_id']=$concat;
							$data_record_topic['duration'] =$course_duration;
							$data_record_topic['description'] =$course_description;
							//==========================TOPIC ID==============================
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
							
							
							//==========================END TOPIC ID===============================*/
                            if($file_uploaded)
                                $data_record['course_video'] =$uploaded_url;
                            if($file_uploaded1)
                                $data_record['course_pdf'] =$uploaded_url1;
                        
                            $data_record['staff_id'] =$staff_idsss;
						   
                            if($record_id)
                            {
                                $where_record=" course_id='".$record_id."'";   
								                             
                                $db->query_update("courses", $data_record,$where_record);  
								$del_old_rec  = " delete from topic_map where $where_record  ";
								$ptr_deleted = mysql_query($del_old_rec);
								for($i=0;$i<count($topics);$i++)
									{
										
										
										$selet_query_for_subject_id = " select subject_id from topic where topic_id ='".$topics[$i]."' ";
										$ptr_subj = mysql_query($selet_query_for_subject_id);
										$data_sub = mysql_fetch_array($ptr_subj);
										
									
										 $insert_into_topic_map=  " insert into topic_map (	topic_id, course_id, admin_id, added_date, subject_id) values('".$topics[$i]."','".$record_id."',	'".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."','".$data_sub['subject_id']."')";
										$insertt_top_map = mysql_query($insert_into_topic_map);
										
										$select_topic_id="select * from topic where topic_id='".$topics[$i]."'";
										$ptr_query=mysql_query($select_topic_id);	
										$data_topic=mysql_fetch_array($ptr_query);
										
									}
								
								                         
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
									$where_admin_id="admin_id='".$_SESSION['admin_id']."'";
                                	$courses_id=$db->query_insert("courses", $data_record);  
									
									for($i=0;$i<count($topics);$i++)
									{
										
										
										$selet_query_for_subject_id = " select subject_id from topic where topic_id ='".$topics[$i]."' ";
										$ptr_subj = mysql_query($selet_query_for_subject_id);
										$data_sub = mysql_fetch_array($ptr_subj);
										
									
										 $insert_into_topic_map=  " insert into topic_map (	topic_id, course_id, admin_id, added_date, subject_id) values('".$topics[$i]."','".$courses_id."',	'".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."','".$data_sub['subject_id']."')";
										$insertt_top_map = mysql_query($insert_into_topic_map);
										
										$select_topic_id="select * from topic where topic_id='".$topics[$i]."'";
										$ptr_query=mysql_query($select_topic_id);	
										$data_topic=mysql_fetch_array($ptr_query);
										
									}
									
									/*$data_record_topic['course_id']=$courses_id;
									$data_record_topic['subject_id']=$course_id;
									$data_record_topic['topic_id']=$concat;
									$data_record_topic['duration'] =$course_duration;
									$data_record_topic['description'] =$course_description;
									$courses_id=$db->query_insert("topic_map", $data_record_topic);	*/	
								    
									/*$data_record_batch['batch_name']=$_POST['batch_name'];
									$data_record_batch['batch_time']=$_POST['batch_time'];
									$data_record_batch['course_id']=$courses_id;
							        $courses_idsss=$db->query_insert("course_batches", $data_record_batch);*/  
								
								/*$no_of_extra=$_POST['no_of_extra'];
								for($i=0;$i<=$no_of_extra;$i++)
								{
									if($_POST['batch_name'.$i] !='')
									{
									$data_record_batch_extra['batch_name']=$_POST['batch_name'.$i];
									$data_record_batch_extra['batch_time']=$_POST['batch_time'.$i];
									$data_record_batch_extra['course_id']=$courses_id;
									
							    $courses_idsss=$db->query_insert("course_batches", $data_record_batch_extra);  
									}
								}*/
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                            
                            $discount['discount']=$discountss;
                            $discount['start_date']=$start_date;
                            $discount['end_date']=$end_date;
                            $discount['status']=$status;
//                            $discount['for_edit']=$_POST['discount_course'];
                            
                            if($courses_id)
                                $discount['course_id']=$courses_id;
                            else 
                                $discount['course_id']=$record_id;
                            if($val_coupon['discount_coupon_id'] && $_POST['discount_course'] == 'Y')
                            {
                                $where=" discount_coupon_id='".$val_coupon['discount_coupon_id']."'";
                                $db->query_update("discount_coupon", $discount,$where);                                
                            }
                            else if($_POST['discount_course']== 'Y')
                            {
								$where_admin_id="admin_id='". $_SESSION['admin_id']."'";
                                $discount['added_date']=date("Y-m-d H:i:s");
                               $discount_id=$db->query_insert("discount_coupon", $discount);
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
                <td width="22%">Course Category<span class="orange_font">*</span></td>
                <td width="38%" >
                    <select name="category_id" id="category_id" class="validate[required] input_select" >  
                        <option value=""> Select Category</option>
                        <?php
                            $select_category = "select * from course_category order by category_id asc";
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
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Course Name<span class="orange_font">*</span></td><? //echo $row_record['course_name'];?>
                <td width="38%">
                    <input type="text" class="validate[required] input_text" name="course_name" id="course_name" value="<?php if($_POST['save_changes']) echo $_POST['course_name']; else echo $row_record['course_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>   
             <tr>
            <td width="20%">Select Subject<span class="orange_font">*</span></td>
            <td width="40%" >
            
            <?php
            
            $sel_tel = "select * from subject  order by subject_id asc";	 
			$query_tel = mysql_query($sel_tel);
			$i=1;
			$total_no = mysql_num_rows($query_tel);
			$member_result='';
			echo '<table width="100%">';
			echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';
			echo  '<tr>';
			
			///-======= Existing course code===
			 if($record_id)
			   { 
			   $select_existing = " select subject_id,topic_id from topic_map where course_id='$record_id' ";
			   $ptr_esxit = mysql_query($select_existing);
			   $subject_array = array();
			   $topic_array = array();
			   $j=0;
			   while( $data_exist = mysql_fetch_array($ptr_esxit))
			   {
				    $subject_array[$j]=$data_exist['subject_id'];
					$topic_array[$j]=$data_exist['topic_id'];
					
					$j++;
				}
				}
			///=== Emd pf existing course code==
			
			
			while($row_member = mysql_fetch_array($query_tel))
			   {
			   echo  '<td style="border:1px solid #999;">'; 
			  $checked= '';
			   if($record_id)
			   {
				   if(in_array($row_member['subject_id'], $subject_array))
				   {
					    $checked=" checked='checked'";
					}
			   }
			   
			   echo  "<input type='checkbox' name='requirment_id[]'  value='".$row_member['subject_id']."' id='requirment_id$i'  onClick='showUser()' class='case' $checked /> ".$row_member['name']." ";
			   echo  '</td>';
			   if($i%4==0)
			   echo  '<tr></tr>';  
			   $i++;
				}
				echo' <input type="hidden" name="total_subject" value="'.($i-1).'" id="total_subject" />';
				echo '</table>';
            
            ?>
                   <!-- <select name="course_id" id="course_id" class="validate[required] input_select" onchange="show_subject(this.value); show_fees(this.value); show_batch(this.value)" >  
                        <option value=""> Select Subject </option>
                        <?php
                            /*$select_category = "select * from subject ".$_SESSION['where_admin_id_2']." order by subject_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['course_id'] == $row_record['course_id'])
                                    echo '<option value='.$data_category['subject_id'].' selected="selected">'.$data_category['name'].'</option>';
                                else
                                    echo '<option value='.$data_category['subject_id'].'>'.$data_category['name'].'</option>';
                            }*/
                            ?>        
                    </select>-->
                    
                    </td> 
<!--                <td width="40%" align="left"> <div id=total_fees></div></td>
-->            </tr> 
            <!-- <tr>
                <td width="20%"> Select Topic </td>
                <td width="40%" ><div id="show_subject"></div>   
                <input type="hidden"  name="total_checked_question" id="total_checked_question"  value="" /> </td> 
                <td width="40%"></td>
            </tr>-->
            
            
             <!--<tr><td>Selected Topics </td>
                <td>-->
                <?php 
				/*if($record_id)
				{
					$sel_topic= "select topic_id from topic_map where course_id=".$record_id." order by topic_id asc";	
					$query_topic = mysql_query($sel_topic);
					$row_member_topic = mysql_fetch_array($query_topic);
					
					$sel_top = "select topic_id,topic_name from topic where topic_id='".$row_member_topic['topic_id']."' order by topic_id asc";	 
					$query_top = mysql_query($sel_top);
					$i=1;
					$total_no = mysql_num_rows($query_top);
					$member_result='';
					echo '<table width="100%">';
					while($row_member = mysql_fetch_array($query_top))
					   {
					   echo  '<td style="border:1px solid #999;">'; 
					  $checked= '';
					   if($record_id)
					   {
						   if(in_array($row_member['topic_id'], $topic_array))
						   {
								$checked=" checked='checked'";
							}
					   }
					   
					   echo  "<input type='checkbox' name='topic_id[]'  value='".$row_member['topic_id']."' id='topic_id$i'  onClick='showUser()' class='case' $checked /> ".$row_member['topic_name']." ";
					   echo  '</td>';
					   if($i%4==0)
					   echo  '<tr></tr>';  
					   $i++;
						}
						
						echo '</table>';
				
				}
				*/
				?>
               
                <tr>
                	<td> Select Topic</td>
                    <td>
                  		<div id="topic_list" >Select Subject first....!
							</div>
                   <!-- <select name="topics[]">
                    <optgroup label='webdesigning'>
                    <option value='1'>html1</option><option value='2'>html2</option>
                    <option value='3'>html1</option>
                    <option value='4'>html2</option>
                    </optgroup>   
                     </select>-->	
					</td>
           	 	</tr>
                   
                
                 <?php
				  if($record_id)
			   	{
					?>
                   <script language="javascript">
				   
				 		showUser();
				 </script>
                 <?php
			   	}
				 ?>
            <tr>
                <td width="22%">Course Duration<span class="orange_font">*</span></td>
                <td width="38%"><input type="text" class="validate[required] input_text" name="course_duration" id="member_contact" value="<?php if($_POST['save_changes']) echo $_POST['course_duration']; else echo $row_record['course_duration'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <?php
                $sql_sub_cat = "select * from courses where course_id='".$row_record['course_id']."' ";
                $data_sub_cat = $db->fetch_array($db->query($sql_sub_cat));
                $implode_data = explode(",",$data_sub_cat['course_author']);            
             ?>
           <!-- <tr>
                <td width="22%">Course Teacher</td>
                <td width="38%" >
                    <select  multiple="multiple" name="staff_id[]" id="user_id" class="input_select" style="width:150px;">                        
                        <?php 
                           /* $select_faculty = "select * from staff_regi  order by staff_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
								$class = '';
								for($t=0;$t<count($implode_data);$t++)
								{  
								if($data_faculty['staff_id'] == $implode_data[$t])
								$class = 'selected="selected"';
								}
							if($class !='')                                    
							echo '<option value="'.$data_faculty['staff_id'].'" '.$class.' >'.$data_faculty['staff_name'].' </option>';     
							else
							echo '<option value="'.$data_faculty['staff_id'].'" >'.$data_faculty['staff_name'].' </option>';  
                            }*/
                            ?>        
                    </select>
                    </td> 
            <td width="40%"></td>
            </tr>-->
            <tr>
            <td width="22%" valign="top">Course Description <!--span class="orange_font">*</span --></td>
            <td colspan="2">
                    <?php
                            include("../FCKeditor/fckeditor.php");
                            $BasePath = "../FCKeditor/";
                            $oFCKeditor 		= new FCKeditor('course_description') ;
                            $oFCKeditor->BasePath	= $BasePath ;
                            if($_POST['save_changes'])
                                $oFCKeditor->Value	= stripslashes($_POST['course_description']);
                            else
                                $oFCKeditor->Value	= stripslashes($row_record['course_description']);
                            //$oFCKeditor->ToolbarSet	= "MyToolBar";
                            $oFCKeditor->Height		= "230";
                            $oFCKeditor->Create() ;
                     ?>
                </td> 
<!--                <td width="40%"></td>-->
            </tr>
            <!--<tr>
                <td width="22%">Is it free course</td>
                <td width="38%">
                    <input type="radio" name="free_course" onchange="showdiv(this.value);" id="free_course" value="Y" <?php if($_POST['free_course'] == 'Y' || $row_record['free_course'] == 'Y') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="free_course" id="free_course" onchange="showdiv(this.value);" value="N" <?php if($_POST['free_course'] == 'N' || $row_record['free_course'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>-->
            
            <tr>
                <td width="22%"><div id="coursess" class="coursess" >Course Fees</div></td>
                
                <td width="38%"><div id="coursess" class="coursess" >
                    <input type="text" class="input_text" name="course_price" id="course_price" value="<?php if($_POST['save_changes']) echo $_POST['course_price']; else echo $row_record['course_price'];?>" />
                </div>
                </td>                
                <td width="40%"></td>
            </tr>
            
            <tr>
                <td width="22%">Discount course</td>
                <td width="38%">
                    <input type="radio" name="discount_course" id="discount_course" onChange="show_dicount(this.value);" value="Y" <?php if($_POST['discount'] == 'Y') echo 'checked="checked"';?>/>Yes  &nbsp; &nbsp; 
                    <input type="radio" name="discount_course" id="discount_course" onChange="show_dicount(this.value);" value="N" <?php if($_POST['discount'] == 'N') echo 'checked="checked"';else echo 'checked="checked"';?> />No </td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <div id="discount" class="discount" style="display:none" >
                        <table border="0" cellspacing="15" cellpadding="0"  width="40%" >
                            <tr>
                                <td >Discount</td>
                                <td >
                                    <input type="text" class="input_text" name="discount" id="discount" value="<?php if($_POST['save_changes']) echo $_POST['discount']; else echo $val_coupon['discount'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="start_date" id="start_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['start_date']; else echo $val_coupon['start_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>
                                    <input type="text" class="validate[required] input_text datepicker" name="end_date" id="end_date" readonly="true" value="<?php if($_POST['save_changes']) echo $_POST['end_date']; else echo $val_coupon['end_date'];?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>                                    
                                    <input type="radio" name="status" id="status"  value="Active" <?php if($_POST['status'] == 'Active' || $val_coupon['status'] == 'Active') echo 'checked="checked"';?>/>Active  &nbsp; &nbsp; 
                                    <input type="radio" name="status" id="status"  value="Inactive" <?php if($_POST['status'] == 'Inactive' || $val_coupon['status'] == 'Inactive') echo 'checked="checked"';?>/>Inactive 
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>                
            </tr>
            <!--<tr>
                <td width="22%"> Add Batch </td>.
                <td width="40%">
                <table width="453">
                <tr><td width="115">Batch Name </td><td width="109">Batch Time </td><td width="154" > 
                 <input type="button" name="Add"   class="addBtn" onClick="javascript:add_degree(1);" alt="Add(+)" >
                 <input type="button" name="Add"  class="delBtn"  onClick="javascript:del_degree(1);" alt="Delete(-)" >
                </td>
                </tr>
                <tr>
                <td> <input type="text" name="batch_name"  class="input_text" /></td><td><input type="text" name="batch_time"  class="input_text" /></td><td></td>
                </tr>
                </table>
                <input type="hidden" name="no_of_extra" id="extra"  value="0" />
                <div id='1'></div>
                </td>
                <td width="10%"></td>
                
                
            </tr>-->
            <tr>
                <td width="22%">Course PDF</td>
                <td width="38%"><input type="file" class="input_text" name="course_pdf" id="course_pdf" value=""/></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td width="22%">Course video</td>
                <td width="38%"><input type="file" class="input_text" name="course_video" id="course_video" value=""/></td> 
                <td width="40%"></td>
            </tr>
<!--            <tr><td></td><td colspan="2" class="orange_font"><strong>OR</strong></td></tr>            
            <tr>
                <td width="20%">Youtube Video Url</td>
                <td width="40%"><input type="text" class="input_text" name="course_url" id="course_url" value="<?php if($_POST['save_changes']) echo $_POST['course_url']; else echo $row_record['course_url'];?>" /></td> 
                <td width="40%"></td>
            </tr>-->
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Course" name="save_changes"  /></td>
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