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
                <td valign="top" width="304" style="font-size:25px">MCQ Examination</td>
                <td width="420" align="right" style="padding-right:15px;">
                   <table width="99%"></table>
                   
                   <td width="42" valign="top">
					<?php
                     if($_GET['action'] !='print')
                     {
                     ?>
                    <a href="student_report_print.php?exam_no=<?php echo $exam_no ?>&student_id=<?php echo $_GET['student_id'] ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
                    <?php } ?>
                   </td>
                   
                   <td width="0"></td>
               </tr>
                    <tr height="5">
            </tr></table>
            <?php
			$sele_stud="select * from stud_login where stud_login_id='".$_GET['student_id']."'";
			$ptr_stud=mysql_query($sele_stud);
			$data_stud=mysql_fetch_array($ptr_stud);
			
			$select_ex="select * from exams where exam_number ='".$exam_no."' ";
			$ptr_ex=mysql_query($select_ex);
			$total_ex = mysql_num_rows($ptr_ex);
			$data_ex=mysql_fetch_array($ptr_ex);
			$i=1;
			?>
            
            <table align="center" border="0" width="786" style="border:1px solid #0066cc;">
             <tr><td><table width="100%">
              <tr>
                <td align="center" style="color:#0066cc;font-size:18px" colspan="3"><strong>Student Report Showing Questions and Answer</strong></td>
              </tr>
              
                <tr>
                 <td width="15%">Examination Number</td><td width="2%">:</td>
                 <td width="46%"><?php echo $exam_no ?></td>
              </tr>
              
              <tr>
                <td>Student Name</td><td width="2%">:</td>
                <td><?php echo $data_stud['name'] ?></td>
              </tr>
               <tr>
                <td>Student Roll No</td><td width="2%">:</td>
                <td><?php echo $data_stud['pass'] ?></td>
              </tr>
             
              <tr>
                <td>Marks</td><td width="2%">:</td>
                <td><?php echo $data_ex['exam_mark'] ?></td>
              </tr>
              
              <tr>
                <td align="center" colspan="3">
                <table style="border:1px solid #0066cc;	border-collapse: collapse;" width="90%" border="1px" align="center">
                    	<tr bgcolor="#0066cc" style="color:black">
                        	<td align="center" >Sr. No.</td>
                            <td align="center">Question No.</td>
                            <td align="center">Unit</td>
                            <td align="center">Answer</td>
                            <td align="center">Marks</td>
                         </tr>
                         
                         <?php
						 
						$select_ques="select * from student_paper where student_id='".$_GET['student_id']."' order by question_id asc";	
						$ptr_std=mysql_query($select_ques);	
						if($total_std=mysql_num_rows($ptr_std))
						{
							$total_m=0;
							$j=1;
							while($data_std=mysql_fetch_array($ptr_std))
							{
								$sel_ques_name="select question_id,question_title,unit_id from question where question_id='".$data_std['question_id']."' order by question_id asc";
								$ptr_que=mysql_query($sel_ques_name);
								$data_que=mysql_fetch_array($ptr_que);
								
								$sel_opt="select * from options where question_id='".$data_std['question_id']."' and answer='y'";
								$ptr_opt=mysql_query($sel_opt);
								$data_opt=mysql_fetch_array($ptr_opt);
								
								$sel_unit="select unit from unit where unit_id='".$data_que['unit_id']."'";
								$ptr_unit=mysql_query($sel_unit);
								$data_unit=mysql_fetch_array($ptr_unit);
								
								if($data_opt['option_id']==$data_std['answer_option'])
								{ $correct="Right"; $mark="1"; $total_m +=1;}
								else
								{ $correct="Wrong"; $mark="0";}
									echo'<tr>
										<td>'.$j.'</td>
										<td>'.$data_que['question_id'].'</td>
										<td>'.$data_unit['unit'].'</td>
										<td>'.$correct.'</td>
										<td>'.$mark.'</td>
									</tr>';
									
							$j++;
							}
							 echo'<tr>
										<td style="background-color:#0066cc;color:white">&nbsp;</td>
										<td style="background-color:#0066cc;color:white">&nbsp;</td>
										<td style="background-color:#0066cc;color:white">&nbsp;</td>
										<td style="background-color:#0066cc;color:black">Total</td>
										<td style="background-color:#0066cc;color:black">'.$total_m.'</td>
									</tr>';
							
						}
						else
						{
							 echo'<tr>
										<td colspan="3">Question Not found </td>
									</tr>';
						}
			?>
            </table></td>
              </tr>
              </table></td>
            </tr>
          </table>   
              
<?php
			if($_GET['action']=='print')
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
 