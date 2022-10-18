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
                    if($page_name =='manage_assets.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="manage_assets.php" style="color:#7CA32F;">Manage Assets</a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="manage_assets.php" style="color:#666666;">Manage Assets</a></td>
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
                    if($page_name =='add_assets.php')
                    {
                    ?>
                    <tr>
                        <td class="tab2_left"></td>
                        <td class="tab2_mid"><a href="add_assets.php" style="color:#7CA32F;">Add Assets</a></td>
                        <td class="tab2_right"></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td class="tab_left"></td>
                        <td class="tab_mid"><a href="add_assets.php" style="color:#666666;">Add Assets</a></td>
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
  			if($page_name == 'manage_assets_category.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="manage_assets_category.php" style="color:#7CA32F;">Manage Asset Category</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="manage_assets_category.php" style="color:#666666;">Manage Asset Category</a></td>
					<td class="tab_right"></td>
				</tr>
				<?php
            }
            ?>
			</table>
		</td>
		<td class="width5"></td>
        <td class="width5"></td>
    	<td>
			<table border="0" cellspacing="0" cellpadding="0">
            <?php
  			if($page_name == 'manage_assets_type.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="manage_assets_type.php" style="color:#7CA32F;">Manage Asset Type</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="manage_assets_type.php" style="color:#666666;">Manage Asset Type</a></td>
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
  			if($page_name == 'add_assets_type.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="add_assets_type.php" style="color:#7CA32F;">Add Asset Type</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="add_assets_type.php" style="color:#666666;">Add Asset Type</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==330) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==331)
				{
					?>
    				<td>
						<table border="0" cellspacing="0" cellpadding="0">
						<?php 
                        if($page_name =='manage_assets.php')
                        {
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="manage_assets.php" style="color:#7CA32F;">Manage Assets</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
                        }
                        else
                        {
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="manage_assets.php" style="color:#666666;">Manage Assets</a></td>
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
				if($array_prev[$e][$f]['privilege_id']==332)
				{
					?>
    				<td>
						<table border="0" cellspacing="0" cellpadding="0">
						<?php 
                        if($page_name =='add_assets.php')
                        {
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="add_assets.php" style="color:#7CA32F;">Add Assets</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
                        }
                        else
                        {
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="add_assets.php" style="color:#666666;">Add Assets</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==333)
				{
					?>
    				<td>
						<table border="0" cellspacing="0" cellpadding="0">
            			<?php
  						if($page_name == 'manage_assets_category.php')
						{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="manage_assets_category.php" style="color:#7CA32F;">Manage Assets Category</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
						}
						else
						{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="manage_assets_category.php" style="color:#666666;">Manage Assets Category</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==334)
				{
					?>
    				<td>
						<table border="0" cellspacing="0" cellpadding="0">
            			<?php
  						if($page_name == 'manage_assets_type.php')
						{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="manage_assets_type.php" style="color:#7CA32F;">Manage Assets Type</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
						}
						else
						{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="manage_assets_type.php" style="color:#666666;">Manage Assets Type</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==335)
				{
					?>
    				<td>
						<table border="0" cellspacing="0" cellpadding="0">
            			<?php
  						if($page_name == 'add_assets_type.php')
						{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="add_assets_type.php" style="color:#7CA32F;">Add Assets Type</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
						}
						else
						{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="add_assets_type.php" style="color:#666666;">Add Assets Type</a></td>
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