<?php 
include 'inc_classes.php';
$action = $_POST['action'];
$type= $_POST['type'];
if($type=="service")
{
	$and_type=" and campaign_for= 'service'";
}
else
{
	$and_type=" and campaign_for='institute'";
}
//GET FILTERS DETAILS IN MANAGE INQUIRY BY BRANCH WISE
$branch_name=$_POST['branch_name'];
$sel_cm_id="select DISTINCT(cm_id) from site_setting where branch_name='".$branch_name."' and type='A'";
$ptr_cm_id=mysql_query($sel_cm_id);
$data_cm_id=mysql_fetch_array($ptr_cm_id);
if($action=='source_details')
{
	echo'<option value="">Select Enquiry Source</option>';
	$sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cm_id['cm_id']."' ".$and_type." order by campaign_name asc";
	$ptr_src=mysql_query($sel_source);
	while($data_src=mysql_fetch_array($ptr_src))
	{
		$sele_source="";
		if($data_src['campaign_id'] == $_REQUEST['enquiry_src'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
		{
			$sele_source='selected="selected"';
		}
		?>
		<option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($_REQUEST['enquiry_src']) && $_REQUEST['enquiry_src'] == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
		<?php
	}
}
?>		  