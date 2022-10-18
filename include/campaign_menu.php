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
            if($page_name =='manage_campaign.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_campaign.php" style="color:#7CA32F;">Manage Campaign </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_campaign.php" style="color:#666666;">Manage Campaign </a></td>
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
  if($page_name == 'add_campaign.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_campaign.php" style="color:#7CA32F;">Add Campaign </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_campaign.php" style="color:#666666;">Add Campaign </a></td>
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
  			if($page_name == 'campaign_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="campaign_report.php" style="color:#7CA32F;">Campaign Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="campaign_report.php" style="color:#666666;">Campaign Report</a></td>
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
        if($page_name == 'campaign_main_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="campaign_main_report.php" style="color:#7CA32F;">Campaign Inquiry Report</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="campaign_main_report.php" style="color:#666666;">Campaign Inquiry Report</a></td>
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
        if($page_name == 'campaign_staff_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="campaign_staff_report.php" style="color:#7CA32F;">Campaign Staff Report</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="campaign_staff_report.php" style="color:#666666;">Campaign Staff Report</a></td>
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
        if($page_name == 'campaign_performance_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="campaign_performance_report.php" style="color:#7CA32F;">Campaign Performance Report</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="campaign_performance_report.php" style="color:#666666;">Campaign Performance Report</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==235) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==236)
				{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name =='manage_campaign.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="manage_campaign.php" style="color:#7CA32F;">Manage Campaign</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="manage_campaign.php" style="color:#666666;">Manage campaign</a></td>
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
                    else if($array_prev[$e][$f]['privilege_id']==237)
                    {
                    ?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'add_campaign.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="add_campaign.php" style="color:#7CA32F;">Add Campaign</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="add_campaign.php" style="color:#666666;">Add Campaign</a></td>
                                    <td class="tab_right"></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </td>
                    <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==238)
					{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
							<?php
                            if($page_name == 'campaign_report.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="campaign_report.php" style="color:#7CA32F;">Campaign Report</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="campaign_report.php" style="color:#666666;">Campaign Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==256)
					{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
							<?php
                            if($page_name == 'campaign_main_report.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="campaign_main_report.php" style="color:#7CA32F;">Campaign Inquiry Report</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="campaign_main_report.php" style="color:#666666;">Campaign Inquiry Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==257)
					{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
							<?php
                            if($page_name == 'campaign_staff_report.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="campaign_staff_report.php" style="color:#7CA32F;">Campaign Staff Report</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="campaign_staff_report.php" style="color:#666666;">Campaign Staff Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==346)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'campaign_performance_report.php')
								{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="campaign_performance_report.php" style="color:#7CA32F;">Campaign Performance Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="campaign_performance_report.php" style="color:#666666;">Campaign Performance Report</a></td>
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