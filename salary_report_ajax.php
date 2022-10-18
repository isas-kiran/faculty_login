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
   text-align:left;
}
input {
	text-align:center;
}
</style>

<hr>
</br>
<center>
<!-- <input type="button" class="input_btn" onClick="PrintDiv('example');" value="Print" name="" style="width:10%;" /> -->
<?php 
$select_exc = "select * from pr_staff_salary_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND branch_name='".$_REQUEST['branch_name']."' ORDER BY payment_date ASC";
                            $ptr_fs = mysql_query($select_exc);
							$total=mysql_num_rows($ptr_fs);
							if(mysql_num_rows($ptr_fs)) {
						   
?>
 <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
<table id="example" class="table1" width="95%" cellspacing="0" style="margin-left: 0px;">
<input type="hidden" name="total" id="total" value="<?php echo $total; ?>"
 <thead>
<tr>

<th class="th1">Staff Name</th>
<th class="th1">Days</th>
<th class="th1">Salary</th>
<th class="th1">Tax</th>
<th class="th1">Customer Bank Details</th>
<th class="th1">Payment Date</th>
<th class="th1">After Advance Deduction</th>
<th class="th1">After Expense Addition</th>
<th class="th1">Incentive</th>
<th class="th1">Salary To Be Paid</th>
<th class="th1">Payment Mode</th>
<th class="th1">Bank Details</th>
<th class="th1">Status</th>

</tr>
</thead>
<tbody>	
<?php


                           $t=1;
                          while($val_query = mysql_fetch_array($ptr_fs))
                            { 
					$select_staff = "select attendence_id,admin_id,name from site_setting where attendence_id= '".$val_query['staff_id']."' "; 
					$staff = $db->fetch_array($db->query($select_staff));
                    
					$tax_detail = "select * from pr_add_salary_details where staff_id= '".$val_query['staff_id']."' "; 
					$tax = $db->fetch_array($db->query($tax_detail));
					
					$leave = "select * from pr_staff_leave_management where staff_id= '".$val_query['staff_id']."' "; 
					$leave_detail = $db->fetch_array($db->query($leave));
					
					$pay = "select * from payment_mode where payment_mode_id= '".$val_query['payment_mode']."' "; 
					$payment_mode = $db->fetch_array($db->query($pay));
								?>
							
<tr>
<td class="td1 td2"><?php echo $staff['name'];  ?></td>
<td class="td1 td2" style="width:50px;"><?php echo 'T.D :- '.$leave_detail['number_of_days_in_month'].'</br> W.D :-  '.$leave_detail['working_days'].'</br> P.D :-  '.$leave_detail['present_days'].'</br> E.D :-  '.$leave_detail['extra_days'].'</br> A.D:-  '.$leave_detail['leave_days'].'</br> L.M:-  '.$leave_detail['late_mark'].'</br> Paid :-  '.$leave_detail['final_paid_days'];  ?></td>
<td class="td1 td2"><?php echo $val_query['salary_to_be_paid']  ?></td>
<td class="td1 td2"><?php echo 'P.T. :- '.$tax['proffessional_tax'].'</br>
								 TDS :- '.$tax['tds'];  ?></td>
<td class="td1 td2"><?php echo 'A/C No. :- '.$tax['bank_account_number'].'</br>
								 Bank Name :- '.$tax['bank_name'];  ?></td>
								 <?php

if (is_null($val_query['payment_date'])) {
    $payment_date = '00-00-0000';
} 
else
{
	$payment_date = date('d-m-Y', strtotime($val_query['payment_date']));
}

?>
<td class="td1 td2"><?php echo $payment_date;  ?></td>
<td class="td1 td2"><?php echo $val_query['after_deduction'];  ?></td>
<td class="td1 td2"><?php echo $val_query['after_expence_deduction'];  ?></td>
<?php echo '<td class="td1 td2"> Service Incentive :- '.$val_query['incentive_on_service'].'</br>
								            Product Incentive :-  '.$val_query['incentive_on_product'].'</br>
											Event Incentive :-  '.$val_query['event_incentive'].'</br>
											Course Incentive :-  '.$val_query['course_incentive'].'</br>
											Other Incentive :-  '.$val_query['other_incentive'].'</br>
											</td>'; ?>
<td class="td1 td2"><?php echo $val_query['salary_to_be_paid'];  ?></td> 

<td class="td1 td2"><?php echo $payment_mode['payment_mode']; ?></td>
<?php 
if($val_query['bank_name']=='35')
	$bank='HDFC 2910';
if($val_query['bank_name']=='36')
	$bank='HDFC 9893';
if($val_query['bank_name']=='37')
	$bank='Cosmos Bank';
?>

<td class="td1 td2"> Bank Name:  <?php echo $bank; ?></br>
Bank A/C Number : <?php echo $val_query['account_no']; ?></br>
Cheque Number : <?php echo $val_query['cheque_no']; ?></td>
<?php
if($val_query['payment_action']=='1')
{
	$status='Done';
$style="style='background-color:green';";
}
else{
	$status='Not Done';
	$style="style='background-color:red';";
}
?>
<td class="td1 td2" <?php echo $style; ?>><?php echo $status;  ?></td>
</tr>

							<?php $t++; } ?>
							
</tbody>  
</table>
<?php
}
 else 
{ ?>
	<p Style="font-size:20px;color:red;">No Record Found</p>
<?php }
?>
</center>

<script type="text/javascript">
        function PrintDiv(elem) {
			$(".table1").css( "border", "1px solid" );
			$(".td1").css( "border", "1px solid" );
			$(".th1").css( "border", "1px solid" );
			$(".table1").css( "border-collapse", "collapse" );
			$(".td1").css( "border-collapse", "collapse" );
			$(".th1").css( "border-collapse", "collapse" );
			$(".table1").css( "padding", "4px" );
			$(".td1").css( "padding", "4px" );
			$(".th1").css( "padding", "4px" );
			$(".table1").css( "font-size", "12px" );
			$(".td1").css( "font-size", "12px" );
			$(".td2").css( "text-align", "center" );
			
			$("#title").remove(); 
            var originalContents = $("body").html();
      	    var printContents = $("#example").html();
      	    $("body").html(printContents);
    	    window.print();
     	    $("body").html(originalContents);
            return false;
		
		
        }
		
		function payment_type(payment_mode,total) {
			var total = $("#total").val();
			
			for(i=0;i<=total;i++)
			{
			var payment_mode = $("#payment_mode"+i).val();
			if(payment_mode=='Online')
			{
		    $("#cheque_no"+i).removeAttr("disabled");	
            $("#bank_name"+i).removeAttr("disabled");	
            $("#account_no"+i).removeAttr("disabled");				
			}
			else if(payment_mode=='Cheque')
			{
			$("#bank_name"+i).attr("disabled", "disabled");
            $("#account_no"+i).attr("disabled", "disabled");
            $("#cheque_no"+i).removeAttr("disabled");			
			}
		    else if(payment_mode=='Cash')
		    {
				
			$("#bank_name"+i).attr("disabled", "disabled");
            $("#account_no"+i).attr("disabled", "disabled");
			$("#cheque_no"+i).attr("disabled", "disabled");
		    }
			}
		}
    </script>
 <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <script type="text/javascript">
    $(document).ready(function()

        {            

            $('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:'dd/mm/yy', showButtonPanel: true, closeText: 'Clear',minDate: '-50Y',

        maxDate: '+2Y',});

        });

</script>