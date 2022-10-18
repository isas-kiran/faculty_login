<?php include 'inc_classes.php';?>
<?php
//$cust_name=$_POST['customer_id'];
$product_id=$_POST['product_id'];

$sel_emp="select product_name, product_id from product where 1 and product_id = '".$product_id."' order by product_id asc";
$ptr_emp=mysql_query($sel_emp);
//$data_cm=mysql_fetch_array($ptr_emp);

    //$sql_cust = "select admin_id,name from site_setting where 1 and (type='ST') and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
   // $ptr_cust = mysql_query($sql_cust);
    echo'<select name="product_name" class="input_select_login" id="pdt_id"  style="width: 150px;">';
    echo'<option value="">Select product</option>';
    while($data_cust = mysql_fetch_array($ptr_emp))
    { 
        echo "<option value='".$data_cust['product_id']."' >".$data_cust['product_name']."</option>";
    }
    echo '</select>';
    ?>
   