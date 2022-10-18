
<?php  include 'inc_classes.php';
if($_POST['show_chapter'] && $_POST['subject_id']) //$_POST:-because of that we can use this  in to the function for ajax 
{
	 $chapter_id = $_GET['topic_id'];
     $subject_id = $_POST['subject_id'];
	
	 $select_topic_id="select * from topic where subject_id ='".$subject_id."' ";
   	 $ptr_select_topic_id=mysql_query($select_topic_id);
	 $total_topics = mysql_num_rows($ptr_select_topic_id);
	 $i=1;
	 echo "<table width='100%'>";
	 echo "<tr>";
	 
	 echo "<td width='20%'> Select Topic </td>";
	 echo "<td width='40%' >";
	 echo "<table>";
	 echo "<tr>";
	 echo "<td><b>Topic name</b></td><td><b>Selected Question</b></td><td><b>Total Ques.</b></td>";
	 echo "</tr>";
	 
		 while($data_topic_id=mysql_fetch_array($ptr_select_topic_id))
		 {
			 $sel_total_ques="select question_id from question where chapter_id='".$data_topic_id['topic_id']."'";
			 $ptr_total_ques=mysql_query($sel_total_ques);
			 $coune_total_ques=mysql_num_rows($ptr_total_ques);
			
			if($chapter_id == $data_topic_id['topic_id'])
			{
				echo "<tr>";
				
				echo "<td><input type='checkbox' name='chapter_id[]'  value='".$data_topic_id['topic_id']."' id='chapter_id$i'  /> ".$data_topic_id['topic_name']." /> </td>";
				echo "<td><input type='text' name='".$data_topic_id['topic_id']."' id='select_question$i' value=''/>($coune_total_ques)</td>";
				echo "<td align='center'>($coune_total_ques)</td>";
				echo "</tr>";
			}
			else
			{
				
				echo "<tr>";
				echo "<td><input type='hidden' name='total_question_$i' id='total_question_$i' value='$coune_total_ques'/>
				<input type='checkbox' name='chapter_id[]'  value='".$data_topic_id['topic_id']."' id='chapter_id$i' onclick='cal_total();'  class='case'/> ".$data_topic_id['topic_name']."</td> ";
				echo "<td><input type='text' name='".$data_topic_id['topic_id']."' id='selected_question$i' onkeyup='cal_total();' value='0' /></td>";
				echo "<td align='center'>($coune_total_ques)</td>";
				echo "<tr>";
				
				
			}
		$i++;
		 }
	echo "</table>";
	echo "</td>
	<input type='hidden' name='total_topics' id='total_topics' value='$total_topics' />
	 <td width='40%'></td>";
	echo "</tr>";
	echo "</table>";
	 
    ?>
   
        <br />
        <input type="text"   name="new_dist" id="new_dist" class="input_text"  style="display:none" placeholder="New Chapter" />
         </div>
    <?php
}
?>
<script>
 /*  function showUser()
{
	alert("hi..");
	total_mbr =  document.getElementById("total_question").value;
	contact ='';
	for(i=1; i<=total_mbr;i++)
	{
		id="chapter_id"+i;
		//alert(id);
		if(document.getElementById(id).checked)
			{
				contact +=document.getElementById(id).value;
				contact +=',';
			}
	}
	
 	var data1="chapter_id="+contact;	
	
        $.ajax({
            url: "get_question.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				 
				  document.getElementById('topic_list').innerHTML=html;
				  $(".multiselect").multiselect();
            }
            });
}
*/



</script>