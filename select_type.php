<?php include 'inc_classes.php';
$send_to=$_POST['send_to'];		
?>
<script type="text/javascript">
   jQuery(document).ready( function() 
	{
		$("#requirment_id").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		//jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	</script>
<select  multiple="multiple" name="requirment_id[]" id="requirment_id" class="input_select" style="width:150px;">
<?php 	
if($_REQUEST['branch_name']!='')
{
	$branch_name=$_REQUEST['branch_name'];
	$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
	$ptr_cm_id=mysql_query($select_cm_id);
	$data_cm_id=mysql_fetch_array($ptr_cm_id);
	$search_cm_id=' and cm_id="'.$data_cm_id['cm_id'].'"';
}
else
{
	$search_cm_id=' and cm_id="'.$_SESSION['cm_id'].'"';
}					
if($send_to=='student') 
{
	if($_POST['type']=='enquiry')
	{
		$sel_child="select inquiry_id, firstname,lastname from inquiry where 1 ".$search_cm_id." and status='Enquiry' and response!='8' order by firstname asc";
		$query_child=mysql_query($sel_child);
		while($fetch_child=mysql_fetch_array($query_child))
		{
			echo '<option value="'.$fetch_child['inquiry_id'].'" >'.$fetch_child['firstname'].' '.$fetch_child['lastname'].'</option>';
			$i++;
		}
		echo '</optgroup>';  
	}
	else if($_POST['type']=='enrolled')
	{
		echo '<optgroup label="Select Student">  ';
		$sel_child="select enroll_id, name from enrollment where 1 ".$search_cm_id." and ref_id='0' ";
		$query_child=mysql_query($sel_child);
		while($fetch_child=mysql_fetch_array($query_child))
		{
			echo '<option '.$class.' value="'.$fetch_child['enroll_id'].'" >'.$fetch_child['name'].'</option>';
			$i++;
		}
		echo '</optgroup>';  
	}
	
}
else 
{
	echo '<optgroup label="Select Staff">  ';
	$sel_child="select distinct admin_id,name from site_setting where 1 ".$search_cm_id." and system_status='Enabled'";
	$query_child=mysql_query($sel_child);
	while($fetch_child=mysql_fetch_array($query_child))
	{
		echo '<option '.$class.' value="'.$fetch_child['admin_id'].'" >'.$fetch_child['name'].'</option>';
		$i++;
	}
	echo '</optgroup>';  
 
} ?>
 </select>        