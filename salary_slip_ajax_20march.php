<?php include 'inc_classes.php';
 ?>
<style>

.table1, .th1, .td1 {
    border: 1px solid;
    border-collapse: collapse;

    padding: 4px;
	font-size:12px;
}
.td2 {
   text-align:center;
}

.table2 tr:first-child td {
  border-top: 0;
}
.table2 tr td:first-child {
  border-left: 0;
}
.table2 tr:last-child td {
  border-bottom: 0;
}
.table2 tr td:last-child {
  border-right: 0;
}

.table2 tr:first-child th {
  border-top: 0;
}
.table2 tr th:first-child {
  border-left: 0;
}
.table2 tr:last-child th {
  border-bottom: 0;
}
.table2 tr th:last-child {
  border-right: 0;
}
</style>
</br>
</br>
<hr>
<?php 
$select_exc = "select * from pr_staff_salary_management where branch_name='".$_REQUEST['branch_name']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND staff_id='".$_REQUEST['staff']."' AND payment_action=1";
                         $payment1 = mysql_query($select_exc);
                         $payment = $db->fetch_array($db->query($select_exc));
							
				
						 $select_staff = "select attendence_id,admin_id,name,company_name from site_setting where attendence_id='".$_REQUEST['staff']."' "; 
							$staff = $db->fetch_array($db->query($select_staff));
							
						   
							if($staff['company_name']=='ISAS')
							{
								$address = "select * from branch where branch_name='".$_REQUEST['branch_name']."'"; 
							    $add = $db->fetch_array($db->query($address));
								$address1=strip_tags($add['branch_address']);
								$company_name="ISAS Beauty School";
								$img='<img src="images/logo.jpg" height="25%" width="50%"/>';
							}
							elseif($staff['company_name']=='Innocent')
							{
								$address = "select * from branch where branch_name='".$_REQUEST['branch_name']."'"; 
							    $add = $db->fetch_array($db->query($address));
								$address1=strip_tags($add['innocent_address']);
								$company_name="Innocent Salon";
								$img='<img src="images/innocent1.png" height="25%" width="50%"/>';
							}
							else
							if(trim($staff['company_name'])=='Frespa')
							{
								$address = "select * from branch where branch_name='".$_REQUEST['branch_name']."'"; 
							    $add = $db->fetch_array($db->query($address));
								$address1=strip_tags($add['frespa_address']);
								$company_name="Frespa Consultancy";
								$img='<img src="images/freshpa.png" height="25%" width="50%"/>';
							} 
							 
							
							 $rent = "select * from pr_add_salary_details where staff_id='".$_REQUEST['staff']."' "; 
							$rent_Detail = $db->fetch_array($db->query($rent));
							
							$leaves = "select * from pr_staff_leave_management where staff_id='".$_REQUEST['staff']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' order by staff_leave_id desc limit 0,1"; 
							$pre_leaves = $db->fetch_array($db->query($leaves));
							
							 $staff_salary = "select * from pr_staff_salary_management where branch_name='".$_REQUEST['branch_name']."' AND staff_id='".$_REQUEST['staff']."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."'"; 
							$staff_sal = $db->fetch_array($db->query($staff_salary));
							
							$current_Month1 =date('Y').'-'.$_REQUEST['month'].'-01';
							$last_month=Date('m', strtotime('-1 month',strtotime($current_Month1)));
							 $last_year=Date('Y', strtotime('-1 month',strtotime($current_Month1)));
							 $leave_detail = "select * from pr_previous_leave_management where staff_id='".$_REQUEST['staff']."' AND month='".$last_month."' AND year='".$last_year."' order by previous_leave_id desc limit 0,1";     
							 $leave = $db->fetch_array($db->query($leave_detail));
							 $lev = mysql_query($leave_detail);
							 $leav_count=mysql_num_rows($lev);
							 $previous_balance_leaves=$leave['previous_balance_leaves'];
							 
