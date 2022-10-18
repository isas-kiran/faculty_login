<?php 
ini_set('max_execution_time', 1000);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php"; ?></td>
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
                            echo "Sheet $i:<br /><br />Total rows in sheet   ".count($data->sheets[$i][cells])."<br />";
                            //echo "<br /> cells".count($data->sheets[$i][cells]);
                            for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
                            {
                                $html.="<tr>";
                                //echo count($data->sheets[$i][cells][$j]);
								echo "Sheet $i:<br /><br />Total Column in sheet   ". $total_column=count($data->sheets[$i][cells][$j])+1;
                                for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
                                {
									//echo "<br />Total counts...".count($data->sheets[$i][cells][$j]);
                                    $html.="<td>";
                                    $html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
                                    $html.="</td>";
                                    $g=1;
                                    for($i=2;$i<=$data->sheets[0]['numRows'];$i++)
                                    {
                                 		"<br />expense_cat_name:".$expense_cat_name=trim($data->sheets[0]['cells'][$i][2]);
                                        "<br />expense1:".$expense1=trim($data->sheets[0]['cells'][$i][3]);
                                       	"<br />expense2:".$expense2=trim($data->sheets[0]['cells'][$i][4]);
                                        "<br />expense3:". $expense3=trim($data->sheets[0]['cells'][$i][5]);
										"<br />expense4:".$expense4=trim($data->sheets[0]['cells'][$i][6]);
                                        /*"<br />size:".$size=trim($data->sheets[0]['cells'][$i][7]);
                                        "<br />unit:".$unit=trim($data->sheets[0]['cells'][$i][8]);
                                        "<br />commision:". $commission=trim($data->sheets[0]['cells'][$i][9]);
										"<br />price:". $price=trim($data->sheets[0]['cells'][$i][10]);
										"<br />brand:". $brand=trim($data->sheets[0]['cells'][$i][11]);
										"<br />vendor:". $vendor=trim($data->sheets[0]['cells'][$i][12]);
										"<br />type:". $type=trim($data->sheets[0]['cells'][$i][13]);
										"<br />quantity:". $quantity=trim($data->sheets[0]['cells'][$i][14]);*/
                                       
                                     	/*$cat_id='';  
									 	$course_id='';$course_id1='';
									 	$subject_id='';$subject_id1='';$subject_id12='';
									 	$topic_id='';$topic_id1='';$topic_id2='';$topic_id22='';*/
										
                                /*=====================================Check Existing Courses=========================================*/
								
								"<br/>". $select_expense_cat= "select expense_category_id from expense_category where name='".trim($data->sheets[0]['cells'][$i][2])."' ".$_SESSION['where']." ";
                                $ptr_expense_cat= mysql_query($select_expense_cat);
								if(mysql_num_rows($ptr_expense_cat) =='' || mysql_num_rows($ptr_expense_cat) ==0)
								{
									if(trim($data->sheets[0]['cells'][$i][2]) !='')
									{
										 "<br/>".$insert_exp_cat= "insert into expense_category (`name`,`added_date`,`cm_id`,`admin_id`) values ('".trim($data->sheets[0]['cells'][$i][2])."','".date("Y-m-d H:i:s")."','".$cm_id."','".$_SESSION['admin_id']."')  ";
                                		$ptr_cat= mysql_query($insert_exp_cat);
										$cat_id=mysql_insert_id();
										for($c=3;$c<$total_column;$c++)
										{
											if(trim($data->sheets[0]['cells'][$i][$c]) !='')
											{
												echo "<br/>1- ".$select_exp_type= "select expense_type_id from expense_type where expense_type='".trim($data->sheets[0]['cells'][$i][$c])."' and category_id='".$cat_id."' ".$_SESSION['where']." ";
												$ptr_exp_type= mysql_query($select_exp_type);
												if(mysql_num_rows($ptr_exp_type) <=0)
												{
													echo "<br/>".$insert_exp_type= "insert into expense_type (`expense_type`,`category_id`,`cm_id`,`admin_id`,`added_date`) values ('".trim($data->sheets[0]['cells'][$i][$c])."','".$cat_id."','".$cm_id."','".$_SESSION['admin_id']."','".date("Y-m-d")."')  ";
													$ptr_exp_type= mysql_query($insert_exp_type);
													$sub_exp_type=mysql_insert_id();	
												}
											}
										}
									}
								}
								else
								{
									$data_expense_cat=mysql_fetch_array($ptr_expense_cat);
									for($c=3;$c<$total_column;$c++)
									{
										if(trim($data->sheets[0]['cells'][$i][$c]) !='')
										{
											"<br/>2- ".$select_exp_type= "select expense_type_id from expense_type where expense_type='".trim($data->sheets[0]['cells'][$i][$c])."' and category_id='".$data_expense_cat['expense_category_id']."' ".$_SESSION['where']." ";
											$ptr_exp_type= mysql_query($select_exp_type);
											if(mysql_num_rows($ptr_exp_type) <=0)
											{
												
												"<br/>".$insert_exp_type= "insert into expense_type (`expense_type`,`category_id`,`cm_id`,`admin_id`,`added_date`) values ('".trim($data->sheets[0]['cells'][$i][$c])."','".$data_expense_cat['expense_category_id']."','".$cm_id."','".$_SESSION['admin_id']."','".date("Y-m-d")."') ";
												$ptr_exp_type= mysql_query($insert_exp_type);
												$sub_exp_type=mysql_insert_id();	
											}
										}
									}
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
<table align="center" style="margin-top:80px;">
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
            echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
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
            
 <!--<table align="center" border="1" >
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><a href="import-course-format.xls"><u>DownLoad Excel</u></a></td></tr>



</table>     -->      
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