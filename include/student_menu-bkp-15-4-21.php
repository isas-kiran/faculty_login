<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	<?php
   	if($_SESSION['type'] =='S')
   	{
		?>
	    <td>
		<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_student.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_student.php" style="color:#7CA32F;">Manage Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_student.php" style="color:#666666;">Manage Enquiry </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?> 
		</table>
		</td>
		<td class="width5"></td>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
            if($page_name == 'inquiry.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="inquiry.php" style="color:#7CA32F;">Add Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="inquiry.php" style="color:#666666;">Add Enquiry </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
            </table>
            </td>
            <td class="width5"></td>
   			<td>
			<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_enroll.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_enroll.php" style="color:#7CA32F;">Manage Enrolled Student </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_enroll.php" style="color:#666666;">Manage Enrolled Student </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
<!--<td class="width5"></td>

     <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            /*if($page_name == 'enroll.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="enroll.php" style="color:#7CA32F;">Enrollment Form </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="enroll.php" style="color:#666666;">Enrollment Form </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}
            ?>
        </table>
	</td>-->
    <!--<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            /*if($page_name == 'enroll_gst.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="enroll_gst.php" style="color:#7CA32F;">Enrollment Form</a></td> 
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="enroll_gst.php" style="color:#666666;">Enrollment Form</a></td>  
                <td class="tab_right"></td>
            </tr>
            <?php
            //}
            ?>
        </table>
	</td>-->
  <!-- <img src="images/new.gif" />-->
<td class="width5"></td>
<?php  if($_SESSION['type']=='B')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_task.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_task.php" style="color:#7CA32F;">My Task </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_task.php" style="color:#666666;">My Task </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php }?>
<?php  if($_SESSION['type']=='B')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="kit.php" style="color:#7CA32F;">Issue Kit </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="kit.php" style="color:#666666;">Issue Kit</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php }?>


<?php  if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='C')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'followup_summery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="followup_summery.php" style="color:#7CA32F;">Followup Summary </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="followup_summery.php" style="color:#666666;">Followup Summary</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php }?>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
    	<?php
		if($page_name == 'followup_record.php')
		{
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="followup_record.php" style="color:#7CA32F;">Followup Report </a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
		}
		else
		{
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="followup_record.php" style="color:#666666;">Followup Report</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
		}
		?>
	</table>
</td>

<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'import_student.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_student.php" style="color:#7CA32F;">Import Student</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_student.php" style="color:#666666;">Import Student</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>    
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php
        if($page_name == 'import_campaign_inquiries.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="import_campaign_inquiries.php" style="color:#7CA32F;">Import Camp. Enquiry</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="import_campaign_inquiries.php" style="color:#666666;">Import Camp. Enquiry</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
        }
        ?>
    </table>
</td>
    
<td class="width5"></td>

<?php  if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='C')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_report.php" style="color:#7CA32F;">Manage Attendence</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_report.php" style="color:#666666;">Manage Attendence</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php } ?>
<?php  if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='C')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'student_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="student_report.php" style="color:#7CA32F;">Attendence Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="student_report.php" style="color:#666666;">Attendence Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
 <td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
    	<?php
		if($page_name == 'dsr_enroll_report.php')
		{
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="dsr_enroll_report.php" style="color:#7CA32F;">DSR Enroll Report </a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
		}
		else
		{
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="dsr_enroll_report.php" style="color:#666666;">DSR Enroll Report</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
		}
		?>
	</table>
</td>
<td class="width5"></td>
<?php }
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	//print_r($array_prev);
	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==3) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==37)
				{
			?>
  <td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_student.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_student.php" style="color:#7CA32F;">Manage Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_student.php" style="color:#666666;">Manage Enquiry </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?> 
</table>
</td>
<td class="width5"></td>
<?php
}
else if($array_prev[$e][$f]['privilege_id']==38)
{
?>

    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'inquiry.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="inquiry.php" style="color:#7CA32F;">Add Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="inquiry.php" style="color:#666666;">Add Enquiry </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
}
else if($array_prev[$e][$f]['privilege_id']==39)
{
?>

   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_enroll.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_enroll.php" style="color:#7CA32F;">Manage Enrolled Student </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_enroll.php" style="color:#666666;">Manage Enrolled Student </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
<td class="width5"></td>
<?php
}
else if($array_prev[$e][$f]['privilege_id']==40)
{
?>

    <!--<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            /*if($page_name == 'enroll.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="enroll.php" style="color:#7CA32F;">Enrollment Form </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="enroll.php" style="color:#666666;">Enrollment Form </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}
            ?>
        </table>
	</td>
    <td class="width5"></td>-->
<!--<td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
    if($page_name == 'enroll_gst.php')
    {
    ?>
    	<tr>
        	<td class="tab2_left"></td>
            <td class="tab2_mid"><a href="enroll_gst.php" style="color:#7CA32F;">Enrollment Form</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
    }
   	else
    {
    ?>
    	<tr>
        	<td class="tab_left"></td>
            <td class="tab_mid"><a href="enroll_gst.php" style="color:#666666;">Enrollment Form</a></td> 
            <td class="tab_right"></td>
        </tr>
        <?php
     }
     ?>
   	</table>
</td>
<td class="width5"></td>-->   
<?php
}
else if($array_prev[$e][$f]['privilege_id']==41)
{
?>

<?php  if($_SESSION['type']=='B')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_task.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_task.php" style="color:#7CA32F;">My Task </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_task.php" style="color:#666666;">My Task </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php }?>
<?php  if($_SESSION['type']=='B')
{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="kit.php" style="color:#7CA32F;">Issue Kit </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="kit.php" style="color:#666666;">Issue Kit</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php }?>
<?php
}
else if($array_prev[$e][$f]['privilege_id']==42)
{
?>
    
<td class="width5"></td>
<?php
}
else if($array_prev[$e][$f]['privilege_id']==43)
{
?>

	<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'followup_summery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="followup_summery.php" style="color:#7CA32F;">Followup Summary </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="followup_summery.php" style="color:#666666;">Followup Summary</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
<td class="width5"></td>
<?php
}
if($array_prev[$e][$f]['privilege_id']==44)
{
	?>
	<td class="width5"></td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php
        if($page_name == 'followup_record.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="followup_record.php" style="color:#7CA32F;">Followup Report </a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="followup_record.php" style="color:#666666;">Followup Report</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
        }
        ?>
    </table>
	</td>    
<?php
}
if($array_prev[$e][$f]['privilege_id']==45)
{
	?>
	<td class="width5"></td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php
        if($page_name == 'import_student.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="import_student.php" style="color:#7CA32F;">Import Student </a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="import_student.php" style="color:#666666;">Import Student</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
        }
        ?>
    </table>
	</td>
	<td class="width5"></td>
<?php 
}
if($array_prev[$e][$f]['privilege_id']==239)
{
?>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php
        if($page_name == 'import_campaign_inquiries.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="import_campaign_inquiries.php" style="color:#7CA32F;">Import Camp. Enquiry</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="import_campaign_inquiries.php" style="color:#666666;">Import Camp. Enquiry</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
        }
        ?>
    </table>
</td>
<td class="width5"></td>
<?php
}
if($array_prev[$e][$f]['privilege_id']==142)
{
?>
	<td class="width5"></td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'student_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="student_report.php" style="color:#7CA32F;">Manage Attendence</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="student_report.php" style="color:#666666;">Manage Attendence</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
	<td class="width5"></td>
<?php 
}
if($array_prev[$e][$f]['privilege_id']==143)
{
	?>
	<td class="width5"></td>
	<td>
        <table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_report.php" style="color:#7CA32F;">Attendence Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_report.php" style="color:#666666;">Attendence Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
	<td class="width5"></td>
	<?php
}
if($array_prev[$e][$f]['privilege_id']==285)
{
	?>
	<td class="width5"></td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
			<?php
			if($page_name == 'dsr_enroll_report.php')
			{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="dsr_enroll_report.php" style="color:#7CA32F;">DSR Enroll Report</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
			}
			else
			{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="dsr_enroll_report.php" style="color:#666666;">DSR Enroll Report</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
			}
			?>
		</table>
	</td>
	<td class="width5"></td>
	<?php 
}


			}
		}
	}
	
   }
   
?>

  </tr>
</table>