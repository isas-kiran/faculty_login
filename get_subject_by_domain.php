<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?>
<?php  include 'inc_classes.php';
$domain_id=$_POST['domain_id'];
$subject_id=$_POST['subject_id'];
$subject_name=$_POST['subject_name'];
if($subject_id !='')
{
	$ques_concat="and subject_id='".$subject_id."' ";
}
if($subject_name)
{
	$ques_concat="and name like '%".$subject_name."%'";
}

echo "<table width='100%' id='wrapper'>";
$sel_contact = "SELECT * FROM subject where 1 and course_domain_id='".$domain_id."' $ques_concat ";	 
$query_contact = mysql_query($sel_contact);
$i=1;
//$total_contact = mysql_num_rows($query_contact,$con2);
echo "<tr><td width='7%' valign='top'>Select Subject <span class='orange_font'>*</span></td>";
echo "<td width='42%' >";
$member_result='';
echo '<table width="100%">';
echo '<tr>';
$i=1;
if($total_contact = mysql_num_rows($query_contact))
{
	while($row_contact = mysql_fetch_array($query_contact))
	{
		echo  "<td id='qs".$row_contact['subject_id']."' ><input type='checkbox' name='subject_id[]' onclick='select_me(\"qs".$row_contact['subject_id']."\")'  value='".$row_contact['subject_id']."' id='chapter_id".$row_contact['subject_id']."' class='case ".$row_contact['subject_id']."' style='vertical-align:top' /><input type='hidden' name='split' >".$row_contact['name']." ";
		echo "<input type='hidden' name='split'><input type='hidden' name='course_domain_id[]' id='selected_units".$row_contact['subject_id']."' value='".$row_contact['course_domain_id']."'>";
		echo "<input type='hidden' name='split'><input type='hidden' name='enroll_id[]' id='selected_enroll".$row_contact['subject_id']."' value='".$row_contact['subject_id']."'>";
		echo  '</td>';
		if($i%2==0)
		echo  '</tr><tr>';  
		$i++;
	}
}
else
{
	echo "* No Subject found ";
}
echo "</tr></table>";
echo "</td></tr></table><hr />";	
echo "</table>";
?>