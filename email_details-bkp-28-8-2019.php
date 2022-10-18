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
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
              
 <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
   
    <?php 
    $sql_employee_name= "SELECT * FROM  enrollment where enroll_id='".$_GET['enroll_id']."' ";
	$employee=mysql_query($sql_employee_name);
	$fetch_array=mysql_fetch_array($employee);
	
	echo ' <p style=" font-size:15px; color:blue; text-align:left; margin-left:120px">Student Name:&nbsp; '.$fetch_array['name'].'</p>';
	//echo ' <p style=" font-size:15px; color:blue; text-align:left; margin-left:120px">Designation:&nbsp; '.$fetch_array['designation'].'</p>';
	//echo ' <p style=" font-size:15px; color:blue; text-align:left; margin-left:120px">Student Id:&nbsp; </p>';
	
    ?>
    
   <!-- <a href="excel.php?<?php //echo 'enroll_id='.$_GET['enroll_id'].'&todo='.$_GET['todo'].'&year='.$_GET['year'].'&month='.$_GET['month'].''; ?>"><img src="images/excel.png" height="50px" width="50px"/></a>-->
        
<table cellspacing="0" cellpadding="0" class="table" width="90%">


 <tr class="head_td">
    <td colspan="12">
       <form method="get" name="f1" >
        
        <input type="hidden" name="enroll_id" value="<?php echo $_GET['enroll_id'] ?>">
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
</select></td>

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
<!--<script>
function redirects()
{
	months = document.f1.month.value;
	years = document.f1.year.value;
	
	document.location.href="view_email.php?enroll_id=<?php echo $_GET['enroll_id']; ?>&month="+months+"&years="+years;
}	
</script>-->



<td><input type="submit" value="Search"></td>
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
			
		  
		  
		 $sql_query1= "SELECT repeated FROM student_attendence  ";  
		 
	    $quer = mysql_query($sql_query1);
		$fetch=mysql_fetch_array($quer);
		  
		  $sep=explode("-",$fetch['repeated']);
	        $result=$sep[0].'-'.$sep[1];
			//if($_GET['year'].'-'.$_GET['month'])
		     // {
				   echo  "<table cellspacing='0' cellpadding='0' class='tale' width='100%' align='center'><tr class='grey_td' >
   
                 <td width='10%' align='center'>".'<strong>Date</strong>'." </td>
                
                 <td width='10%' align='center'>".'<strong>Status</strong>'."</td></tr>";
				
		   ?>
             
                
          <!---------------------------------------------------------------------------------------------------------------------> 
 <?Php

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
				$sele_all="select * from student_attendence where enroll_id='".$_GET['enroll_id']."' and `repeated`	like '".$_GET['year']."-".$_GET['month']."-".$i."'  ";
		        
	    	}
			else
			{
				$sele_all= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and stud_status='".$_GET['Pre']."'and `repeated` 
		like '".$_GET['year']."-".$_GET['month']."-".$i."' ";  
	
			}
			$query=mysql_query($sele_all);
			if($total_rows=mysql_num_rows($query))
			{
				$array=mysql_fetch_array( $query);
				$new_date= explode('-',$array['repeated'],3); 
				$date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
				echo '<tr>
				<td align="center">' .$date_email. '</td>';
				if($array['stud_status']=="present")
				{
					echo '<td align="center"><span style="background-color:green;padding:10px;">Present</span></td>';
					$total_found++;
					$x=$x+1;
				}
				else
				{
					echo '<td align="center"><span style="background-color:red;padding:10px;">Absent</span></td>';
					$not_found++;
					$y=$y+1;
				}
				
				echo '</tr>';
				
				
			}
			  if($total_found==0 && $not_found==0 && $number-1==$i)
			{
			
                          echo "<tr><td colspan='2' align='center'><strong>Record Not Found</strong></td></tr>";

			}
				//echo "<br/>-- ".$number."---".$i;
			if($x>0 && $number-1==$i)
			{
	 
				echo "<tr><td colspan='2' align='center'><table width='100%' class='tale'  style='font-weight:bold;'><tr><td  width='50%' align='center'>No. OF Days Present</td>								            
				<td align='center'>".$total_found."</td></tr>
				</table></td></tr>";
			}
			if($y>0 && $number-1==$i)
			{
				//echo $number;
				echo "<tr><td colspan='2' align='center'>
				<table width='100%' class='tale'  style='font-weight:bold;'><tr><td  width='50%' align='center'>No. OF Days Absent</td>								            <td align='center'>".$not_found."</td></tr>
   
				</table></td></tr>";
			}
			
	 	}
	}
}
	if($_GET['Pre']=="")
	{

    $sql_query= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."'   ";  
	$qu = mysql_query($sql_query);
	//$array=mysql_fetch_array( $query);
	
	
	 
	while($array=mysql_fetch_array( $qu))
	{
		
		$new_date= explode('-',$array['repeated'],3); 
	$date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
	 
		echo '<tr>
	  	<td align="center">' .$date_email. '</td>';
	  	if(mysql_num_rows($qu))
	   	{
			if($array['stud_status']=="present")
			{
				//echo "get enroll";
			//$x= $x+1;
			echo '<td align="center"><span style="background-color:green;padding:10px;">Present</span></span></td>';
			$total_found++;
			}
	   	    if($array['stud_status']=="absent")
	      {
			//$x= $x+1;
	    	echo '<td align="center"><span style="background-color:red;padding:10px;">Absent</span></td>';
	    	$not_found++;
	      }
		}
	    echo '</tr>';
		//echo "";
	}
	echo "<tr><td colspan='2' align='center'>
		   <table width='100%' class='tale'  style='font-weight:bold;'><tr><td  width='50%' align='center'>No. OF Days Present</td>                <td align='center'>".$total_found."</td></tr>
		   <tr><td  width='50%' align='center'>No. OF Days Absent</td><td align='center'>".$not_found."</td></tr>
		   
		   </table></td></tr>";
	
	}

	


