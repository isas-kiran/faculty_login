<?php include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
$makeup_grade='';
$spa_grade='';
$beauty_grade='';
$hair_grade='';
$sel_grade="select * from action_certificate_grade where enroll_id='".$record_id."' ";
$ptr_sel=mysql_query($sel_grade);
if(mysql_num_rows($ptr_sel))
{
	while($data_grade_rec=mysql_fetch_array($ptr_sel))
	{
		
		if($data_grade_rec['course_id']=='98')
		{
			$makeup_grade=$data_grade_rec['grade'];
		}
		else if($data_grade_rec['course_id']=='92')
		{
			$spa_grade=$data_grade_rec['grade'];
		}
		else if($data_grade_rec['course_id']=='15')
		{
			$beauty_grade=$data_grade_rec['grade'];
		}
		else if($data_grade_rec['course_id']=='12')
		{
			$hair_grade=$data_grade_rec['grade'];
		}	
	}
}
?>
<head>
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	jQuery(document).ready( function() {
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
    </script>
    <link rel="stylesheet" href="js/jquery.custom/development-bundle/themes/base/jquery.ui.all.css">
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <script type="text/javascript">
    $(document).ready(function()
    {
        //$('.date-input-1').datepicker({ maxDate: "+0D",changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-1').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-2').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst) 
        {
            res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
        }
    });
    </script>
    <style>
	.left_border{ border-left:solid #999 1px; }
	.right_border{ border-right:solid #999 1px;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid #999 1px;}
	.bottom_border{ border-bottom:solid #999 1px;}
	body{ font-family:Verdana, Geneva, sans-serif}
	</style>
<style>
.container {
    position: relative;
    text-align: center;
}
.bottom-left {
    position: absolute;
    bottom: 10px;
    left: 16px;
}
.reg_no {
    position: absolute;
    top: 90%;
    left: 65%;
	font-weight:bold;
	color:#69291a;
	font-size:12px !important;
}
/*.cer_no {
    position: absolute;
    top: 94%;
    left: 46%;
	font-size:10px;
}*/
.award_on {
    position: absolute;
    top: 93.2%;
    left: 65%;
	font-weight:bold;
	font-size: 12px !important;
	color:#69291a;
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
.name {
    position: absolute;
    top: 38.2%;
    left: 74%;
	right:-21%;
	font-size: 44px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.beauty_grade {
    position: absolute;
    top: 57.2%;
    left: 80%;
	right: -21%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.makup_grade {
    position: absolute;
    top: 61.5%;
    left: 80%;
	right: -21%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.hair_grade {
    position: absolute;
    top: 65.2%;
    left: 80%;
	right: -21%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.spa_grade {
    position: absolute;
    top: 69%;
    left: 80%;
	right: -21%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
/*.nail_grade {
    position: absolute;
    top: 73.5%;
    left: 60.5%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.salon_grade {
    position: absolute;
    top: 77.3%;
    left: 60.5%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}*/
.from_date {
    position: absolute;
    top: 84.2%;
    left: 60.5%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.to_date {
    position: absolute;
    top: 84.2%;
    left: 75%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
.print {
    position: absolute;
    top: 90.4%;
    left: 50.8%;
	font-size: 30px;
	color:#69291a;
	font-style:italic;
	font-family: Brush Script MT, cursive;
    transform: translate(-50%, -50%);
}
</style>
</head>
<body>
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	$course_id=$_REQUEST['course_id'];
}
else
{
	$record_id='';
	$course_id='';
}
?>
    <div class="heightSpacer"></div>
	<table align="center" >
		<tr>
			<td valign="top" width="185" height="100"><!--<img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg" title="Isasbeautyschool "/>--></td>
			<td width="601" align="right" style="padding-right:15px;">
        		<table width="99%">
			   <?php 
               if($_SESSION['type']=='S')
               {
                   $sele_cm_id="select branch_name from site_setting where cm_id='2'";
                   $ptr_cm_id=mysql_query($sele_cm_id);
                   $data_cm_id=mysql_fetch_array($ptr_cm_id);
                   
                   $select_branch_address="select branch_address from branch where branch_name='Pune'";
                   $pte_branch_name=mysql_query($select_branch_address);
                   $data_branch_name=mysql_fetch_array($pte_branch_name);
                   
                   //echo $data_branch_name['branch_address'];
                }
                else
                {
                    //echo $_SESSION['branch_address'];
                }
                ?>
        		</table>
            </td>
        	<td valign="top">
        	<?php
		 	if($_GET['action'] !='print' && $_GET['for']!='email')
		 	{
		 		?>
        		<a href="print_certificate_pgdc_1.php?action=print&record_id=<?php echo $record_id; ?>&course_id=<?php echo $course_id; ?>" style="text-decoration:none"><input type="button" name="print" value="Print" /></a> 
        		<?php 
			} ?>
        	</td>
        </tr>
        <?php
		$sql_record= "SELECT * FROM action_print_certificate where enroll_id='".$record_id."' and course_id='".$course_id."' order by id desc";
		if(mysql_num_rows($db->query($sql_record)))
		$row_record=$db->fetch_array($db->query($sql_record));
		?>
        <!--<table align="center" border="0" width="786" cellpadding="0" >
			<tr><td colspan="4" height="151"><h3 align="center"><font size="+1"></font></h3></td></tr>
			<tr><td colspan="4" style="font-family:Comic Sans MS, cursive, sans-serif;"><h3 align="center"><font size="+1" >&nbsp;&nbsp;&nbsp;<?php //echo $row_record['name']; ?></font></h3></td></tr>
			<tr><td colspan="4" height="0" style="font-family:Comic Sans MS, cursive, sans-serif;padding-top:60px"><h3 align="center"><font size="+1" ><?php //echo $row_record['beauty_grade']; ?><br/><br/><?php //echo $row_record['makup_grade']; ?><br/><br/><?php //echo $row_record['hair_grade']; ?><br/><br/><?php //echo $row_record['nail_grade']; ?></font></h3></td></tr> 
		</table>-->
        <!--<tr>
        	<td colspan="5">
                
        	</td>
        </tr>-->
    </table>
    <div class="">
    	
        
        <div class="name"><?php echo $row_record['name']; ?></div>
        <div class="beauty_grade"><?php if($beauty_grade!='') echo $beauty_grade; else echo $row_record['beauty_grade']; ?></div>
        <div class="makup_grade"><?php if($makeup_grade!='') echo $makeup_grade; else echo $row_record['makup_grade']; ?></div>
        <div class="hair_grade"><?php if($hair_grade!='') echo $hair_grade; else echo $row_record['hair_grade']; ?></div>
        <div class="spa_grade"><?php if($spa_grade!='') echo $spa_grade; else echo $row_record['spa_grade']; ?></div>
        <!--<div class="nail_grade"><?php //echo $row_record['nail_grade']; ?></div>
        <div class="salon_grade"><?php //echo $row_record['salon_grade']; ?></div>-->
        <div class="from_date"><?php echo $row_record['from_date']; ?></div>
        <div class="to_date"><?php echo $row_record['to_date']; ?></div>
        <div class="reg_no">ISAS/PUN/2019/Oct/3088</div>
        <!--<div class="cer_no"><?php //echo $row_record['certificate_no']; ?></div>-->
        <div class="award_on">30/10/2019</div>
    </div>
	<?php
    if($_GET['action']=='print' )
    {
        ?>
        <script language="javascript">
        window.print();
        //window.close();
        setTimeout('window.close();',3000);
        //setTimeout('window.close();',5000);
        </script>
        <?php	
    }							
    ?>
</body>
</html>
<?php $db->close();?>