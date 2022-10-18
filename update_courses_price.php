<?php 
ini_set('max_execution_time', 1000);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Courses Price</title>
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
		$("#branch_name").chosen({allow_single_deselect:true});	
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
        if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
								echo"<br/>Sr_no:".$sr_no=trim($data->sheets[0]['cells'][$i][1]);
								echo"<br/>Course_Name:".$course_name=trim($data->sheets[0]['cells'][$i][2]);
								//echo"<br/>Course Category:".$course_category=trim($data->sheets[0]['cells'][$i][3]);
								//echo"<br/>Course Domain:".$course_category=trim($data->sheets[0]['cells'][$i][4]);
								//echo"<br />Course Domain:".$course_domain=trim($data->sheets[0]['cells'][$i][4]);
								//echo"<br/>Course Duration:".$course_deration=trim($data->sheets[0]['cells'][$i][5]);
								//echo"<br/>Description:".$description=trim($data->sheets[0]['cells'][$i][6]);
								echo"<br/>Course ID:".$course_id=trim($data->sheets[0]['cells'][$i][3]);
								echo"<br/>Price:".$price=trim($data->sheets[0]['cells'][$i][4]);
								echo"<br/>Non taxable Price:".$pune_price=trim($data->sheets[0]['cells'][$i][5]);
								echo"<br/>Discount Normal-OTP:".$pune_discount_otp=trim($data->sheets[0]['cells'][$i][6]);
								
								echo"<br/>Discount Normal-OTP Inst:".$pune_discount_otp_with_inst=trim($data->sheets[0]['cells'][$i][7]);
								echo"<br/>Discount Normal-Inst:".$pune_discount_inst=trim($data->sheets[0]['cells'][$i][8]);
								echo"<br/>Discount Now-OTP:".$pune_now_discount_otp=trim($data->sheets[0]['cells'][$i][9]);
								echo"<br/>Discount Now-OTP Inst:".$pune_now_discount_otp_with_inst=trim($data->sheets[0]['cells'][$i][10]);
								echo"<br/>Discount Now-Inst:".$pune_now_discount_inst=trim($data->sheets[0]['cells'][$i][11]);
								
								/*========================  Check Course Price =======================================*/
								$sele_price="select course_price_id from courses_price where course_id='".$course_id."' and cm_id='".$cm_id."'";
								$ptr_sel_pr=mysql_query($sele_price);
								if(mysql_num_rows($ptr_sel_pr))
								{
									$update_course="update courses_price set course_price='".$pune_price."',discount_otp='".$pune_discount_otp."',discount_inst='".$pune_discount_inst."',discount_otp_inst='".$pune_discount_otp_with_inst."', discount_now_otp='".$pune_now_discount_otp."',discount_now_inst='".$pune_now_discount_inst."',discount_now_otp_inst='".$pune_now_discount_otp_with_inst."' where course_id='".$course_id."' and cm_id='".$cm_id."'";
									$ptr_update=mysql_query($update_course);
								}
								else
								{
									$ins_course="insert into courses_price (`course_id`,`course_price`,`discount_otp`,`discount_inst`,`discount_otp_inst`,`discount_now_otp`,`discount_now_inst`,`discount_now_otp_inst`,`cm_id`) values ('".$course_id."','".$pune_price."','".$pune_discount_otp."','".$pune_discount_inst."','".$pune_discount_otp_with_inst."','".$pune_now_discount_otp."','".$pune_now_discount_inst."','".$pune_now_discount_otp_with_inst."','".$cm_id."')";
									$ptr_update=mysql_query($ins_course);
								}
								//==================================End Course================================================		
								$html.="</tr>";
							}//for loop for total numrows
						}//End loop - to get data in a table format.
					}//loop used to get each row of the sheet
				}//checking sheet not empty
			}//Loop To Get To all Sheet- echo $html;
			echo "<br/>Total Exist = ".$exist;
			echo "<br/>Total New = ".$new;
		$html="</table>";
	}
	?>
	<form method="post" enctype="multipart/form-data">
		<table align="center" style="margin-top:20px;">
			<?php
            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
                        $sel_branch="SELECT * FROM branch where 1 order by branch_id asc ";	 
                        $query_branch= mysql_query($sel_branch);
                        $total_Branch= mysql_num_rows($query_branch);
                        echo '<table width="100%"><tr><td>';
                        echo '<select id="branch_name" name="branch_name" >';
                        while($row_branch = mysql_fetch_array($query_branch))
                        {
                            ?>
                            <option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name']==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"'; ?> ><?php echo $row_branch['branch_name']; ?></option>
                            <?php
                        }
                        echo '</select>';
                        echo "</td></tr></table>";
                        ?>
                    </td>
                </tr>
                <?php 
            }  
            else 
            { 
                ?>
                <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                <?php 
            }?>
            <tr>
                <td><b>Import excel file</b> </td>
                <td>
                    <?php
                    echo '<input type="file" name="excel_file" id="excel_file" class=" input_text"></td>';
                    ?>
                </td>
            </tr>        
            <tr>
                <td></td>
                <td><input type="submit" name="import_excel" value="save" /></td>
            </tr>
		</table>
	</form>
	<table align="center" border="1" >
		<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
		<tr><td><a href="update_courses_price.xls"><u>DownLoad Excel</u></a></td></tr>
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
 <div id="footer" style="margin-top:300px;"><?php require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>