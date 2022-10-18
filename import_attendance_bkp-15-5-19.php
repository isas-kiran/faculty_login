<?php 
ini_set('max_execution_time', 300);
include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import Attendance</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
 <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
        {
			$("#year").chosen({allow_single_deselect:true});
			$("#month").chosen({allow_single_deselect:true});
			
			<?php 
			if($_SESSION['type']=="S")
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
		});
	</script>     
	 
  <script type="text/javascript">
         function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }
            document.getElementById('formAction').value=action;
            if(action=="delete")
            {

                if(confirm("Are you sure, you want to delete selected record(s)?"))

                    document.frmTakeAction.submit();

                else

                {

					//alert("hi");

                    $('#selAction').val('');

                    return false;

                }

            }

            else

                document.frmTakeAction.submit();

        }

        function redirect1(value,value1)

        {           

            //alert(value);

           // alert(value1);

            window.location.href=value+value1;

        }

        function validationToDelete(type)

        {

            if(confirm("Are you sure, you want to delete selected record(s)?"))

                return true;

            else

                return false;

        }

    </script>         

<?php
if(isset($_POST['import_excel']))
{
	$branch_name=$_POST['branch_name'];
    require_once 'Excel/reader.php';
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
						$staff_id=0;
                        if(count($data->sheets[$i][cells])>0) // checking sheet not empty
                        {
                            echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
                             $n=1;
                            for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
                            {
                                $html.="<tr>";
								// echo "rows>>>>>>>>>>".count($data->sheets[$i][cells][$j]);
								// for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
								//{
								$html.="<td>";
								$html.='R=>'.$j.'C=>'.$k.' .. '. $data->sheets[$i][cells][$j][$k];
								$html.="</td>";
								$total_month=$_REQUEST['no_of_days'];
								
								$month=$_REQUEST['month'];
								$year=$_REQUEST['year'];
								//echo "j=".$j." k=".$k."n=".$n;
								//$k=$j;
								if($j==1 || (($k-$n)%$total_month)==0)
								{
									if($j==1)
									{$k=$j;}
									else
									{$j=$k;}
								
								     "<br />staff_id: ".$staff_id=$data->sheets[0]['cells'][$k][3];
									//$sep=explode(" ",$data->sheets[0]['cells'][$k][2]);
									//"<br />staff_id: ".$staff_id=$sep[3];
									$j++;$k++;
								}
								//echo $data->sheets[0]['numRows'];	
								for($k=$j;$k<($j+$total_month);$k++)
								{
									// echo "<br />sr_no:".$sr_no=$data->sheets[0]['cells'][$i][1];
									
									 "<br />date:".$date=$data->sheets[0]['cells'][$k][2];
									//echo "<br />shift_type:".$shift_type=$data->sheets[0]['cells'][$k][3];
									//echo "<br />shift_time:". $shift_time=$data->sheets[0]['cells'][$k][4];
									 "<br />punch_in:".$punch_in=$data->sheets[0]['cells'][$k][3];
									 "<br />punch_out:".$punch_out=$data->sheets[0]['cells'][$k][4];
									 "<br />toal_hrs:".$toal_hrs=$data->sheets[0]['cells'][$k][5];
									 "<br />extra_hrs:". $extra_hrs=$data->sheets[0]['cells'][$k][6];
									//echo "<br />attendance:". $attendance=$data->sheets[0]['cells'][$k][9];
									 "<br />full_day:". $full_day=$data->sheets[0]['cells'][$k][7];
									 "<br />Half_Day:". $Half_Day=$data->sheets[0]['cells'][$k][8];
									 "<br />Quarter:". $quarter_day=$data->sheets[0]['cells'][$k][9];
									 "<br />one third:". $one_third=$data->sheets[0]['cells'][$k][10];
									 "<br />two trird:". $two_third=$data->sheets[0]['cells'][$k][11];
									 "<br />over 1.25 :". $over1=$data->sheets[0]['cells'][$k][12];
									 "<br />over 1.5:". $over2=$data->sheets[0]['cells'][$k][13];
									 "<br />over 2:". $over3=$data->sheets[0]['cells'][$k][14];
									 "<br /> Day Total:". $day_total=$data->sheets[0]['cells'][$k][15];
									 "<br />Total Till date:". $total_till_date=$data->sheets[0]['cells'][$k][16];
									 "<br />Late Marks:". $late_marks=$data->sheets[0]['cells'][$k][17];
									// "<br />Extra Days:". $extra_days=$data->sheets[0]['cells'][$k][18];
									
									if($full_day==''){ $full_day=0;	} else { $full_day=$full_day; }
									if($Half_Day==''){ $Half_Day=0;	} else { $Half_Day=$Half_Day; }
									if($quarter_day==''){ $quarter_day=0;	} else { $quarter_day=$quarter_day; }
									if($one_third==''){ $one_third=0;	} else { $one_third=$one_third; }
									if($two_third==''){ $two_third=0;	} else { $two_third=$two_third; }
									if($over1==''){ $over1=0;	} else { $over1=$over1; }
									if($over2==''){ $over2=0;	} else { $over2=$over2; }
									if($over3==''){ $over3=0;	} else { $over3=$over3; }
									if($day_total==''){ $day_total=0;	} else { $day_total=$day_total; }
									if($total_till_date==''){ $total_till_date=0;	} else { $total_till_date=$total_till_date; }
									if($late_marks==''){ $late_marks=0;	} else { $late_marks=$late_marks; }
									//if($extra_days==''){ $extra_days=0;	} else { $extra_days=$extra_days; }
									
									//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
							{
								 $sel_branch="select cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
							    $cm_id=$data_branch['cm_id'];
								$branch_name=$data_branch['branch_name'];
								
							}	
							else
							{
								$cm_id=$_SESSION['cm_id'];
								$branch_name=$_SESSION['branch_name'];
							}
							$admin_id=$_SESSION['admin_id'];
							//====================================================================
							$insert= "insert into pr_import_attendance (`staff_id`,`month`,`branch_name`,`year`,`days`,`date`,`punch_in`,`punch_out`,`total_hrs`,`extra_hrs`,`full_day`,`half_day`,`quarter_day`,`one_third`,`two_third`,`over1`,`over2`,`over3`,`day_total`,`total_till_date`,`file_name`,`late_marks`,`cm_id`,`admin_id`) values ('".$staff_id."','".$month."','".$branch_name."','".$year."','".$total_month."','".trim($data->sheets[0]['cells'][$k][2])."','".trim($data->sheets[0]['cells'][$k][3])."','".trim($data->sheets[0]['cells'][$k][4])."','".trim($data->sheets[0]['cells'][$k][5])."','".trim($data->sheets[0]['cells'][$k][6])."','".trim($data->sheets[0]['cells'][$k][7])."','".trim($data->sheets[0]['cells'][$k][8])."','".trim($data->sheets[0]['cells'][$k][9])."','".trim($data->sheets[0]['cells'][$k][10])."','".trim($data->sheets[0]['cells'][$k][11])."','".trim($data->sheets[0]['cells'][$k][12])."','".trim($data->sheets[0]['cells'][$k][13])."','".trim($data->sheets[0]['cells'][$k][14])."','".trim($data->sheets[0]['cells'][$k][15])."','".trim($data->sheets[0]['cells'][$k][16])."','".$filename."','".$late_marks."','".$cm_id."','".$admin_id."')";
							$ptr_certificate= mysql_query($insert);
							$ins_no=mysql_num_rows();
							
							$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Import_attendence','Import','attendence sheet','".$ins_no."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
    						/*===================End Course=======================*/		
							$html.="</tr>";
						}//for loop for total numrows
						$n++;
					   // }//End loop - to get data in a table format.
					}//loop used to get each row of the sheet
                }//checking sheet not empty
            }//Loop To Get To all Sheet- echo $html;
                     $html="</table>";
}                   

