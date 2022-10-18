<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_scheme.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_scheme.php" style="color:#7CA32F;">Manage Scheme </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_scheme.php" style="color:#666666;">Manage Scheme </a></td>
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
            if($page_name == 'add_pages.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_scheme.php" style="color:#7CA32F;">Add Scheme </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_scheme.php" style="color:#666666;">Add Scheme </a></td>
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
            if($page_name == 'add_sub_scheme.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_sub_scheme.php" style="color:#7CA32F;">Add Sub Scheme </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_sub_scheme.php" style="color:#666666;">Add Sub Scheme  </a></td>
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