<?php
	$request_data= $_POST["request_data"];

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

	$file = fopen("cams-attendance-record.txt","a");
	fwrite($file, $content);
	
	// Uncomment this block to write the values in your DB. Make sure that following table is created and $servername, $username , $password and $dbname are filled with its actual values
	//DB Script for table name CamsBiometricAttendance
	// Create Table CamsBiometricAttendance ( ID int NOT NULL AUTO_INCREMENT,    ServiceTagId varchar(20), UserID varchar(9), AttendanceTime BigInt, AttendanceType varchar(16), PRIMARY KEY (ID)};
	// After success execution of the script run the following query at your sql server
	//select ServiceTagId, UserId, from_unixtime(AttendanceTime), AttendanceType  from BiometricAttendance order by id desc
	
	
	$ServiceTagId = $request->ServiceTagId;
	$UserId = $request->ApiRequestInfo->UserId;
	$AttendanceTime = $request->ApiRequestInfo->OperationTime;
	$AttendanceType = $request->ApiRequestInfo->OperationData->AttendanceType;
		
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

	$sql = "INSERT INTO CamsBiometricAttendance (ServiceTagId, UserId, AttendanceTime, AttendanceType) VALUES ('". $ServiceTagId ."', '". $UserId ."', " . $AttendanceTime . ", '" . $AttendanceType . "')";

	fwrite($file,$sql);
	if ($conn->query($sql) === TRUE) {
		fwrite($file, " -- inserted in db");
	} else {
		fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
	}

	$conn->close();

	fclose($file);	
}
?>

