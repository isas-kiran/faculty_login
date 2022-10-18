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
            if($page_name == 'lb_issue_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_issue_book.php" style="color:#7CA32F;">Issue Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_issue_book.php" style="color:#666666;">Issue Book</a></td>
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
            if($page_name == 'lb_return_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_return_book.php" style="color:#7CA32F;">Return Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_return_book.php" style="color:#666666;">Return Book</a></td>
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
            if($page_name == 'lb_manage_issue_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_manage_issue_book.php" style="color:#7CA32F;">Manage Issued Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_manage_issue_book.php" style="color:#666666;">Manage Issued Book</a></td>
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
            if($page_name == 'lb_manage_return_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_manage_return_book.php" style="color:#7CA32F;">Manage Return Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_manage_return_book.php" style="color:#666666;">Manage Return Book</a></td>
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
            if($page_name == 'lb_manage_lost_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_manage_lost_book.php" style="color:#7CA32F;">Manage Book Lost</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_manage_lost_book.php" style="color:#666666;">Manage Book Lost</a></td>
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
            if($page_name == 'lb_manage_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_manage_book.php" style="color:#7CA32F;">Manage Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_manage_book.php" style="color:#666666;">Manage Book</a></td>
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
            if($page_name == 'lb_add_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_add_book.php" style="color:#7CA32F;">Add Book</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_add_book.php" style="color:#666666;">Add Book</a></td>
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
            if($page_name == 'lb_add_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_add_category.php" style="color:#7CA32F;">Add Cateory</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_add_category.php" style="color:#666666;">Add Category</a></td>
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
            if($page_name == 'lb_manage_user.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_manage_user.php" style="color:#7CA32F;">Manage Users</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_manage_user.php" style="color:#666666;">Manage Users</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>-->
<!--<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'lb_total_book.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_total_book.php" style="color:#7CA32F;">Total Books</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_total_book.php" style="color:#666666;">Total Books</a></td>
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
            if($page_name == 'lb_user_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lb_user_report.php" style="color:#7CA32F;">User Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lb_user_report.php" style="color:#666666;">User Report</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==263) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==264)
				{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                        <?php 
                            if($page_name == 'lb_issue_book.php')
                            {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="lb_issue_book.php" style="color:#7CA32F;">Issue Book</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                            }
                            else
                            {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="lb_issue_book.php" style="color:#666666;">Issue Book</a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==265)
				{
					?>
                    <td>
                		<table border="0" cellspacing="0" cellpadding="0">
						<?php 
                        if($page_name == 'lb_manage_issue_book.php')
                        {
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="lb_manage_issue_book.php" style="color:#7CA32F;">Manage Issued Book</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
                        }
						else
						{
                        	?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="lb_manage_issue_book.php" style="color:#666666;">Manage Issued Book</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==266)
					{
					?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                        <?php 
                        if($page_name == 'lb_manage_return_book.php')
                        {
                            ?>
                            <tr>
                                <td class="tab2_left"></td>
                                <td class="tab2_mid"><a href="lb_manage_return_book.php" style="color:#7CA32F;">Manage Returned Book</a></td>
                                <td class="tab2_right"></td>
                            </tr>
                            <?php
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td class="tab_left"></td>
                                <td class="tab_mid"><a href="lb_manage_return_book.php" style="color:#666666;">Manage Returned Book</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==267)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_manage_lost_book.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_manage_lost_book.php" style="color:#7CA32F;">Manage Lost Book</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_manage_lost_book.php" style="color:#666666;">Manage Lost Book</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==268)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_manage_book.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_manage_book.php" style="color:#7CA32F;">Manage Book</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_manage_book.php" style="color:#666666;">Manage Book</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==269)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_add_book.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_add_book.php" style="color:#7CA32F;">Add Book</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_add_book.php" style="color:#666666;">Add Book</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==270)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_add_category.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_add_category.php" style="color:#7CA32F;">Add Category</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_add_category.php" style="color:#666666;">Add Category</a></td>
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
					/*else if($array_prev[$e][$f]['privilege_id']==271)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_manage_user.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_manage_user.php" style="color:#7CA32F;">Manage User</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_manage_user.php" style="color:#666666;">Manage User</a></td>
                                    <td class="tab_right"></td>
                                </tr>
                                <?php
                            }            
                            ?>         
                            </table>
                        </td>
                        <td class="width5"></td>
						<?php
					}*/
					/*else if($array_prev[$e][$f]['privilege_id']==272)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_total_book.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_total_book.php" style="color:#7CA32F;">Total Books</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_total_book.php" style="color:#666666;">Total Books</a></td>
                                    <td class="tab_right"></td>
                                </tr>
                                <?php
                            }            
                            ?>         
                            </table>
                        </td>
                        <td class="width5"></td>
						<?php
					}*/
					else if($array_prev[$e][$f]['privilege_id']==273)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            if($page_name == 'lb_user_book_report.php')
                            {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="lb_user_book_report.php" style="color:#7CA32F;">User Report</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="lb_user_book_report.php" style="color:#666666;">User Report</a></td>
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