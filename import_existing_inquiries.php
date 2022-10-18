<?php 
ini_set('max_execution_time', 1000);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import Services</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
 <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            $("#enquiry_src").chosen({allow_single_deselect:true});
			
        });
		</script>
</head>
<body>
<?php include "include/header.php";?>
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
<?php
if(isset($_POST['import_excel']))
{
	require_once 'Excel/reader.php';
	$branch_name=$_POST['branch_name'];
	$cm_id='0';
	if($_SESSION['type']=='S')
	{
		$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$cm_id=$data_branch['cm_id'];
	}	
	else
	{
		$branch_name1=$_SESSION['branch_name'];
		$cm_id=$_SESSION['cm_id'];
	}
	$enquiry_src=$_POST['enquiry_src'];
	
	$filename = basename($_FILES['excel_file']['name']);
    move_uploaded_file($_FILES['excel_file']['tmp_name'],"excel_files/$filename");
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$path="excel_files/$filename";
	$data->read("excel_files/$filename");
                   
                echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
                $html="<table border='1'>";
                    for($i=0;$i<1;$i++) // Loop to get all sheets in a file.
                    {   
					
                        if(count($data->sheets[$i][cells])>0) // checking sheet not empty
                        {
                            echo "Sheet $i:<br /><br />Total rows in sheet- ".count($data->sheets[$i][cells])."<br />";
                             //echo "<br /> cells".count($data->sheets[$i][cells]);
							 
                            for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
                            {
								
                                $html.="<tr>";
                                echo"Total count- ". count($data->sheets[$i][cells][$j]);
                                for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
                                {
									
									//echo "<br />Total counts...".count($data->sheets[$i][cells][$j]);
                                    $html.="<td>";
                                    $html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
                                    $html.="</td>";
                                    $g=1;
                                    for($i=2;$i<=$data->sheets[0]['numRows'];$i++)
                                    {
                                 		"<br />Course_name:".$date=trim($data->sheets[0]['cells'][$i][1]);
                                        "<br />Email_ID:".$customer=trim($data->sheets[0]['cells'][$i][2]);
                                       	"<br />Fullname:".$fullname=trim($data->sheets[0]['cells'][$i][3]);
										"<br />Phone_Number:".$contact_no=trim($data->sheets[0]['cells'][$i][4]);
                                       // "<br />Phone_Number:".$contact_no1=substr(trim($data->sheets[0]['cells'][$i][4]),3);
										"<br />Locality:".$locality=trim($data->sheets[0]['cells'][$i][5]);
										"<br />city:".$city=trim($data->sheets[0]['cells'][$i][6]);
										"<br />category:".$category=trim($data->sheets[0]['cells'][$i][7]);
										
                                     	$cat_id='0';  
										$sub_cat_id='0';
										$product_id='0';
									 	$course_id='';$course_id1='';
									 	$subject_id='';$subject_id1='';$subject_id12='';
									 	$topic_id='';$topic_id1='';$topic_id2='';$topic_id22='';
                                /*=====================================Check Existing Courses=========================================*/
								
								$select_inq="select inquiry_id from inquiry where 1 and mobile1='".trim($contact_no)."' ";
                                $ptr_inq= mysql_query($select_inq);
								if(mysql_num_rows($ptr_inq))
								{
									echo "<br/>"."<span style='color:red'><strong>Enquiry of ".$fullname." is already exist .</strong></span>";
									
									/*$insert_inq= "insert into check_existing_inquiries (`date`,`student_name`,`mobile_no`,`locality`, `city`,`category`,`existing_status`,`cm_id`,`added_date`) values ('".$date."','".$fullname."','".$contact_no."','".$locality."','".$city."','".$category."','Yes', '".$cm_id."','".date("Y-m-d H:i:s")."')  ";
									$ptr_inqu= mysql_query($insert_inq);
									$inquiry_id=mysql_insert_id();*/
								}
								else
								{
									if(trim($data->sheets[0]['cells'][$i][4]) !='')
									{
										/*$insert_inq= "insert into check_existing_inquiries (`date`,`student_name`,`mobile_no`,`locality`, `city`,`category`,`existing_status`,`cm_id`,`added_date`) values ('".$date."','".$fullname."','".$contact_no."','".$locality."','".$city."','".$category."','No', '".$cm_id."','".date("Y-m-d H:i:s")."')  ";
										$ptr_inqu= mysql_query($insert_inq);
										$inquiry_id=mysql_insert_id();*/
										$campaign_id='';
										$selc="select c_id from campaign where campaign_id='".$enquiry_src."'";
										$ptrcmp=mysql_query($selc);
										if(mysql_num_rows($ptrcmp))
										{
											$datsc=mysql_fetch_array($ptrcmp);
											$campaign_id=$datsc['c_id'];
										}
										
										$insert_inq= "insert into inquiry (`firstname`,`mobile1`,`email_id`,`remark`, `enquiry_source`,`campaign_id`,`added_date`,`cm_id`,`status`) values ('".$fullname."','".$contact_no."','','".$category."','".$enquiry_src."','".$campaign_id."','".date("Y-m-d H:i:s")."', '".$cm_id."','Enquiry')  ";
                                		$ptr_inqu= mysql_query($insert_inq);
										$inquiry_id=mysql_insert_id();
										
										$insert_stud_regi= "insert into stud_regi (`name`,`contact`,`mail`,`enquiry_source`,`campaign_id`,`class_id`,`added_date`,`cm_id`) values ('".$fullname."','".$contact_no."','','".$enquiry_src."','".$campaign_id."','".$inquiry_id."','".date("Y-m-d H:i:s")."', '".$cm_id."')  ";
                                		$ptr_stud= mysql_query($insert_stud_regi);
										$cat_id=mysql_insert_id();
										
									}
									echo "<br/>"."<span style='color:green'><strong>Enquiry of ".$fullname." is added successfully .</strong></span>";
								}
								
								/*==========================================End Course================================================*/		
								 $html.="</tr>";
                            }//for loop for total numrows
                        }//End loop - to get data in a table format.
                    }//loop used to get each row of the sheet
                   
                }//checking sheet not empty
            }//Loop To Get To all Sheet- echo $html;
                     $html="</table>";
} 
?>
<form method="post" enctype="multipart/form-data">
<center><b style="font-size:15px;color:#CC0000;">For Institute</b></center>
<table align="center" style="margin-top:20px;">
<?php 
if($_SESSION['type']=='S')
{
	?>
	  <tr>
		<td>Select Branch</td>
		<td>
			<?php 
            if($_REQUEST['record_id'])
            {
                $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." ";
                $ptr_query=mysql_query($sel_cm_id);
                $data_branch_nmae=mysql_fetch_array($ptr_query);
            }
            $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
            $query_branch = mysql_query($sel_branch);
            $total_Branch = mysql_num_rows($query_branch);
            echo '<table width="100%"><tr><td>'; 
            echo ' <select id="branch_name" name="branch_name" >';
            while($row_branch = mysql_fetch_array($query_branch))
            {
                ?>
                <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
        
                </option>
                <?php
            }
            echo '</select>';
            echo "</td></tr></table>";
            ?>
		</td>
	</tr>
	<?php }  
	else { ?>
	   <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
	 <?php 
}?>
<tr>
    <td>Select Campaign Name</td>
    <td>
    <select id="enquiry_src" name="enquiry_src" class="input_select">
    <option value="">--Select Enquiry Source Name--</option>
    <?php 
    $course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']." ";
    $ptr_course_cat = mysql_query($course_category);
    while($data_cat = mysql_fetch_array($ptr_course_cat))
    {
        echo "<optgroup label='".$data_cat['branch_name']."'>";
        $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' order by campaign_name asc";
        $ptr_src=mysql_query($sel_source);
        while($data_src=mysql_fetch_array($ptr_src))
        {
             $sele_source="";
            if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
            {
                $sele_source='selected="selected"';
            }
            ?>
            <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
            <?
        }
        echo " </optgroup>";
    }?>
    </select>
    </td>
</tr>
<tr>
             <td><b>Import excel file</b> </td>
             <td>
            <?php
                echo '<input type="file" name="excel_file" id="excel_file" class=" input_text"></td>';
            ?>
             </td>
</tr>
            
<tr>
             <td>
             </td>
            
             <td><input type="submit" name="import_excel" value="save" /></td>
</tr>
             </table>
             </form>
            
<table align="center" border="1" >
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><a href="import_campaign_inquiries.xls"><u>DownLoad Excel</u></a></td></tr>
</table>    
    </td>
          
          
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
 <div id="footer" style="margin-top:300px;"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>