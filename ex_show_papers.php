<?php  include 'ex_inc_classes.php';
if($_POST['show_unit'] && $_POST['syllabus_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
     $syllabus_id = $_POST['syllabus_id'];
	 $language_id=$_POST['language_id'];
	 
	 $select_unit_id="select * from ex_question where unit_id ='".$unit_id."' and language_id='".$language_id."' ";
   	 $ptr_unit_id=mysql_query($select_unit_id);
	 $total_unit = mysql_num_rows($ptr_unit_id);
	 $i=1;
	 echo "<table width='100%'>";
	 echo "<tr>";
	 echo "<td width='30%' valign='top'>Select Papers<span class='orange_font'>*</span></td>";
	 echo "<td width='40%' >";
	 
			$sel_tel = "select * from ex_papers where syllabus_id='".$syllabus_id."' and language_id ='".$language_id."' order by papers_id asc";	 
			$query_tel = mysql_query($sel_tel);
			$i=1;
			$total_no = mysql_num_rows($query_tel);
			$member_result='';
			echo '<table width="100%">';

			/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
			echo  '<tr>';
			while($row_member = mysql_fetch_array($query_tel))
		   	{

			/*$sele_init_name="select unit from unit where unit_id='".$row_member['unit_id']."'";
			$ptr_unit=mysql_query($sele_init_name);
			$data_unit=mysql_fetch_array($ptr_unit);*/
			$sel_lang="select language_id,language_name,language_code from ex_language where language_id='".$language_id."'";       
			$ptr_lang=mysql_query($sel_lang);                      
			$data_lang=mysql_fetch_array($ptr_lang);
			echo  '<td style="border:1px solid #999;">'; 
			$checked= '';
			$ids=$row_member['papers_id'];
		   echo  "<input type='radio' name='requirment_id'  value='".$row_member['papers_id']."' id='requirment_id".$i."' onclick='show_ques(this.value);' class='case' $checked /> ".$row_member['paper_name']."".$data_lang['language_code']." ";

		   echo  '</td>';

		   if($i%4==0)

		   echo  '<tr></tr>';  

		   $i++;

			}

			echo' <input type="hidden" name="total_no_unit" value="'.($i-1).'" id="total_no" />';

			echo '</table>';

				

	echo "</td>

	

	<input type='hidden' name='total_papers' id='total_papers' value='$total_no' />

	<td width='40%'></td>";

	echo "</tr>";

	echo "</table>";

	 

    ?>



        <br />

         </div>

    <?php

}

?>

