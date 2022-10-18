<?php 

	$update="UPDATE `stud_regi` SET `not_status`='signs_off' where `not_status`='signs_on' ";
	$update_query= mysql_query($update);
	
?>
<script>
document.location.href='manage_student.php';
</script>