?>


<form method="post" enctype="multipart/form-data">
<table align="center" style="margin-top:80px;">


<tr>

<?php if($_SESSION['type']=='S')
{
?>
	<td width="10%">Select Branch<span class="orange_font">*</span></td>
	<td width="15%">
	<?php 
	if($_REQUEST['record_id'])
	{
		$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
		$ptr_query=mysql_query($sel_cm_id);
		$data_branch_nmae=mysql_fetch_array($ptr_query);
	}
	$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
	$query_branch = mysql_query($sel_branch);
	$total_Branch = mysql_num_rows($query_branch);
	echo '<table width="100%"><tr><td>'; 
	echo '<select style="width:100%;" id="branch_name" name="branch_name" onChange="getmonthdays()">';
	echo '<option value="">Select Branch</option>';
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
	
	<?php
}  
else 
{ 
	?>
	<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"/> 
   <?php 
}?>

 <td style="padding-left:20px;">
<?php 

echo 'Select Year<span class="orange_font">*</span></td><td style="padding-left:20px;">';
$nxt=date('Y')-1;
$yearArray = range($nxt, 2030);
echo ' <select required id="year" name="year" style="width:100px;" onChange="getmonthdays();">';
					
?>
    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
       // $selected = ($year == 2018) ? 'selected' : '';
	   
	   ?><option <?php if($year==$_REQUEST['year']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php
    }
    ?>
