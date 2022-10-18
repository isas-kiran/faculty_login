<?php include 'inc_classes.php';?>
<?php
//$cust_name=$_POST['customer_id'];
$branch_name=$_POST['branch_name'];

$sel_emp="select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and branch_name='".$branch_name."'";
$ptr_emp=mysql_query($sel_emp);
//$data_cm=mysql_fetch_array($ptr_emp);

    //$sql_cust = "select admin_id,name from site_setting where 1 and (type='ST') and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
   // $ptr_cust = mysql_query($sql_cust);
    echo'<select name="employee_id" id="employee_id"  class="input_select_login"  style="width: 150px;" onchange="show_product(this.value)">';
    echo'<option value="">Select Employee</option>';
    while($data_cust = mysql_fetch_array($ptr_emp))
    { 
        echo "<option value='".$data_cust['admin_id']."' >".$data_cust['name']."</option>";
    }
    echo '</select>';
    ?>
   