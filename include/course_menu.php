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
                if($page_name =='manage_course_domain.php')
                {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="manage_course_domain.php" style="color:#7CA32F;">Manage Course Domain</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
                }
                else
                {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="manage_course_domain.php" style="color:#666666;">Manage Course Domain</a></td>
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
                if($page_name =='add_course_domain.php')
                {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="add_course_domain.php" style="color:#7CA32F;">Add Course Domain</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
                }
                else
                {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="add_course_domain.php" style="color:#666666;">Add Course Domain</a></td>
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
            if($page_name =='course_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="course_manage.php" style="color:#7CA32F;">Manage Course</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="course_manage.php" style="color:#666666;">Manage Course</a></td>
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
		if($page_name == 'add_course.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course.php" style="color:#7CA32F;">Add Course </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course.php" style="color:#666666;">Add Course </a></td>
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
            if($page_name == 'course_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="course_category.php" style="color:#7CA32F;">Manage Course Cat. </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="course_category.php" style="color:#666666;">Manage Course Cat. </a></td>
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
            if($page_name == 'add_course_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course_category.php" style="color:#7CA32F;">Add Course Category </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course_category.php" style="color:#666666;">Add Course Category </a></td>
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
            if($page_name =='subject_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subject_manage.php" style="color:#7CA32F;">Manage Subject </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subject_manage.php" style="color:#666666;">Manage Subject </a></td>
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
  if($page_name == 'subject_add.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subject_add.php" style="color:#7CA32F;">Add Subject </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subject_add.php" style="color:#666666;">Add Subject </a></td>
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
            if($page_name == 'topic_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="topic_manage.php" style="color:#7CA32F;">Manage Topic </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="topic_manage.php" style="color:#666666;">Manage Topic </a></td>
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
            if($page_name == 'add_topic.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_topic.php" style="color:#7CA32F;">Add Topic </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_topic.php" style="color:#666666;">Add Topic </a></td>
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
            if($page_name == 'batch_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="batch_manage.php" style="color:#7CA32F;">Manage Batch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="batch_manage.php" style="color:#666666;">Manage Batch </a></td>
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
            if($page_name == 'add_batch.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_batch.php" style="color:#7CA32F;">Add Batch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_batch.php" style="color:#666666;">Add Batch </a></td>
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
    if($page_name == 'create_logsheet.php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="create_logsheet.php" style="color:#7CA32F;">Manage Logsheet</a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
    }
    else
    {
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="create_logsheet.php" style="color:#666666;">Manage Logsheet</a></td>
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
            if($page_name == 'import_all.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="import_all.php" style="color:#7CA32F;">Import</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="import_all.php" style="color:#666666;">Import</a></td>
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
            if($page_name == 'add_notes_in_course.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_notes_in_course.php" style="color:#7CA32F;">Upload Notes</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_notes_in_course.php" style="color:#666666;">Upload Notes</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
		</table>
	</td>
<td class="width5"></td>
<!--<td class="width5"></td>
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
        if($array_previ_parent[$e]['privilege_id']==2) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{
				if($array_prev[$e][$f]['privilege_id']==297)
				{
					?>
    				<td>
                        <table border="0" cellspacing="0" cellpadding="0">
                                <?php 
                                if($page_name =='manage_course_domain.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="manage_course_domain.php" style="color:#7CA32F;">Manage Course Domain</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="manage_course_domain.php" style="color:#666666;">Manage Course Domain</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==296)
				{
					?>
    				<td>
                        <table border="0" cellspacing="0" cellpadding="0">
							<?php 
                            if($page_name =='add_course_domain.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="add_course_domain.php" style="color:#7CA32F;">Add Course Domain</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="add_course_domain.php" style="color:#666666;">Add Course Domain</a></td>
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
                else if($array_prev[$e][$f]['privilege_id']==26)
				{
					?>
    				<td>
                        <table border="0" cellspacing="0" cellpadding="0">
                                <?php 
                                if($page_name =='course_manage.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="course_manage.php" style="color:#7CA32F;">Manage Course </a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="course_manage.php" style="color:#666666;">Manage Course </a></td>
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
                else if($array_prev[$e][$f]['privilege_id']==27)
                {
                	?>
                	<td>
                	<table border="0" cellspacing="0" cellpadding="0">
                    <?php
              		if($page_name == 'add_course.php')
            		{
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="add_course.php" style="color:#7CA32F;">Add Course </a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
					}
					else
					{
					?>
					<tr>
						<td class="tab_left"></td>
						<td class="tab_mid"><a href="add_course.php" style="color:#666666;">Add Course </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==28)
				{
				?>
                    <td>
                    <table border="0" cellspacing="0" cellpadding="0">
					<?php 
                    if($page_name == 'course_category.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="course_category.php" style="color:#7CA32F;">Manage Course Cat. </a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="course_category.php" style="color:#666666;">Manage Course Cat. </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==29)
				{
				?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_course_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_course_category.php" style="color:#7CA32F;">Add Course Category </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_course_category.php" style="color:#666666;">Add Course Category </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==30)
				{
				?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='subject_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subject_manage.php" style="color:#7CA32F;">Manage Subject </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subject_manage.php" style="color:#666666;">Manage Subject </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==31)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'subject_add.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="subject_add.php" style="color:#7CA32F;">Add Subject </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="subject_add.php" style="color:#666666;">Add Subject </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==32)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'topic_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="topic_manage.php" style="color:#7CA32F;">Manage Topic </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="topic_manage.php" style="color:#666666;">Manage Topic </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==33)
				{
				?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_topic.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_topic.php" style="color:#7CA32F;">Add Topic </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_topic.php" style="color:#666666;">Add Topic </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==34)
				{
				?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'batch_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="batch_manage.php" style="color:#7CA32F;">Manage Batch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="batch_manage.php" style="color:#666666;">Manage Batch </a></td>
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
else if($array_prev[$e][$f]['privilege_id']==35)
{
?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_batch.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_batch.php" style="color:#7CA32F;">Add Batch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_batch.php" style="color:#666666;">Add Batch </a></td>
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
else if($array_prev[$e][$f]['privilege_id']==294)
{
	?>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'create_logsheet.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="create_logsheet.php" style="color:#7CA32F;">Manage Logsheet</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="create_logsheet.php" style="color:#666666;">Manage Logsheet</a></td>
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
else if($array_prev[$e][$f]['privilege_id']==36)
{
?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'import_all.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_all.php" style="color:#7CA32F;">Import</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_all.php" style="color:#666666;">Import</a></td>
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
            else if($array_prev[$e][$f]['privilege_id']==367)
			{
				?>
				<td>
                    <table border="0" cellspacing="0" cellpadding="0">
                    <?php 
                    if($page_name == 'add_notes_in_course.php')
                    {
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="add_notes_in_course.php" style="color:#7CA32F;">Upload Notes</a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
                    }
                    else
                    {
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="add_notes_in_course.php" style="color:#666666;">Upload Notes</a></td>
							<td class="tab_right"></td>
						</tr>
						<?php
                    }            
                    ?>  
                    </table>
				</td>
				<?php
        	}
        	?>
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
		}
			}

   }
			
 ?>
  </tr>
</table>