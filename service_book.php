<?php 
ini_set('max_execution_time', 1000);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import Services</title>
<link href="../../safar-live/Admin/css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>

<script src="dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	
<link rel="stylesheet" href="dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" charset="utf-8">

</head>
<body onLoad="init();">
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
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
                                for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
                                {
									
									//echo "<br />Total counts...".count($data->sheets[$i][cells][$j]);
                                    $html.="<td>";
                                    $html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
                                    $html.="</td>";
                                    $g=1;
                                    for($i=3;$i<=$data->sheets[0]['numRows'];$i++)
                                    {
                                 		"<br />service_name:".$service_name=trim($data->sheets[0]['cells'][$i][2]);
                                        "<br />service_code:".$service_code=trim($data->sheets[0]['cells'][$i][3]);
                                       	"<br />service_category:".$service_category=trim($data->sheets[0]['cells'][$i][4]);
                                        "<br />service_sub-category:". $service_subcategory=trim($data->sheets[0]['cells'][$i][5]);
										"<br />service_description:".$service_description=trim($data->sheets[0]['cells'][$i][6]);
                                        "<br />time_to_finish:".$time_to_finish=trim($data->sheets[0]['cells'][$i][7]);
                                        "<br />product_cost:".$product_cost=trim($data->sheets[0]['cells'][$i][8]);
                                        "<br />other_cost:". $other_cost=trim($data->sheets[0]['cells'][$i][9]);
										"<br />total_cost:". $total_cost=trim($data->sheets[0]['cells'][$i][10]);
										"<br />service_price:". $service_price=trim($data->sheets[0]['cells'][$i][11]);
										"<br />visit:". $visit=trim($data->sheets[0]['cells'][$i][12]);
										"<br />notes:". $notes=trim($data->sheets[0]['cells'][$i][13]);
										
                                       
                                     	$cat_id='';  
									 	$course_id='';$course_id1='';
									 	$subject_id='';$subject_id1='';$subject_id12='';
									 	$topic_id='';$topic_id1='';$topic_id2='';$topic_id22='';
                                /*=====================================Check Existing Courses=========================================*/
								
								"<br/>". $select_product_cat= "select category_name,service_category_id from service_category where category_name='".trim($data->sheets[0]['cells'][$i][4])."'  ";
                                $ptr_product_cat= mysql_query($select_product_cat);
								if(mysql_num_rows($ptr_product_cat) =='' || mysql_num_rows($ptr_product_cat) ==0)
								{
									if(trim($data->sheets[0]['cells'][$i][4]) !='')
									{
										"<br/>".$insert_cours_cat= "insert into service_category (`category_name`,`added_date`) values ('".trim($data->sheets[0]['cells'][$i][4])."','".date("Y-m-d H:i:s")."')  ";
                                		$ptr_cat= mysql_query($insert_cours_cat);
										$cat_id=mysql_insert_id();
										
										 "<br/>Select in main- ".$select_sub_cat= "select sub_name,sub_id,category_id from service_subcategory where sub_name='".trim($data->sheets[0]['cells'][$i][5])."'  ";
                                		$ptr_sub_cat= mysql_query($select_sub_cat);
										if(mysql_num_rows($ptr_sub_cat) =='' || mysql_num_rows($ptr_sub_cat) ==0)
										{
											if(trim($data->sheets[0]['cells'][$i][5]) !='')
											{
												
												 "<br/>Insert in main".$insert_sub_cat= "insert into service_subcategory (`sub_name`,`category_id`) values ('".trim($data->sheets[0]['cells'][$i][5])."','".$cat_id."')  ";
												$ptr_sub_cat= mysql_query($insert_sub_cat);
												$sub_cat_id=mysql_insert_id();
													
												
												"<br/>".$insert_product= "insert into servies (`service_name`,`service_code`,`service_category_id`,`subcategory_id`,`service_description`,`service_time`,`product_cost`,`other_cost`,`total_cost`,`service_price`,`visit_frequency`,`notes`,`added_date`,`cm_id`) values ('".$service_name."','".$service_code."','".$cat_id."','".$sub_cat_id."','".$service_description."','".$time_to_finish."','".$product_cost."','".$other_cost."','".$total_cost."','".$service_price."','".$visit."','".$notes."','".date('Y-m-d H:i:s')."','".$cm_id."')  ";
                                				$ptr_product= mysql_query($insert_product);
												$product_id=mysql_insert_id();
												
											}
										}
										else
										{
											
												$data_sub_cat=mysql_fetch_array($ptr_sub_cat);
												"<br/> eles sub cat-  ".$insert_product= "insert into servies (`service_name`,`service_code`,`service_category_id`,`subcategory_id`,`service_description`,`service_time`,`product_cost`,`other_cost`,`total_cost`,`service_price`,`visit_frequency`,`notes`,`added_date`,`cm_id`) values ('".$service_name."','".$service_code."','".$cat_id."','".$data_sub_cat['sub_id']."','".$service_description."','".$time_to_finish."','".$product_cost."','".$other_cost."','".$total_cost."','".$service_price."','".$visit."','".$notes."','".date('Y-m-d H:i:s')."','".$cm_id."')  ";
                                				$ptr_product= mysql_query($insert_product);
												$product_id=mysql_insert_id();
												
												
										}
									}
								}
								else
								{
									$data_product_cat=mysql_fetch_array($ptr_product_cat);
									
									 "<br/>sel sub cat- ".$select_subcat_id= "select sub_name,sub_id,category_id from service_subcategory where sub_name='".trim($data->sheets[0]['cells'][$i][5])."' ";
									$ptr_subcat_id= mysql_query($select_subcat_id);
									if(mysql_num_rows($ptr_subcat_id) =='' || mysql_num_rows($ptr_subcat_id) ==0)
									{
										
										 "<br/>second category- ".$insert_sub_cat= "insert into service_subcategory (`sub_name`,`category_id`) values ('".trim($data->sheets[0]['cells'][$i][5])."','".$data_product_cat['service_category_id']."')  ";
										$ptr_sub_cat= mysql_query($insert_sub_cat);
										$sub_cat_id=mysql_insert_id();
										
										$insert_product= "insert into servies (`service_name`,`service_code`,`service_category_id`,`subcategory_id`,`service_description`,`service_time`,`product_cost`,`other_cost`,`total_cost`,`service_price`,`visit_frequency`,`notes`,`added_date`,`cm_id`) values('".$service_name."','".$service_code."','".$data_product_cat['service_category_id']."','".$sub_cat_id."','".$service_description."','".$time_to_finish."','".$product_cost."','".$other_cost."','".$total_cost."','".$service_price."','".$visit."','".$notes."','".date('Y-m-d H:i:s')."','".$cm_id."')  ";
										$ptr_product= mysql_query($insert_product);
										$product_id=mysql_insert_id();
										
										
									}
									else
									{
										$data_subcat_id=mysql_fetch_array($ptr_subcat_id);
										
										$insert_product= "insert into servies (`service_name`,`service_code`,`service_category_id`,`subcategory_id`,`service_description`,`service_time`,`product_cost`,`other_cost`,`total_cost`,`service_price`,`visit_frequency`,`notes`,`added_date`,`cm_id`) values('".$service_name."','".$service_code."','".$data_product_cat['category_id']."','".$data_subcat_id['sub_id']."','".$service_description."','".$time_to_finish."','".$product_cost."','".$other_cost."','".$total_cost."','".$service_price."','".$visit."','".$notes."','".date('Y-m-d H:i:s')."','".$cm_id."')  ";
										$ptr_product= mysql_query($insert_product);
										$product_id=mysql_insert_id();
										
										
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
<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>


  
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