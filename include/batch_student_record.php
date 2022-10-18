<?php  include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Email Details</title>

<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?> 

    <link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<style>
.tale td{border:1px solid #dddddd !important; height:30px}
</style>

    
  
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
}
?>
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
               
 <tr>
 <td class="mid_left" align="center"></td>
   
 <?php if($_SESSION['type']=='S') {?><td class="mid_mid" ><a href="student_attedance_excel.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a> </td><?php } ?>
	<td class="mid_right" > </td>
   <!-- <a href="excel.php?<?php //echo 'enroll_id='.$_GET['enroll_id'].'&todo='.$_GET['todo'].'&year='.$_GET['year'].'&month='.$_GET['month'].''; ?>"><img src="images/excel.png" height="50px" width="50px"/></a>-->
   </tr>     
<table cellspacing="0" cellpadding="0" class="table" width="90%">
<tr class="head_td">
<?php 
    $sql_employee_name= "SELECT * FROM  enrollment where enroll_id='".$_GET['enroll_id']."' ";
	$employee=mysql_query($sql_employee_name);
	$fetch_array=mysql_fetch_array($employee);

	$sql_batch= "select * FROM  student_course_batch_map where enroll_id='".$_GET['enroll_id']."' and c_b_id='".$_GET['c_b_id']."' ";
	$batch=mysql_query($sql_batch);
	$fetch_batch=mysql_fetch_array($batch);

	$select_cb = "select * from course_batch_mapping where c_b_id='".$_GET['c_b_id']."'";
						$ptr_cb = mysql_query($select_cb);
						$data_cb = mysql_fetch_array($ptr_cb);

	$sel_staff="select name from site_setting where admin_id='".$data_cb['staff_id']."'";
	$ptr_staff=mysql_query($sel_staff);
	$data_staff=mysql_fetch_array($ptr_staff);
	
	$sel_course="select course_name from courses where course_id='".$data_cb['course_id']."'";
	$ptr_course=mysql_query($sel_course);
	$data_course=mysql_fetch_array($ptr_course);
	
	echo '<td font-size:15px; margin-left:120px>Student Name:</td> <td style=" font-size:15px; color:blue; text-align:left; margin-left:120px">&nbsp; '.$fetch_array['name'].'</td>';
	echo ' <td font-size:15px; margin-left:120px>Mail Id:</td> <td style=" font-size:15px; color:blue; text-align:left; margin-left:120px">&nbsp; '.$fetch_array['mail'].'</td>';
	echo ' <td font-size:15px; margin-left:120px>Batch:</td> <td style=" font-size:15px; color:blue; text-align:left; margin-left:120px">'.$data_cb['batch_name'].'&nbsp;&nbsp;('.$data_course['course_name'].')&nbsp;&nbsp;</td><td font-size:15px; margin-left:120px> From :</td> <td style=" font-size:15px; color:blue; text-align:left; margin-left:120px">'.$data_cb['start_date'].'</td> <td font-size:15px; margin-left:120px> To :</td> <td style=" font-size:15px; color:blue; text-align:left; margin-left:120px"> '.$data_cb['end_date'].'</td>';
	
    ?>
</tr>
 <tr class="head_td">
    <td colspan="12">
       <form method="get" name="f1" >
        
        <input type="hidden" name="enroll_id" value="<?php echo $_GET['enroll_id'] ?>">
        <input type="hidden" name="c_b_id" value="<?php echo $_GET['c_b_id'] ?>">
        <input type="hidden" name="todo" value="submit">
		<table cellspacing="0" cellpadding="0" width="99%" align="center">
            <tr>
                <td class="width5"></td>
                <td width="20%"> 
                    <?php
                    // set start and end year range
                    $yearArray = range(2015, date('Y'));
                    ?>

                    <select name="year" required>
                        <option value="">Select Year</option>
                        <?php
                        foreach ($yearArray as $year) 
                        {   
                                    
                            // if you want to select a particular year
                            
                            $selected= ($year == $_GET['year']) ? 'selected' : '';
                            echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
                        }
                        ?>
                        </select>
                    </td>

                    <td width="20%">
                    <?php
                    $monthArray = range(1, 12);
                    ?>
                    <select name="month" required>
                        <option value="">Select Month</option>
                        <?php
                        
                        foreach ($monthArray as $month)
                        {
                            // padding the month with extra zero
                            $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
                            // you can use whatever year you want
                            // you can use 'M' or 'F' as per your month formatting preference
                            $fdate = date("F", strtotime("".date('Y')."-$monthPadding-01"));
                            $sele='';
                            if($monthPadding == $_GET['month'])
                            {
                                $sele='selected="selected"';
                            }
                            $selected = ($monthPadding == $_GET['month'] || $monthPadding==date('m')) ? 'selected' : '';
                            echo '<option '.$sele.' value="'.$monthPadding.'">'.$fdate.'</option>';
                        }
                        ?>
                    </select></td>

                    <td>
                        <select name="Pre" id="Pre">
                        <option <?php 'selected="selected"'; ?> value="present"<?php if($_GET['Pre']=="present") echo 'selected="selected"'; ?>>Present</option>
                        <option <?php 'selected="selected"'; ?>value="absent"<?php if($_GET['Pre']=="absent") echo 'selected="selected"'; ?>>Absent</option>
                        <option <?php 'selected="selected"'; ?> value="all"<?php if($_GET['Pre']=="all") echo 'selected="selected"'; elseif($_GET['Pre']=="") echo 'selected="selected"'; ?>>All</option>
                        </select>

                    </td>
                    <td>
                        <input type="submit" value="Search" name="search"></td>
                    <td>

                    <?php

                    /*if($_GET['year'])
                    $conss =" and (report_date between '".$_GET['year']."-".$_GET['month']."-1' and '".$_GET['year']."-".$_GET['month']."-30' )";
                    else
                        $conss =" and (report_date between '".date('Y')."-".date('m')."-1' and '".date('Y')."-".date('m')."-30' )";
                    $sql_query1= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' $conss and faculty_sign='absent' ";  
                        $query1 = mysql_query($sql_query1);
                        if(mysql_num_rows($query1))
                        {*/
                    ?>
                    <!--<a href="#" onclick="redirects();">view email</a>-->
                    <?php
                        //}
                    ?>
    </td>
    <?php

            $sql_query1= "SELECT attendence_date FROM student_attendence  ";  
                    
            $quer = mysql_query($sql_query1);
            $fetch=mysql_fetch_array($quer);
            
            $sep=explode("-",$fetch['attendence_date']);
                $result=$sep[0].'-'.$sep[1];
                
                    echo  "<table cellspacing='0' cellpadding='0' class='tale' width='100%' align='center'><tr class='grey_td' >

                    <td width='10%' align='center'>".'<strong>Date</strong>'." </td>
                    
					<td width='10%' align='center'>".'<strong>Status</strong>'."</td>
					<td width='8%' align='center'>".'<strong>Uniform</strong>'."</td>
					<td width='8%'  align='center'>".'<strong>LateMark</strong>'."</td>
					<td width='8%'  align='center'>".'<strong>Mobile Submit</strong>'."</td>
					<td width='12%' align='center'>".'<strong>SMS & Mail</strong>'."</td>

					</tr>";
				
		   ?>
             
                
          <!---------------------------------------------------------------------------------------------------------------------> 
 <?php

 $todo=$_GET['todo'];
$enroll_id=$_GET['enroll_id'];



if($_GET['year'].'-'.$_GET['month'])
{
	$number = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']); // 31
	//echo "There were {$number} days in ".$_GET['month']." 2003";
	for($i = 1; $i <=  $number; $i++)
	{   
 		$dates[] =  str_pad($i, 2, '0', STR_PAD_LEFT);
 	}
	$total_found =0;	
	$not_found=0;
	$x=0; 
	$y=0;
        $z=0;
		$k=0;
	/*if($_GET['year'].'-'.$_GET['month'])
	{
	 echo $sql_query= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and `repeated` like '".$date."%' 
	 and faculty_sign='absent' ";  
	$query= mysql_query($sql_query);
	
	}f
	}
	}*/
	//echo "<br/>".$number;
	for($i=1;$i<$number;$i++)
	{
		 if($i<=9)
	    {
		 $a=0;
		 $i=$a.$i;
	     }
		if($_GET['Pre'] !="")
		{
			if($_GET['Pre']=='all')
	   		{
				 $sele_all="select * from student_attendence where enroll_id='".$_GET['enroll_id']."' and course_batch_id='".$_GET['c_b_id']."' and `attendence_date` like '".$_GET['year']."-".$_GET['month']."-".$i."' ";
		        
	    	}
			else
			{
				 $sele_all= "select * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and course_batch_id='".$_GET['c_b_id']."' and attendence='".$_GET['Pre']."' and `attendence_date` like '".$_GET['year']."-".$_GET['month']."-".$i."'";  
	
			}
			$query=mysql_query($sele_all);
			if($total_rows=mysql_num_rows($query))
			{
                $array=mysql_fetch_array( $query);
                
                $new_date= explode('-',$array['attendence_date'],3); 
                $date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
				
				echo '<tr>
				<td align="center">' .$date_email. '</td>';
				if($array['attendence']=="present")
				{
					echo '<td align="center"><span style="background-color:green;padding:7px;">Present</span></td>';
					$total_found++;
					$x=$x+1;
				}
				else
				{
					echo '<td align="center"><span style="background-color:red;padding:7px;">Absent</span></td>';
					$not_found++;
					$y=$y+1;
				}

				?>
		<td align="center"><?php if($array['uniform'] =="no"){?><img src="images/index.png" height="30px" width="30px"/><?php }else{?><img src="images/nouniform.png" height="30px" width="30px"/><?php }?> </td>
		<td align="center"><?php if($array['latemark'] =="no"){?><img src="images/latemark.jpg" height="30px" width="30px"/><?php }else{?><img src="images/nolatemark.jpg" height="30px" width="30px"/><?php }?>  </td>
		<td align="center"><?php if($array['mobile_submit'] =="no") {?><img src="images/nomob.jpg" height="30px" width="30px"/><?php }else{?><img src="images/mob.png" height="30px" width="30px"/><?php }?> </td>
					
		<?php if($array["sms_send"] =="yes"){?>
			<td align="center">YES</td>
		<?php }else{?>
			<td align="center">NO</td>
		<?php }?>
				
		<?php
				
				echo '</tr>';
				
				
			}
			  if($total_found==0 && $not_found==0 && $number-1==$i)
			{
			
                echo "<tr><td colspan='2' align='center'><strong>Record Not Found</strong></td></tr>";

			}
				//echo "<br/>-- ".$number."---".$i;
			if($x>0 && $number-1==$i)
			{
	 
				echo "<tr><td colspan='12' align='center'>
		   <table width='100%' class='tale'  style='font-weight:bold;'>
		   <tr>
		   <td colspan='6' width='50%' align='center'>No. OF Days Present</td>               
		    <td align='center'>".$total_found."</td></tr>
		   
		   
		   </table></td></tr>";
	
			}
			if($y>0 && $number-1==$i)
			{
				//echo $number;
				echo "<tr><td colspan='12' align='center'>
				<table width='100%' class='tale'  style='font-weight:bold;'><tr><td colspan='6' width='50%' align='center'>No. OF Days Absent</td>								            <td align='center'>".$not_found."</td></tr>
   
				</table></td></tr>";
			}
			
	 	}
	}
}
	if($_GET['Pre']=="")
	{

    $sql_query= "select * FROM student_attendence where enroll_id='".$_GET['enroll_id']."'  and course_batch_id='".$_GET['c_b_id']."' ";  
	$qu = mysql_query($sql_query);
	
	while($array=mysql_fetch_array( $qu))
	{
		
            $new_date= explode('-',$array['attendence_date'],3); 
        $date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
	 
		echo '<tr>
	  	<td align="center">' .$date_email. '</td>';
	  	if(mysql_num_rows($qu))
	   	{
			if($array['attendence']=="present")
			{
				
			echo '<td align="center"><span style="background-color:green;padding:7px;">Present</span></span></td>';
			$total_found++;
			}
	   	    if($array['attendence']=="absent")
	      {
			//$x= $x+1;
	    	echo '<td align="center"><span style="background-color:red;padding:7px;">Absent</span></td>';
	    	$not_found++;
	      }
		}
		
		?>
		<?php if($array['attendence']=="present")
			{ ?>
		<td align="center"><?php if($array['uniform'] =="no"){?><img src="images/index.png" height="30px" width="30px"/><?php }else{?><img src="images/nouniform.png" height="30px" width="30px"/><?php }?> </td>
		<td align="center"><?php if($array['latemark'] =="no"){?><img src="images/latemark.jpg" height="30px" width="30px"/><?php }else{?><img src="images/nolatemark.jpg" height="30px" width="30px"/><?php }?>  </td>
		<td align="center"><?php if($array['mobile_submit'] =="no") {?><img src="images/nomob.jpg" height="30px" width="30px"/><?php }else{?><img src="images/mob.png" height="30px" width="30px"/><?php }?> </td>
		<?php	} ?>

		<?php if($array['attendence']=="absent")
			{ ?>
		<td align="center"><img src="images/reduni.png" height="30px" width="30px"/> </td>
		<td align="center"><img src="images/late.png" height="30px" width="30px"/></td>
		<td align="center"><img src="images/redmob.png" height="30px" width="30px"/></td>
		<?php	} ?>

		<?php if($array["sms_send"] =="yes"){?>
			<td align="center">YES</td>
		<?php }else{?>
			<td align="center">NO</td>
		<?php }?>
				
		<?php
		echo'</td>';
	    echo '</tr>';
		//echo "";
	}
	echo "<tr><td colspan='12' align='center'>
		   <table width='100%' class='tale'  style='font-weight:bold;'>
		   <tr>
		   <td colspan='6' width='50%' align='center'>No. OF Days Present</td>               
		    <td align='center'>".$total_found."</td></tr>
		   <tr>
		   <td colspan='6' width='50%' align='center'>No. OF Days Absent</td>
		   <td align='center'>".$not_found."</td>
		   </tr>
		   
		   </table></td></tr>";
	
	}

	


$month=$_GET['month'];

$dt=$_GET['dt'];

$year=$_GET['year'];

 $date_value="$month/$year";


$date_value="$year-$month";
?></table>
          
         

          
                                 
           <!---------------------------------------------------------------------------------------------------------------------> 
                
            </tr>
        </table>
        </form>	
    </td>
  </tr>

 
            <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
              <?php
				if(!$_GET['todo'] && !$_GET['year'] && !$_GET['month'])	
                     {	
						?>
                        <table cellspacing="0" cellpadding="0" class="tale" width="90%" align="center">
  <tr class="grey_td" >
   
    
    
	
     
  
  </tr>
  
<?php


		
 
echo '<tr>';



 $number = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); // 31
//echo "There were {$number} days in August 2003";

//select * from student_attendence where 
			
// for($i = 1; $i <=  $number; $i++)
// {
//    // add the date to the dates array
//   // echo "hi";
//    $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
// }

 
		  
// $t=0;	
// $total_found =0;	
// $not_found=0; 
// foreach($dates as $date)
// {
// 	$array[$t];
// 	$explode_date = explode(' ', $array[$t]);
	
// 	$sql_query= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and course_batch_id='".$_GET['c_b_id']."' and `attendance_date` like '".$date."%' and stud_status='absent' ";  
// 	$query2 = mysql_query($sql_query);
// 	//echo '<br/>'.$date;
// 	$new_date= explode('-',$date,3); 
// 	$date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
	
// 	if($array['attendance_date'] != "")
// 	{
//       	echo '<tr><td align="center">' .$date_email. '</td>';
// 	  	if(mysql_num_rows($query2))
// 		{
// 			echo '<td align="center">Absent '.$array['repeated'].'<span style="padding-left:10%"></span></td>';
// 			$total_found++;
// 	   	}
// 		else
// 	  	{
// 	 		echo '<td align="center">Present</td>';
// 	 		$not_found++;
// 	  	}
// 		echo '</tr><tr>';
// 		// echo '<tr><td align="center">' .$date_email. '</td>';
// 		echo '</tr>';	
// 		echo "<tr><td colspan='2' align='center'>
// 		<table width='100%' class='tale'  style='font-weight:bold;'>
// 		<tr><td  width='50%' align='center'>Total Days </td><td align='center'>".$number."</td></tr>
// 		<tr><td align='center'>No. OF Days Absent</td><td align='center'>".$total_found."</td></tr>
// 		</table></td></tr>";
//     	$t++;	
//   }
// }

	
	
}

	?>
            
            
 
 </table>       </form>
 </table>        
         
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

<?php include "include/footer.php"; ?>

<!--footer end-->
</body>
</html>
