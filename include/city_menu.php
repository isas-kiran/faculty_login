<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'city_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="city_manage.php" style="color:#7CA32F;">Manage City </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="city_manage.php" style="color:#666666;">Manage City </a></td>
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
            if($page_name == 'city_add.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="city_add.php" style="color:#7CA32F;">Add City </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="city_add.php" style="color:#666666;">Add City </a></td>
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