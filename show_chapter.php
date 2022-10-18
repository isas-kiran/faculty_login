<?php  include 'inc_classes.php';
if($_POST['show_chapter'] && $_POST['subject_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	 $chapter_id = $_GET['topic_id'];
     $subject_id = $_POST['subject_id'];
	
	?>
    <select name="chapter_id" id="chapter_id"  class="input_select"  onclick=" show_news(this.value,'');" >
    <option value="">Select Topic </option>
	<?
	 $select_topic_id="select * from topic where subject_id ='".$subject_id."' ";
   	 $ptr_select_topic_id=mysql_query($select_topic_id);
		 while($data_topic_id=mysql_fetch_array($ptr_select_topic_id))
		 {
		
			if($chapter_id == $data_topic_id['topic_id'])
				echo '<option value='.$data_topic_id['topic_id'].' selected="selected">'.$data_topic_id['topic_name'].'</option>';
			else
				echo '<option value='.$data_topic_id['topic_id'].' >'.$data_topic_id['topic_name'].'</option>';
		 }
	
    ?>
    <option value="new_dist" style="color:#900; cursor:pointer;">Add Topic </option>
        </select>
        <br />
        <input type="text"   name="new_dist" id="new_dist" class="input_text"  style="display:none" placeholder="New Chapter" />
         </div>
    <?php
}
?>
