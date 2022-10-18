<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$sel_log="select * from course_notes where notes_id='".$record_id."'";
$ptr_log=mysql_query($sel_log);
$row_record=mysql_fetch_array($ptr_log);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Notes</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var pageName='add_timetable';
        jQuery(document).ready( function() 
        {
			//$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            /*$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }*/
            // binds form submission and fields to the validation engine
			$("#course_id").chosen({allow_single_deselect:true});
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });

function delete_records(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#day'+id).replaceWith(function(){
			return $('<input type="text"  name="day'+id+'" id="day'+id+'"  style="width:40px" />', {html: $(this).html()});
		});
		$('#topic'+id).replaceWith(function(){
			return $('<input type="text" name="topic'+id+'" id="topic'+id+'" value="" style="width:200px" />', {html: $(this).html()});
		});
		$('#topic_content'+id).replaceWith(function(){
			return $('<input type="text" name="topic_content'+id+'" id="topic_content'+id+'" value="" />', {html: $(this).html()});
		});
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			showUser();
		}
	}
}        
</script>
<!--<script language="javascript" src="js/script.js"></script>-->
<script language="javascript" src="js/conditions-script.js"></script>
<style>
.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
.inactive{ background-color:#FFF;cursor:pointer; color:#000}
.active{ background-color:#699;cursor:pointer; color:#FFF}
.hidden{ display:none; width:0px; height:0px;}	
.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
.pointer{ cursor:pointer;}
</style>
<script>
/*function select_course(course_id)
{
	var data1="action=gettopic&course_id="+course_id;
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			//res=html;
			document.getElementById("create_floor").innerHTML='';
			document.getElementById("res1").value=html;
		}
	});
}*/
function select_subject(domain_id)
{
	var data1="action=getdomain&domain_id="+domain_id;
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			document.getElementById("create_floor").innerHTML='';
			document.getElementById("res1").value=html;
			
		}
	});
}
function select_topics(idss,subject_id)
{
	var data1="action=gettopic&subject_id="+subject_id+"&ids="+idss;
	//alert(data1);
	$.ajax({
		url: "get_topic_list.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			var topicids="topic_val"+idss;
			document.getElementById(topicids).innerHTML=html;
			//document.getElementById("res2").value=html;
			$("#topic"+idss+"").chosen({allow_single_deselect:true});
		}
	});
}
</script>
</head>
<body>
<?php include "include/header.php";?>

