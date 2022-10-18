<?php	$request_data= $_POST["request_data"];
	//include "include/headHeader_gst.php";
	// We capture all the incoming data from CAMS into file: cams-attendance-record.txt.
	// If you need to maintain it in your own database, you need to impletement the same here.

	$Operation = json_decode($request_data)->ApiRequestInfo->Operation;

	if ($Operation == 'RealTimePunchLog' )
	{
		handle_attendance_log($request_data);
	}

	$response = new StdClass();
	$response->status="done";

	header("Content-Type: application/text;charset=utf-8");
	http_response_code(200);
	echo json_encode($response);

// You can test url of this file through postman with POST->body->x-www-form-urlencoded parameter request_data
// the results will be avilable in http://<domain:port>/cams-attendance-record.txt
// ------------------------------------------------------------------------------------------------------------
function handle_attendance_log($request_data)
{
		// Sample request_data
		// {
		//   "ApiRequestInfo": {
		//     "AuthToken": "k3wgUszWcH4EjXM7sUWI38yJPkXhmvao",
		//     "Operation": "RealTimePunchLog",
		//     "OperationData": {
		//       "AttendanceType": "CheckIn",
		//       "InputType": "Card"
		//     },
		//     "OperationReferenceId": "",
		//     "OperationTime": "1556637142",
		//     "UserId": "852"
		//   },
		//   "ServiceTagId": "ST-KY19123123"
		// }

	$request = new StdClass();
	$request->ServiceTagId="";
	$request->ApiRequestInfo = new StdClass();
	$request->ApiRequestInfo->AuthToken="";
	$request->ApiRequestInfo->Operation="";
	$request->ApiRequestInfo->UserId="";
	$request->ApiRequestInfo->OperationTime="";
	$request->ApiRequestInfo->OperationReferenceId="";
	$request->ApiRequestInfo->OperationData= new StdClass();
	$request->ApiRequestInfo->OperationData->AttendanceType="";
	$request->ApiRequestInfo->OperationData->InputType="";

	$request = json_decode($request_data);

	$content = 'ServiceTagId:' . $request->ServiceTagId . ",\t";
	$content = $content . 'Operation:' . $request->ApiRequestInfo->Operation . ",\t";
	$content = $content . 'AuthToken:' . $request->ApiRequestInfo->AuthToken . ",\t";
	$content = $content . 'UserId:' . $request->ApiRequestInfo->UserId . ",\t";
	$content = $content . 'AttendanceTime:' . date("Y-m-d H:i:s", $request->ApiRequestInfo->OperationTime) . ",\t";
	$content = $content . 'AttendanceType:' . $request->ApiRequestInfo->OperationData->AttendanceType . ",\t";
	$content = $content . 'InputType:' . $request->ApiRequestInfo->OperationData->InputType . "\n";

	$file = fopen("pune-biometric-attendance-record.txt","a");
	fwrite($file, $content);
	
	// Uncomment this block to write the values in your DB. Make sure that following table is created and $servername, $username , $password and $dbname are filled with its actual values
	//DB Script for table name CamsBiometricAttendance
	// Create Table CamsBiometricAttendance ( ID int NOT NULL AUTO_INCREMENT,    ServiceTagId varchar(20), UserID varchar(9), AttendanceTime BigInt, AttendanceType varchar(16), PRIMARY KEY (ID)};
	// After success execution of the script run the following query at your sql server
	//select ServiceTagId, UserId, from_unixtime(AttendanceTime), AttendanceType  from BiometricAttendance order by id desc
	
	
	$ServiceTagId = $request->ServiceTagId;
	$operation=$request->ApiRequestInfo->Operation;
	$inputtype=$request->ApiRequestInfo->OperationData->InputType;
	$UserId = $request->ApiRequestInfo->UserId;
	$AttendanceTime = $request->ApiRequestInfo->OperationTime;
	$AttendanceType = $request->ApiRequestInfo->OperationData->AttendanceType;
	$punchTime=gmdate("Y-m-d H:i:s", $AttendanceTime);
	$ChkPunchTime=gmdate("Y-m-d", $AttendanceTime);
	
	$month=date("m", strtotime($punchTime));
	$year=date("Y", strtotime($punchTime));
	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
	$cm_id='2';
	
	$servername = "localhost";
	$username = "isasadmin";
	$password = "isasadmin007";
	$dbname = "isasbeautyschool_org";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		fwrite($file,"Connection failed: " . $conn->connect_error);
		die("Connection failed: " . $conn->connect_error);
	}
	
