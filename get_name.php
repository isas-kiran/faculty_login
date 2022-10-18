<?php include 'inc_classes.php';?>
<?php
$action=$_POST['action'];
if($action=="service")
{
	$mobile_no=$_POST['mobile_no'];
	if($mobile_no !='')
	{
		$sel_tel = "select cust_id,cust_name,email from customer where mobile1='".$mobile_no."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['cust_id']."###";
		?>
        <select name="customer_id" id="customer_id" style="width:200px;" onChange="getMembership(this.value)">
         	<option value="">Select Customer</option> 
          	<?php  
            $sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
            $ptr_cust = mysql_query($sql_cust);
            while($data_cust = mysql_fetch_array($ptr_cust))
            { 
                    $selecteds = '';
                    if($data_cust['cust_id']==$data_srvice['cust_id'])
                    $selecteds = 'selected="selected"';	
                echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
            }
            ?>
                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
        </select>
        <?php
		echo "###".$data_srvice['email'];
	}
}
else if($action=="membership")
{
	$mobile_no=$_POST['mobile_no'];
	if($mobile_no !='')
	{
		$sel_tel = "select cust_id,cust_name,email from customer where mobile1='".$mobile_no."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['cust_id']."###";
		?>
        <select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
         	<option value="">Select Customer</option> 
          	<?php  
            $sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
            $ptr_cust = mysql_query($sql_cust);
            while($data_cust = mysql_fetch_array($ptr_cust))
            { 
                    $selecteds = '';
                    if($data_cust['cust_id']==$data_srvice['cust_id'])
                    $selecteds = 'selected="selected"';	
                echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
            }
            ?>
                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
        </select>
        
        <?php
		echo "###".$data_srvice['email'];
	}
}
else if($action=="sale_product")
{
	$mobile_no=$_POST['mobile_no'];
	if($mobile_no !='')
	{
		if($_POST['type']=='Customer')
		{
			$sel_tel = "select cust_id,cust_name,email,address,delivery_address from customer where mobile1='".$mobile_no."'";	 
			$query_tel = mysql_query($sel_tel);
			$data_srvice = mysql_fetch_array($query_tel);
			echo $data_srvice['cust_id']."###";
			?>
			<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
			<option value="">Select Customer</option> 
			<?php  
			$sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
			$ptr_cust = mysql_query($sql_cust);
			while($data_cust = mysql_fetch_array($ptr_cust))
			{ 
				$selecteds = '';
				if($data_cust['cust_id']==$data_srvice['cust_id'])
				$selecteds = 'selected="selected"';	
				echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
			}
			?>
			<option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
			</select>
		
			<?php
            echo "###".$data_srvice['mail'];
            echo "###".$data_srvice['address'];
			echo "###".$data_srvice['delivery_address'];
		}
		else if($_POST['type']=='Student')
		{
			$sel_tel = "select enroll_id,name,mail,address from enrollment where contact='".$mobile_no."'";	 
			$query_tel = mysql_query($sel_tel);
			$data_srvice = mysql_fetch_array($query_tel);
			echo $data_srvice['enroll_id']."###";
			?>
			<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
			<option value="">Select Student</option> 
			<?php  
			$sql_cust = "select name, enroll_id,address from enrollment where 1 ".$_SESSION['where']." order by enroll_id asc";
			$ptr_cust = mysql_query($sql_cust);
			while($data_cust = mysql_fetch_array($ptr_cust))
			{ 
				$selecteds = '';
				if($data_cust['enroll_id']==$data_srvice['enroll_id'])
				$selecteds = 'selected="selected"';	
				echo "<option value='".$data_cust['enroll_id']."' ".$selecteds.">".$data_cust['name']."</option>";
			}
			?>
			<option value="custome" style="font-style:oblique; font-weight:800">New Student</option> 
			</select>
			
			<?php
			echo "###".$data_srvice['mail'];
			echo "###".$data_srvice['address'];	
			echo "###".$data_srvice['address'];	
		}
		else if($_POST['type']=='Employee')
		{
			$sel_tel = "select admin_id,name,contact_email,current_address from site_setting where contact_phone='".$mobile_no."'";	 
			$query_tel = mysql_query($sel_tel);
			$data_srvice = mysql_fetch_array($query_tel);
			echo $data_srvice['admin_id']."###";
			?>
			<select name="customer_id" id="customer_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
         	<option value="">Select Employee</option> 
          	<?php  
            $sql_cust = "select name, admin_id from site_setting where 1 ".$_SESSION['where']." order by admin_id asc";
            $ptr_cust = mysql_query($sql_cust);
            while($data_cust = mysql_fetch_array($ptr_cust))
            { 
                    $selecteds = '';
                    if($data_cust['admin_id']==$data_srvice['admin_id'])
                    $selecteds = 'selected="selected"';	
                echo "<option value='".$data_cust['admin_id']."' ".$selecteds.">".$data_cust['name']."</option>";
            }
            ?>
                <option value="custome" style="font-style:oblique; font-weight:800">New Employee</option> 
            </select>
            
            <?php
            echo "###".$data_srvice['contact_email'];	
            echo "###".$data_srvice['current_address'];
			echo "###".$data_srvice['current_address'];	
		}
	}

}
else if($action=="sale_voucher")
{
	$mobile_no=$_POST['mobile_no'];
	if($mobile_no !='')
	{
		$sel_tel = "select cust_id,cust_name,email from customer where mobile1='".$mobile_no."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['cust_id']."###";
		?>
        <select name="cust_id" id="cust_id" style="width:200px;" onChange="show_mobile_no(this.value)" >
         	<option value="">Select Customer</option> 
          	<?php  
            $sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
            $ptr_cust = mysql_query($sql_cust);
            while($data_cust = mysql_fetch_array($ptr_cust))
            { 
                    $selecteds = '';
                    if($data_cust['cust_id']==$data_srvice['cust_id'])
                    $selecteds = 'selected="selected"';	
                echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
            }
            ?>
                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
        </select>
        
        <?php
		echo "###".$data_srvice['email'];
	}
}
else if($action=="get_cust_mobileno")
{
	$cust_id=$_POST['cust_id'];
	if($cust_id !='')
	{
		echo "<select id='realtxt' name='realtxt' onChange='searchSel(this.value)'>";
		echo'<option value="">Select Mobile</option>';
		$sql_cust = "select mobile1,cust_id from customer where 1 ".$_SESSION['where']."  order by cust_id asc";
		$ptr_cust = mysql_query($sql_cust);
		while($data_cust = mysql_fetch_array($ptr_cust))
		{ 
			$selecteds = '';
			if($data_cust['cust_id']==$cust_id )
				$selecteds = 'selected="selected"';	
			echo "<option value='".$data_cust['mobile1']."' ".$selecteds.">".$data_cust['mobile1']."</option>";

		}
		echo'</select>';
	}
}
else
{
	$mobile_no=$_POST['mobile_no'];
	if($mobile_no !='')
	{
		$sel_tel = "select cust_id,cust_name,email from customer where mobile1='".$mobile_no."'";	 
		$query_tel = mysql_query($sel_tel);
		$data_srvice = mysql_fetch_array($query_tel);
		echo $data_srvice['cust_id']."###";
		?>
        <select name="customer_id" id="customer_id" style="width:200px;" >
         	<option value="">Select Customer</option> 
          	<?php  
            $sql_cust = "select cust_name, cust_id from customer where 1 ".$_SESSION['where']." order by cust_id asc";
            $ptr_cust = mysql_query($sql_cust);
            while($data_cust = mysql_fetch_array($ptr_cust))
            { 
                    $selecteds = '';
                    if($data_cust['cust_id']==$data_srvice['cust_id'])
                    $selecteds = 'selected="selected"';	
                echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";
            }
            ?>
                <option value="custome" style="font-style:oblique; font-weight:800">New Customer</option> 
        </select>
        
        <?php
		echo "###".$data_srvice['email'];
	}
}
?>	
