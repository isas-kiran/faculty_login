<?php include 'inc_classes.php';?>
<?php
$staff_id=$_POST['staff'];
$month=$_POST['month'];
$year=$_POST['year'];
if($staff_id)
{
	$select_exc = "select m.* from customer_service_map m, customer_service s where s.customer_service_id=m.customer_service_id and MONTH(s.added_date)='".$month."' and YEAR(s.added_date)='".$year."' and m.admin_id='".$staff_id."' order by  m.customer_service_map_id asc ";
	$ptr_fs = mysql_query($select_exc);
	$t=1;
	$total_comision= mysql_num_rows($ptr_fs);
	$total_conditions= mysql_num_rows($ptr_fs);
	while($data_exclusive = mysql_fetch_array($ptr_fs))
	{ 
		$slab_id= $data_exclusive['customer_service_map_id'];
		?> 
		<div class="floor_div" id="floor_id<?php echo $t; ?>">
		<table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
		<tr>
		<td valign="" width="12%" align="center"><input type="hidden" name="exclusive_id<?php echo $t; ?>" id="exclusive_id<?php echo $t; ?>" value="<?php echo $t; ?>" /><select name="service_id<?php echo $t; ?>" id="service_id<?php echo $t; ?>" style="width:140px" onChange="getprice(this.value,<?php echo $t; ?>)"><option value="">Select Service</option><?php
		$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
		$query_tel = mysql_query($sel_tel);
		if($total=mysql_num_rows($query_tel))
		{
			while($data=mysql_fetch_array($query_tel))
			{
				$selected='';
				if($data_exclusive['service_id'] ==$data['service_id'] )
				{
					$selected='selected="selected"';
				}
				echo '<option value="'.$data['service_id'].'" '.$selected.'>'.$data['service_name']."   (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time'].")".'</option>';
			}
		}
		?>
		</select></td>
		<td width="8%" align="center"><input type="text" onkeyup="calc_service_price('<?php echo $t; ?>')" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px;" value="<?php echo $data_exclusive['total_price'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_service_cgst<?php echo $t; ?>" id="sin_service_cgst<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_cgst_price<?php echo $t; ?>" id="sin_service_cgst_price<?php echo $t; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_sgst<?php echo $t; ?>" id="sin_service_sgst<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_sgst_price<?php echo $t; ?>" id="sin_service_sgst_price<?php echo $t; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_igst<?php echo $t; ?>" id="sin_service_igst<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_igst_price<?php echo $t; ?>" id="sin_service_igst_price<?php echo $t; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_card<?php echo $t; ?>" id="sin_service_card<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_card_price<?php echo $t; ?>" id="sin_service_card_price<?php echo $t; ?>" style=" width:60px" /></td><td width="4%" align="center"><input type="text" name="temp_total<?php echo $t; ?>" id="temp_total<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px;" /></td><td width="4%" align="center"><input type="text" name="incentive_percentage<?php echo $t; ?>" id="incentive_percentage<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="incentive_amount<?php echo $t; ?>" id="incentive_amount<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="adjustment_amount<?php echo $t; ?>" id="adjustment_amount<?php echo $t; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" value="0"/></td><td width="4%" align="center"><input type="text" name="total<?php echo $t; ?>" id="total<?php echo $t; ?>" style="width:60px;margin-right: 12px;" /><input type="hidden" name="total_sales_service[]" id="total_sales_service<?php echo $t; ?>" /><input type="hidden" name="row_deleted<?php echo $t; ?>" id="row_deleted<?php echo $t; ?>" value="" /></td>
		
		</tr>
		
		</table>
		</div>
		<?php
		$t++;
		$tot +=$data_exclusive['total_price'];
	}
	 $sql_record= "SELECT * FROM pr_add_incentive_details where admin_id='".$staff_id."' ";
     $row_record=$db->fetch_array($db->query($sql_record));
	 
	 if($tot>$row_record['s_target_amount1'] && $tot<$row_record['s_target_amount2'])
	 {
		 $per=$row_record['s_percentage1'];
		  echo $per."% Incentive Approved";
	 }
	 elseif($tot>$row_record['s_target_amount2'] && $tot<$row_record['s_target_amount3'])
	 	 {
		 $per=$row_record['s_percentage2'];
		   echo $per."% Incentive Approved";
	 }
	 elseif($tot>$row_record['s_target_amount3'])
	 {
		  $per=$row_record['s_percentage3'];
		   echo "Incentive Not Approved";
	 }
	 else
	 {
		 echo "Incentive Not Approved";
	 }
}

$i='';
echo $i."#####".$total_conditions; ?>