//======================================================================================================================================================
//Change in code - Verify attendace, avoid duplications, check in and check out only for verified in 15 min
// change by kiran
// date 6-1-2020

	$sql_user = "select * from pr_pune_biometric_attendance where UserId='".trim($UserId)."' and DATE(PunchTime)='".date($ChkPunchTime)."' order by ID desc";
	$result_att = $conn->query($sql_user);
	if ($result_att->num_rows > 0) 
	{
		$punchDate=$ChkPunchTime;
		$data_attendace = $result_att->fetch_assoc();
		if($data_attendace['AttendanceType']=='CheckIn')
		{
			$PunchInData=explode(" ",$data_attendace['PunchTime']);
			$CheckIn=$PunchInData[1];
			$differTime=abs($data_attendace['AttendanceTime']- $AttendanceTime)/60;
			if($differTime >=5) //check out if verified after 10 minute
			{
				$sql = "INSERT INTO pr_pune_biometric_attendance (ServiceTagId, UserId, AttendanceTime, AttendanceType, Operation, InputType, PunchTime, year, month, days, cm_id) VALUES ('".$ServiceTagId."', '".$UserId."', ". $AttendanceTime.", 'CheckOut', '".$operation."', '".$inputtype."','".$punchTime."','".$year."','".$month."','".$days."','".$cm_id."')";
				if ($conn->query($sql) === TRUE) {
					fwrite($file, " -- CheckOut Added after checkin");
				} else {
					fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
				}
			}
			else //verified
			{
				$sql = "Update pr_pune_biometric_attendance set AttendanceTime=".$AttendanceTime.", PunchTime='".$punchTime."' where UserId='".$UserId."' and AttendanceType='CheckIn' and DATE(PunchTime)='".$ChkPunchTime."' ";
				if ($conn->query($sql) === TRUE) {
					fwrite($file, " -- Verified CheckIn");
				} else {
					fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
				}
			}
		}
		else if($data_attendace['AttendanceType']=='CheckOut')
		{
			$PunchInData=explode(" ",$data_attendace['PunchTime']);
			$CheckIn=$PunchInData[1];
			$differTime=abs($data_attendace['AttendanceTime']- $AttendanceTime)/60;
			if($differTime >=5) //check In if verified after 10 min
			{
				$sql = "INSERT INTO pr_pune_biometric_attendance (ServiceTagId, UserId, AttendanceTime, AttendanceType, Operation, InputType, PunchTime, year, month, days, cm_id) VALUES ('".$ServiceTagId."', '".$UserId."', ". $AttendanceTime.", 'CheckIn', '".$operation."', '".$inputtype."','".$punchTime."','".$year."','".$month."','".$days."','".$cm_id."')";
				if ($conn->query($sql) === TRUE) {
					fwrite($file, " -- CheckIn Added after Checkout");
				} else {
					fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
				}
			}
			else //verified
			{
				$sql ="Update pr_pune_biometric_attendance set AttendanceTime=".$AttendanceTime.", PunchTime='".$punchTime."' where UserId='".$UserId."' and AttendanceType='CheckOut' and DATE(PunchTime)='".$ChkPunchTime."' ";
				if ($conn->query($sql) === TRUE) {
					fwrite($file, " -- Verified CheckIn");
				} else {
					fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
				}
			}
		}
	}
	else
	{
		$sql = "INSERT INTO pr_pune_biometric_attendance (ServiceTagId, UserId, AttendanceTime, AttendanceType, Operation, InputType, PunchTime, year, month, days, cm_id) VALUES ('". $ServiceTagId ."', '". $UserId ."', " . $AttendanceTime . ", '" . $AttendanceType . "', '".$operation."', '".$inputtype."','".$punchTime."','".$year."','".$month."','".$days."','".$cm_id."')";
		fwrite($file,$sql);
		if ($conn->query($sql) === TRUE) {
			fwrite($file, " -- inserted in db");
		} else {
			fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
		}
	}

//===================================================================================================================================================
	
	//$sql = "INSERT INTO pr_pune_biometric_attendance (ServiceTagId, UserId, AttendanceTime, AttendanceType, Operation, InputType, PunchTime) VALUES ('". $ServiceTagId ."', '". $UserId ."', " . $AttendanceTime . ", '" . $AttendanceType . "', '".$operation."', '".$inputtype."','".$punchTime."')";
	
	/*$sql_user = "select * from site_setting where attendence_id='".trim($UserId)."' and branch_name='Pune'";
	$result_user = $conn->query($sql_user);
	if ($result_user->num_rows > 0) {
		// output data of each row
		$data_user = $result_user->fetch_assoc();
			
		$message="Hi, ".$data_user['name']." is punching at ".$punchTime." for type ".$AttendanceType."";
		//$type='Tansactional';
		$mobile=$data_user['contact_phone'];
		//send_sms_function($data_user['contact_phone'],$message,$type);
		
		$service_url ="http://sms.digicalmmedia.com/vendorsms/pushsms.aspx?user=isasbeauty01&password=MM55A8QX&msisdn=".$mobile."&sid=ISASBS&msg=".urldecode($message)."&fl=0&gwid=2";
		echo ' <iframe src="'.$service_url.'" id="iframe" style="display:none"></iframe> ';	
		
	} else {
		echo "0 results";
	}*/
	
	

	$conn->close();

	fclose($file);	
}
?>

