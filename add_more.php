<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_course_question_options where course_question_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}

$date=date('Y-m-d');
$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $date ) )) ;
echo $from_second_last_installment_month= " and DATE(`i.installment_amount`) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
echo "<br/>".$to_second_last_installment_month= " and DATE(`i.installment_amount`) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> More options</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready( function() 
{
// binds form submission and fields to the validation engine
jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
});
</script>
<script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        
        function del_degree(del)
        {            
            /*var j=del;
            document.getElementById(j).style.display='none'; */
            var j=document.getElementById('extras').value;
            if(j != 0)
            {
                var curr_div = "div_"+j;
                document.getElementById(curr_div).style.display='none';
                previouss= j;
                if(previouss==0)
                {
                    previouss=0;
                }
                else
                    {
                        previouss= parseInt(j)-1;
                    }
                document.getElementById('extras').value=previouss;
                $('.scrollbar1').tinyscrollbar();
            }
        }
        function add_degree(no)
        {            
            var i=parseInt(document.getElementById('extras').value);
        
                if(i==0)
                {
                    i=1;
                }
                else
                {
                    i= parseInt(i)+1;
                }
                document.getElementById('extras').value=i;
                var next = parseInt(i)+1;
                var curr_div = "div_"+i;
                if(document.getElementById(curr_div).style.display=='none')
                {
                    document.getElementById(curr_div).style.display='block';
                }
                else
                {
                  var data1="curr_div="+i;
                //alert(data1);

                $.ajax({
                    url: "admin_ajax_process.php?action=AddCourse", type: "post", data: data1, cache: false,
                    success: function (html)
                    {
                        //alert(html);
                        document.getElementById(curr_div).innerHTML=html;
                    }
                });               
                }
                
            
        }
    </script>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/test_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['save_changes'])
                    {
                        $extra_pdf = $_POST['extras'];
                        
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    <?php
                        }
                        else
                        {
                            $success=1;
                           
                                for($i=0;$i<=$extra_pdf;$i++)
                                {                                 
                                     $data_query['option_title'] = $_POST['tag'.$i];
                                     if($_POST['duration'.$i]=='y')
                                     $data_query['answer'] = 'y';
                                     else 
                                     $data_query['answer'] = 'n';
                                     $data_query['course_question_id'] = $_REQUEST['record_id'];  
                                     $insert_id=$db->query_insert("course_question_options", $data_query);                                
                                }
                                if($insert_id)
                                { 
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div><br></br>';
                                }                      
                        }
                    }
                    if($success==0)
                    {
                        
                    ?>
            <tr><td>
                    <form  method="post" enctype="multipart/form-data" name="form1" id="jqueryForm">
                    <input type="hidden" name="no_of_extra" id="extra" value="1" />                        
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">                        
                        <tr>
                            <td width="20%"></td>
                            <td colspan="2">
                                <table width="100%">
                                    <tr>
                                        <td>Option</td>
                                        <td>Answer</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">
                                            <textarea name="tag0" id="tag0" class="input_textarea"><?php if($_POST['save_changes']) echo $_POST['tag0']; else echo $row_record['tag0'];?></textarea>
                                        </td>
                                        <td width="40%" valign="bottom">
                                            <input type="radio" name="duration0" id="duration0" value="y" onMouseDown="this.__chk = this.checked" onClick="if (this.__chk) this.checked = false" /> 
                                        </td>
                                        <td width="20%">
                                            <a href="javascript:void();" style="color:#7CA32F;" title="Add Degree" onclick="javascript:add_degree(1);"> Add&nbsp;(+)</a>&nbsp;&nbsp;&nbsp;<b></b>&nbsp;&nbsp;&nbsp;    
                                            <a href="javascript:void();" style="color:#7CA32F;" title="Delete Degree" onclick="javascript:del_degree(1);">Delete&nbsp;(-)</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                         <input type="hidden" name="extras" id="extras" value='0'/>
                         <tr><td colspan="3" width="100%"><div id='div_1'></div></td></tr>
                         <tr><td></td><td colspan="2" ><input class="input_btn" name="save_changes" type="submit" value="Submit" id="save_changes" /></td></tr>
                    </table>
                </form>
        </td></tr>
<?php
                        }?>
	 
        </table></td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
