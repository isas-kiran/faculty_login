<?php include 'inc_classes.php';?>
<?php
/*function send_sms_function($mobile,$message)
{
	$sendmsg=urlencode($message);
	$username="kapd-santosh";
	$password="sapke";
	$type=0;
	$dlr=1;
	$destination=$mobile;
	$source="ISASBS";
	$message=$sendmsg;


	 "<br/>".$service_url = "http://103.16.101.52:8080/sendsms/bulksms?username=".urlencode('kapd-santosh')."&password=".urlencode('sapke')."&type=0&dlr=1&destination=".$mobile."&source=ISASBS&message=".urldecode($message)."";

	echo ' <iframe src="'.$service_url.'" id="iframe" style="display:none"></iframe> ';

}
$todays_date=date('Y-m-d');
$prv_date =date('Y-m-d', strtotime('+3 day', strtotime($todays_date)));
$newdate =date('d-M-Y', strtotime($prv_date));
$select_inst="select enroll_id,installment_amount,cm_id from installment where installment_date='".$prv_date."' ";
$ptr_inst=mysql_query($select_inst);
if(mysql_num_rows($ptr_inst))
{
	while($data_inst=mysql_fetch_array($ptr_inst))
	{
		$desc="Installment reminder";
		$cm_id=$data_inst['cm_id'];
		
		$select_mobno = " select name,contact,course_id from enrollment where enroll_id='".$data_inst['enroll_id']."' ";
		$ptr_mob = mysql_query($select_mobno);
		$data_mob = mysql_fetch_array($ptr_mob);
		
		$name=$data_mob['name'];
		$sel_course="select course_name from courses where course_id='".$data_mob['course_id']."'";
		$ptr_course=mysql_query($sel_course);
		$data_course=mysql_fetch_array($ptr_course);
		
		"<br/>".$insert_sms="insert into sms_log_history (`sent_name`,`sent_mobile`,`sent_desc`,`user_type`,`sms_type`,`cm_id`,`added_date`) values('".$data_mob['name']."','".$data_mob['contact']."','".$desc."','student','installment_reminder','".$cm_id."','".date('Y-m-d H:i:s')."')";
		$ptr_sms=mysql_query($insert_sms);
		
		"<br/>".$mesg ="Hi ".$name." your EMI of ".$data_inst['installment_amount']." for ".$data_course['course_name']." course is due on ".$newdate.". Please arrange sufficient amount. -ISAS";
		$messagessss =$mesg;
		
		send_sms_function($data_mob['contact'],$messagessss);
		
		"<br/>".$mesg_faculty="".$name." has installment due for ".$data_course['course_name']." course  on ".$newdate.". Pls contct him/her for arrange sufficient amount";
		
		"<br/>".$sel_act="select contact_phone from site_setting where type='S' ";
		$ptr_cnt=mysql_query($sel_act);
		if(mysql_num_rows($ptr_cnt))
		{
			while($data_cnt=mysql_fetch_array($ptr_cnt))
			{
				send_sms_function($data_cnt['contact_phone'],$mesg_faculty);
			}
		}
	}
}*/
?>