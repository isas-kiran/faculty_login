<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <?php
    if($_SESSION['type'] =='S')
   {
	   ?>
        <!--<td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            /*if($page_name == 'manage_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_source.php" style="color:#7CA32F;">Manage Source </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_source.php" style="color:#666666;">Manage Source </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }   */         
            ?> 
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            /*if($page_name == 'add_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_source.php" style="color:#7CA32F;">Add Source </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_source.php" style="color:#666666;">Add Source </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            } */           
            ?>         
</table>
</td>

<td class="width5"></td>-->
   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_branch.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_branch.php" style="color:#7CA32F;">Manage Branch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_branch.php" style="color:#666666;">Manage Branch </a></td>
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
            if($page_name == 'add_branch.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_branch.php" style="color:#7CA32F;">Add Branch </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_branch.php" style="color:#666666;">Add Branch </a></td>
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
            if($page_name == 'manage_tax.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_tax.php" style="color:#7CA32F;">Manage Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_tax.php" style="color:#666666;">Manage Tax </a></td>
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
            if($page_name == 'add_tax.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_tax.php" style="color:#7CA32F;">Add Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_tax.php" style="color:#666666;">Add Tax </a></td>
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
            if($page_name == 'manage_tax_type.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_tax_type.php" style="color:#7CA32F;">Manage Tax Type</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_tax_type.php" style="color:#666666;">Manage Tax Type</a></td>
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
            if($page_name == 'add_tax_type.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_tax_type.php" style="color:#7CA32F;">Add Tax Type</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_tax_type.php" style="color:#666666;">Add Tax Type</a></td>
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
            if($page_name == 'manage_discount.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_discount.php" style="color:#7CA32F;">Manage Discount</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_discount.php" style="color:#666666;">Manage Discount</a></td>
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
            if($page_name == 'add_discount.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_discount.php" style="color:#7CA32F;">Add Discount</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_discount.php" style="color:#666666;">Add Discount</a></td>
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
            if($page_name == 'manage_batch_time.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_batch_time.php" style="color:#7CA32F;">Manage Batch Time </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_batch_time.php" style="color:#666666;">Manage Batch Time </a></td>
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
            if($page_name == 'add_batch_time.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_batch_time.php" style="color:#7CA32F;">Add Batch Time </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_batch_time.php" style="color:#666666;">Add Batch Time </a></td>
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
            if($page_name == 'manage_kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_kit.php" style="color:#7CA32F;">Manage Kit</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_kit.php" style="color:#666666;">Manage Kit</a></td>
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
            if($page_name == 'add_kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_kit.php" style="color:#7CA32F;">Add Kit</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_kit.php" style="color:#666666;">Add Kit</a></td>
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
            if($page_name == 'manage_item.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_item.php" style="color:#7CA32F;">Manage Item</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_item.php" style="color:#666666;">Manage Item</a></td>
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
            if($page_name == 'add_item.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_item.php" style="color:#7CA32F;">Add Item</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_item.php" style="color:#666666;">Add Item</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>-->
<td class="width5"></td>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_lab.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_lab.php" style="color:#7CA32F;">Manage Lab</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_lab.php" style="color:#666666;">Manage Lab</a></td>
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
            if($page_name == 'add_lab.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_lab.php" style="color:#7CA32F;">Add Lab </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_lab.php" style="color:#666666;">Add Lab </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<!--
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            //if($page_name == 'manage_sms_mail.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sms_mail.php" style="color:#7CA32F;">Manage SMS & Mail</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sms_mail.php" style="color:#666666;">Manage SMS & Mail</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            //if($page_name == 'add_sms_mail.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_sms_mail.php" style="color:#7CA32F;">Add SMS & Mail</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_sms_mail.php" style="color:#666666;">Add SMS & Mail</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>

<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            //if($page_name == 'module_types.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="module_types.php" style="color:#7CA32F;">Add Modules</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="module_types.php" style="color:#666666;">Add Modules</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>
-->
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'rewards_value_config.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="rewards_value_config.php" style="color:#7CA32F;">Manage Reward Value</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="rewards_value_config.php" style="color:#666666;">Manage Reward Value</a></td>
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
            if($page_name == 'rewards_point_config.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="rewards_point_config.php" style="color:#7CA32F;">Manage Reward Point</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="rewards_point_config.php" style="color:#666666;">Manage Reward Point</a></td>
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
            if($page_name == 'manage_sac_code.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sac_code.php" style="color:#7CA32F;">Manage SAC code</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sac_code.php" style="color:#666666;">Manage SAC code</a></td>
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
            if($page_name == 'responce_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="responce_category.php" style="color:#7CA32F;">Add Responce</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="responce_category.php" style="color:#666666;">Add Responce</a></td>
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
            if($page_name == 'add_holiday.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="add_holiday.php" style="color:#7CA32F;">Add holidays</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="add_holiday.php" style="color:#666666;">Add holidays</a></td>
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
           // if($page_name == 'add_sallery.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_sallery.php" style="color:#7CA32F;">Add Sallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {
            */?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_sallery.php" style="color:#666666;">Add Sallery</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>-->
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'basic_course_weightage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="basic_course_weightage.php" style="color:#7CA32F;">Basic Course Weightage</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="basic_course_weightage.php" style="color:#666666;">Basic Course Weightage</a></td>
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
		if($page_name == 'advance_course_weightage.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="advance_course_weightage.php" style="color:#7CA32F;">Integrated Course Weightage</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="advance_course_weightage.php" style="color:#666666;">Integrated Course Weightage</a></td>
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
		if($page_name == 'add_grading_calculation.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="add_grading_calculation.php" style="color:#7CA32F;">Manage Grade Calculation</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="add_grading_calculation.php" style="color:#666666;">Manage Grade Calculation</a></td>
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
		if($page_name == 'manage_biometric_machine.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_biometric_machine.php" style="color:#7CA32F;">Manage Biometric Device</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_biometric_machine.php" style="color:#666666;">Manage Biometric Device</a></td>
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
		if($page_name == 'other_links.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="other_links.php" style="color:#7CA32F;">Other Links</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="other_links.php" style="color:#666666;">Other Links</a></td>
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
            if($page_name=='manage_country.php')
            {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="manage_country.php" style="color:#7CA32F;">Manage Country</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="manage_country.php" style="color:#666666;">Manage Country</a></td>
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
            if($page_name=='manage_state.php')
            {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="manage_state.php" style="color:#7CA32F;">Manage State</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="manage_state.php" style="color:#666666;">Manage State</a></td>
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
            if($page_name=='manage_city.php')
            {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="manage_city.php" style="color:#7CA32F;">Manage City</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="manage_city.php" style="color:#666666;">Manage City</a></td>
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
            if($page_name=='manage_area.php')
            {
                ?>
                <tr>
                    <td class="tab2_left"></td>
                    <td class="tab2_mid"><a href="manage_area.php" style="color:#7CA32F;">Manage Area</a></td>
                    <td class="tab2_right"></td>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr>
                    <td class="tab_left"></td>
                    <td class="tab_mid"><a href="manage_area.php" style="color:#666666;">Manage Area</a></td>
                    <td class="tab_right"></td>
                </tr>
                <?php
            }            
            ?>
        </table>
	</td>
       <?php
}
else
{
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==12) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==70)
				{
					?>
                	<!--<td>
                    <table border="0" cellspacing="0" cellpadding="0">
				   	<?php 
                    /*if($page_name == 'manage_source.php')
                    {
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="manage_source.php" style="color:#7CA32F;">Manage Source </a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
                    }
                    else
                    {
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="manage_source.php" style="color:#666666;">Manage Source </a></td>
							<td class="tab_right"></td>
						</tr>
						<?php
                    }   */         
                    ?> 
                	</table>
                	</td>
                	<td class="width5"></td>-->
					<?php
				}
				else if($array_prev[$e][$f]['privilege_id']==71)
				{
					?>
                    <!--<td>
                    <table border="0" cellspacing="0" cellpadding="0">
					<?php 
                    /*if($page_name == 'add_source.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="add_source.php" style="color:#7CA32F;">Add Source </a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="add_source.php" style="color:#666666;">Add Source </a></td>
                        <td class="tab_right"></td>
                    </tr>
                    <?php
                    }  */          
                    ?>         
                    </table>
                    </td>-->
                    <?php
				}
				else if($array_prev[$e][$f]['privilege_id']==72)
				{
					?>
					<td class="width5"></td>
   					<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
                    if($page_name == 'manage_branch.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="manage_branch.php" style="color:#7CA32F;">Manage Branch </a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="manage_branch.php" style="color:#666666;">Manage Branch </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==73)
				{
					?>
    				<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<?php
                    if($page_name == 'add_branch.php')
                    {
						?>
						<tr>
							<td class="tab2_left"></td>
							<td class="tab2_mid"><a href="add_branch.php" style="color:#7CA32F;">Add Branch </a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
                    }
                    else
                    {
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="add_branch.php" style="color:#666666;">Add Branch </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==74)
				{
				?>
   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_tax.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_tax.php" style="color:#7CA32F;">Manage Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_tax.php" style="color:#666666;">Manage Tax </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==75)
					{
					?>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_tax.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_tax.php" style="color:#7CA32F;">Add Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_tax.php" style="color:#666666;">Add Tax </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==90)
					{
					?>
   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_tax_type.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_tax_type.php" style="color:#7CA32F;">Manage Tax Type</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_tax_type.php" style="color:#666666;">Manage Tax Type</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==89)
					{
					?>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_tax_type.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_tax_type.php" style="color:#7CA32F;">Add Tax Type</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_tax_type.php" style="color:#666666;">Add Tax Type</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==76)
					{
					?>
   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_discount.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_discount.php" style="color:#7CA32F;">Manage Discount</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_discount.php" style="color:#666666;">Manage Discount</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==77)
					{
					?>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_discount.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_discount.php" style="color:#7CA32F;">Add Discount</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_discount.php" style="color:#666666;">Add Discount</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==78)
					{
					?>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_batch_time.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_batch_time.php" style="color:#7CA32F;">Manage Batch Time </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_batch_time.php" style="color:#666666;">Manage Batch Time </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==79)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'add_batch_time.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_batch_time.php" style="color:#7CA32F;">Add Batch Time </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_batch_time.php" style="color:#666666;">Add Batch Time </a></td>
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
            if($page_name == 'manage_kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_kit.php" style="color:#7CA32F;">Manage Kit</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_kit.php" style="color:#666666;">Manage Kit</a></td>
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
            if($page_name == 'add_kit.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_kit.php" style="color:#7CA32F;">Add Kit</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_kit.php" style="color:#666666;">Add Kit</a></td>
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
            if($page_name == 'manage_item.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_item.php" style="color:#7CA32F;">Manage Item</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_item.php" style="color:#666666;">Manage Item</a></td>
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
            if($page_name == 'add_item.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_item.php" style="color:#7CA32F;">Add Item</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_item.php" style="color:#666666;">Add Item</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>-->
<td class="width5"></td>
<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==84)
					{
					?>
     <td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_lab.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_lab.php" style="color:#7CA32F;">Manage Lab</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_lab.php" style="color:#666666;">Manage Lab</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==85)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'add_lab.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_lab.php" style="color:#7CA32F;">Add Lab </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_lab.php" style="color:#666666;">Add Lab </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<!--
<td class="width5"></td>
<?php
					//}
					//else if($array_prev[$e][$f]['privilege_id']==86)
					//{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            //if($page_name == 'manage_sms_mail.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sms_mail.php" style="color:#7CA32F;">Manage SMS & Mail</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sms_mail.php" style="color:#666666;">Manage SMS & Mail</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>
<td class="width5"></td>

<?php
					//}
					//else if($array_prev[$e][$f]['privilege_id']==87)
					//{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            //if($page_name == 'add_sms_mail.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_sms_mail.php" style="color:#7CA32F;">Add SMS & Mail</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_sms_mail.php" style="color:#666666;">Add SMS & Mail</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>         
</table>
</td>-->
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']=='160')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'rewards_value_config.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="rewards_value_config.php" style="color:#7CA32F;">Manage Reward Value</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="rewards_value_config.php" style="color:#666666;">Manage Reward Value</a></td>
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
	else if($array_prev[$e][$f]['privilege_id']=='174')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'manage_sac_code.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sac_code.php" style="color:#7CA32F;">Manage SAC code</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sac_code.php" style="color:#666666;">Manage SAC code</a></td>
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
	else if($array_prev[$e][$f]['privilege_id']=='161')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'rewards_point_config.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="rewards_point_config.php" style="color:#7CA32F;">Manage Reward Point</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="rewards_point_config.php" style="color:#666666;">Manage Reward Point</a></td>
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
	else if($array_prev[$e][$f]['privilege_id']==142)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
        	if($page_name == 'responce_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="responce_category.php" style="color:#7CA32F;">Add Responce</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="responce_category.php" style="color:#666666;">Add Responce</a></td>
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
	else if($array_prev[$e][$f]['privilege_id']==293)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
        	if($page_name == 'add_holiday.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_holiday.php" style="color:#7CA32F;">Add Holiday</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_holiday.php" style="color:#666666;">Add Holiday</a></td>
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
	/*else if($array_prev[$e][$f]['privilege_id']==88)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'add_sallery.php')
		{
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="add_sallery.php" style="color:#7CA32F;">Add Sallery</a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
		}
		else
		{
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="add_sallery.php" style="color:#666666;">Add Sallery</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}*/
	else if($array_prev[$e][$f]['privilege_id']==324)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'basic_course_weightage.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="basic_course_weightage.php" style="color:#7CA32F;">Basic Course Weightage</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="basic_course_weightage.php" style="color:#666666;">Advance Course Weightage</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	else if($array_prev[$e][$f]['privilege_id']==325)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'advance_course_weightage.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="advance_course_weightage.php" style="color:#7CA32F;">Integrated Course Weightage</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="advance_course_weightage.php" style="color:#666666;">Integrated Course Weightage</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//============================================
	if($array_prev[$e][$f]['privilege_id']==326)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'add_grading_calculation.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="add_grading_calculation.php" style="color:#7CA32F;">Manage Grade Calculation</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="add_grading_calculation.php" style="color:#666666;">Manage Grade Calculation</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//============================================
	if($array_prev[$e][$f]['privilege_id']==328)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'manage_biometric_machine.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_biometric_machine.php" style="color:#7CA32F;">Manage Biometric Machine</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_biometric_machine.php" style="color:#666666;">Manage Biometric Machine</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//======================================
	//============================================
	if($array_prev[$e][$f]['privilege_id']==343)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'manage_country.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_country.php" style="color:#7CA32F;">Manage Country</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_country.php" style="color:#666666;">Manage Country</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//============================================
	if($array_prev[$e][$f]['privilege_id']==344)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'manage_state.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_state.php" style="color:#7CA32F;">Manage State</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_state.php" style="color:#666666;">Manage State</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//============================================
	if($array_prev[$e][$f]['privilege_id']==345)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'manage_city.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_city.php" style="color:#7CA32F;">Manage City</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_city.php" style="color:#666666;">Manage City</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//======================================
	//============================================
	if($array_prev[$e][$f]['privilege_id']==346)
	{
		?>
    	<td>
		<table border="0" cellspacing="0" cellpadding="0">
       	<?php 
		if($page_name == 'manage_area.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="manage_area.php" style="color:#7CA32F;">Manage Area</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="manage_area.php" style="color:#666666;">Manage Area</a></td>
				<td class="tab_right"></td>
			</tr>
			<?php
		}            
		?>         
		</table>
		</td>
		<?php 
	}
	//======================================
			}
		}
	}
   
}
					?>

  </tr>
</table>