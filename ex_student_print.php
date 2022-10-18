<?php include 'inc_classes.php';?>

<?php include "../classes/thumbnail_images.class.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
</head>
<body>
  <div class="heightSpacer"></div>
  
     <?php
         $exam_no =$_GET['exam_no'];
		 ?>
         
         <table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
             <tr>
                <td valign="top" width="304" style="font-size:25px"><?php echo $exam_no ?> Exam's students</td>
                <td width="420" align="right" style="padding-right:15px;">
                   <table width="99%"></table>
                   
                   <!-- <td width="42" valign="top">
					< ?php
                     if($_GET['action'] !='print')
                     {
                     ?>
                    <a href="student_print.php?exam_no=< ?php echo $exam_no ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
                    < ?php } ?>
                   </td>
                    -->
                   <td width="0"></td>
               </tr>
                    <tr height="5">
            </tr></table>
            
            
            <table align="center" border="0" width="786" style="border:1px solid #0066cc;">
            <?php                      
                       
                        ?>
              <tr class="grey_td" >
                <td width="5%" align="center"><strong>Sr. No.</strong></td>
                <td width="10%" align="center"><strong>Student Name</strong><?php echo $img1;?></td>
                <td width="10%" align="center"><strong>Course Name</strong></td>
                <td width="10%" align="center"><strong>School code</strong></td>
                <td width="10%" align="center"><strong>Exam no</strong></td>
                <td width="10%" align="center"><strong>enroll no</strong></td>
                <td width="10%" align="center"><strong>Password</strong></td>
                <td width="10%" align="center"><strong>present or abscent</strong></td>
                <td width="10%" align="center"><strong>Added Date</strong></td>
              </tr>
              <?php
            echo $sql_query= "select * from student_exam_registration where 1 and exam_no = '".$_GET['exam_no']."' "; 
                     
                    while($val_query=mysql_fetch_array($db->query($sql_query)))
                    {
                      
                      echo '<tr>';

                      echo '<td align="center">'.$sr_no.'</td>';

                    $select_name="select name from enrollment where enroll_id='".$val_query['enroll_no']."'";
                    $ptr_name=mysql_query($select_name , $con2);
                    $nm = mysql_fetch_array($ptr_name);

                      echo '<td align="center">'.$nm['name'].'</td>';

                      $select_course="select course_name from courses where course_id='".$val_query['course_id']."'";
                    $ptr_course=mysql_query($select_course , $con2);
                    $cs = mysql_fetch_array($ptr_course);


                      echo '<td align="center">'.$cs['course_name'].'</td>'; 
                    $select_school_code = "select school_code FROM `exams` WHERE exam_number='".$_GET['exam_no']."'";
                    $ptr_schoolcode = mysql_query($select_school_code);
                    $sc = mysql_fetch_array($ptr_schoolcode);
                    echo '<td align="center">'.$sc['school_code'].'</td>';
                    echo '<td align="center">'.$val_query['exam_no'].'</td>';          
                    echo '<td align="center">'.$val_query['enroll_no'].'</td>';
                    echo '<td align="center">'.$val_query['pwd'].'</td>';
                    echo '<td align="center">';
                    echo '<div>';
                    $act_selecteds = '';
                    $inact_selecteds='';
                    if($val_query['status']=='0')
                   echo $act_selecteds = 'Present';
                    else if	($val_query['status']=='1')
                    echo $inact_selecteds = 'Abscent"';

                  
                    echo'</div>';
                    echo '</td>';
                    echo '<td align="center">'.$val_query['date_added'].'</td>';


                      echo '</tr>';
                      
                    }
                    ?>
          </table>   
              
<!-- < ?php
			if($_GET['action']=='print')
			{
			?>
			<script language="javascript">
			
			window.print();
			//window.close();
			setTimeout('window.close();',3000);
			//setTimeout('window.close();',5000);
			</script>
			< ?php	
			}							
			?> -->
			</body>
			</html>
			<?php $db->close();?>
 