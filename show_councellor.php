<?php include 'inc_classes.php';?>
<?php
$branch_id=$_POST['branch_id'];
$action=$_POST['action'];
$admin_id=$_POST['admin_id'];
if($action=="enrollment")
{
	$record_id=$_POST['record_id'];
	$where_branch='';
	if($branch_id!='')
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
	
	if($branch_id!='')
	{
		$where_branch=" and branch_name='".$branch_id."'";
	}
	
	if($_POST['record_id'] >0)
	{
		$sel_added_by="select employee_id,admin_id from inquiry where inquiry_id='".$_POST['record_id']."'";
		$ptr_sel=mysql_query($sel_added_by);
		$data_rec_id=mysql_fetch_array($ptr_sel);
		
		$where_added_by=" and (admin_id='".$data_rec_id['employee_id']."' or admin_id='".$data_rec_id['admin_id']."')";
	}
	
	if($_SESSION['type']=='AG')
	{
		$sel_admin_id="select added_by from site_setting where admin_id='".$_SESSION['admin_id']."'";
		$ptr_admin_id=mysql_query($sel_admin_id);
		$data_admin_ids=mysql_fetch_array($ptr_admin_id);
		
		$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and admin_id='".$data_admin_ids['added_by']."' and (type='C' or type='Z' or type='LD' or type='A') and (system_status='Enabled' || system_status='Agent_Enabled') order by name";
	}
	else
	{
		if($_SESSION['type']=="S" && $_SESSION['type']=="Z")
		{
			$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
		}
		else
		{
			$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_added_by." ".$where_branch." and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
		}
		
	}
	$ptr_name=mysql_query($sel_name);
	?>
	<select id="employee_id" name="employee_id" class="input_select">
	<option value="">--Select Staff--</option>
	<?php
	while($fetch_name=mysql_fetch_array($ptr_name))
	{
		$sel='';
		if($_POST['record_id']>0)
		{
			if($data_rec_id['employee_id']==$fetch_name['admin_id'])
			{
				$sel='selected="selected"';
			}
		}
		else
		{
			if($admin_id==$fetch_name['admin_id'])
			{
				$sel='selected="selected"';
			}
		}
		?>
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel;?>><?php echo $fetch_name['name'];?></option>
		<?php
	}
	?>
	</select>
	<?php
}
else if($action=="add_leads")
{
	$where_branch='';
		
	if($branch_id!='')
	{
		$where_branch=" and branch_name='".$branch_id."'";
	}
	
	if($_SESSION['type']=='AG')
	{
		$sel_admin_id="select added_by from site_setting where admin_id='".$_SESSION['admin_id']."'";
		$ptr_admin_id=mysql_query($sel_admin_id);
		$data_admin_ids=mysql_fetch_array($ptr_admin_id);
		
		$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and admin_id='".$data_admin_ids['added_by']."' and (type='C' or type='Z' or type='LD' or type='A') and (system_status='Enabled' || system_status='Agent_Enabled') order by name";
	}
	else
	{
		$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='LD' or type='A') and system_status='Enabled' order by name";
	}
	$ptr_name=mysql_query($sel_name);
	?>
	<select id="employee_id" name="employee_id" class="input_select">
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
		<option value="<?php echo $fetch_name['admin_id']?>" <?php echo $sel;?>><?php echo $fetch_name['name'];?></option>
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
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and (type='C' or type='Z' or type='A' or or type='LD') and system_status='Enabled' order by name";
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
else if($action=="utilization_report")
{
	$where_branch='';
	$where_branch=" and branch_name='".$branch_id."'";
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
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
else if($action=="performance_report")
{
	$where_branch='';
	$where_branch="  and branch_name='".$branch_id."'";
	$sel_name="SELECT * FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	?>
    <select name="staff_id" id="staff_id" class="input_select" style="width:150px" onchange="check_data(this.value)">
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
else if($action=="stockiest")
{
	$where_branch=" and branch_name='".$branch_id."'";
	
	$sel_added_by="SELECT admin_id,name FROM site_setting WHERE 1 ".$where_branch." and (type='ST' or type='A' or type='S' or type='Z') and system_status='Enabled' order by name";
	$ptr_added_by=mysql_query($sel_added_by);
	?>
    <select name="employee_id" style="width:200px;" id="employee_id" >
	<option value="">Assigned To</option>
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
    </select>
    <?php
}
else if($action=="get_emp_checkouts")
{
	$where_branch=" and branch_name='".$branch_id."'";
	$sel_added_by="SELECT admin_id,name FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
	$ptr_added_by=mysql_query($sel_added_by);
	
	while($data_added_by=mysql_fetch_array($ptr_added_by))
	{
		$sel='';
		if($_SESSION['admin_id']==$data_added_by['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $data_added_by['admin_id']?>" <?php echo $sel; ?>> <?php echo $data_added_by['name'];?></option>
		<?php
	}
	?>
    <?php
}
else if($action=="get_emp_sales")
{
	$where_branch=" and branch_name='".$branch_id."'";
	$sel_added_by="SELECT admin_id,name FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
	$ptr_added_by=mysql_query($sel_added_by);
	
	while($data_added_by=mysql_fetch_array($ptr_added_by))
	{
		$sel='';
		if($_SESSION['admin_id']==$data_added_by['admin_id'])
		{
			$sel='selected="selected"';
		}
		?>
		<option value="<?php echo $data_added_by['admin_id']?>" <?php echo $sel; ?>> <?php echo $data_added_by['name'];?></option>
		<?php
	}
	?>
    <?php
}

else if($action=="product_vendor")
{
	$where_branch=" and branch_name='".$branch_id."'";
	
	$sel_name="SELECT DISTINCT(cm_id) FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	$data_cm=mysql_fetch_array($ptr_name);
	?>
	<select  multiple="multiple" name="requirment_id[]" id="vendor_id" class="input_select" style="width:150px;" >                        
	<?php 
    $select_vendor = "select vendor_id,name from vendor where 1 and cm_id='".$data_cm['cm_id']."' order by vendor_id asc";
    $query_vendor = mysql_query($select_vendor);
    $i=0;
    while($data_vendor = mysql_fetch_array($query_vendor))
    { 
        echo '<option '.$class.' value="'.$data_vendor['vendor_id'].'" >'.$data_vendor['name'].'</option>';  
        $i++;
    }
    ?>  
    </select>
    <?php
}
else if($action=="show_vendor")
{
	$where_branch=" and branch_name='".$branch_id."'";
	$record_id=$_POST['record_id'];
	
	$sel_vandor="select vendor_id from inventory where inventory_id='".$record_id."'";
	$ptr_vendors=mysql_query($sel_vandor);
	$data_rec_vendors=mysql_fetch_array($ptr_vendors);
	
	$sel_name="SELECT DISTINCT(cm_id) FROM site_setting WHERE 1 ".$where_branch." and system_status='Enabled' order by name";
	$ptr_name=mysql_query($sel_name);
	$data_cm=mysql_fetch_array($ptr_name);
	?>
	<select name="vendor_id" id="vendor_id" class="input_select" style="width:200px;" onChange="get_product_list(this.value)">       
    <option value="">Select Vender</option>	                 
	<?php 
    $select_vendor="select vendor_id,name from vendor where 1 and cm_id='".$data_cm['cm_id']."' order by vendor_id asc";
    $query_vendor=mysql_query($select_vendor);
    $i=0;
    while($data_vendor=mysql_fetch_array($query_vendor))
    {
		$selecteds='';
		if($data_vendor['vendor_id']==$data_rec_vendors['vendor_id'])
		{
        	$selecteds='selected="selected"';
		}
        echo '<option  '.$selecteds.' '.$class.' value="'.$data_vendor['vendor_id'].'" >'.$data_vendor['name'].'</option>';  
        $i++;
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