<div id="info"> 

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
		<?php 
        if($_REQUEST['deleteRecord'])
        {
            $del_record_id=$_REQUEST['deleteRecord'];
            $sql_query= "SELECT notes_id FROM course_notes where notes_id='".$del_record_id."'";
            if(mysql_num_rows($db->query($sql_query)))
            {                           
                $delete_query="delete from course_notes where notes_id='".$del_record_id."'";
                $db->query($delete_query);
                
                ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record Deleted Successfully</p></center></div>
                <script type="text/javascript">
                $(document).ready(function() {
                    $( "#statusChangesDiv" ).dialog({
                        modal: true,
                        buttons: {
                            Ok: function() { $( this ).dialog( "close" );}
                        }
                    });
                });
                setTimeout('document.location.href="add_notes_in_course.php";',500);
                </script>
                <?php
            }
        }
        ?>
               
        <form method="post" name="frmTakeAction" enctype="multipart/form-data">
        <?php
        $sql_records= "SELECT * FROM course_notes where 1";
        $no_of_records=mysql_num_rows($db->query($sql_records));
        if($no_of_records)
        {
            $bgColorCounter=1;
            if(!$_SESSION['showRecords'])
                $_SESSION['showRecords']=10;

            $query_string.="&show_records=".$showRecord;
            $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
            $all_records= $pager->paginate();?>
            
            <table cellpadding="0" cellspacing="0" width="100%" border="0">
            <tr><td valign="top" colspan="2">
                <table width="98%" align="center" cellpadding="0" cellspacing="1" class="table" style="width: 100%;">
                    <tr align="center" class="grey_td" >
                    	<td width="7%" class="tr-header"><strong>Sr.</strong></td>
                        <td width="40%" class="tr-header"><strong>Course name</strong></td>
                        <td width="20%" class="tr-header"><strong>File name</strong></td>
                        <td width="20%" class="tr-header"><strong>Date</strong></td>
                        <td width="20%" class="tr-header">Action</td>
					</tr>
					<?php
					while($val_record=mysql_fetch_array($all_records))
					{
						if($bgColorCounter%2==0)
							$bgcolor='class="grey_td"';
						else
							$bgcolor=""; 
						 //$payment_mode_id=$val_record['module_type_id'];
						$paid_totas=0;
						$listed_record_id=$val_record['notes_id'];
						include "include/paging_script.php";
						echo '<tr class="'.$bgclass.'">';
						echo '<td align="center">'.$sr_no.'</td>'; 
																
						$sel_course="select course_name from courses where course_id='".$val_record['course_id']."'";
						$ptr_course=mysql_query($sel_course);
						$data_course=mysql_fetch_array($ptr_course);
						
						echo '<td align="center"><a href="add_notes_in_course.php?record_id='.$listed_record_id.'" target="_blank" >'.$data_course['course_name'].'</a></td>';
						
						echo '<td align="center">'.$val_record['notes_file'].'</td>';
						
						echo '<td align="center">'.$val_record['added_date'].'</td>';
						
						echo '<td align="center">';										
						echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;<a href="add_notes_in_course.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
						echo '</td>';
						echo '</tr>';
					   $bgColorCounter++;
					}
					?>
					</table>
					</td></tr>
					<tr><td height="10"></td></tr>
					<tr>
						<td valign="middle" align="right">
							<table width="100%" cellpadding="0" callspacing="0" border="0">
								<tr>
									<?php
									if($no_of_records>10)
									{
										echo '<td width="3%" align="left">Show</td>
										<td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';
										for($s=0;$s<count($show_records);$s++)
										{
											if($_SESSION['show_records']==$show_records[$s])
												echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
											else
												echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
										}
										echo'</td></select>';
									}
									?>
									<td align="right"><?php echo $pager->renderFullNav();?></td>
								</tr>
							</table>
						</td></tr>
					</table>
				<?php
			}
			else if($_GET['search'])
				echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
			else
				echo'<center><br><div id="alert" style="width:30%">No Records here</div><br></center>';
    $errors=array(); $i=0;			
    $success=0;
    
    if($_POST['save_changes'])
    {
        $course_id=$_POST['course_id'];
        $admin_id=$_SESSION['admin_id'];
        $cm_id=$_SESSION['cm_id'];
        if(count($errors))
        {
            ?>
            <tr><td colspan="2"> <br></br>
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
            $data_record['course_id'] = $course_id;
            $data_record['cm_id'] =$cm_id;
            $data_record['admin_id'] = $admin_id;
            $data_record['added_date'] = date('Y-m-d H:i:s');
            
            //=================== NOTES FILE ==============================
            $uploaded_url1="";
            if(count($errors)==0 && $_FILES['notes_file']["name"])
            {
                if($record_id)
                {
                    $update_news="update course_notes set notes_file='' where notes_id='".$record_id."'";
                    $db->query($update_news);
                    if($row_record['notes_file'] && file_exists("excel_files/".$row_record['notes_file']))
                        unlink("excel_files/".$row_record['notes_file']);
                    if($row_record['notes_file'] && file_exists("iexcel_files/".$row_record['notes_file']))
                        unlink("excel_files/".$row_record['notes_file']);
                }
                $uploaded_url1=time().basename($_FILES['notes_file']["name"]);
                $newfile = "excel_files/";
                $filename = $_FILES['notes_file']['tmp_name']; // File being uploaded.
                $filetype = $_FILES['notes_file']['type'];// type of file being uploaded
                $filesize = filesize($filename); // File size of the file being uploaded.
                $source1 = $_FILES['notes_file']['tmp_name'];
                $target_path1 = $newfile.$uploaded_url1;
                
                if(move_uploaded_file($source1, $target_path1))
                {
                    $thump_target_path="excel_files/".$uploaded_url1;
                    copy($target_path1,$thump_target_path);
                    list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                    $file_uploaded1=1;
                }
                else
                {
                    $file_uploaded1=0;
                    $success=0;
                    $errors[$i++]="There are some errors while uploading image, please try again";
                }
            }
            
            $data_record['notes_file']=$uploaded_url1;
            if($record_id)
            {
                $where_record="notes_id='".$record_id."'";
                $db->query_update("course_notes", $data_record,$where_record);
                
                echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense type added successfully</p></center></div>
                <script type="text/javascript">
                $(document).ready(function() {
                    $( "#statusChangesDiv" ).dialog({
                        modal: true,
                        buttons: {
                            Ok: function() { $( this ).dialog( "close" );}
                        }
                    });																
                });
                setTimeout('document.location.href="add_notes_in_course.php";',800);
                </script>
                <?php
            }
            else
            {
                $record_ids=$db->query_insert("course_notes",$data_record);
                $sub_id=mysql_insert_id();  
                
                echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                ?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense type added successfully</p></center></div>
                <script type="text/javascript">
                $(document).ready(function() {
                    $( "#statusChangesDiv" ).dialog({
                        modal: true,
                        buttons: {
                            Ok: function() { $( this ).dialog( "close" );}
                        }
                    });															
                });
                setTimeout('document.location.href="add_notes_in_course.php";',800);
                </script>
                <?php
            }
        }
    }
    if($success==0)
    {
    ?>
    <table width="98%" align="center" cellpadding="3" cellspacing="3" style="width:90%;border:1px solid #CCC">
    <tr>
        <td width="20%">Select Course<span class="orange_font">*</span></td>
        <td width="40%" class="customized_select_box">
            <select name="course_id" id="course_id" class="validate[required] input_select" style="width:400px">  
            <option value="">Select Course Name</option>
            <?php
            $select_course_name="select * from courses where status='Active' order by course_id asc";
            $ptr_course=mysql_query($select_course_name);
            while($data_course=mysql_fetch_array($ptr_course))
            {
                $sel='';
                if($data_course['course_id']==$row_record['course_id'])
                {
                    $sel='selected="selected"';
                }
                echo '<option value='.$data_course['course_id'].' '.$sel.'>'.$data_course['course_name'].'</option>';
            }
            ?>        
            </select>
        </td>
    </tr>
    <tr>
        <td width="20%">Upload File (Only Pdf)<span class="orange_font">*</span></td>
        <td width="40%" class="customized_select_box"><?php
if($record_id && $row_record['notes_file'] && file_exists("excel_files/".$row_record['notes_file']))
    echo '<strong>'.$row_record['notes_file'].'</strong><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&img_id=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
else
    echo '<input type="file" name="notes_file" id="notes_file" class="input_text"></td>';?></td>
    </tr>
    
    <tr>
        <td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();"  value="Save"  /></td>
    </tr>
    </table>
    <?php 
}?>
</form>
</td>
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<?php
if($record_id!='')
{
	?>
    <script>
	domain_id =document.getElementById("domain_id").value;
	//alert(vendor_id);
	setTimeout(select_subject(domain_id),500);
    //create_floor('add');
	//branch_name1 =document.getElementById("branch_name").value;
	//alert(branch_name1)
	//show_bank(branch_name1);
	</script>
    <?php
}
?>
<script language="javascript">
//create_floor('add');
</script>
<script language="javascript">
//create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>