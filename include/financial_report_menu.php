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
		if($page_name == 'enroll_incomming_gst.php')
		{
			?>
			<tr>
				<td class="tab2_left"></td>
				<td class="tab2_mid"><a href="enroll_incomming_gst.php" style="color:#7CA32F;">Enroll incomming GST</a></td>
				<td class="tab2_right"></td>
			</tr>
			<?php
		}
		else
		{
			?>
			<tr>
				<td class="tab_left"></td>
				<td class="tab_mid"><a href="enroll_incomming_gst.php" style="color:#666666;">Enroll incomming GST</a></td>
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
				if($page_name == 'product_incomming_gst.php')
				{
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="product_incomming_gst.php" style="color:#7CA32F;">Product incomming GST</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
				}
				else
				{
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="product_incomming_gst.php" style="color:#666666;">Product incomming GST</a></td>
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
            if($page_name == 'service_incomming_gst.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="service_incomming_gst.php" style="color:#7CA32F;">Service incomming GST</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="service_incomming_gst.php" style="color:#666666;">Service incomming GST</a></td>
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
            if($page_name == 'purchase_outgoing_gst.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="purchase_outgoing_gst.php" style="color:#7CA32F;">Purchase Outgoing GST</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="purchase_outgoing_gst.php" style="color:#666666;">Purchase Outgoing GST</a></td>
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
            if($page_name == 'expense_outgoing_gst.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="expense_outgoing_gst.php" style="color:#7CA32F;">Expense Outgoing GST</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="expense_outgoing_gst.php" style="color:#666666;">Expense Outgoing GST</a></td>
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
            if($page_name == 'refund_outgoing_gst.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="refund_outgoing_gst.php" style="color:#7CA32F;">Refund Outgoing GST</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="refund_outgoing_gst.php" style="color:#666666;">Refund Outgoing GST</a></td>
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
            if($page_name == 'expense_tds.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="expense_tds.php" style="color:#7CA32F;">Expense TDS</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="expense_tds.php" style="color:#666666;">Expense TDS</a></td>
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
            if($page_name == 'gst_summury_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="gst_summury_report.php" style="color:#7CA32F;">GST Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="gst_summury_report.php" style="color:#666666;">GST Summary Report</a></td>
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
            if($page_name == 'gst_profit_loss_report.php')
            {
				?>
				<tr>
					<td class="tab2_left"></td>
					<td class="tab2_mid"><a href="gst_profit_loss_report.php" style="color:#7CA32F;">GST Profit Loss Report</a></td>
					<td class="tab2_right"></td>
				</tr>
				<?php
            }
            else
            {
				?>
				<tr>
					<td class="tab_left"></td>
					<td class="tab_mid"><a href="gst_profit_loss_report.php" style="color:#666666;">GST Profit Loss Report</a></td>
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
            if($page_name == 'bank_summery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="bank_summery.php" style="color:#7CA32F;">Enrollment Bank Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="bank_summery.php" style="color:#666666;">Enrollment Bank Report</a></td>
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
            if($page_name == 'enrollment_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="enrollment_summery_report.php" style="color:#7CA32F;">Enrollment Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="enrollment_summery_report.php" style="color:#666666;">Enrollment Summary Report</a></td>
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
            if($page_name == 'product_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="product_summery_report.php" style="color:#7CA32F;">Product Sales Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="product_summery_report.php" style="color:#666666;">Product Sales Summary Report</a></td>
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
            if($page_name == 'service_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="service_summery_report.php" style="color:#7CA32F;">Service Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="service_summery_report.php" style="color:#666666;">Service Summary Report</a></td>
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
            if($page_name == 'expense_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="expense_summery_report.php" style="color:#7CA32F;">Expense Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="expense_summery_report.php" style="color:#666666;">Expense Summary Report</a></td>
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
            if($page_name == 'purchase_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="purchase_summery_report.php" style="color:#7CA32F;">Purchase Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="purchase_summery_report.php" style="color:#666666;">Purchase Summary Report</a></td>
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
            if($page_name == 'cash_transfer_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="cash_transfer_summery_report.php" style="color:#7CA32F;">Cash Transfer Bank Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="cash_transfer_summery_report.php" style="color:#666666;">Cash Transfer Bank Report</a></td>
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
            if($page_name == 'receipt_summury_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="receipt_summury_report.php" style="color:#7CA32F;">Receipt Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="receipt_summury_report.php" style="color:#666666;">Receipt Summary Report</a></td>
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
           /* if($page_name == 'all_bank_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="all_bank_report.php" style="color:#7CA32F;">ALl Bank Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="all_bank_report.php" style="color:#666666;">ALl Bank Summary Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }*/
            ?>
        </table>
	</td>-->
    <!--<td class="width5"></td>
    <td>
		<table border="0" cellspacing="0" cellpadding="0">
            <?php
            /*if($page_name == 'bank_summery_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="bank_summery_report.php" style="color:#7CA32F;">Old Bank Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="bank_summery_report.php" style="color:#666666;">Old Bank Summary Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }*/
            ?>
        </table>
	</td>-->
    <td class="width5"></td>
    <td>
		<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'profit_loss_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="profit_loss_report.php" style="color:#7CA32F;">Profit-Loss Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="profit_loss_report.php" style="color:#666666;">Profit-Loass Report</a></td>
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
            if($page_name == 'petty_cash_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="petty_cash_report.php" style="color:#7CA32F;">Petty Cash Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="petty_cash_report.php" style="color:#666666;">Petty Cash Report</a></td>
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
            if($page_name == 'bank_transaction_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="bank_transaction_report.php" style="color:#7CA32F;">Bank Summary Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="bank_transaction_report.php" style="color:#666666;">Bank Summary Report</a></td>
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
        if($array_previ_parent[$e]['privilege_id']==196) //'for only change password'
        {
			$x=0;
			for($f=0;$f<count($array_prev[$e]);$f++)
			{
				if($array_prev[$e][$f]['privilege_id']==197)
				{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php 
							if($page_name == 'enroll_incomming_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="enroll_incomming_gst.php" style="color:#7CA32F;">Enroll Incomming GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="enroll_incomming_gst.php" style="color:#666666;">Enroll Incomming GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}            
							?>  
						</table>
					</td>
					<td class="width5"></td>
					<?php
					$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==198)
				{
				?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'product_incomming_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="product_incomming_gst.php" style="color:#7CA32F;">Product Incomming GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="product_incomming_gst.php" style="color:#666666;">Product Incomming GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
				<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==199)
				{
				?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'service_incomming_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="service_incomming_gst.php" style="color:#7CA32F;">Service Incomming GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="service_incomming_gst.php" style="color:#666666;">Service Incomming GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
					$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==200)
				{
				?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'purchase_outgoing_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="purchase_outgoing_gst.php" style="color:#7CA32F;">Purchase Outgoing GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="purchase_outgoing_gst.php" style="color:#666666;">Purchase Outgoing GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
				<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==201)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'expense_outgoing_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="expense_outgoing_gst.php" style="color:#7CA32F;">Expense Outgoing GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="expense_outgoing_gst.php" style="color:#666666;">Expense Outgoing GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==292)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'refund_outgoing_gst.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="refund_outgoing_gst.php" style="color:#7CA32F;">Refund Outgoing GST</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="refund_outgoing_gst.php" style="color:#666666;">Refund Outgoing GST</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'expense_tds.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="expense_tds.php" style="color:#7CA32F;">Expense TDS</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="expense_tds.php" style="color:#666666;">Expense TDS</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==247)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'gst_summury_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="gst_summury_report.php" style="color:#7CA32F;">GST Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="gst_summury_report.php" style="color:#666666;">GST Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==298)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'gst_profit_loss_report.php')
							{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="gst_profit_loss_report.php" style="color:#7CA32F;">GST Profit Loss Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
							}
							else
							{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="gst_profit_loss_report.php" style="color:#666666;">GST Profit Loss Report</a></td>
									<td class="tab_right"></td>
								</tr>
								<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'bank_summery.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="bank_summery.php" style="color:#7CA32F;">Enrollment Bank Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="bank_summery.php" style="color:#666666;">Enrollment Bank Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==321)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'enrollment_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="enrollment_summery_report.php" style="color:#7CA32F;">Enrollment Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="enrollment_summery_report.php" style="color:#666666;">Enrollment Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'product_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="product_summery_report.php" style="color:#7CA32F;">Product Sales Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="product_summery_report.php" style="color:#666666;">Product Sales Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'service_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="service_summery_report.php" style="color:#7CA32F;">Service Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="service_summery_report.php" style="color:#666666;">Service Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'expense_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="expense_summery_report.php" style="color:#7CA32F;">Expense Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="expense_summery_report.php" style="color:#666666;">Expense Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'purchase_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="purchase_summery_report.php" style="color:#7CA32F;">Purchase Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="purchase_summery_report.php" style="color:#666666;">Purchase Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==202)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'cash_transfer_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="cash_transfer_summery_report.php" style="color:#7CA32F;">Cash Transfer Bank Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="cash_transfer_summery_report.php" style="color:#666666;">Cash Transfer Bank Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==251)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'receipt_summury_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="receipt_summury_report.php" style="color:#7CA32F;">Receipt Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="receipt_summury_report.php" style="color:#666666;">Receipt Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				/*else if($array_prev[$e][$f]['privilege_id']==252)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'all_bank_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="all_bank_report.php" style="color:#7CA32F;">All Bank Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="all_bank_report.php" style="color:#666666;">All Bank Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}*/
				/*else if($array_prev[$e][$f]['privilege_id']==253)
				{
				?>
					<td>
					<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'bank_summery_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="bank_summery_report.php" style="color:#7CA32F;">Old Bank Summary Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="bank_summery_report.php" style="color:#666666;">Old Bank Summary Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}*/
				else if($array_prev[$e][$f]['privilege_id']==278)
				{
				?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'profit_loss_report.php')
							{
							?>
							<tr>
								<td class="tab2_left"></td>
								<td class="tab2_mid"><a href="profit_loss_report.php" style="color:#7CA32F;">Profit-Loss Report</a></td>
								<td class="tab2_right"></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td class="tab_left"></td>
								<td class="tab_mid"><a href="profit_loss_report.php" style="color:#666666;">Profit-Loss Report</a></td>
								<td class="tab_right"></td>
							</tr>
							<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==289)
				{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'petty_cash_report.php')
							{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="petty_cash_report.php" style="color:#7CA32F;">Petty Cash Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
							}
							else
							{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="petty_cash_report.php" style="color:#666666;">Petty Cash Report</a></td>
									<td class="tab_right"></td>
								</tr>
								<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				else if($array_prev[$e][$f]['privilege_id']==329)
				{
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							if($page_name == 'bank_transaction_report.php')
							{
								?>
								<tr>
									<td class="tab2_left"></td>
									<td class="tab2_mid"><a href="bank_transaction_report.php" style="color:#7CA32F;">Bank Summary Report</a></td>
									<td class="tab2_right"></td>
								</tr>
								<?php
							}
							else
							{
								?>
								<tr>
									<td class="tab_left"></td>
									<td class="tab_mid"><a href="bank_transaction_report.php" style="color:#666666;">Bank Summary Report</a></td>
									<td class="tab_right"></td>
								</tr>
								<?php
							}
							?>
						</table>
					</td>
					<td class="width5"></td>
					<?php
				$x++;
				}
				if($x%11==0)
				{
					//echo "<br/>====";
					echo "</tr><tr>";
				}	
			}
		}
	}
   }
   ?>
  </tr>
</table>