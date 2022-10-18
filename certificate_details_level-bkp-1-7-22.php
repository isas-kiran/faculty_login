<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
//include "include/ps_pagination.php";
//$db= new Database(); $db->connect();
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
	font-size: 13px !important;
	color:#69291a;
	font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;
	opacity:10;
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
	font-size: 13px !important;
	color:#69291a;
	font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;
	opacity:10;
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
    font-size: 44px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
	opacity:10;
    transform: translate(-50%, -50%);
}
.centered {
    position: absolute;
    top: 46.8%;
    left: 65%;
    font-size: 44px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
	opacity:10;
    transform: translate(-50%, -50%);
}
.beauty {
    position: absolute;
    top: 55.6%;
    left: 70%;
    font-size: 34px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
	opacity:10;
    transform: translate(-50%, -50%);
}
.from_date {
    position: absolute;
    top: 72.8%;
    left: 59.5%;
    font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
	opacity:10;
    transform: translate(-50%, -50%);
}
.to_date {
    position: absolute;
    top: 72.8%;
    left: 72%;
    font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
	opacity:10;
    transform: translate(-50%, -50%);
}
.print {
    position: absolute;
    top: 98%;
    left: 57%;
    transform: translate(-50%, -50%);
}
</style>
</head>
<body >
<?php
$sel_name="select name,installment_display_id,course_start_date,course_end_date,installment_display_id,certificate_date,course_id from enrollment where enroll_id='".$record_id."'";
$ptr_sel=mysql_query($sel_name);
$data_sel=mysql_fetch_array($ptr_sel);
$s_name=$data_sel['name'];
$course_id=$data_sel['course_id'];

$select_course_name="select course_name from courses where course_id='".$data_sel['course_id']."'";
$ptr_course=mysql_query($select_course_name);
$data_course_name=mysql_fetch_array($ptr_course);

if(isset($_POST['save_changes']))
{
	$data_record['enroll_id'] =$record_id;							
	$data_record['course_id'] =$course_id;
	$data_record['reg_no'] =$_POST['reg_no'];
	$data_record['certificate_no'] =$_POST['cer_no'];
	$data_record['awarded_on'] =$_POST['award_on'];
	$data_record['name']=trim($_POST['name']);
	$data_record['beauty_grade']=$_POST['beauty_grade'];
	$data_record['makup_grade']=$_POST['makeup_grade'];
	$data_record['hair_grade']=$_POST['hair_grade'];
	$data_record['nail_grade']=$_POST['nail_grade'];
	
	$data_record['from_date']=$_POST['from_date'];
	$data_record['to_date']=$_POST['to_date'];
	$data_record['cm_id']=$_SESSION['cm_id'];
	$data_record['admin_id']=$_SESSION['admin_id'];
	$data_record['added_date']=date('Y-m-d');
	
	//echo "<br/>".$insert_into_cer="INSERT INTO action_print_certificate (`enroll_id`, `course_id`, `reg_no`, `certificate_no`,`awarded_on`,`name`,`beauty_grade`,`makup_grade`,`hair_grade`,`nail_grade`,`from_date`,`to_date`, `cm_id`,`admin_id`, `added_date`) VALUES ('".$record_id."', '".$course_id."','".$_POST['reg_no']."', '".$_POST['cer_no']."', '".$_POST['award_on']."', '".$_POST['name']."', '".$_POST['beauty_grade']."','".$_POST['makeup_grade']."','".$_POST['hair_grade']."','".$_POST['nail_grade']."','".$_POST['from_date']."','".$_POST['to_date']."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."', '".date('Y-m-d')."')";
	//$ptr_isert_invp=mysql_query($insert_into_cer) or die(mysql_error());
	//echo "<br/>".$ins_ds=mysql_insert_id();
	$sel_rec="select id from action_print_certificate where enroll_id='".$record_id."' and course_id='".$course_id."'";
	$ptr_rec=mysql_query($sel_rec);
	if(mysql_num_rows($ptr_rec))
	{
		$where_record=" enroll_id='".$record_id."' and course_id='".$course_id."'";
		$db->query_update("action_print_certificate", $data_record,$where_record);
	}
	else
	{
		$rec_id=$db->query_insert("action_print_certificate", $data_record);
		$ins_id=mysql_insert_id();
	}
	
	$action_cert="update action_final set print_certificate_action='yes', certificate_print_date='".date('Y-m-d')."' where enroll_id='".$record_id."' and course_id='".$course_id."'";
	$ptr_query=mysql_query($action_cert) or die(mysql_error());
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
	<div class="course"><?php if($data_course_name['course_name'])echo $data_course_name['course_name']; ?><input type="hidden" name="course_name" value="<?php if($data_course_name['course_name'])echo $data_course_name['course_name']; ?>" style="width:500px"></div>
    <div class="centered"><?php echo $s_name; ?><input type="hidden" name="name" value="<?php echo trim($s_name);?>" style="width:500px"></div>
	<div class="beauty"><?php if($grade_rec!='') echo $grade_rec; ?><input type="hidden" name="beauty_grade" Placeholder="Beauty Grade" value="<?php if($grade_rec!='') echo $grade_rec;?>" style="width:70px"></div>
	<div class="from_date"><?php if($data_sel['course_start_date'])echo $data_sel['course_start_date']; ?><input type="hidden" name="from_date" class="datepicker" Placeholder="From" value="<?php if($data_sel['course_start_date'])echo $data_sel['course_start_date']; ?>" style="width:115px"></div>
	<div class="to_date"><?php if($data_sel['course_end_date'])echo $data_sel['course_end_date']; ?><input type="hidden" name="to_date" class="datepicker" Placeholder="To" value="<?php if($data_sel['course_end_date'])echo $data_sel['course_end_date']; ?>" style="width:115px"></div>
    <div class="reg_no"><?php if($data_sel['installment_display_id'])echo $data_sel['installment_display_id']; ?><input type="hidden" name="reg_no" Placeholder="Reg. No:" value="<?php if($data_sel['installment_display_id'])echo $data_sel['installment_display_id']; ?>" style="width:150px"></div>
	<div class="award_on"><?php if($data_sel['certificate_date']) echo $data_sel['certificate_date']; ?><input type="hidden" name="award_on" Placeholder="Award on" class="datepicker" value="<?php if($data_sel['certificate_date']) echo $data_sel['certificate_date']; ?>" style="width:150px"></div>
	<div class="print"><a href="print_certificate_level.php?action=print&record_id=<?php echo $record_id;?>&course_id=<?php echo $course_id;?>" style="text-decoration:none"><input type="submit" name="save_changes" value="Save & Print" /></a></div>
	</form>
</div>
</body>
</html>
<?php $db->close();?>