<?php include 'inc_classes.php';
$campaign_id=$_POST['campaign_id'];
$select_cmp="select * from campaign where campaign_id='".$campaign_id."'";
$ptr_cmp=mysql_query($select_cmp);
$data_cmp=mysql_fetch_array($ptr_cmp);

$c_id=$data_cmp['c_id'];
$campaign_id=$data_cmp['campaign_id'];
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];

if($from_date!='')
{
	$frm_date=explode("/",$from_date);
	$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
	$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
}
else
{
	$pre_from_date="";                            
}
if($to_date!='')
{
	$to_dates_ex=explode("/",$to_date);
	$to_dates=$to_dates_ex[2]."-".$to_dates_ex[1]."-".$to_dates_ex[0];
	$pre_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($to_dates))."'";						
}
else
	$pre_to_date="";
?>
<table border="0" style="border:1px solid; font-size:14px" cellspacing="15" cellpadding="0" width="100%">
    <tr>
        <td colspan="1">Campaig Name : </td>
        <td colspan="5"><?php echo $data_cmp['campaign_name']; ?></td>
    </tr>
    <tr>
        <td colspan="1">Campaig URL : </td>
        <td colspan="5"><?php echo $data_cmp['campaign_url']; ?></td>
    </tr>
    <tr>
        <td colspan="1">Pixel Code : </td>
        <td colspan="5"><?php echo $data_cmp['pixel_code']; ?></td>
    </tr>
    <tr>
        <td>Form Date : </td>
        <td><?php if($from_date) echo $from_date; else if($data_cmp['from_date']) echo $data_cmp['from_date']; ?></td>
        <td>To Date : </td>
        <td><?php if($to_date) echo $to_date; else if($data_cmp['to_date']) echo $data_cmp['to_date']; ?></td>
        <td>Response Date : </td>
        <td><?php echo $data_cmp['response_date']; ?></td>
    </tr>
    <?php 
		$sel_cmp="select totalvisit from web_counter_totalview where c_id='".$c_id."'";
		$ptr_cmp=mysql_query($sel_cmp);
		$data_cmps=mysql_fetch_array($ptr_cmp);
		
		"<br/>".$sel_cmp="select inquiry_id from inquiry where enquiry_source='".$campaign_id."' and (response !='7' and response!='8' or response is NULL) ".$pre_from_date." ".$pre_to_date."";
		$ptr_cmp=mysql_query($sel_cmp);
		$total_cmp=mysql_num_rows($ptr_cmp);
		
		"<br/>".$sel_cmp_inv="select inquiry_id from inquiry where enquiry_source='".$campaign_id."' and (response ='7' or response='8') ".$pre_from_date." ".$pre_to_date."";
		$ptr_cmp_inv=mysql_query($sel_cmp_inv);
		$total_cmp_inv=mysql_num_rows($ptr_cmp_inv);
		
		"<br/>".$sel_cmp1="select enroll_id from enrollment where 1 and ref_id='0' and source='".$campaign_id."' ".$pre_from_date." ".$pre_to_date."";
		$ptr_cmp1=mysql_query($sel_cmp1);
		$total_cmp1=mysql_num_rows($ptr_cmp1);
		
		$sel_earn="select SUM(net_fees) as total_fees from enrollment where source='".$campaign_id."' ".$pre_from_date." ".$pre_to_date."";
		$ptr_earn=mysql_query($sel_earn);
		$data_earn=mysql_fetch_array($ptr_earn);
	?>
    <tr>
        <td colspan="1">Total Views : </td>
        <td colspan="5"><?php echo $data_cmps['totalvisit']; ?></td>
    </tr>
    <tr>
        <td colspan="1">Total Enquiry : </td>
        <td colspan="5"><a href="manage_student.php?enquiry_src=<?php echo $campaign_id; ?>&start_date=<?php echo $from_date; ?>&end_date=<?php echo $to_date; ?>" target="_blank"><?php echo $total_cmp; ?> + <?php echo $total_cmp_inv; ?>(Invalid Enquiries)</a></td>
    </tr>
    <tr>
        <td colspan="1">Total Enrolled : </td>
        <td colspan="5"><a href="manage_enroll.php?enquiry_src=<?php echo $campaign_id; ?>&start_date=<?php echo $from_date; ?>&end_date=<?php echo $to_date; ?>" target="_blank"><?php echo $total_cmp1; ?></a></td>
    </tr>
    <tr>
        <td colspan="6"><hr/></td>
    </tr>
    <tr>
        <td colspan="1">Total Earned From Enroolment : </td>
        <td colspan="5"><?php echo $data_earn['total_fees']; ?></td>
    </tr>
    <tr>
        <td colspan="1">Total Spend On Campaign : </td>
        <td colspan="5"><?php echo $data_cmp['total_cost']; ?></td>
    </tr>
</table>