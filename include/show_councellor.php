<?php include 'inc_classes.php';?>
<?php
$branch_id=$_POST['branch_id'];
$action=$_POST['action'];
$admin_id=$_POST['admin_id'];
if($action=="enrollment")
{
	$record_id=$_POST['record_id'];
	$where_branch='';
	if($_SESSION['type']!="S" && $_SESSION['type']!="Z")
	{
		$where_branch=" and branch_name='".$branch_id."'";
	}
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch."  and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	?>
	<option value="">--Select Staff--</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($record_id)
		{
			$select_rec="select assigned_to from enrollment where enroll_id='".$record_id."'";
			$ptr_rec=mysql_query($select_rec);
			if(mysql_num_rows($ptr_rec))
			{
				$data_rec=mysql_fetch_array($ptr_rec);
				$admin_id=$data_rec['assigned_to'];
			}
		}
		if($admin_id==$fetch_name['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value ="<?php echo $fetch_name['admin_id']?>" <?php echo $sel; ?> > <?php echo $fetch_name['name'] ?> </option>
		<?php
	}
}
else if($action=="inquiry")
{
	$where_branch='';
	if($_SESSION['type']!="S" && $_SESSION['type']!="Z")
	{
		$where_branch=" and branch_name='".$branch_id."'";
	}
	if($_SESSION['type']=='AG')
	{
		$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and admin_id=added_by and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
	}
	else
	{
		$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
	}
	$ptr_name=mysql_query($sel_name);
	?>
	<select id="employee_id" name="employee_id" class="input_select">
	<option value="">--Select Staff--</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($admin_id==$fetch_name['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel; ?>> <?php echo $fetch_name['name'] ?> </option>
		<?php
	}
	?>
	</select>
	<?php
}
else if($action=="manage_student")
{
	//========================Enquiry added by========================
	$where_branch=" and branch_name='".$branch_id."'";
	
	$sel_added_by="SELECT admin_id,name FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='A' or type='S') and system_status='Enabled' order by name";
	$ptr_added_by=mysql_query($sel_added_by);
	?>
	<option value="">Enquiry Created By</option>
	<?php
	while($data_added_by=mysql_fetch_array($ptr_added_by))
	{
		$sel='';
		if($_REQUEST['enquiry_added']==$data_added_by['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $data_added_by['admin_id']?>" <?php echo $sel; ?>> <?php echo $data_added_by['name'] ?> </option>
		<?php
	}
	?>
	<?php
	echo '###';
	//=========================Enquiry Asssigned to==================
	$sel_assigned="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='A' or type='S') and system_status='Enabled' order by name";
	$ptr_assigned=mysql_query($sel_assigned);
	?>
	<option value="">Enquiry Assigned To</option>
	<?php
	while($data_assigned=mysql_fetch_array($ptr_assigned))
	{
		$sel='';
		if($_REQUEST['assigned_to']==$data_assigned['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $data_assigned['admin_id']?>" <?php echo $sel; ?>> <?php echo $data_assigned['name'] ?> </option>
		<?php
	}
	?>
	<?php
}
else if($action=="stack_report")
{
	$where_branch='';
	$where_branch="  and branch_name='".$branch_id."'";
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='A') and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	?>
    <select name="staff_id" id="staff_id" class="input_select" style="width:150px">
	<option value="">Select Staff</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($admin_id==$fetch_name['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel; ?>> <?php echo $fetch_name['name'] ?> </option>
		<?php
	}
	?>
    </select>
	<?php
}
else if($action=="random_councilior")
{
	$sel_name="SELECT admin_id FROM site_setting WHERE 1 and branch_name='".$branch_id."' and type='C' and system_status='Enabled' order by RAND() limit 0,1";
	$ptr_name=mysql_query($sel_name);
	if(mysql_num_rows($ptr_name))
	{
		$fetch_name=mysql_fetch_array($ptr_name);
		echo $fetch_name['admin_id'];
	}
	else
	{
		$sel_name="SELECT admin_id FROM site_setting WHERE 1 and branch_name='".$branch_id."' and type='A' and system_status='Enabled' order by RAND() limit 0,1";
		$ptr_name=mysql_query($sel_name);
		$fetch_name=mysql_fetch_array($ptr_name);
		echo $fetch_name['admin_id'];
	}
}
else if($action=="voucher")
{
	$where_branch='';
	if($_SESSION['type']!="S" && $_SESSION['type']!='Z')
	{
		$where_branch="  and branch_name='".$branch_id."'";
	}
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='A' or type='S' or type='Z') and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	?>
	<select id="employee_id" name="employee_id" class="input_select">
	<option value="">--Select Staff--</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($admin_id==$fetch_name['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel; ?>> <?php echo $fetch_name['name'] ?> </option>
		<?php
	}
	?>
	</select>
	<?php
}
else
{
	$sel_name="SELECT * FROM site_setting WHERE branch_name='".$branch_id."' and (type='C' or type='A' or type='S' or type='Z') and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	?>
	<option value="">--Select Staff--</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($admin_id==$fetch_name['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel; ?>> <?php echo $fetch_name['name'] ?> </option>
		<?php
	}
}
?>