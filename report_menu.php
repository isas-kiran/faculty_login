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
					<td class="tab2_mid"><a href="manage_report.php" style="color:#7CA32F;">Manage Student Report </a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="manage_report.php" style="color:#666666;">Manage Student Report </a></td>
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
                <td class="tab2_mid"><a href="total_enquiry.php" style="color:#7CA32F;">Total Enquiry Report </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_enquiry.php" style="color:#666666;">Total Enquiry Report </a></td>
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
            if($page_name == 'manage_stack_report.php' || $page_name == 'manage_daily_stack_report.php' || $page_name == 'manage_inq_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_stack_report.php" style="color:#7CA32F;">All Stack Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_stack_report.php" style="color:#666666;">All Stack Report</a></td>
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
            if($page_name == 'manage_fresh_leads_stack_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_fresh_leads_stack_report.php" style="color:#7CA32F;">Fresh Lead Stack Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_fresh_leads_stack_report.php" style="color:#666666;">Fresh Lead Stack Report</a></td>
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
            if($page_name == 'lead.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="lead.php" style="color:#7CA32F;">Lead Grade Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="lead.php" style="color:#666666;">Lead Grade Report</a></td>
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
            if($page_name == 'outstand_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="outstand_report.php" style="color:#7CA32F;">OutStanding Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="outstand_report.php" style="color:#666666;">OutStanding Report</a></td>
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
            if($page_name == 'product_outstand_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="product_outstand_report.php" style="color:#7CA32F;">Product OutStanding Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="product_outstand_report.php" style="color:#666666;">Product OutStanding Report</a></td>
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
            if($page_name == 'total_sales_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_sales_report.php" style="color:#7CA32F;">Total Sales Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_sales_report.php" style="color:#666666;">Total Sales Report</a></td>
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
            if($page_name == 'total_product_sales_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_product_sales_report.php" style="color:#7CA32F;">Total Product Sales Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_product_sales_report.php" style="color:#666666;">Total Product Sales Report</a></td>
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
            if($page_name == 'total_purchase_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_purchase_report.php" style="color:#7CA32F;">Total Purchase Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_purchase_report.php" style="color:#666666;">Total Purchase Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    
    <td class="width5"></td>
    </tr>
    
    <tr>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'total_service_sales_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="total_service_sales_report.php" style="color:#7CA32F;">Total Service Sales Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="total_service_sales_report.php" style="color:#666666;">Total Service Sales Report</a></td>
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
            if($page_name == 'package_service.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="package_service.php" style="color:#7CA32F;">Package Service Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="package_service.php" style="color:#666666;">Package Service Report</a></td>
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
                <td class="tab2_mid"><a href="dsr_report.php" style="color:#7CA32F;">Manage DSR Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="dsr_report.php" style="color:#666666;">Manage DSR Report</a></td>
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
            if($page_name == 'consumption_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="consumption_report.php" style="color:#7CA32F;">Consumption Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="consumption_report.php" style="color:#666666;">Consumption Report</a></td>
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
            <td class="tab2_mid"><a href="customer_service_report.php" style="color:#7CA32F;">Customer Service Report</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="customer_service_report.php" style="color:#666666;">Customer Service Report</a></td>
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
    if($page_name == 'customer_sales_report.php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="customer_sales_report.php" style="color:#7CA32F;">Customer Sales Report</a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
    }
    else
    {
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="customer_sales_report.php" style="color:#666666;">Customer Sales Report</a></td>
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
        if($page_name == 'customer_ladger.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="customer_ladger.php" style="color:#7CA32F;">Customer Ledger</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="customer_ladger.php" style="color:#666666;">Customer Ledger</a></td>
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
        if($page_name == 'student_ladger.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="student_ladger.php" style="color:#7CA32F;">Student Ledger</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="student_ladger.php" style="color:#666666;">student Ledger</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
        }
        ?>
        </table>
	</td>
    <td class="width5"></td>
    </tr>
    
    <tr>
	<td>
        <table border="0" cellspacing="0" cellpadding="0">
        <?php
        if($page_name == 'employee_ladger.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="employee_ladger.php" style="color:#7CA32F;">Employee Ledger</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="employee_ladger.php" style="color:#666666;">Employee Ledger</a></td>
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
        if($page_name == 'vendor_ladger.php')
        {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="vendor_ladger.php" style="color:#7CA32F;">Vendor Ledger</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="vendor_ladger.php" style="color:#666666;">Vendor Ledger</a></td>
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
        if($page_name == 'audit_report.php')
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
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
		<?php
        if($page_name == 'feedback_report.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="feedback_report.php" style="color:#7CA32F;">Service Feedback Report</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="feedback_report.php" style="color:#666666;">Service Feedback Report</a></td>
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
            if($page_name == 'service_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="service_report.php" style="color:#7CA32F;">Service Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="service_report.php" style="color:#666666;">Service Report</a></td>
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
            if($page_name == 'daily_sales_performance_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="daily_sales_performance_report.php" style="color:#7CA32F;">DSP Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="daily_sales_performance_report.php" style="color:#666666;">DSP Report</a></td>
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
            if($page_name=='product_stock_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="product_stock_report.php" style="color:#7CA32F;">Product Stock Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="product_stock_report.php" style="color:#666666;">Product Stock Report</a></td>
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
            if($page_name=='manage_ni_report.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="manage_ni_report.php" style="color:#7CA32F;">Manage Ni/Invalid Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="manage_ni_report.php" style="color:#666666;">Manage Ni/Invalid Report</a></td>
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
            if($page_name=='certificate_issued_report.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="certificate_issued_report.php" style="color:#7CA32F;">Certificate Issued Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="certificate_issued_report.php" style="color:#666666;">Certificate Issued Report</a></td>
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
            if($page_name=='manage_all_dsr_reports.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="manage_all_dsr_reports.php" style="color:#7CA32F;">Manage All Centre DSR</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="manage_all_dsr_reports.php" style="color:#666666;">Manage All Centre DSR</a></td>
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
            if($page_name=='upcoming_student_batch_report.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="upcoming_student_batch_report.php" style="color:#7CA32F;">Upcoming Student Batch Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="upcoming_student_batch_report.php" style="color:#666666;">Upcoming Student Batch Report</a></td>
					<td class="tab_right"></td>
				</tr>
				<?php
            }
            ?>
        </table>
    </td>
    </tr>
    
    <tr>
    <td class="width5"></td>
    <td>
        <table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name=='outstanding_installment_report.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="outstanding_installment_report.php" style="color:#7CA32F;">Outstanding Installment Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="outstanding_installment_report.php" style="color:#666666;">Outstanding Installment Report</a></td>
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
            if($page_name=='outstanding_installment_report_by_date.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="outstanding_installment_report_by_date.php" style="color:#7CA32F;">Daily Outstanding Installment Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="outstanding_installment_report_by_date.php" style="color:#666666;">Daily Outstanding Installment Report</a></td>
					<td class="tab_right"></td>
				</tr>
				<?php
            }
            ?>
        </table>
    </td>
    </tr>
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
					else if($array_prev[$e][$f]['privilege_id']==274)
					{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'manage_stack_report.php' || $page_name == 'manage_daily_stack_report.php' || $page_name == 'manage_inq_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="manage_stack_report.php" style="color:#7CA32F;">Stack Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="manage_stack_report.php" style="color:#666666;">Stack Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==338)
					{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'manage_fresh_leads_stack_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="manage_fresh_leads_stack_report.php" style="color:#7CA32F;">Fresh Lead Stack Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="manage_fresh_leads_stack_report.php" style="color:#666666;">Fresh Lead Stack Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==148)
					{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'lead.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="lead.php" style="color:#7CA32F;">Lead Grade Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="lead.php" style="color:#666666;">Lead Grade Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==149)
					{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'outstand_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="outstand_report.php" style="color:#7CA32F;">OutStanding Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="outstand_report.php" style="color:#666666;">OutStanding Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==248)
					{
					?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'product_outstand_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="product_outstand_report.php" style="color:#7CA32F;">Product OutStanding Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="product_outstand_report.php" style="color:#666666;">Product OutStanding Report</a></td>
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
                    else if($array_prev[$e][$f]['privilege_id']==154)
                    {
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'total_sales_report.php')
								{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="total_sales_report.php" style="color:#7CA32F;">Total Sales Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="total_sales_report.php" style="color:#666666;">Total Sales Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==316)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'total_product_sales_report.php')
								{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="total_product_sales_report.php" style="color:#7CA32F;">Total Product Sales Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="total_product_sales_report.php" style="color:#666666;">Total Product Sales Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==317)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'total_purchase_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="total_purchase_report.php" style="color:#7CA32F;">Total Purchase Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="total_purchase_report.php" style="color:#666666;">Total Purchase Report</a></td>
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
                    else if($array_prev[$e][$f]['privilege_id']==318)
                    {
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'total_service_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="total_service_report.php" style="color:#7CA32F;">Total Service Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="total_service_report.php" style="color:#666666;">Total service Report</a></td>
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
                    else if($array_prev[$e][$f]['privilege_id']==150)
                    {
						?>
                        <td>
                        	<table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'package_service.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="package_service.php" style="color:#7CA32F;">Package Service Report</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="package_service.php" style="color:#666666;">Package Service Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==176)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'consumption_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="consumption_report.php" style="color:#7CA32F;">Consumption Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="consumption_report.php" style="color:#666666;">Consumption Report</a></td>
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
							<td class="tab2_mid"><a href="customer_service_report.php" style="color:#7CA32F;">Customer Service Report</a></td>
							<td class="tab2_right"></td>
						</tr>
						<?php
						}
						else
						{
						?>
						<tr>
							<td class="tab_left"></td>
							<td class="tab_mid"><a href="customer_service_report.php" style="color:#666666;">Customer Service Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==277)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <?php
                            if($page_name == 'customer_sales_report.php')
                            {
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="customer_sales_report.php" style="color:#7CA32F;">Customer Sales Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
                            }
                            else
                            {
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="customer_sales_report.php" style="color:#666666;">Customer Sales Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==279)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
								<?php
                                if($page_name == 'customer_ladger.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="customer_ladger.php" style="color:#7CA32F;">Customer Ledger</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="customer_ladger.php" style="color:#666666;">Customer Ledger</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==280)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
								<?php
                                if($page_name=='student_ladger.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="student_ladger.php" style="color:#7CA32F;">Student Ledger</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="student_ladger.php" style="color:#666666;">Student Ledger</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==281)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
								<?php
                                if($page_name=='employee_ladger.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="employee_ladger.php" style="color:#7CA32F;">Employee Ledger</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="employee_ladger.php" style="color:#666666;">Employee Ledger</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==282)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name=='vendor_ladger.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="vendor_ladger.php" style="color:#7CA32F;">Vendor Ledger</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="vendor_ladger.php" style="color:#666666;">Vendor Ledger</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==153)
					{
						?>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'audit_report.php')
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
					else if($array_prev[$e][$f]['privilege_id']==239)
					{
						?>
						<td>
						<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'feedback_report.php')
								{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="feedback_report.php" style="color:#7CA32F;">Service Feedback Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="feedback_report.php" style="color:#666666;">Service Feedback Report</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==240)
					{
						?>
						<td>
						<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'service_report.php')
								{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="service_report.php" style="color:#7CA32F;">Service Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
								}
								else
								{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="service_report.php" style="color:#666666;">Service Report</a></td>
									<td class="tab_right"></td>
								</tr>
								<?php
								}
								?>
							</table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==347)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'daily_sales_performance_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="daily_sales_performance_report.php" style="color:#7CA32F;">DSP Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="daily_sales_performance_report.php" style="color:#666666;">DSP Report</a></td>
										<td class="tab_right"></td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==348)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'product_stock_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="product_stock_report.php" style="color:#7CA32F;">Product Stock Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="product_stock_report.php" style="color:#666666;">Product Stock Report</a></td>
										<td class="tab_right"></td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==364)
					{
						?>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<?php
								if($page_name == 'certificate_issued_report.php')
								{
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="certificate_issued_report.php" style="color:#7CA32F;">Certificate Issued Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="certificate_issued_report.php" style="color:#666666;">Certificate Issued Report</a></td>
										<td class="tab_right"></td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==365)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'manage_all_dsr_reports.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="manage_all_dsr_reports.php" style="color:#7CA32F;">Manage All Centre DSR</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="manage_all_dsr_reports.php" style="color:#666666;">Manage All Centre DSR</a></td>
                                    <td class="tab_right"></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==366)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'upcoming_student_batch_report.php')
                                {
                                ?>
                                <tr>
                                    <td class="tab2_left"></td>
                                    <td class="tab2_mid"><a href="upcoming_student_batch_report.php" style="color:#7CA32F;">Upcoming Student Batch Report</a></td>
                                    <td class="tab2_right"></td>
                                </tr>
                                <?php
                                }
                                else
                                {
                                ?>
                                <tr>
                                    <td class="tab_left"></td>
                                    <td class="tab_mid"><a href="upcoming_student_batch_report.php" style="color:#666666;"> Upcoming Student Batch Report</a></td>
                                    <td class="tab_right"></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==368)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'outstanding_installment_report.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="outstanding_installment_report.php" style="color:#7CA32F;">Outstanding Installment Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="outstanding_installment_report.php" style="color:#666666;">Outstanding Installment Report</a></td>
										<td class="tab_right"></td>
									</tr>
									<?php
                                }
                                ?>
                            </table>
						</td>
						<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==369)
					{
						?>
						<td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <?php
                                if($page_name == 'outstanding_installment_report_by_date.php')
                                {
									?>
									<tr>
										<td class="tab2_left"></td>
										<td class="tab2_mid"><a href="outstanding_installment_report_by_date.php" style="color:#7CA32F;">Daily Outstanding Installment Report</a></td>
										<td class="tab2_right"></td>
									</tr>
									<?php
                                }
                                else
                                {
									?>
									<tr>
										<td class="tab_left"></td>
										<td class="tab_mid"><a href="outstanding_installment_report_by_date.php" style="color:#666666;">Daily Outstanding Installment Report</a></td>
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