$month=$_GET['month'];

$dt=$_GET['dt'];

$year=$_GET['year'];

 $date_value="$month/$year";

//echo "mm/dd/yyyy format :$date_value<br>";

$date_value="$year-$month";

//echo "YYYY-mm-dd format :$date_value<br>";


		 // }




//}?></table>
          
         <!--<td width="20%"> 
         <?php
// set start and end year range
/*$yearArray = range(2010, date('Y'));
?>

<select name="year">
    <option value="">Select Year</option>
    <?php
    foreach ($yearArray as $year) 
	{
        // if you want to select a particular year
        //$selected = ($year == 2015) ? 'selected' : '';
        echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
    }*/
    ?>
</select></td>-->

<!--<td width="20%">
<?php
/*$monthArray = range(1, 12);
?>
<select name="month">
    <option value="">Select Month</option>
    <?php
    foreach ($monthArray as $month)
	 {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("F", strtotime("".date('Y')."-$monthPadding-01"));
        echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
    }*/
    ?>
</select></td>-->
<!--<td><input type="submit" value="Submit"></td>-->
          
                                 
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
			
for($i = 1; $i <=  $number; $i++)
{
   // add the date to the dates array
  // echo "hi";
   $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
}

 
		  
$t=0;	
$total_found =0;	
$not_found=0; 
foreach($dates as $date)
{
	$array[$t];
	$explode_date = explode(' ', $array[$t]);
	
	$sql_query= "SELECT * FROM student_attendence where enroll_id='".$_GET['enroll_id']."' and `repeated` like '".$date."%' and stud_status='absent' ";  
	$query2 = mysql_query($sql_query);
	//echo '<br/>'.$date;
	$new_date= explode('-',$date,3); 
	$date_email= $new_date[2].'-'.$new_date[1].'-'.$new_date[0];
	
	if($array['repeated'] != "")
	{
      	echo '<tr><td align="center">' .$date_email. '</td>';
	  	if(mysql_num_rows($query2))
		{
			echo '<td align="center">Absent '.$array['repeated'].'<span style="padding-left:10%"></span></td>';
			$total_found++;
	   	}
		else
	  	{
	 		echo '<td align="center">Present</td>';
	 		$not_found++;
	  	}
		echo '</tr><tr>';
		// echo '<tr><td align="center">' .$date_email. '</td>';
		echo '</tr>';	
		echo "<tr><td colspan='2' align='center'>
		<table width='100%' class='tale'  style='font-weight:bold;'>
		<tr><td  width='50%' align='center'>Total Days </td><td align='center'>".$number."</td></tr>
		<tr><td align='center'>No. OF Days Absent</td><td align='center'>".$total_found."</td></tr>
		</table></td></tr>";
    	$t++;	
  }
}

	
	
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
