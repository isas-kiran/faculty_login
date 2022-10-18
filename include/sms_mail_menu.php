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
            if($page_name =='batch_specific.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="batch_specific.php" style="color:#7CA32F;">Batch Specific </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="batch_specific.php" style="color:#666666;">Batch Specific</a></td>
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
            if($page_name == 'manage_subscriber.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_subscriber.php" style="color:#7CA32F;">Manage Subscriber</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_subscriber.php" style="color:#666666;">Manage Subscriber</a></td>
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
            if($page_name == 'subscriber_specific.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subscriber_specific.php" style="color:#7CA32F;">Subscriber Specific </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subscriber_specific.php" style="color:#666666;">Subscriber Specific </a></td>
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
            if($page_name == 'manage_group.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_group.php" style="color:#7CA32F;">Manage Group </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_group.php" style="color:#666666;">Manage Group </a></td>
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
            if($page_name == 'add_group.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_group.php" style="color:#7CA32F;">Add Group </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_group.php" style="color:#666666;">Add Group </a></td>
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
            if($page_name =='group_by_sms.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="group_by_sms.php" style="color:#7CA32F;">Group By SMS </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="group_by_sms.php" style="color:#666666;">Group By SMS </a></td>
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
  if($page_name == 'send_sms_email.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="send_sms_email.php" style="color:#7CA32F;">Send SMS</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="send_sms_email.php" style="color:#666666;">Send SMS</a></td>
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
  if($page_name == 'upload_num_excel.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="upload_num_excel.php" style="color:#7CA32F;">Upload Excel</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="upload_num_excel.php" style="color:#666666;">Upload Excel</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
  
<!--<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_course_certification.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_course_certification.php" style="color:#7CA32F;">Manage Course Certification </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_course_certification.php" style="color:#666666;">Manage Course Certification </a></td>
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
            if($page_name == 'add_course_certification.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course_certification.php" style="color:#7CA32F;">Add Course Certification </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course_certification.php" style="color:#666666;">Add Course Certification </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>-->
       <?php
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==226) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==227)
				{
			?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='batch_specific.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="batch_specific.php" style="color:#7CA32F;">Batch Specific </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="batch_specific.php" style="color:#666666;">Manage Course </a></td>
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
else if($array_prev[$e][$f]['privilege_id']==228)
{
?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_subscriber.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_subscriber.php" style="color:#7CA32F;">Manage Subscriber </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_subscriber.php" style="color:#666666;">Manage Subscriber </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==229)
				{
				?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'subscriber_specific.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subscriber_specific.php" style="color:#7CA32F;">Subscriber Specific </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subscriber_specific.php" style="color:#666666;">Subscriber Specific </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==230)
				{
				?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_group.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_group.php" style="color:#7CA32F;">Manage Group</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_group.php" style="color:#666666;">Manage Group</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==231)
				{
				?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='add_group.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_group.php" style="color:#7CA32F;">Add Group </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_group.php" style="color:#666666;">Add Group</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==232)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'group_by_sms.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="group_by_sms.php" style="color:#7CA32F;">Group By SMS </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="group_by_sms.php" style="color:#666666;">Group By SMS </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    <?php
				}
				else if($array_prev[$e][$f]['privilege_id']==233)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'send_sms_email.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="send_sms_email.php" style="color:#7CA32F;">Send SMS / Email</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="send_sms_email.php" style="color:#666666;">Send SMS / Email</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>


<?php
				}

	}
		}
			}

   }
			
 ?>
  </tr>
</table>