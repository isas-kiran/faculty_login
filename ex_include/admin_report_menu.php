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
            if($page_name =='audit_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="audit_report.php" style="color:#7CA32F;">Audit Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="audit_report.php" style="color:#666666;">Audit Report</a></td>
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

        if($array_previ_parent[$e]['privilege_id']==5) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==27)
				{
			?>

<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='audit_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="audit_report.php" style="color:#7CA32F;">Audit Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="audit_report.php" style="color:#666666;">Audit Report</a></td>
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