<?php include 'inc_classes.php';?>
<?php
$branch_name=$_REQUEST['branch_name'];

$sel_cm="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
$ptr_cm=mysql_query($sel_cm);
$data_cm=mysql_fetch_array($ptr_cm);
?>
<select name="vendor_id" id="vendor_id"  class="input_select_login"  style="width: 150px;">
<option value="">-Select Vendor-</option>
<?php 
    $sel_vendor="select vendor_id,name from vendor where 1 and cm_id='".$data_cm['cm_id']."' and name!=''";
    $ptr_vendor=mysql_query($sel_vendor);
    while($data_vendor=mysql_fetch_array($ptr_vendor))
    {
        /*$sel='';
        if($data_vendor['vendor_id']==$_REQUEST['vendor_id'])
        {
            $sel='selected="selected"';
        }*/
        echo '<option value="'.$data_vendor['vendor_id'].'" > '.$data_vendor['name'].'</option>';
    }		
?>
</select>


	