</select>
						<?php
						
						?> 
								</td>
								
								<td width="12%" style="padding-left:20px;">
						<?php
						
						echo 'Select Month<span class="orange_font">*</span></td><td style="padding-right:20px;">';
						$monthArray = range(1, 12);
						$currentMonth =date('Y').'-'.date('m').'-01';
                        $prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
						 $prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
						echo ' <select required id="month" name="month" onChange="getmonthdays(this.value);">';
					?>
    <option value="<?php echo $prv_month1; ?>"><?php echo $prv_month; ?></option>
    <?php
    foreach ($monthArray as $month) {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("F", strtotime("2015-$monthPadding-01"));
	
        ?><option <?php if($month==$_REQUEST['month']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
   <?php }
    ?>
</select>
</td>

              
               


             <td><b>Import excel file</b> </td>
             <td>
            <?php
           
         
                echo '<input type="file" onChange="getmonthdays();" name="excel_file" id="excel_file" class=" input_text"></td>';
            ?>
             </td>
			
			   <td>
			 
			 <input  type="hidden" id="no_of_days" name="no_of_days" value="" />
			 <input style="margin-left: -10px;"  type="submit" class="input_btn" name="import_excel" id="save_changes" value="save" /></td>
			 
			 </tr>
            

             </table>
             </form>
            <hr style="color:#F1EFF0;margin:10px;">
 <table align="center" border="1" style="border-collapse:collapse;">
<tr><td colspan="3"><h2>Download Formats: </h2></td></tr>
<tr><td><center><a href="final.xls"><u>DownLoad Excel</u></a></center></td></tr>



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
<!-- List view Start -->

<div id="right_info">

<table border="0" cellspacing="0" cellpadding="0" width="100%">

 
<?php if($_POST['formAction'])

                    {

                        if($_POST['formAction']=="delete")
                        {
							
						
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
								$ds=$_POST['chkRecords'][$r];
								$val=explode('-',$ds);
								$del_record_id=$val[0];
								$month=$val[1];
								$year=$val[2];
								$sql_query= "SELECT month,year FROM ".$GLOBALS["pre_db"]."pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$month."' AND year='".$year."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                {
									"<br>".$sql_query= "SELECT * FROM pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$month."' AND year='".$year."'";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);       
									                                     
                                    $delete_query="delete from ".$GLOBALS["pre_db"]."pr_import_attendance where month='".$month."' AND year='".$year."'";
                                    $db->query($delete_query);                                                                                        
                               }
                             }
                             ?>
							<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
							<script type="text/javascript">
							// $("#statusChangesDiv").dialog();
								$(document).ready(function() {
									$( "#statusChangesDiv" ).dialog({
											modal: true,
											buttons: {
														Ok: function() { $( this ).dialog( "close" );}
													 }
									});
								});
							</script>
                            <?php                            

                                }                       

                     }

                    if($_REQUEST['deleteRecord'] && $_REQUEST['branch_name'])
                    {
                        $del_record_id=$_REQUEST['branch_name'];
                        $sql_query= "SELECT year,month FROM ".$GLOBALS["pre_db"]."pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$sql_query= "SELECT * FROM pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."'";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
								
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                        
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."pr_import_attendance where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."'";
                        	$db->query($delete_query);

                            ?>

                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>

                            <script type="text/javascript">

                            // $("#statusChangesDiv").dialog();

                                $(document).ready(function() {

                                    $( "#statusChangesDiv" ).dialog({

                                            modal: true,

                                            buttons: {

                                                        Ok: function() { $( this ).dialog( "close" );}

                                                     }

                                    });

                                });

                            </script>

                            <?php

                        }

                    }

                    ?>

  <tr>

    <td class="mid_left"></td>

    <td class="mid_mid" align="center">

        

