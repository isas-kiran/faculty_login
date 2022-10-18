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
            if($page_name =='ex_privilages_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_privilages_manage.php" style="color:#7CA32F;">Manage Previlages </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_privilages_manage.php" style="color:#666666;">Manage Previlages </a></td>
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
  if($page_name == 'ex_add_privileges.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_add_privilages.php" style="color:#7CA32F;">Add Previlages </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_add_privilages.php" style="color:#666666;">Add Previlages </a></td>
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
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
    $array_previ_parent= $_SESSION['privilege_id_parent'];
    for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==7) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==25)
				{
			?>

<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='course_manage.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_privilages_manage.php" style="color:#7CA32F;">Manage Previlages </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_privilages_manage.php" style="color:#666666;">Manage Previlages </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
</table>
</td>
<?php }elseif($array_prev[$e][$f]['privilege_id']==26){?>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'ex_add_course.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="ex_add_privilages.php" style="color:#7CA32F;">Add Previlages </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="ex_add_privilages.php" style="color:#666666;">Add Previlages </a></td>
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