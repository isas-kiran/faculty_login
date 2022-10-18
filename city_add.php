<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_city where city_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> City</title>
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
        function OpenStatediv(country_id)
        {
            
            if(country_id)
                {
                    var data1="country_id="+country_id;
            //alert(data1);
            $.ajax({
                url: "select_state.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                    //alert(html);
                    $("#statediv").html(html);
                    //document.getElementById(div_id).innerHTML=html;
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
    <td class="top_mid" valign="bottom"><?php include "include/city_menu.php"; ?></td>
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
                        $city_name= strip_tags($_POST['city_name']);   
                        $country_id = $_POST['country_id'];
                        
                        if($country_id =="")
                        {
                                $success=0;
                                $errors[$i++]="Select country";
                        }   
                        if($city_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter city name ";
                        }
                        if($record_id =='')  {
                            $select_exist_userTable = "SELECT * FROM PB_city where city_name='".$city_name."'";
                            if(mysql_num_rows($db->query($select_exist_userTable)))	
                            {
                                    $success=0;
                                    $errors[$i++]="This city is already exists, please choose another one";
                            }
                        }
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
                            $data_record['country_id'] =$country_id;
                            $data_record['city_name'] = $city_name;
                           if($record_id)
                            {
                                $where_record=" city_id='".$record_id."'";
                                $db->query_update("city", $data_record,$where_record);
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
                                $record_id=$db->query_insert("city", $data_record);
                                echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
                        }
                    }
                    if($success==0)
                    {
                    //United States USA
                      //  Canada CAN
                    ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            <tr>
                <td width="20%">Select Country<span class="orange_font">*</span></td>
                <td width="40%">
                    <select class="validate[required] input_select" name="country_id" id="country_id" onchange="OpenStatediv(this.value);">
                            <option value="">Select Country</option>
                            <?php
                            $select_country = "select * from PB_country order by country_id asc ";
                            $ptr_country = mysql_query($select_country);
                            while($data_country = mysql_fetch_array($ptr_country))
                            {                                
                                
                                if($data_country['country_id'] == $row_record['country_id'])
                                    echo '<option value='.$data_country['country_id'].' selected="selected">'.$data_country['country_name'].'</option>';
                                else
                                    echo '<option value='.$data_country['country_id'].'>'.$data_country['country_name'].'</option>';
                            }
                            ?>                                
                    </select>
                </td> 
                <td width="40%"></td>
            </tr> 
            
            <tr>
                <td width="20%">City Name<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="city_name" id="city_name" value="<?php if($_POST['save_changes']) echo $_POST['city_name']; else echo $row_record['city_name'];?>" /></td> 
                <td width="40%"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> City" name="save_changes"  /></td>
                <td></td>
            </tr>
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