<table cellspacing="0" cellpadding="0" class="table" width="95%">

  <tr class="head_td">

    <td colspan="16">

        <form method="get" name="search">

	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">

              <tr>

                <td class="width5"></td>

                <td width="20%">

                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">

                                <option value="">-Operation-</option>

                                <option value="delete">Delete</option>

                        </select>

                </td>

                

                <td class="rightAlign" > 

                    <table border="0" cellspacing="0" cellpadding="0" align="right">

              <tr>

              <td></td>

              <td class="width5"></td>

                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>

                <td class="width2"></td>

                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>

              </tr>

                    </table>	

                </td>

            </tr>

        </table>

        </form>	

    </td>

  </tr>

    

    

    <?php

                        if($_REQUEST['keyword']!="Keyword")

                            $keyword=trim($_REQUEST['keyword']);

                        if($keyword !='')

                            {                            

                               $pre_keyword="and (branch_name like '%".$keyword."%' or  month like '%".$keyword."%' or  year like '%".$keyword."%' )";

                            }                            

                        else

                            {$pre_keyword="";}

                        

                        if($_REQUEST['free_course'])

                             $course_keyword="  and type ='".$_REQUEST['free_course']."'";

                            else 

                             $course_keyword="";

						 if($_REQUEST['branch_name'])

                             $branch_keyword="  and branch_name ='".$_REQUEST['branch_name']."'";

                            else 

                             $branch_keyword="";

                        if($_REQUEST['page'])

                            $page=$_REQUEST['page'];

                        else

                            $page=0;

                        

                        if($_REQUEST['show_records'])

                            $show=$_REQUEST['show'];

                        else

                            $show=0;



                        if($_GET['order']=='asc')

                        {

                            $order='desc';

                            $img = "<img src='images/sort_up.png' border='0'>";

                        }

                        else if($_GET['order']=='desc')

                        {

                            $order='asc';

                            $img = "<img src='images/sort_down.png' border='0'>";

                        }

                        else

                            $order='desc';



                        if($_GET['orderby']=='course_name' )

                            $img1 = $img;



                        if($_GET['order'] !='' && ($_GET['orderby']=='course_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by admin_id desc';                      
							
							if($_SESSION['type']=="S")
							$type='';
							else
							$type="and type !='S'";
							$user_type="";

						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and admin_id='".$_GET['record_id']."' ";
							
						} 
						
                    	$sql_query= "SELECT DISTINCT cm_id,branch_name,month,year,file_name FROM pr_import_attendance where 1 ".$_SESSION['where']." ".$pre_keyword." order by attendance_id desc"; 
						//".$_SESSION['where_admin_id-cm_id']."
                       	//echo $sql_query;
                       	$no_of_records=mysql_num_rows($db->query($sql_query));

                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
    <input type="hidden" name="formAction" id="formAction" value=""/>
	<tr class="grey_td" >
<?php if($_SESSION['type']=='S')
	{
	?>
    <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
	<?php } ?>
    <td width="4%" align="center"><strong>Sr. No.</strong></td>
	<?php if($_SESSION['type']=='S')
							{ ?>
 <td width="10%"><strong>Branch Name</strong></td>
							<?php } ?>
    <td width="12%"><strong>Year</strong></td>

    <td width="10%"><strong>Month</strong></td>
	 <td width="10%"><strong>File Name</strong></td>
	 <?php if($_SESSION['type']=='S')
							{ ?>
<td width="7%" class="centerAlign"><strong>Action</strong></td>
	<?php } ?>
  </tr>

                            <?php



                            while($val_query=mysql_fetch_array($all_records))

                            {

                                $name = '';

                                if($bgColorCounter%2==0)

                                    $bgcolor='class="grey_td"';

                                else

                                    $bgcolor="";                

                                

                               $listed_record_id=$val_query['event_id']; 
							   $listed_record_id1=$val_query['event_id'].'-'.$val_query['month'].'-'.$val_query['year']; 
                                $select_event= "select * from pr_add_event where event_id = '".$val_query['event_id']."' ";                                           

                                $val_event = $db->fetch_array($db->query($select_event));

                                if($val_query['month']=='1'){ $month="January"; }
								if($val_query['month']=='2'){ $month="February "; }
								if($val_query['month']=='3'){ $month="March"; }
								if($val_query['month']=='4'){ $month="April"; }
								if($val_query['month']=='5'){ $month="May"; }
								if($val_query['month']=='6'){ $month="June"; }
								if($val_query['month']=='7'){ $month="July"; }
								if($val_query['month']=='8'){ $month="Auguest"; }
								if($val_query['month']=='9'){ $month="September"; }
								if($val_query['month']=='10'){ $month="October"; }
								if($val_query['month']=='11'){ $month="November"; }
								if($val_query['month']=='12'){ $month="December"; }
								
                                


                                    /*$select_name = "select * from admin_previleges where staff_id = '".$staff_id."' ";                                           

                                    while($val_name = $db->fetch_array($db->query($select_name)))

									{

									

                                        $name .=$val_name['privilege_id'].', ';

                                    }                                    

                                     $names = rtrim($name, ", ");

                                */

                                include "include/paging_script.php";

                                

                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S')
								{
									echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id1.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>'; 
							if($_SESSION['type']=='S')
							{								
									echo '<td >'.$val_query['branch_name'].'</td>';
							}
									echo '<td >'.$val_query['year'].'</td>';
									echo '<td >'.$month.'</td>';
									echo '<td><a href="excel_files/'.$val_query['file_name'].'"><u>'.$val_query['file_name'].'</u></a></td>';
									if($_SESSION['type']=='S')
							{	
									echo '<td align="center">									
									<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&branch_name='.$val_query['branch_name'].'&year='.$val_query['year'].'&month='.$val_query['month'].'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
							}
                                echo '</tr>';

                                $bgColorCounter++;

                            }

                                ?>

  <tr class="head_td">

    <td colspan="16">
	
       <table cellspacing="0" cellpadding="0" width="100%">

            <tr>

                <?php

                      if($no_of_records>10)

                            {

                                echo '<td width="3%" align="left">Show</td>

                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';

                                $show_records=array(0=>'10',1=>'20','50','100');

                                for($s=0;$s<count($show_records);$s++)

                                {

                                    if($_SESSION['show_records']==$show_records[$s])

                                        echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';

                                    else

                                        echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';

                                }

                                echo'</td></select>';

                            }

                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';

                 ?>

            </tr>

        </table>                         

    </td>

    </tr></form>

      <?php } 

      else

        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No course found related to your search criteria, please try again</div><br></td></tr>';?>

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
<!--List view end-->


</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
 <div id="footer" style="margin-top:300px;"><?php require("include/footer.php");?></div>
 <script language="javascript">

function getmonthdays(i)
{
	var year= $("#year").val();
	var i= $("#month").val();
	var month=i-1;
     var days= 32 - new Date(year, month, 32).getDate();
	 $('#no_of_days').val(days);
	 
	 var year = $("#year").val();
	var month = $("#month").val();
	var branch_name = $("#branch_name").val();	
	var ptype = 'imp_attendance';
	 $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'check_exist.php',
            data: { year: year,month:month,branch_name:branch_name,ptype:ptype },
            
        }).done(function(responseData) {
		// alert(responseData);
		if(responseData>0)
		{
			alert("Record All Ready Exist For This Selection");
			$('#month').val('');
			$('#branch_name').val('');
			$('#year').val('');
			$("#save_changes").hide();
			
		}
		else
		{			
			$("#save_changes").show();
		}
		
        }).fail(function() {
            console.log('Failed');
        });
	 
 }
<?php 
if($_SESSION['type']!="S")
{
?>
branch_name=document.getElementById['branch_name'].value;
get_staff(branch_name);
<?php
}
?>
</script>
<!--footer end-->
</body>
</html>