<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
.hr_line { border: 0; border-bottom: 1px dashed #ccc; background: #999; }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Certificate Biotop</title>
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
    top: 100px;
    left: 40px;
}
.cer_no {
    position: absolute;
    top: 208px;
    left: 40px;
}
.award_on {
    position: absolute;
    top: 318px;
    left: 40px;
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

.centered {
    position: absolute;
    top: 56.5%;
    left: 29.5%;
    transform: translate(-50%, -50%);
}
.course {
    position: absolute;
    top: 61.5%;
    left: 51.5%;
    transform: translate(-50%, -50%);
}
.beauty {
    position: absolute;
    top: 85.5%;
    left: 26%;
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
    top: 76.5%;
    left: 22.5%;
    transform: translate(-50%, -50%);
}
.to_date {
    position: absolute;
    top: 71.5%;
    left: 81%;
    transform: translate(-50%, -50%);
}
.print {
    position: absolute;
    top: 97.5%;
    left: 50.8%;
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
	
    $sql_record= "SELECT * FROM action_print_certificate where enroll_id='".$record_id."' order by id desc";
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

	
?>
<?php
if($_POST['save_changes'])
{
	  $insert_into_cer= "INSERT INTO `action_print_certificate` (`enroll_id`, `reg_no`,`name`,`from_date`, `cm_id`,`admin_id`, `added_date`) VALUES ('".$record_id."','".$_POST['reg_no']."', '".$_POST['name']."','".$_POST['from_date']."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."', '".date('Y-m-d')."')";
	$ptr_isert_invp = mysql_query($insert_into_cer);
	?>
	<script>
		setTimeout('document.location.href="print_certificate_keratine.php?record_id=<?php echo $record_id; ?>&course_id=<?php echo $course_id; ?>";',1000);
	</script>
	<?php
}
	?>
<div class="container">
	<img src="images/keratine.jpg" alt="Certificate Keratine" style="width:100%;">
	<form method="post" name="frmTakeAction">
	
	
	
	<div class="centered"><input type="text" name="name" value="<?php echo $s_name; ?>" style="width:500px"></div>
	<div class="from_date"><input type="text" name="from_date" class="datepicker" Placeholder="Date" value="<?php if($_POST['from_date']!='') echo $_POST['from_date']; else if($row_record['from_date'])echo $row_record['from_date']; ?>" style="width:115px"></div>
	<div class="beauty"><input type="text" name="reg_no" Placeholder="Certificate Number"  value="<?php if($_POST['reg_no']!='') echo $_POST['reg_no']; else if($row_record['reg_no'])echo $row_record['reg_no']; ?>" style="width:150px"></div>
	<div class="print"><a href="print_certificate_level.php?action=print&record_id=<?php echo $record_id;?>&course_id=<?php echo $course_id;?>" style="text-decoration:none"><input type="submit" name="save_changes" value="Save & Print" /></a></div>
	</form>
</div>
</body>
</html>
<?php $db->close();?>