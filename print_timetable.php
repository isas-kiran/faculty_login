<?php include 'inc_classes.php';?>
<?php //include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
	    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 
?>
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
						$record_id =$_GET['record_id'];
                        $sql_records= "SELECT* from timetable where timetable_id ='".$record_id."'";
						$ptr_exsist =$db->query($sql_records);
						$data_bill_master=mysql_fetch_array($ptr_exsist);
						?>
						<!--<table align="center" border="0" width="786" class="left_border right_border top_border" style="border-radius:5px;">
                        	<tr>
                        		<td valign="top" width="185"><img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg" title="Isasbeautyschool "/></td>
                        		<td width="601" align="right" style="padding-right:15px;">
                                	<table width="99%">
									<?php 
                            		/*if($_SESSION['type']=='S')
                            		{
                                		$sele_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']."";
                                		$ptr_cm_id=mysql_query($sele_cm_id);
                                		$data_cm_id=mysql_fetch_array($ptr_cm_id);
                               
                                		$select_branch_address="select branch_address from branch where branch_name='".$data_cm_id['branch_name']."'";
                                		$pte_branch_name=mysql_query($select_branch_address);
                                		$data_branch_name=mysql_fetch_array($pte_branch_name);
                                		echo $data_branch_name['branch_address'];
                            		}
                            		else
                            		{
                                		echo $_SESSION['branch_address'];
                            		}*/
                            		?>
                        			</table>
                        		<td valign="top">
                        		<?php
                        		/*if($_GET['action'] !='print')
                         		{
									?>
                        			<a href="print_timetable.php?record_id=<?php echo $record_id; ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>				<?php 
								} */?>
                        		</td>
                        	</tr>
                        	<tr height="5">
                            </tr>
                       	</table>-->
                        <table align="center" border="1px"  width="786" cellpadding="0" cellspacing="0" bgcolor="#EFEFEF" style=" border:1px solid;" >
                        <!-- <table width="990" height="84" align="center" class="table">-->
						<?php
                        $select_course = " select course_id,course_name from courses where course_id='".$data_bill_master['course_id']."' ";
                        $ptr_course=mysql_query($select_course);
                        $data_course = mysql_fetch_array($ptr_course);
                        echo '<input type="hidden" name="total_topic" value="'.$c.'"/>';
                        ?>
                        <tr><th colspan="2"><? echo strtoupper($data_course['course_name']); ?> Timetable</th></tr>
                       
                   	</table>
               	</td>
            </tr>
        </table>
        <table align="center" border="1px" width="786" cellpadding="0" cellspacing="1" bgcolor="#EFEFEF" style=" border:1px solid;" >
            <tr align="center" class="grey_td" >
                <td width="5%" class="tr-header"><strong>Sr No.</strong></td>
                <td width="10%" class="tr-header"><strong>Day</strong></td>
                <td width="15%" class="tr-header"><strong>Date</strong></td>
                <td width="27%" class="tr-header"><strong>Topic Name</strong></td>
                <td width="33%" class="tr-header"><strong>Topic Content</strong></td>
                <td width="10%" class="tr-header"><strong>Model Required</strong></td>
            </tr><?php
			$bgColorCounter=1;
			$j=1;
			
			$select_topic_id = "select * from timetable_topic_map where timetable_id='".$record_id."' order by day asc";
			$ptr_topic_id=mysql_query($select_topic_id);
			if(mysql_num_rows($ptr_topic_id))
			while($data_topic_id = mysql_fetch_array($ptr_topic_id))
			{
				$select_topic_name = " select topic_id,topic_name from topic where topic_id='".$data_topic_id['topic_id']."' ";
				$ptr_topic_name=mysql_query($select_topic_name);
				$data_topic_name = mysql_fetch_array($ptr_topic_name);
				
				if($bgColorCounter%2==0)
					$bgcolor='class="grey_td"';
				else
					$bgcolor=""; 
				$enroll_id=$data_topic_id['topic_id'];
			 	$paid_totas=0;
				
				include "include/paging_script.php";
				echo '<tr class="'.$bgclass.'">';
				echo '<td align="center">'.$sr_no.'</td>';
				echo "<td align='center'>Day ".$data_topic_id['day']."</td>";
				echo "<td align='center'></td>"; 
				echo '<td align="center">'.$data_topic_name['topic_name'].'</td>'; 
				echo '<td align="center">'.$data_topic_id['topic_content'].'</td>'; 
				echo '<td align="center">'.$data_topic_id['model_required'].'</td>';
				echo '</tr>';
				$bgColorCounter++;
		   		$j++;
		   		$i--;
			}
			?>
       	</table>
		<?php
		if($_GET['action']=='print')
		{
			?>
			<script language="javascript">
			window.print();
			//window.close();
			setTimeout('window.close();',3000);
			</script>
			<?php	
        }							
        ?>
		</body>
	</html>
<?php $db->close();?>