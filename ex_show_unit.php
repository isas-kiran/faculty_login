<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?><?php  include 'inc_classes.php';
if($_POST['show_unit'] && $_POST['syllabus_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
     $syllabus_id = $_POST['syllabus_id'];
	 //$language_id=$_POST['language_id'];
	 /*$select_unit_id="select * from question where unit_id ='".$unit_id."' and language_id='".$language_id."' ";
   	 $ptr_unit_id=mysql_query($select_unit_id);
	 $total_unit = mysql_num_rows($ptr_unit_id);*/
	 $i=1;
	 echo "<table width='100%'>";
	 echo "<tr>";
	 echo "<td width='18%' valign='top'>Select Topic<span class='orange_font'>*</span></td>";
	 echo "<td width='82%' colspan='2'>";
	 
	       // $sel_telx = "select unit_id from syllabus_unit_map where syllabus_id='".$syllabus_id."' order by s_u_id asc";	 
		//	$query_telx = mysql_query($sel_telx);
			//$total_no = mysql_num_rows($query_telx);
		//	$conc_unit ='';
		//	$c=1;
		//	while($row_memberx = mysql_fetch_array($query_telx))
			//{
		//		$conc_unit .= " unit_id ='".$row_memberx['unit_id']."' ";
		//		if($c !=$total_no)
		//		$conc_unit .= " or ";
		///		$c++;
		//	}
			$i=1;
			$member_result='';
			echo '<table width="100%">';
			/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
			echo  '<tr>';
			$sel_name1= "select topic_id FROM `topic_map` WHERE 1 and subject_id='".$syllabus_id."' order by topic_id asc";
	$ptr1=mysql_query($sel_name1);
	while($fetch_name1=mysql_fetch_array($ptr1)){
		$sele_init_name="select topic_id, topic_name FROM topic WHERE 1 and topic_id='".$fetch_name1['topic_id']."'";
   
			//$sele_init_name="select topic_id,  topic_name  from topic where 1 and subject_id='".$syllabus_id."'";
			$ptr_unit=mysql_query($sele_init_name);
			while($data_unit=mysql_fetch_array($ptr_unit))
		   	{
				echo  '<td style="border:1px solid #999;">'; 
				$checked= '';
		   		echo  "<input type='checkbox' name='requirment_id[]'  value='".$data_unit['topic_id']."' id='requirment_id$i'  onClick='show_ques($i)' class='case' $checked style='vertical-align:top'/> ".$data_unit['topic_name']." ";
		   		echo  '</td>';
		   		if($i%4==0)
		  		echo  '<tr></tr>';  
		   		$i++;
			}
		}
			echo' <input type="hidden" name="total_no_unit" value="'.($i-1).'" id="total_no" />';
			echo '</table>';

	echo "</td>
	<input type='hidden' name='total_unit' id='total_unit' value='$total_no' />";
	echo "</tr>";
	echo "</table>";
    ?>
        <br />
         </div>
    <?php
}
?>

