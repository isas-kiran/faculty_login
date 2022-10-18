<?php include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];
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
    top: 30px;
    left: 5px;
	font-size:10px;
}
.cer_no {
    position: absolute;
    top: 110px;
    left: 5px;
	font-size:10px;
}
.award_on {
    position: absolute;
    top: 200px;
    left: 5px;
	font-size:10px;
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
    top: 51%;
    left: 64%;
    transform: translate(-50%, -50%);
}
.name {
    position: absolute;
    top: 49.5%;
    left: 51.5%;
	font-size: 28px;
    transform: translate(-50%, -50%);
}
.beauty {
    position: absolute;
    top: 95%;
    left: 26%;
	
    transform: translate(-50%, -50%);
}
.makup_grade {
    position: absolute;
    top: 64.8%;
    left: 55%;
    transform: translate(-50%, -50%);
}
.hair_grade {
    position: absolute;
    top: 68.9%;
    left: 55%;
    transform: translate(-50%, -50%);
}
.nail_grade {
    position: absolute;
    top: 75%;
    left: 55%;
    transform: translate(-50%, -50%);
}
.from_date {
    position: absolute;
    top: 70%;
    left: 51.5%;
	font-size: 28px;
    transform: translate(-50%, -50%);
}
.to_date {
    position: absolute;
    top: 75%;
    left: 86%;
    transform: translate(-50%, -50%);
}
.print {
    position: absolute;
    top: 90.5%;
    left: 50.8%;
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
        		<a href="print_certificate_biotop.php?action=print&record_id=<?php echo $record_id; ?>&course_id=<?php echo $course_id; ?>" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
        		<?php 
			} ?>
        	</td>
        </tr>
        <?php
		$sql_record= "SELECT * FROM action_print_certificate where enroll_id='".$record_id."' order by id desc";
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
		<?php $date=explode("/",$row_record['from_date']); 
			  $day=$date[0]; 
			  $month1=$date[1];
			  $year=$date[2];
			  if($day==1) $pre="st";
			  else if($day==2) $pre="nd";
			  else if($day==3) $pre="rd";
			  else $pre="th";
			  $finalday=$day."<sup>".$pre."</sup>";
								if($month1=='1'){ $month="January"; }
								if($month1=='2'){ $month="February "; }
								if($month1=='3'){ $month="March"; }
								if($month1=='4'){ $month="April"; }
								if($month1=='5'){ $month="May"; }
								if($month1=='6'){ $month="June"; }
								if($month1=='7'){ $month="July"; }
								if($month1=='8'){ $month="Auguest"; }
								if($month1=='9'){ $month="September"; }
								if($month1=='10'){ $month="October"; }
								if($month1=='11'){ $month="November"; }
								if($month1=='12'){ $month="December"; }
								$fdate=$finalday." ".$month." ".$year;
			  ?>
        <div class="from_date"><?php echo $fdate; ?></div>
        <div class="beauty"><?php echo $row_record['reg_no']; ?></div>
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