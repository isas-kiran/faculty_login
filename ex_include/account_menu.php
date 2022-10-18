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
            if($page_name == 'ex_account_details.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_details.php" style="color:#7CA32F;">Account Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_details.php" style="color:#666666;">Account Details</a></td>
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
  if($page_name == 'ex_account_edit_details.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_edit_details.php" style="color:#7CA32F;">Edit Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_edit_details.php" style="color:#666666;">Edit Details</a></td>
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
  if($page_name == 'ex_account_change_username.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_change_username.php" style="color:#7CA32F;">Change Username</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_change_username.php" style="color:#666666;">Change Username</a></td>
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
  if($page_name == 'ex_account_change_password.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_change_password.php" style="color:#7CA32F;">Change Password</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_change_password.php" style="color:#666666;">Change Password</a></td>
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
  if($page_name == 'ex_wel_comecont.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="wel_comecont.php" style="color:white;">Add Well-Come Containt</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="wel_comecont.php" style="color:white;">Add Well-Come Containt</a></td>
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
  if($page_name == 'wish_image.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="wish_image.php" style="color:white;">Add Wish Image</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="wish_image.php" style="color:white;">Add Wish Image</a></td>
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
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
    $array_previ_parent= $_SESSION['privilege_id_parent'];
   
    for($e=0;$e<count($array_previ_parent);$e++)
    {

        if($array_previ_parent[$e]['privilege_id']==1) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==28)
				{
			?>

<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'ex_account_details.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_details.php" style="color:#7CA32F;">Account Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_details.php" style="color:#666666;">Account Details</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
  
</table>
</td>
<?php }elseif($array_prev[$e][$f]['privilege_id']==29){?>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'ex_account_edit_details.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_edit_details.php" style="color:#7CA32F;">Edit Details</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_edit_details.php" style="color:#666666;">Edit Details</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    <?php }elseif($array_prev[$e][$f]['privilege_id']==30){?>
	<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'ex_account_change_username.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_change_username.php" style="color:#7CA32F;">Change Username</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_change_username.php" style="color:#666666;">Change Username</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
  
</table>
	</td>
    <?php }elseif($array_prev[$e][$f]['privilege_id']==31){?>
	<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'ex_account_change_password.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_account_change_password.php" style="color:#7CA32F;">Change Password</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_account_change_password.php" style="color:#666666;">Change Password</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
  
</table>
	</td>
    <?php
				}
			}
		}
	}
}
				?>
   
  </tr>
</table>