<?php include 'inc_classes.php';
$action = $_POST['action'];
if($action=='show_data')
{
	$action_page=$_POST['action_page'];
	$record_id=$_POST['record_id'];
	$branch_name=$_POST['branch_name'];
			
	$sel_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A' limit 0,1";
	$ptr_cm_id=mysql_query($sel_cm_id);
	$data_cm_ids=mysql_fetch_array($ptr_cm_id);
	
	$user_cm='';
	if($_SESSION['where'] !='')
	{
		$user_cm=$_SESSION['where'];
	}
	else
	{
		$user_cm=" and cm_id='".$data_cm_ids['cm_id']."'";
	}
	
	if($_POST['id']=='Customer')
	{
		?>
		<table style="width:100%;">
		<tr>
			<td width="70%" id="sel_cust" class="customized_select_box">
			<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
			<option value="">Select Customer</option> 
			<?php  
			$sql_cust = "select cust_name, cust_id from customer where 1 ".$user_cm." or cust_id='1113' or cust_id='1212' or cust_id='1805' or cust_id='18' order by cust_id asc";
			$ptr_cust = mysql_query($sql_cust); // 1212 = Ahmednagar, 1113= PCMC, 1805=Pune,18=Ahmedbad
			while($data_cust = mysql_fetch_array($ptr_cust))
			{
				$selecteds="";
				if($action_page=="book_service" && $record_id!='')
				{
					$sel_serv="select customer_id from customer_service where customer_service_id='".$record_id."'";
					$ptr_serv=mysql_query($sel_serv);
					if(mysql_num_rows($ptr_serv))
					{
						$data_serv=mysql_fetch_array($ptr_serv);
						if($data_cust['cust_id']==$data_serv['customer_id'])
						{
							$selecteds='selected="selected"';
						}
					}
				}
				echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
			}
			?>
			<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>
			</select>
			<td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
		</tr>
		</table>
	<?php
	}
	else if($_POST['id']=='Student')
	{
		?>
		<table style="width:100%;">
			<tr>
				<td width="70%" id="sel_cust" class="customized_select_box">
				<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
				<option value="">Select Student</option> 
				<?php  
				$sql_cust = "select name, enroll_id from enrollment where 1 ".$user_cm." and ref_id='0' order by enroll_id asc";
				$ptr_cust = mysql_query($sql_cust);
				while($data_cust = mysql_fetch_array($ptr_cust))
				{
					$selecteds="";
					if($action_page=="book_service" && $record_id!='')
					{
						$sel_serv="select customer_id from customer_service where customer_service_id='".$record_id."'";
						$ptr_serv=mysql_query($sel_serv);
						if(mysql_num_rows($ptr_serv))
						{
							$data_serv=mysql_fetch_array($ptr_serv);
							if($data_cust['enroll_id']==$data_serv['customer_id'])
							{
								$selecteds='selected="selected"';
							}
						}
					}
					echo "<option value='".$data_cust['enroll_id']."' ".$selecteds.">".$data_cust['name']."</option>";
				}
				?>
				<!--<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>-->
				</select>
				<td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
			</tr>
		</table>
		<?php
	}
	else if($_POST['id']=='Employee')
	{
		?>
		<table style="width:100%;">
			<tr>
				<td width="70%" id="sel_cust" class="customized_select_box">
				<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
				<option value="">Select Employee</option> 
				<?php  
				$sql_cust = "select name, admin_id from site_setting where 1 and system_status='Enabled' ".$user_cm." order by admin_id asc";
				$ptr_cust = mysql_query($sql_cust);
				while($data_cust = mysql_fetch_array($ptr_cust))
				{
					$selecteds="";
					if($action_page=="sales_product" && $record_id!='')
					{
						$sel_prod="select customer_id from sales_product where sales_product_id='".$record_id."'";
						$ptr_prod=mysql_query($sel_prod);
						if(mysql_num_rows($ptr_prod))
						{
							$data_prod=mysql_fetch_array($ptr_prod);
							if($data_cust['admin_id']==$data_prod['customer_id'])
							{
								$selecteds='selected="selected"';
							}
						}
					}
					if($action_page=="book_service" && $record_id!='')
					{
						$sel_serv="select customer_id from customer_service where customer_service_id='".$record_id."'";
						$ptr_serv=mysql_query($sel_serv);
						if(mysql_num_rows($ptr_serv))
						{
							$data_serv=mysql_fetch_array($ptr_serv);
							if($data_cust['admin_id']==$data_serv['customer_id'])
							{
								$selecteds='selected="selected"';
							}
						}
					}
					echo "<option value='".$data_cust['admin_id']."' ".$selecteds.">".$data_cust['name']."</option>";
				}
				?>
				<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option>
				</select>
				<td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
			</tr>
		</table>
		<?php
	}
	else if($_POST['id']=='Vendor')
	{
		?>
		<table style="width:100%;">
			<tr>
				<td width="70%" id="sel_cust" class="customized_select_box">
				<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value,'<?php echo $_POST['id']; ?>')" >
				<option value="">Select Vendor</option> 
				<?php  
				$sql_cust = "select contact,vendor_id,name from vendor where 1 ".$user_cm." order by vendor_id asc";
				$ptr_cust = mysql_query($sql_cust);
				while($data_cust = mysql_fetch_array($ptr_cust))
				{ 
					echo "<option value='".$data_cust['vendor_id']."' ".$selecteds.">".$data_cust['name']."</option>";
				}
				?>
				</select>
				<td width="10%"><input type="hidden" name="mail" id="mail" value=""  /></td>
			</tr>
		</table>
		<?php
	}
}