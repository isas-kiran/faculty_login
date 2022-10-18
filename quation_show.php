<?php 
 include 'inc_classes.php';?>
<TABLE  width="1000" border="0" align="center">
	        <?php
			
			
            $subject_id=$_GET['q'];
            $sel_class = "select * from question where subject_id='".$subject_id."'";
            $execute_class = mysql_query($sel_class);
            ?>	
              	<?php
			     $j=1;
                 while($class_data= mysql_fetch_array($execute_class))
                  {
                     $class_data['question_title']; 
					 $question_ids = $class_data['question_id'];
					
              ?>
              <tr>
             <td width="34" height="32"><?  echo $j; ?>)</td>
              <td width="592">
			  <? echo $class_data['question_title']; ?> </td><!------"quation_id[]" ------->
       <td width="153"><input type="checkbox" name= "quation_id<? echo $j;?>" style="text-align:right"  value="<?=$question_ids;  ?> "  id="<? echo $j;?>" class="myCheckbox" onclick="counter_check(<?php echo $j; ?>);"/> </td>
              
               <td width="100">&nbsp;</td>
               <td width="99">&nbsp;</td>
               </tr>
               <? 	 $j++; }?>
               
         </TABLE>
          <input type="hidden" name="total_checked_question" id="total_checked_question" value="0" />
         <input type="hidden" name="total_quation_id"  value="<? echo $j-1;?>" id="txtHint">