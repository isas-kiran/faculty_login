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
