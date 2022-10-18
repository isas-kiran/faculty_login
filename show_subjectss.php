<?php  include 'inc_classes.php';
if($_POST['showsubject_name'] && $_POST['course_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
        	$subject = $_POST['course_id'];
       $select_subjects_id="select * from subject where  course_id ='".$subject."' ".$_SESSION['where_admin_id']."";
   	 $ptr_select_subjecst_id=mysql_query($select_subjects_id);
	?>
     <select name="subject_id" id="subject_id"  class="inputSelect"  onchange="showUser(this.value)" >
    <option value="">Select subject </option>
	<?
     
	 while($val_recordsss=mysql_fetch_array($ptr_select_subjecst_id))
	 {
		 ?>
	<?
	echo "<option value='".$val_recordsss['subject_id']."'>".$val_recordsss['name']."</option>";
   // echo $val_recordsss['name'];
    }
    ?>
    </select>
    
    
    
    <?php
	
}
?>
