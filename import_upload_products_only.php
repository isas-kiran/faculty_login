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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
	$admin_ids=$_POST['admin_id'];
	if($_SESSION['type']=='S')
	{
		$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
		$ptr_branch=mysql_query($sel_branch);
		$data_branch=mysql_fetch_array($ptr_branch);
		$cm_id=$data_branch['cm_id'];
		$admin_id=$admin_ids;
	}	
	else
	{
		$branch_name1=$_SESSION['branch_name'];
		$cm_id=$_SESSION['cm_id'];
		$admin_id=$_SESSION['admin_id'];
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
					for($i=2;$i<=$data->sheets[0]['numRows'];$i++)
					{
						"<br/>product_name:".$product_name=trim($data->sheets[0]['cells'][$i][2]);
						"<br/>product_code:".$product_code=trim($data->sheets[0]['cells'][$i][3]);
						"<br/>product_category:".$product_category=trim($data->sheets[0]['cells'][$i][4]);
						"<br/>product_sub-category:".$product_subcategory=trim($data->sheets[0]['cells'][$i][5]);
						"<br/>product_description:".$product_description=trim($data->sheets[0]['cells'][$i][6]);
						"<br/>size:".$size=trim($data->sheets[0]['cells'][$i][7]);
						"<br/>unit:".$unit=trim($data->sheets[0]['cells'][$i][8]);
						"<br/>commision:". $commission=trim($data->sheets[0]['cells'][$i][9]);
						"<br/>price:". $price=trim($data->sheets[0]['cells'][$i][10]);
						"<br/>brand:". $brand=trim($data->sheets[0]['cells'][$i][11]);
						"<br/>vendor:". $vendor=trim($data->sheets[0]['cells'][$i][12]);
						"<br/>type:". $type=trim($data->sheets[0]['cells'][$i][13]);
						"<br/>quantity:". $quantity=trim($data->sheets[0]['cells'][$i][14]);
						$cat_id='';  
						/*$course_id='';$course_id1='';
						$subject_id='';$subject_id1='';$subject_id12='';
						$topic_id='';$topic_id1='';$topic_id2='';$topic_id22='';*/
						
						/*=====================Check Existing Courses==============================*/
						/*$select_product_cat= "select pcategory_name,pcategory_id from product_category where pcategory_name='".trim($data->sheets[0]['cells'][$i][4])."' and cm_id='".$cm_id."' and admin_id='".$admin_id."'  ";
						$ptr_product_cat= mysql_query($select_product_cat);
						if(mysql_num_rows($ptr_product_cat) =='' || mysql_num_rows($ptr_product_cat) ==0)
						{
							//if(trim($data->sheets[0]['cells'][$i][4]) !='')
							//{
								$insert_cours_cat= "insert into product_category (`pcategory_name`,`added_date`,`cm_id`,`admin_id`) values ('".trim($data->sheets[0]['cells'][$i][4])."','".date("Y-m-d H:i:s")."','".$cm_id."','".$admin_id."')  ";
								$ptr_cat= mysql_query($insert_cours_cat);
								$cat_id=mysql_insert_id();
								
								$select_sub_cat= "select sub_name,sub_id,pcategory_id from product_subcategory where sub_name='".trim($data->sheets[0]['cells'][$i][5])."' and cm_id='".$cm_id."' and admin_id='".$admin_id."'  ";
								$ptr_sub_cat= mysql_query($select_sub_cat);
								if(mysql_num_rows($ptr_sub_cat) =='' || mysql_num_rows($ptr_sub_cat) ==0)
								{
									//if(trim($data->sheets[0]['cells'][$i][5]) !='')
									//{
										$insert_sub_cat= "insert into product_subcategory (`sub_name`,`pcategory_id`,`cm_id`,`admin_id`) values ('".trim($data->sheets[0]['cells'][$i][5])."','".$cat_id."','".$cm_id."','".$admin_id."')  ";
										$ptr_sub_cat= mysql_query($insert_sub_cat);
										$sub_cat_id=mysql_insert_id();
										$vendor_id='';*/
										/*$sel_vendor="select vendor_id from vendor where name='".$vendor."' and cm_id='".$cm_id."' ";
										$ptr_vendor=mysql_query($sel_vendor);
										$vendor_id='';
										if(mysql_num_rows($ptr_vendor) =='' || mysql_num_rows($ptr_vendor) ==0)
										{
											$ins_vendor="insert into vendor (`name`,`added_date`,`cm_id`) values ('".$vendor."','".date('Y-m-d')."','".$cm_id."')";
											$ptr_vendors=mysql_query($ins_vendor);
											$vendor_id=mysql_insert_id();
											
											$ins_into_vendor=" insert into product_vendor_map (`product_id`,`vendor_id`) values('".$product_id."','".$vendor_id."')";
											$ptr_vendor_map=mysql_query($ins_into_vendor);
										}
										else
										{
											$data_vendor=mysql_fetch_array($ptr_vendor);
											$vendor_id=$data_vendor['vendor_id'];
											
											$ins_into_vendor=" insert into product_vendor_map (`product_id`,`vendor_id`) values('".$product_id."','".$data_vendor['vendor_id']."')";
											$ptr_vendor=mysql_query($ins_into_vendor);
										}*/
										
										echo "<br/>".$insert_product= "insert into product (`product_name`,`product_code`,`pcategory_id`,`sub_id`,`description`,`size`,`unit`,`commission`,`price`,`type`,`quantity`,`brand`,`added_date`,`cm_id`,`vender`,`admin_id`) values ('".$product_name."','0','0','0','','0','0','0','0','','".$quantity."','','".date('Y-m-d H:i:s')."','".$cm_id."','0','".$admin_id."')  ";
										$ptr_product= mysql_query($insert_product);
										$product_id=mysql_insert_id();
									//}
								/*}
							//}
						}
						else
						{
							echo'<br/> Not Updated';
						}*/
						/*=========================End Course==============================*/		
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
<?php 
if($_SESSION['type']=='S')
{
	?>
	  <tr>
		<td>Select Staff</td>
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
            echo ' <select id="admin_id" name="admin_id">';
            $sle_name="select admin_id,name from site_setting ".$_SESSION['where_cm_id'].""; 
            $ptr_name=mysql_query($sle_name);
            while($data_name=mysql_fetch_array($ptr_name))
            {
                $selected='';
                if($data_name['admin_id'] == $row_record['employee_id'])
                {
                    $selected='selected="selected"';
                }
                 echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
            }
            echo '</select>';
            echo "</td></tr></table>";
            ?>
		</td>
	</tr>
	<?php }  
	else { ?>
	   <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_SESSION['admin_id']; ?>"  /> 
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