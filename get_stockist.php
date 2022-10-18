<?php include 'inc_classes.php';?>
<?php
$cust_name=$_POST['customer_id'];
$branch_name=$_POST['action_for'];

$sel_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
$ptr_cm=mysql_query($sel_cm_id);
$data_cm=mysql_fetch_array($ptr_cm);
?>
<table width="100%">
<tr>
    <td width="12%" valign="top">Select Stockist<span class="orange_font"></span></td>
    <td width="70%" id="sel_cust" class="customized_select_box">
    <select name="stockist_id" id="stockist_id" style="width:200px;"  >
    <option value="">Select name</option> 
    <?php  
    $sql_cust = "select admin_id,name from site_setting where 1 and (type='ST') and cm_id='".$data_cm['cm_id']."' and system_status='Enabled' order by name asc";
    $ptr_cust = mysql_query($sql_cust);
    while($data_cust = mysql_fetch_array($ptr_cust))
    { 
        echo "<option value='".$data_cust['admin_id']."' >".$data_cust['name']."</option>";
    }
    ?>
    </select>
</tr>
</td>