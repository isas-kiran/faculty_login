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
            if($page_name == 'manage_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_report.php" style="color:#7CA32F;">Manage Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_report.php" style="color:#666666;">Manage Report </a></td>
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
            if($page_name == 'total_enrollment.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_enrollment.php" style="color:#7CA32F;">Total Enrollment </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_enrollment.php" style="color:#666666;">Total Enrollment </a></td>
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
            if($page_name == 'total_enquiry.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_enquiry.php" style="color:#7CA32F;">Total Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_enquiry.php" style="color:#666666;">Total Enquiry </a></td>
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
            if($page_name == 'total_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_source.php" style="color:#7CA32F;">Source by Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_source.php" style="color:#666666;">Source Report</a></td>
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
            if($page_name == 'total_response.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_response.php" style="color:#7CA32F;">Response Category Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_response.php" style="color:#666666;">Response Category Report</a></td>
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
            if($page_name == 'manage_expense.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_expense.php" style="color:#7CA32F;">Manage Expense</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_expense.php" style="color:#666666;">Manage Expense</a></td>
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
            if($page_name == 'dsr_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="dsr_report.php" style="color:#7CA32F;">Manage DSR</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="dsr_report.php" style="color:#666666;">Manage DSR</a></td>
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
            if($page_name == 'checkout_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="checkout_report.php" style="color:#7CA32F;">Checkout Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="checkout_report.php" style="color:#666666;">Checkout Report</a></td>
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
            if($page_name == 'customer_service_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="customer_service_report.php" style="color:#7CA32F;">Service & Sales Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="customer_service_report.php" style="color:#666666;">Service & Sales Report</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==16) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==97)
				{
			?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_report.php" style="color:#7CA32F;">Manage Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_report.php" style="color:#666666;">Manage Report </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==98)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_enrollment.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_enrollment.php" style="color:#7CA32F;">Total Enrollment </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_enrollment.php" style="color:#666666;">Total Enrollment </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==99)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_enquiry.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_enquiry.php" style="color:#7CA32F;">Total Enquiry </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_enquiry.php" style="color:#666666;">Total Enquiry </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==100)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_source.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_source.php" style="color:#7CA32F;">Source by Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_source.php" style="color:#666666;">Source Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==101)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_response.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_response.php" style="color:#7CA32F;">Response Category Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_response.php" style="color:#666666;">Response Category Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==102)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_expense.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_expense.php" style="color:#7CA32F;">Manage Expense</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_expense.php" style="color:#666666;">Manage Expense</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==103)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'dsr_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="dsr_report.php" style="color:#7CA32F;">Manage DSR</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="dsr_report.php" style="color:#666666;">Manage DSR</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==143)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'checkout_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="checkout_report.php" style="color:#7CA32F;">Checkout Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="checkout_report.php" style="color:#666666;">Checkout Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==144)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'customer_service_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="customer_service_report.php" style="color:#7CA32F;">Service & Sales Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="customer_service_report.php" style="color:#666666;">Service & Sales Report</a></td>
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