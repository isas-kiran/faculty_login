<?php include 'inc_classes.php';?>
<?php
$cust_name=$_POST['customer_id'];
$action_for=$_POST['action_for'];
if($action_for =='ahmedabad')
{
	?>
	<table width="100%">
	<tr>
		<td width="20%" valign="top">Select Stockist<span class="orange_font"></span></td>
		<td width="70%" id="sel_cust" class="customized_select_box">
		<select name="stockist_id" id="stockist_id" style="width:200px;"  >
		<option value="">Select name</option> 
		<?php  
		$sql_cust = "select admin_id,name from site_setting where 1 and type='ST' and branch_name='Ahmedabad' order by name asc";
		$ptr_cust = mysql_query($sql_cust);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			
			echo "<option value='".$data_cust['admin_id']."' >".$data_cust['name']."</option>";
		}
		?>
		</select>
	</tr>
	</table>
	<?php
}
else if($action_for =='pune')
{
	?>
	<table width="100%">
	<tr>
		<td width="20%" valign="top">Select Stockist<span class="orange_font"></span></td>
		<td width="70%" id="sel_cust" class="customized_select_box">
		<select name="stockist_id" id="stockist_id" style="width:200px;" >
		<option value="">Select name</option> 
		<?php  
		$sql_cust = "select admin_id,name from site_setting where 1 and type='ST' and branch_name='Pune' order by name asc";
		$ptr_cust = mysql_query($sql_cust);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			
			echo "<option value='".$data_cust['admin_id']."'>".$data_cust['name']."</option>";
		}
		?>
		</select>
	</tr>
	</table>
	<?php
}
else if($action_for =='isas_pcmc')
{
	?>
	<table width="100%">
	<tr>
		<td width="20%" valign="top">Select Stockist<span class="orange_font"></span></td>
		<td width="70%" id="sel_cust" class="customized_select_box">
		<select name="stockist_id" id="stockist_id" style="width:200px;" >
		<option value="">Select name</option> 
		<?php  
		$sql_cust = "select admin_id,name from site_setting where 1 and type='ST' and branch_name='ISAS PCMC' order by name asc";
		$ptr_cust = mysql_query($sql_cust);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			
			echo "<option value='".$data_cust['admin_id']."'>".$data_cust['name']."</option>";
		}
		?>
		</select>
	</tr>
	</table>
	<?php
}
else if($action_for =='ahmednagar')
{
	?>
	<table width="100%">
	<tr>
		<td width="20%" valign="top">Select Stockist<span class="orange_font"></span></td>
		<td width="70%" id="sel_cust" class="customized_select_box">
		<select name="stockist_id" id="stockist_id" style="width:200px;" >
		<option value="">Select name</option> 
		<?php  
		$sql_cust = "select admin_id,name from site_setting where 1 and type='ST' and branch_name='ahmednagar' order by name asc";
		$ptr_cust = mysql_query($sql_cust);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			
			echo "<option value='".$data_cust['admin_id']."'>".$data_cust['name']."</option>";
		}
		?>
		</select>
	</tr>
	</table>
	<?php
}
else if($action_for =='lemeurice')
{
	$host 			= "localhost";
	$dbuid			= "lemeurice";
	$dbpwd 			= "lemeurice@007";
	$dbname			= "lemeurice";
	
	$db2 = mysql_connect($host, $dbuid, $dbpwd, true); 
	mysql_select_db($dbname, $db2);
	?>
	<table width="100%">
	<tr>
		<td width="22%" valign="top">Select Stockist<span class="orange_font"></span></td>
		<td width="70%" id="sel_cust" class="customized_select_box">
		<select name="stockist_id" id="stockist_id" style="width:200px;" >
		<option value="">Select name</option> 
		<?php  
		$sql_cust = "select admin_id,name from site_setting where 1 and (type='ST' or type='A') order by name asc";
		$ptr_cust = mysql_query($sql_cust,$db2);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			echo "<option value='".$data_cust['admin_id']."'>".$data_cust['name']."</option>";
		}
		?>
		</select>
	</tr>
	</table>
	<?php
	mysql_close($db2);
}
?>