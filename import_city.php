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
<script>
function show_campaign(branch_name)
{
	if(branch_name!='')
    {
		var data1="branch_name="+branch_name;
	   	//alert(data1);
        $.ajax({
        	url: "show_campaign_name.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				document.getElementById("campaign_div").innerHTML =html;
				$("#enquiry_src").chosen({allow_single_deselect:true});
            }
		});
		
	}
}
</script>
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
	if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
                                 		"<br />Course_name:".$course_name=trim($data->sheets[0]['cells'][$i][1]);
                                        /* "<br />Email_ID:".$email_id=trim($data->sheets[0]['cells'][$i][2]);
                                       	"<br />Fullname:".$fullname=trim($data->sheets[0]['cells'][$i][3]);
										"<br />Phone_Number:".$contact_no=trim($data->sheets[0]['cells'][$i][4]);
                                        "<br />Phone_Number:".$contact_no1=substr(trim($data->sheets[0]['cells'][$i][4]),3);
										 */
                                     	$cat_id='0'; 
								
                                        $select_area="select area_id from city_area where 1 and area_name is like '%".trim($course_name)."%' ";
                                        $ptr_area= mysql_query($select_area);
                                        if(mysql_num_rows($ptr_area))
                                        {
                                            echo "<br/>"."<span style='color:red'><strong>Enquiry of ".$course_name." is already exist .</strong></span>";
                                        }
                                        else
                                        {
                                            if(trim($data->sheets[0]['cells'][$i][1]) !='')
                                            {
                                                $insert_area= "insert into city_area (`area_name`,`city_id`,`state_id`) values ('".$course_name."','1558','15499') ";
                                                $ptr_area= mysql_query($insert_area);
                                                $area_id=mysql_insert_id();
                                            }
                                            echo "<br/>"."<span style='color:green'><strong>City name of ".$course_name." is added successfully .</strong></span>";
                                        }		
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
                    <tr>
                        <td><b>Import excel file</b> </td>
                        <td>
                        <?php
                            echo '<input type="file" name="excel_file" id="excel_file" class=" input_text"></td>';
                        ?>
                        </td>
                    </tr>  
                    <tr>
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