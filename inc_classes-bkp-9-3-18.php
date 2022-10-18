<?php session_start();
date_default_timezone_set('Asia/Kolkata');
	//error_reporting( E_ALL );
	//ini_set('display_errors', 1);
		 
	include("include/config.php");
	include("classes/Database.class.php");
	//require 'PHPMailer-5.2.14/class.phpmailer.php';
	function __autoload($className)
	{
		//require_once("classes/{$className}.php");
		if (file_exists('classes/{$className}.php')) 
		{
			include("classes/{$className}.php");
			return true;
		}
		 return false;
	}
    //==================make db connection for all files. Dont Delete
    $db = new Database();
	$db->connect();
	//=======================
	
	/*$mail = new PHPMailer;
	$mail->SMTPDebug=1;   
	$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'kiran.vyavahare@waakan.com';                   // SMTP username
	$mail->Password = '';                            // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'tls' also accepted
	$mail->Port = 465;
	
	$mail->setFrom('kiran.vyavahare@waakan.com','isasbeautyschool');     //Set who the message is to be sent from
	$mail->addReplyTo('kiran.vyavahare@waakan.com', 'isas');*/
?>
<?php


$show_records=array(0=>'10',1=>'20','50','100','500','1000');
function addNotifications($args)
{
    $sql_loggein= "SELECT cm_id,type,admin_id,name FROM site_setting where admin_id='".$_SESSION['admin_id']."'";
	$db112=mysql_query($sql_loggein);
    $row_loggedin=mysql_fetch_array($db112);
	$action=trim($args['on_action']);
    if(trim($args['on_action']) == "enquiry_added")
    {
		$inquiry_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
        //----get logged in user type and based on that send the notification ----
        //print_r($row_loggedin);
        if($row_loggedin['type'] == 'A')
        {
            //--first message to the Councellor---
            '<br/>'.$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' and cm_id='".$row_loggedin['admin_id']."'";
            $row_Councellor =$db1->fetch_array($db1->query($sql_councellor));
			//echo $row_Councellor['admin_id'];
            if($row_Councellor['admin_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_Councellor['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
            }
            //--second message to the admin---
            if($row_loggedin['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_loggedin['cm_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
            }
            //--to own---
          
        }
		
        else if($row_loggedin['type'] == 'C')
        {
            //--first message to the cm---
            if($row_loggedin['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_loggedin['cm_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
				
                $ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
            }
            //--second message to the admin---
            $sql_cm = "SELECT admin_id,cm_id FROM site_setting where type='A' and admin_id='".$row_loggedin['cm_id']."'";
			$db1=mysql_query($sql_cm);
            $row_cm =mysql_fetch_array($db1);
            if($row_cm['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_cm['cm_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
				
				$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
            }
            //--to own---
            if($row_loggedin['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $_SESSION['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
				
                $ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
            }
        }
		else if($row_loggedin['type'] == 'S')
        {
            //--first message to the cm---
			echo"<br/>". $sql_cm = "SELECT admin_id,cm_id FROM site_setting where type='A' and cm_id='".$_SESSION['cm_id_notification']."'";
			$db155=mysql_query($sql_cm);
            $row_cm =mysql_fetch_array($db155);
            //print_r();
			
            if($row_cm['cm_id'])
            {
				echo "<br/>name- ".$row_loggedin['name'];
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_cm['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
				
				$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
				$ptr_inst=mysql_query($ins_notifi);
                //$db1->query_insert('notifications',$data_record);
            }
            //--second message to the Councellor---
			$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' and cm_id='".$_SESSION['cm_id_notification']."'";
			$db11=mysql_query($sql_councellor);
            while($row_Councellor =mysql_fetch_array($db11))
			{
				if($row_Councellor['cm_id'])
				{
					$data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
					$data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
					$data_record['added_by'] = $_SESSION['admin_id'];
					$data_record['added_for'] = $row_Councellor['admin_id'];
					$data_record['on_action'] = $args['on_action'];
					$data_record['is_read'] = 'No';
					$data_record['added_date'] = date("Y-m-d H:i:s");
					
					$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
					$ptr_inst=mysql_query($ins_notifi);
					//$db1->query_insert('notifications',$data_record);
				}
			}
        }
    }
	else if(trim($args['on_action']) == "enroll")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' or type='S' or type='A' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Enrollment added by '.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'manage_enroll.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "add_new_course")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' or type='S' or type='A' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Course added by Enrolled student by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'manage_enroll.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "batch_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' or type='S' or type='A' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Batch added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'add_batch.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "product_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Product added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'manage_product.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "expence_type_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Expence type added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'expence_type_edit.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "service_category_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Service Category added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'service_category.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "service_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Service type added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'service_category.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "customer_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New Customer added by client added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'service_category.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if(trim($args['on_action']) == "vendor_added")
	{
		$enroll_id = $args['reference_id'];//----you can use if you want to send the more details regarding the inquiry
		//----get logged in user type and based on that send the notification ----
		$sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='S' or type='A' or type='ST' and cm_id='".$row_loggedin['admin_id']."'";
		$db1=mysql_query($sql_councellor);
		while($row_Councellor =mysql_fetch_array($db1))
		{
			$data_record['notification'] = 'New vendor added by client added by faculty'.$row_loggedin['name'];
			$data_record['redirect_page_url'] = 'service_category.php?record_id='.$args['reference_id'];
			$data_record['added_by'] = $_SESSION['admin_id'];
			$data_record['added_for'] = $row_Councellor['admin_id'];
			$data_record['on_action'] = $args['on_action'];
			$data_record['is_read'] = 'No';
			$data_record['added_date'] = date("Y-m-d H:i:s");
			$ins_notifi="insert into notifications(`notification`,`redirect_page_url`,`added_by`,`added_for`,`on_action`,`is_read`,`added_date`) values('".$data_record['notification']."','".$data_record['redirect_page_url']."','".$data_record['added_by']."','".$data_record['added_for']."','".$data_record['on_action']."','".$data_record['is_read']."','".$data_record['added_date']."')";
			$ptr_inst=mysql_query($ins_notifi);
			
		}
		
	}
	else if($args['on_action'] == 'course_added')  ////========== Logsheet req added or custome corse added
	{
		 //--second message to the Councellor---
            $sql_councellor = "SELECT admin_id FROM site_setting where type='C' and cm_id='".$_SESSION['cm_id']."'";
            $row_Councellor =$db1->fetch_array($db1->query($sql_councellor));
            if($row_Councellor['admin_id'])
            {
				
				 $get="SELECT course_id,course_name FROM courses where course_id='".$args['reference_id']."' ";
                 $myQuery=mysql_query($get);
				 $data_course = mysql_fetch_array($myQuery);
				
                $data_record['notification'] = 'Customised Course '.$data_course['course_name'].' added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_course.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_Councellor['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $db1->query_insert('notifications',$data_record);
            }
	}
    else
    {
        $data_record['notification'] = $args['notification'];
        $data_record['redirect_page_url'] = $args['redirect_page_url'];
        $data_record['added_by'] = $args['added_by'];
        $data_record['added_for'] = $args['added_for'];
        $data_record['on_action'] = $args['on_action'];
        $data_record['is_read'] = 'No';
        $data_record['added_date'] = date("Y-m-d H:i:s");
        $RecordId=$db1->query_insert('notifications',$data_record);
    }
   // $db1->close();
    if($RecordId)
        return $RecordId;
    else
        return false;
}

?>