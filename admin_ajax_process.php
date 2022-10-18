<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<?php
if($_REQUEST['action']== 'AddSubTopic')
{
     $i = $_REQUEST['curr_div'];  
    $j=$i+1;
?>
    <div id="div_<?php echo $i;?>">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">              
            <tr>
                <td width="20%"></td>
                <td colspan="2" width="80%">
                    <table width="100%">
                        <tr>
                            <td width="40%" style="padding-left: 10px;">
                                <input type="text" class="validate[required] input_text" name="tag<?php echo $i;?>" id="tag<?php echo $i;?>" value="" />
                            </td>
                            <td width="40%" >
                                <input type="text" class="validate[required] input_text" name="duration<?php echo $i;?>" id="duration<?php echo $i;?>" value="" />                                
                            </td>
                            <td width="20%">&nbsp;</td>
                        </tr>
                    </table>
                </td>            
            </tr>
            <tr><td class="height10"></td></tr>
      </table>
    </div><div id="div_<?php echo $j;?>"></div>
<?php
}
if($_REQUEST['action']== 'AddSubTopicDetails')
{
    $i = $_REQUEST['curr_div'];  
    $j=$i+1;
?>
    <div id="div_<?php echo $i;?>">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">              
            <tr>
                <td width="20%"></td>
                <td colspan="2" width="80%">
                    <table width="100%">
                        <tr>
                            <td width="40%" style="padding-left: 10px;">
                                <input type="text" class="validate[required] input_text" name="tag<?php echo $i;?>" id="tag<?php echo $i;?>" value="" />
                            </td>
                            <td width="40%" >
                                <input type="text" class="validate[required] input_text" name="duration<?php echo $i;?>" id="duration<?php echo $i;?>" value="" />                                
                            </td>
                            <td width="20%">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td class="height10"></td></tr>
        </table>
    </div><div id="div_<?php echo $j;?>"></div>
<?php
}
if($_REQUEST['action']== 'AddCourse')
{
    $i = $_REQUEST['curr_div'];  
    $j=$i+1;
?>
    <div id="div_<?php echo $i;?>">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td width="20%"></td>
                <td colspan="2" width="80%">
                    <table width="100%">
                        <tr>
                            <td width="40%" style="padding-left: 10px;">
                                <textarea name="tag<?php echo $i;?>" id="tag<?php echo $i;?>" class="validate[required] input_textarea"></textarea>
                            </td>
                            <td width="40%" >
                                 <input type="radio" name="duration<?php echo $i;?>" id="duration<?php echo $i;?>" value="y" onMouseDown="this.__chk = this.checked" onClick="if (this.__chk) this.checked = false" />
                            </td>
                            <td width="20%">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td class="height10"></td></tr>
        </table>
    </div><div id="div_<?php echo $j;?>"></div>
<?php
}
if($_REQUEST['action']== 'show_exams')
{
    $id=$_REQUEST['id'];
    if($id)
     {
         $select_city = "select * from PB_course_exam_duration where course_id = ".$id."";
         $ptr_city = mysql_query($select_city);
         echo '<select name="exam_duration_id" id="exam_duration_id" class="validate[required] input_select" > 
                <option value="">Select Exam</option>';
                while($data_city = mysql_fetch_array($ptr_city))
                {                   
                    echo  '<option value="'.$data_city['exam_duration_id'].'">'.$data_city['exam_name'].'</option>';
                }
         echo '</select>';

     }
}

?>