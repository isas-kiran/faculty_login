<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_admin.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_admin.php" style="color:#7CA32F;">Manage SuperAdmin </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_admin.php" style="color:#666666;">Manage SuperAdmin </a></td>
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
            if($page_name == 'add_admin.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_admin.php" style="color:#7CA32F;">Add SuperAdmin </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_admin.php" style="color:#666666;">Add SuperAdmin </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
<!--<td class="width5"></td>-->
  </tr>
</table>