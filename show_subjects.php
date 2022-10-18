<?php session_start();
 include 'inc_classes.php';
?>
<?
if($_POST['show_subject'] && $_POST['subject']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	        $subject = $_POST['subject'];
	    	echo $select_sales_representative=" select  subject_id,name from subject  where  course_id ='".$_POST['subject']."' ".$_SESSION['where_admin_id']."";
	?>
            <select name="subject_id" class="text-input input_select" id='subject_id' onchange="show_chapter(this.value)"   >
            <option value="" selected>Select Subject </option>
            <?php
			$result_position=mysql_query($select_sales_representative);
		    while($row_position=mysql_fetch_array($result_position))
            {
            ?>
            <option value="<?php echo $row_position['subject_id']; ?>" >
          <?php echo $row_position['name']; ?></option>
            <?php
            }
            ?>
            </select>
 <?
}
?>