<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$grade_rec='';

$sel_grade="select * from action_certificate_grade where enroll_id='".$record_id."' and is_print='y'";
$ptr_sel=mysql_query($sel_grade);
if(mysql_num_rows($ptr_sel))
{
	while($data_grade_rec=mysql_fetch_array($ptr_sel))
	{
		
		if($data_grade_rec['grade']!='')
		{
			$grade_rec=$data_grade_rec['grade'];
		}
			
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
.hr_line { border: 0; border-bottom: 1px dashed #ccc; background: #999; }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Certificate Diploma Level</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--<script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<!-- Multiselect -->
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
<script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
<script type="text/javascript" src="multifilter/assets/prettify.js"></script>

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
<style>
.container {
    position: relative;
    text-align: center;
    color: white;
}

.bottom-left {
    position: absolute;
    bottom: 8px;
    left: 16px;
}

.reg_no {
    position: absolute;
    top: 91.5%;
    left: 46%;
}
/*.cer_no {
    position: absolute;
    top: 208px;
    left: 40px;
}*/
.award_on {
    position: absolute;
    top: 94.5%;
    left: 46%;
}

.top-right {
    position: absolute;
    top: 8px;
    right: 16px;
}

.bottom-right {
    position: absolute;
    bottom: 8px;
    right: 16px;
}

.course {
    position: absolute;
    top: 39.8%;
    left: 55%;
    transform: translate(-50%, -50%);
}
.centered {
    position: absolute;
    top: 46.8%;
    left: 65%;
    transform: translate(-50%, -50%);
}
.beauty {
    position: absolute;
    top: 55.6%;
    left: 70%;
    transform: translate(-50%, -50%);
}
.make_up {
    position: absolute;
    top: 63.9%;
    left: 45%;
    transform: translate(-50%, -50%);
}
.hair {
    position: absolute;
    top: 68.4%;
    left: 45%;
    transform: translate(-50%, -50%);
}
.nail {
    position: absolute;
    top: 73%;
    left: 44.8%;
    transform: translate(-50%, -50%);
}
.from_date {
    position: absolute;
    top: 72.8%;
    left: 59.5%;
    transform: translate(-50%, -50%);
}
.to_date {
    position: absolute;
    top: 72.8%;
    left: 72%;
    transform: translate(-50%, -50%);
}
.print {
    position: absolute;
    top: 81%;
    left: 55%;
    transform: translate(-50%, -50%);
}
</style>
</head>
<body >
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$course_id=$_REQUEST['course_id'];
	
    $sql_record= "SELECT * FROM action_print_certificate where enroll_id='".$record_id."' and course_id='".$course_id."' order by id desc";
    if(mysql_num_rows($db->query($sql_record)))
	{
    $row_record=$db->fetch_array($db->query($sql_record));
	$s_name=$row_record['name'];
	}
	else  
	{
	$sel_name="select name from enrollment where enroll_id='".$record_id."'";
$ptr_sel=mysql_query($sel_name);
$data_sel=mysql_fetch_array($ptr_sel);
$s_name=$data_sel['name'];
	} 
}
else
{
	$record_id='';
	$course_id='';
}

	$select_course_name="select course_name from courses where course_id='".$course_id."'";
	$ptr_course=mysql_query($select_course_name);
	$data_course_name=mysql_fetch_array($ptr_course);
?>
<?php
if($_POST['save_changes'])
{
	$insert_into_cer= "INSERT INTO `action_print_certificate` (`enroll_id`, `course_id`, `reg_no`, `certificate_no`,`awarded_on`,`name`,`beauty_grade`,`makup_grade`,`hair_grade`,`nail_grade`,`from_date`,`to_date`, `cm_id`,`admin_id`, `added_date`) VALUES ('".$record_id."', '".$course_id."','".$_POST['reg_no']."', '".$_POST['cer_no']."', '".$_POST['award_on']."', '".$_POST['name']."', '".$_POST['beauty_grade']."','".$_POST['makeup_grade']."','".$_POST['hair_grade']."','".$_POST['nail_grade']."','".$_POST['from_date']."','".$_POST['to_date']."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."', '".date('Y-m-d')."')";
	$ptr_isert_invp = mysql_query($insert_into_cer);
	?>
	<script>
		setTimeout('document.location.href="print_certificate_level.php?record_id=<?php echo $record_id; ?>&course_id=<?php echo $course_id; ?>";',1000);
	</script>
	<?php
}
	?>
<div class="container">
	<img src="images/certificate_level.jpg" alt="Certificate Level" style="width:100%;">
	<form method="post" name="frmTakeAction">
	<div class="reg_no"><input type="text" name="reg_no" Placeholder="Reg. No:" value="<?php if($_POST['reg_no']!='') echo $_POST['reg_no']; else if($row_record['reg_no'])echo $row_record['reg_no'];else echo 'PN0153309/8665'; ?>" style="width:150px"></div>
	<!--<div class="cer_no"><input type="text" name="cer_no" Placeholder="Certificate No" value="<?php //if($_POST['cer_no']!='') echo $_POST['cer_no']; else if($row_record['certificate_no'])echo $row_record['certificate_no']; ?>" style="width:150px"></div>-->
	<div class="award_on"><input type="text" name="award_on" Placeholder="Award on" class="datepicker" value="<?php if($_POST['award_on']!='') echo $_POST['award_on']; else if($row_record['awarded_on'])echo $row_record['awarded_on']; ?>" style="width:150px"></div>
	
    <div class="course"><input type="text" name="course_name" value="<?php if($_POST['course_name']!='') echo $_POST['course_name']; else if($data_course_name['course_name'])echo $data_course_name['course_name']; ?>" style="width:500px"></div>
    <div class="centered"><input type="text" name="name" value="<?php echo $s_name; ?>" style="width:500px"></div>
	<div class="beauty"><input type="text" name="beauty_grade" Placeholder="Beauty Grade"  value="<?php if($_POST['beauty_grade']!='') echo $_POST['beauty_grade']; else if($grade_rec!='') echo $grade_rec; else if($row_record['beauty_grade'])echo $row_record['beauty_grade']; ?>" style="width:70px"></div>
	<div class="from_date"><input type="text" name="from_date" class="datepicker" Placeholder="From" value="<?php if($_POST['from_date']!='') echo $_POST['from_date']; else if($row_record['from_date'])echo $row_record['from_date']; ?>" style="width:115px"></div>
	<div class="to_date"><input type="text" name="to_date" class="datepicker" Placeholder="To" value="<?php if($_POST['to_date']!='') echo $_POST['to_date']; else if($row_record['to_date'])echo $row_record['to_date']; ?>" style="width:115px"></div>
	<div class="print"><a href="print_certificate_level.php?action=print&record_id=<?php echo $record_id;?>&course_id=<?php echo $course_id;?>" style="text-decoration:none"><input type="submit" name="save_changes" value="Save & Print" /></a></div>
	</form>
</div>
</body>
</html>
<?php $db->close();?>