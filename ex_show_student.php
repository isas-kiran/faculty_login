<?php   include 'inc_classes.php';
header('Content-Type: text/html; charset=ISO-8859-15'); ?>
<?php
$enroll_id=$_POST['enroll_id'];
$name=$_POST['name'];
if($enroll_id !='')
{
	$ques_concat="and enroll_id='$enroll_id' ";
}
if($name)
{
	$ques_concat="and name like '%".$name."%'";
}
echo "<table width='100%' id='wrapper'>";
$sel_contact = "SELECT student_id, ref_id, name ,enroll_id, course_id , contact FROM enrollment where 1 $ques_concat ";	 
$query_contact = mysql_query($sel_contact);

$i=1;
//$total_contact = mysql_num_rows($query_contact,$con2);
echo "<table><tr><td width='9%' valign='top'>Select student <span class='orange_font'>*</span></td>";
echo "<td width='41%' >";
$member_result='';
echo '<table width="100%">';
echo  '<tr>';
$i=1;
if($total_contact = mysql_num_rows($query_contact))
{
	while($row_contact = mysql_fetch_array($query_contact))
	{
		$course = " SELECT course_name from courses where course_id = '".$row_contact['course_id']."'";
		$c = mysql_query($course);
		$cs = mysql_fetch_array($c);
		
		echo  "<td id='qs".$row_contact['enroll_id']."'><input type='checkbox' name='enroll_id[]' onclick='select_me(\"qs".$row_contact['enroll_id']."\")'  value='".$row_contact['enroll_id']."' id='chapter_id$i' class='case ".$row_contact['enroll_id']."' style='vertical-align:top' /><input type='hidden' name='split' >".$row_contact['name'].".".$cs['course_name']."";
		echo "<input type='hidden' name='split'><input type='hidden' name='course_id[]' id='selected_units".$row_contact['enroll_id']."' value='".$row_contact['course_id']."' >";
		echo "<input type='hidden' name='split'><input type='hidden' name='enroll_id[]' id='selected_enroll".$row_contact['enroll_id']."' value='".$row_contact['enroll_id']."' >";

	   echo  '</td>';
	   if($i%2==0)
	   echo  '</tr><tr>';  
	   $i++;
	}
}
else
{
	echo "* No student found ";
}
echo "</tr></table>";
echo "</td></tr></table><hr />";	
echo "</table>";
?>