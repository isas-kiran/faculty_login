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
input {
	text-align:center;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!-- 	
<!-- Begin
function CheckAll(chk)
{
	if ($('#Check_All').attr('checked'))
	{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = true ;
		
	}
	else{
		for (i = 0; i < chk.length; i++)
		chk[i].checked = false ;
	}
}

//  End -->
</script>
<hr>
</br>
<!-- <input type="button" class="input_btn" onClick="PrintDiv('example');" value="Print" name="" style="width:10%;" /> -->
<?php 
$select_exc = "select * from pr_staff_salary_management where month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."' AND branch_name='".$_REQUEST['branch_name']."' order by payment_action asc ";
$ptr_fs = mysql_query($select_exc);
$total=mysql_num_rows($ptr_fs);
if(mysql_num_rows($ptr_fs)) 
{
	?>
	<!-- <form method="post" name="myform" id="jqueryForm" enctype="multipart/form-data" >-->
	<table id="example" class="table1" width="95%" cellspacing="0" style="margin-left: 0px;">
        <input type="hidden" name="total" id="total" value="<?php echo $total; ?>" />
        <thead>
        <tr>
            <th class="th1">Staff Name</th>
            <th class="th1">Attendance Details</th>
            <th class="th1">Salary</th>
            <th class="th1">Tax Deduction</th>
            <th class="th1">Customer Bank Details</th>
            <th class="th1">Payment Date</th>
            <th class="th1">Payment Mode</th>
            <th class="th1">Bank Name</th>
            <th class="th1">Account No.</th>
            <th class="th1">Cheque No.</th>
            <th class="th1">Comment</th>
            <th class="th1">Action <input type="checkbox" name="Check_All" id="Check_All" value="Check All" onClick="CheckAll(document.myform.check_list)"></th>
        </tr>
        </thead>
		<tbody>	
			<?php
			$t=1;
			while($val_query = mysql_fetch_array($ptr_fs))
			{ 
				$select_staff = "select * from site_setting where admin_id= '".$val_query['employee_id']."' "; 
				$staff = $db->fetch_array($db->query($select_staff));
		   	
				$tax_detail = "select * from pr_add_salary_details where employee_id= '".$val_query['employee_id']."' "; 
				$tax = $db->fetch_array($db->query($tax_detail));
			
				$leave = "select * from pr_staff_leave_management where employee_id= '".$val_query['employee_id']."' "; 
				$leave_detail = $db->fetch_array($db->query($leave));
			
				$inc_month = "select * from pr_incentive_calculation where branch_name='".$_REQUEST['branch_name']."'";
				$inc = $db->fetch_array($db->query($inc_month));
					
				if($val_query['payment_action']==1){ $style="style=background-color:#CBCACA;"; } else { $style=""; } ?>					
				<tr <?php echo $style; ?>>
					<td class="td1 td2"><?php echo $staff['name'];  ?></td>
					<input type="hidden" name="employee<?php echo $t; ?>" id="employee<?php echo $t; ?>" value="<?php echo $staff['admin_id']; ?>" />
					<input type="hidden" name="emp_id<?php echo $t; ?>" id="emp_id<?php echo $t; ?>" value="<?php echo $staff['attendence_id']; ?>" />
            		<td class="td1 td2" style="width:50px;"><?php echo 'T.D :- '.$leave_detail['number_of_days_in_month'].'</br> W.D :-  '.$leave_detail['working_days'].'</br> P.D :-  '.$leave_detail['present_days'].'</br> E.D :-  '.$leave_detail['extra_days'].'</br> A.D:-  '.$leave_detail['leave_days'].'</br> L.M:-  '.$leave_detail['late_mark'].'</br> Paid :-  '.$leave_detail['final_paid_days'];  ?></td>
            		<td class="td1 td2"><?php echo $val_query['salary_to_be_paid'];  ?></td>
            		<input type="hidden" name="salary<?php echo $t; ?>" id="salary<?php echo $t; ?>" value="<?php echo $val_query['salary_to_be_paid']; ?>" />
            		<td class="td1 td2"><?php echo 'P.T. :- '.$tax['proffessional_tax'].'</br>  TDS :- '.$tax['tds'];  ?></td>
            		<td class="td1 td2"><?php echo 'A/C No. :- '.$tax['bank_account_number'].'</br>	Bank Name :- '.$tax['tds'];  ?></td>
            		<!--<td class="td1 td2"><?php //echo $val_query['after_deduction'];  ?></td>
            		<td class="td1 td2"><?php //echo $val_query['after_expence_deduction'];  ?></td>
            		<td class="td1 td2"><?php //echo $val_query['incentive_on_service']+$val_query['incentive_on_product']+$val_query['event_incentive']+$val_query['course_incentive']+$val_query['other_incentive'];  ?></td>
            		<td class="td1 td2"><?php //echo $val_query['salary_to_be_paid'];  ?></td> -->
            		<?php
            		if (is_null($val_query['payment_date'])) {
                		$payment_date = $inc['payment_date']."/".$_REQUEST['month']."/".$_REQUEST['year'];
					} 
					else
					{
						$payment_date = date('d/m/Y', strtotime($val_query['payment_date']));
					}
					?>
            		<td class="td1 td2"><input type="text" class="input_text datepicker" style="width:100px;" name="payment_date<?php echo $t; ?>" id="payment_date<?php echo $t; ?>" value="<?php echo $payment_date;  ?>" /></td>
            		<td class="td1 td2">
                    <select name="payment_mode<?php echo $t; ?>" id="payment_mode<?php echo $t; ?>" style="width:70px;" onChange="payment_type(this.value,<?php echo $t; ?>);">
                    <option value="">--Payment Mode--</option>
                    <?php
                    $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                    $ptr_payment_mode=mysql_query($sel_payment_mode);
                    $selctds='';
                    while($data_payment=mysql_fetch_array($ptr_payment_mode))
                    {
                        $selected='';
                        if(($data_payment['payment_mode_id'] == $val_query['payment_mode']) || ($payment_type == $data_payment['payment_mode_id']))
                        {
                            $selected='selected="selected"';
                            $selctds = $data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'];
                            ?>
                            <script language="javascript">
                            //alert('<?php //echo $selctds; ?>');
                            </script>
                            <?php
                        }
                        echo '<option '.$selected.' value="'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
                    }
                    ?>
                    </select>
            		</td>
            		<td class="td1 td2">
                		<select name="bank_name<?php echo $t; ?>" style="width:120px;" id="bank_name<?php echo $t; ?>" onChange="show_acc_no(this.value,<?php echo $t; ?>)">
                		<option value="">--Bank--</option>
						<?php
                        $sle_bank_name="select bank_id,bank_name from bank"; 
                        $ptr_bank_name=mysql_query($sle_bank_name);
                        while($data_bank=mysql_fetch_array($ptr_bank_name))
                        {
                            $selected='';
                            if($data_bank['bank_id'] == $val_query['bank_name'])
                            {
                                $selected='selected="selected"';
                            }
        
                            echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';
                        }
                        ?>
                        </select>
                		<?php // }?>
            		</td>
            		<td class="td1 td2"><input type="text" style="width:100px;" name="account_no<?php echo $t; ?>" id="account_no<?php echo $t; ?>" value="<?php echo $val_query['account_no'];  ?>" /></td>
            		<td class="td1 td2"><input type="text" style="width:100px;" name="cheque_no<?php echo $t; ?>" id="cheque_no<?php echo $t; ?>" value="<?php echo $val_query['cheque_no'];  ?>" /></td>
            		<td class="td1 td2"><input type="text" style="width:100px;" name="comment<?php echo $t; ?>" id="comment<?php echo $t; ?>" value="<?php echo $val_query['comment'];  ?>" /></td>
            		<td class="td1 td2">
            		<?php if($val_query['payment_action']==1)
            		{ ?>
               		 	<img src="images/active_icon.png">
                		<?php 
            		} 
            		else 
            		{ ?>
                		<input type="checkbox" name="action<?php echo $t; ?>" id="check_list" value="" />
                		<?php 
            		} ?>
            		</td>
            		<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id<?php echo $t; ?>" value="<?php echo $val_query['staff_salary_id'] ?>" />
            <input type="hidden" name="days" id="days" value="<?php echo $val_query['days'] ?>" />
        		</tr>
				<?php 
				$t++; 
			} ?>							
		</tbody>  
	</table>
	<input style="margin-top:10px;" type="submit" class="input_btn" value="Make Payment" name="save_changes" />
	<?php
}
else 
{ 
	?>
	<p Style="font-size:20px;color:red;">No Record Found</p>
	<?php 
}
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
function payment_type(payment_mode,i) 
{
	//var i = $("#total").val();
	// for(i=0;i<=total;i++)
	// {
	var payment_mode = $("#payment_mode"+i).val();
	//alert(payment_mode);
	if(payment_mode=='5' || payment_mode=='4' || payment_mode=='2')
	{
	$("#cheque_no"+i).removeAttr("disabled");	
	$("#bank_name"+i).removeAttr("disabled");	
	$("#account_no"+i).removeAttr("disabled");				
	}
	else if(payment_mode=='1')
	{
		
	$("#bank_name"+i).attr("disabled", "disabled");
	$("#account_no"+i).attr("disabled", "disabled");
	$("#cheque_no"+i).attr("disabled", "disabled");
	}
	else{
	$("#bank_name"+i).attr("disabled", "disabled");
	$("#account_no"+i).attr("disabled", "disabled");
	$("#cheque_no"+i).attr("disabled", "disabled");
	}
	//}
}

function show_acc_no(bank_id,id)
{
	var total = $("#total").val();
	//var bank_id = $("#bank_name"+i).val();
	$.ajax({ 
		type: 'post',
		url: 'account_ajax.php',
		data: { bank_id: bank_id },
		
	}).done(function(val) {
   //alert(val);
	$('#account_no'+id).val(val);	
	//document.getElementById("account_no"+i).value=val;
	}).fail(function() {
		console.log('Failed');
	});
}
</script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function()
{            
	$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:'dd/mm/yy', showButtonPanel: true, closeText: 'Clear',});
});
</script>