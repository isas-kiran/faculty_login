<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>
	<table border="0" cellspacing="0" cellpadding="0">
           <?php 
            if($page_name == 'manage_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_source.php" style="color:white;">Manage Source </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_source.php" style="color:white;">Manage Source </a></td>
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
            if($page_name == 'add_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_source.php" style="color:white;">Add Source </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_source.php" style="color:white;">Add Source </a></td>
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
                <td class="tab2_mid"><a href="manage_tax.php" style="color:white;">Manage Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_tax.php" style="color:white;">Manage Tax </a></td>
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
                <td class="tab2_mid"><a href="add_tax.php" style="color:white;">Add Tax </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_tax.php" style="color:white;">Add Tax </a></td>
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
                <td class="tab2_mid"><a href="manage_discount.php" style="color:white;">Manage Discount </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_discount.php" style="color:white;">Manage Discount </a></td>
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
                <td class="tab2_mid"><a href="add_discount.php" style="color:white;">Add Discount </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_discount.php" style="color:white;">Add Discount </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    <td class="width5"></td>
  </tr>
</table>