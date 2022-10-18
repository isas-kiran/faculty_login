<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='ex_manage_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_manage_question.php" style="color:#7CA32F;">Manage Subject Questions </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_manage_question.php" style="color:#666666;">Manage Subject Questions </a></td>
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
  if($page_name == 'ex_create_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_create_question.php" style="color:#7CA32F;">Add Subject Quations </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_create_question.php" style="color:#666666;">Add Subject Quations </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
  </tr>
</table>