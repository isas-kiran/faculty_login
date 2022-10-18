<?php include 'inc_classes.php';
$action = $_POST['action'];
if($action=='show_data')
{
	$action_page=$_POST['action_page'];
	$record_id=$_POST['record_id'];
	$branch_name=$_POST['branch_name'];
	
	$ids=$_POST['ids'];
	if($action_page=="checkout_product")
	{
		$style='style="width:14%;" align="lefft"';
		$style2='style="width:14%" align="left"';
	}
	else if($action_page=="kit_product")
	{
		$style='style="width:9.5%;" align="lefft"';
		$style2='style="width:9.5%" align="left"';
	}
	else
	{
		$style='style="width:16%;" align="left"';
		$style2='style="width:16%;" align="left"';
	}
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
		<!--<tr>
			<td id="mobiles">
			<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php //echo $_POST['id']; ?>')">
				<option value="">Select Mobile No.</option>
				<?php  
                /*$sql_cust = "select mobile1,cust_id from customer where 1 ".$user_cm." order by cust_id asc";
                $ptr_cust = mysql_query($sql_cust);
                while($data_cust = mysql_fetch_array($ptr_cust))
                {
                    echo "<option ".$selecteds." value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";
                }*/
                ?>
			</select>
			</td>
		</tr> -->
		<tr>
			<td width="70%" id="sel_cust<?php echo $ids; ?>" class="customized_select_box">
			<select name="employee_id<?php echo $ids; ?>" id="employee_id<?php echo $ids; ?>" style="width:200px;" > <!--onChange="show_mobile_no(this.value,'<?php //echo $_POST['id']; ?>')"-->
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
				if($action_page=="sales_product" && $record_id!='')
				{
					$sel_prod="select customer_id from sales_product where sales_product_id='".$record_id."'";
					$ptr_prod=mysql_query($sel_prod);
					if(mysql_num_rows($ptr_prod))
					{
						$data_prod=mysql_fetch_array($ptr_prod);
						if($data_cust['cust_id']==$data_prod['customer_id'])
						{
							$selecteds='selected="selected"';
						}
					}
				}
				echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
			}
			?>
			</select>
		</tr>
		</table>
	<?php
	}
	else if($_POST['id']=='Student')
	{
		?>
		<table style="width:100%;">
			<!--<tr>
				<input type="hidden" name="res1" id="res1" />
				<input type="hidden" name="res_tax" id="res_tax" />
				<td>
				<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php //echo $_POST['id']; ?>')">
				<option value="">Select Mobile No.</option>
				<?php  
				/*$sql_cust="select contact,enroll_id from enrollment where 1 ".$user_cm." and ref_id='0' order by enroll_id asc";
				$ptr_cust = mysql_query($sql_cust);
				while($data_cust = mysql_fetch_array($ptr_cust))
				{ 
					echo "<option value='".$data_cust['contact']."' ".$selecteds.">".$data_cust['contact']."</option>";
				}*/
				?>
				</select>
				</td>
			</tr> -->
			<tr>
				<td width="70%" id="sel_cust<?php echo $ids; ?>" class="customized_select_box">
				<select name="employee_id<?php echo $ids; ?>" id="employee_id<?php echo $ids; ?>" style="width:200px;" >
				<option value="">Select Student</option> 
				<?php  
				$sql_cust="select name, enroll_id from enrollment where 1 ".$user_cm." and ref_id='0' order by enroll_id asc";
				$ptr_cust=mysql_query($sql_cust);
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
					if($action_page=="sales_product" && $record_id!='')
					{
						$sel_prod="select customer_id from sales_product where sales_product_id='".$record_id."'";
						$ptr_prod=mysql_query($sel_prod);
						if(mysql_num_rows($ptr_prod))
						{
							$data_prod=mysql_fetch_array($ptr_prod);
							if($data_cust['enroll_id']==$data_prod['customer_id'])
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
			</tr>
		</table>
		<?php
	}
	else if($_POST['id']=='Employee')
	{
		?>
		<table style="width:100%;">
			<!--<tr>
				<td>
				<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php //echo $_POST['id']; ?>')">
				<option value="">Select Mobile No.</option>
				<?php  
				/*$sql_cust = "select contact_phone,admin_id from site_setting where 1 ".$user_cm." order by admin_id asc";
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
							if($data_cust['customer_id']==$data_prod['customer_id'])
							{
								$selecteds='selected="selected"';
							}
						}
					}
					echo "<option value='".$data_cust['contact_phone']."' ".$selecteds.">".$data_cust['contact_phone']."</option>";
				}*/
				?>
				</select>
				</td>
			</tr>--> 
			<tr>
				<td width="70%" id="sel_cust<?php echo $ids; ?>" class="customized_select_box">
				<select name="employee_id<?php echo $ids; ?>" id="employee_id<?php echo $ids; ?>" style="width:200px;" >
				<option value="">Select Employee</option> 
				<?php
				$sql_cust="select name, admin_id from site_setting where 1 ".$user_cm." order by admin_id asc";
				$ptr_cust=mysql_query($sql_cust);
				while($data_cust=mysql_fetch_array($ptr_cust))
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
				</select>
			</tr>
		</table>
		<?php
	}
	else if($_POST['id']=='Vendor')
	{
		?>
		<table style="width:100%;">
			<!--<tr>
				<td>
				<select id="realtxt" name="realtxt" style="width:200px" onChange="searchSel(this.value,'<?php //echo $_POST['id']; ?>')">
				<option value="">Select Mobile No.</option>
				<?php  
				/*$sql_cust = "select contact,vendor_id from vendor where 1 ".$user_cm." order by vendor asc";
				$ptr_cust = mysql_query($sql_cust);
				while($data_cust = mysql_fetch_array($ptr_cust))
				{
					echo "<option value='".$data_cust['contact']."' ".$selecteds.">".$data_cust['contact']."</option>";
				}*/
				?>
				</select>
				</td>
			</tr>--> 
			<tr>
				<td width="70%" id="sel_cust<?php echo $ids; ?>" class="customized_select_box">
				<select name="employee_id<?php echo $ids; ?>" id="employee_id<?php echo $ids; ?>" style="width:200px;" >
				<option value="">Select Vendor</option> 
				<?php
				$sql_cust="select contact,vendor_id,name from vendor where 1 ".$user_cm." order by vendor_id asc";
				$ptr_cust=mysql_query($sql_cust);
				while($data_cust=mysql_fetch_array($ptr_cust))
				{ 
					echo "<option value='".$data_cust['vendor_id']."' ".$selecteds.">".$data_cust['name']."</option>";
				}
				?>
				</select>
			</tr>
		</table>
		<?php
	}
}
?>