if(mysql_num_rows($payment1))
{								?>
<center>
 <input class="input_btn" type="button" onClick="PrintDiv();" name="btnPrint" id="btnPrint" value="Print" style="width: 70px;background-color: #424A5D;">
</br>
</br>
<div id="showtable">
<table id="customer-order" style="overflow: visible;width:70%;" class="table1">
  <tr>
    <th class="th1" style="width:50%" colspan="3"><?php echo $img; ?></th>
    <th class="th1" style="width:50%" colspan="2"><b style="font-size:24px;"><?php echo $company_name; ?></b></th> 
  </tr>
  <tr>
   
    <td class="td1" colspan="5"><center><p style=""><?php echo $address1; ?>		</p></center>	
			
</td>
   
  </tr>
  <tr>
    <?php 
	                            if($_REQUEST['month']=='1'){ $month="January"; }
								if($_REQUEST['month']=='2'){ $month="February "; }
								if($_REQUEST['month']=='3'){ $month="March"; }
								if($_REQUEST['month']=='4'){ $month="April"; }
								if($_REQUEST['month']=='5'){ $month="May"; }
								if($_REQUEST['month']=='6'){ $month="June"; }
								if($_REQUEST['month']=='7'){ $month="July"; }
								if($_REQUEST['month']=='8'){ $month="Auguest"; }
								if($_REQUEST['month']=='9'){ $month="September"; }
								if($_REQUEST['month']=='10'){ $month="October"; }
								if($_REQUEST['month']=='11'){ $month="November"; }
								if($_REQUEST['month']=='12'){ $month="December"; }
	?>
    <td class="td1" colspan="5"><center><b style="font-size:16px;">PAYSLIP FOR THE MONTH OF <?php echo $month; ?> <?php echo $_REQUEST['year']; ?>.</b></center>	
	</td>
   
  </tr>
  
  <tr>
  <td colspan="5" style="border: 0px solid;border-collapse: collapse;">
 <table class="table2" style="overflow: visible;width:100%;border-collapse: collapse;border: 0px solid;">
   <tr>
    <td class="td1" style="width:50%" colspan="3">Emp Code: ISAS-EMP-APP-<?php echo $staff['attendence_id']; ?>
</td>
    <td class="td1" style="width:50%" colspan="2">Emp Name: <?php echo $staff['name']; ?>.	
</td>
    
  </tr>
  
  <tr>
    <td class="td1" style="width:50%" colspan="3">Department: Technical	
	
</td>
    <td class="td1" style="width:50%" colspan="2">	
	
</td>
    
  </tr>
  <tr>
    <td class="td1" style="width:50%" colspan="3">Location: <?php echo $staff['contact_address']; ?>	
	
</td>
    <td class="td1" style="width:50%" colspan="2">Designation: <?php echo $staff['designation']; ?>.	
	
</td>
    
  </tr>
  <tr>
    <td class="td1" style="width:50%" colspan="3">Date Of Birth: <?php echo $staff['dob']; ?>
	
</td>
    <td class="td1" style="width:50%" colspan="2">Bank A/c No.: 	<?php echo $rent_Detail['bank_account_number']; ?>
	
</td>
    
  </tr>
  <tr>
    <td class="td1" style="width:50%" colspan="3">Date of Joining: <?php echo $staff['joining_date']; ?>	

</td>
    <td class="td1" style="width:50%" colspan="2">Employment Status: Confirmed	

</td>
    
  </tr>
  <tr>
    <td class="td1" style="width:50%" colspan="3">Pan No.:<?php echo $rent_Detail['pan_number']; ?>

</td>
    <td class="td1" style="width:50%" colspan="2">Salary Tenure: <?php echo "1-".$_REQUEST['month']."-".$_REQUEST['year']." To ".$payment['days_in_month']."-".$_REQUEST['month']."-".$_REQUEST['year']; ?>
 	
</td>
    
  </tr>
  
  </table>
  </td>
  </tr>
  
  
   <tr>
    <th class="th1"><b style="font-size:14px;">Total Working Days</b>

</th>
    <th class="th1"><b style="font-size:14px;">Present Days</b>
	
</th>
 <th class="th1"><b style="font-size:14px;">Extra Days</b>
	
</th>
     <th class="th1"><b style="font-size:14px;">LWP Days</b>

	
</th>
 <th class="th1"><b style="font-size:14px;">Balance Leaves</b>

	
</th>
  </tr>
  <tr>
  <td class="td1 td2">	<?php echo $payment['days_in_month']; ?>	
</td>
 <td class="td1 td2">	<?php echo $pre_leaves['present_days']; ?>	
</td>
<td class="td1 td2">	<?php echo $pre_leaves['extra_days']; ?>	
</td>
 <td class="td1 td2">	<?php echo $pre_leaves['leave_days']; ?>	
</td>
 <td class="td1 td2">	<?php echo $pre_leaves['final_leave_balance']; ?>	
</td>
  </tr>
  
   <tr>
   <td colspan="5">
   <table class="table2" style="overflow: visible;width:100%;border-collapse: collapse;border: 0px solid;">
   <tr>
  <th class="th1"><b style="font-size:14px;">Earnings</b>
	
</th>
 <th class="th1"><b style="font-size:14px;">Amount</b>
	
</th>
 <th class="th1"><b style="font-size:14px;">Deductions</b>
	
</th>
 <th class="th1"><b style="font-size:14px;">Amount</b>
	
</th>
  </tr>
 
  
 <tr>
  <td class="td1">Basic
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['basic_salary'];  ?>
	
</td>
 <td class="td1">Professional Tax
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['proffessional_tax'];  ?>
	
</td>
  </tr>

 <tr>
  <td class="td1">House Rent Allowance
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['house_rent_allowance'];  ?>
	
</td>
 <td class="td1">Income Tax (TDS)
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['tds'];  ?>
	
</td>
  </tr>

 <tr>
  <td class="td1">Travelling Allowance
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['travelling_allowance'];  ?>
	
</td>
 <td class="td1">Advance
	
</td>
 <td class="td1 td2"><?php echo $staff_sal['advance_deduction'];  ?>
	
</td>
  </tr>

 <tr>
  <td class="td1">Medical Allowance
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['medical_allowance'];  ?>
	
</td>
 <td class="td1">Fine / Deductions
	
</td>
 <td class="td1 td2">	0
</td>
  </tr>

 <tr>
  <td class="td1">Incentive
	
</td>
 <td class="td1 td2"><?php echo $incentive=$staff_sal['incentive_on_service']+$staff_sal['incentive_on_product']+$staff_sal['event_incentive']+$staff_sal['course_incentive']+$staff_sal['other_incentive'];  ?>	
</td>
 <td class="td1">Total Deductions
	
</td>
 <td class="td1 td2"><?php echo $rent_Detail['proffessional_tax']+$rent_Detail['tds']+$staff_sal['advance_deduction']; ?>
	
</td>
  </tr>

 <tr>
  <td class="td1">Gross Salary
	
</td>
 <td class="td1 td2"><?php echo $incentive+$payment['payable_salary'];  ?>
	
</td>
 <td class="td1">	Expense Addition  
</td>
 <td class="td1 td2">
<?php echo $staff_sal['expence_deduction'];  ?>
</td>
  </tr>

 <tr>
  <td class="td1">	Total Deductions

</td>
 <td class="td1 td2">	<?php echo $rent_Detail['proffessional_tax']+$rent_Detail['tds']+$staff_sal['advance_deduction']; ?>


</td>
 <td class="td1">
Extra  
</td>
 <td class="td1 td2">	
 <?php echo $payment['extra_days_payment_amount'];  ?>
</td>
  </tr>

 <tr>
  <td class="td1">Net Salary
	
</td>
 <td class="td1 td2"><?php echo $payment['salary_to_be_paid']; ?>
	
</td>
 <td class="td1">
Adjustment 
</td>
 <td class="td1 td2">	
 <?php echo $staff_sal['adjustment'];  ?>
</td>
  </tr>  
 
<tr>

  <th class="th1">Bank Name 


</th>
 <th class="th1">Cheque No
</th>
 <th class="th1" colspan="2">Branch Description	
	
	
</th>
 
  </tr> 
 
 <tr>
 <?php 
if($staff_sal['bank_name']=='35')
{
   $bank='HDFC 2910';
}
else if($staff_sal['bank_name']=='36')
{
 $bank='HDFC 9893';
}
else if($staff_sal['bank_name']=='37')
{
 $bank='Cosmos Bank';
}
else 
{
 $bank='Cash Payment';	
}

?>
  <td class="td1 td2"><?php echo $bank; ?>
</td>
 <td class="td1 td2"><?php echo $staff_sal['cheque_no'];?></td>
 <td class="td1 td2" colspan="2">Koregaon Park, Pune - 411001.	
	
	

	
	
</td>
 
  </tr> 
   </table>
  </td>
  </tr>
 <tr>
 <td class="td1" colspan="5"><b style="float:right;margin-top:50px;font-size:14px;">Authorized Sign</b>
 </td>
 </tr>
</table>
</div>
</center>
<?php } else { ?>
<center><p style="color:red;font-size:15px;"><b>**** Payment Not Done For Selected Staff ****</b></p></center>
<?php } ?>


 <script type="text/javascript">
   function PrintDiv() {
			 $(".Actionhide").hide();
            var divContents = $("#showtable").html();
			
            var printWindow = window.open('', '', 'height=400,width=800');
			
         //   printWindow.document.write('<html><head><title>Bank Reconcilation Report</title>');
			
			 printWindow.document.write('<link rel="stylesheet" type="text/css" href="css/printcss.css"/>');
		
            printWindow.document.write('</head><body >');
		//	printWindow.document.write('<h4 style="text-align: left">Bank Reconcilation Report</h4>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
		
		 $(".Actionhide").show();
		
        }
 
 
 
        
    </script>