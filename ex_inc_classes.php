<?php session_start();
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
	include("include/config.php");
	include("../classes/Database.class.php");
	function __autoload($className)
	{
		require_once("classes/{$className}.php");
	}
    //make db connection for all files
    $db = new Database();
    $db->connect();
	
	 //$db_2 = new Database();
	 //$db_2->connect_db2();
	 
	
?>
<?php
$show_records=array(0=>'10',1=>'20','50','100','500','1000');
function addNotifications($args)
{
   /// echo "sss";
    $db1 = new Database();
    $db1->connect();
    $sql_loggein= "SELECT cm_id,type,admin_id,name FROM site_setting where admin_id='".$_SESSION['admin_id']."'";
    $row_loggedin=$db1->fetch_array($db1->query($sql_loggein));
    if($args['on_action'] == "enquiry_added")
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
                $db1->query_insert('notifications',$data_record);
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
                $db1->query_insert('notifications',$data_record);
            }
            //--to own---
           /* if($row_loggedin['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $_SESSION['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $db1->query_insert('notifications',$data_record);
            }*/
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
                $db1->query_insert('notifications',$data_record);
            }
            //--second message to the admin---
            $sql_cm = "SELECT admin_id,cm_id FROM site_setting where type='A' and admin_id='".$row_loggedin['cm_id']."'";
            $row_cm =$db1->fetch_array($db1->query($sql_councellor));
            if($row_cm['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_cm['cm_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $db1->query_insert('notifications',$data_record);
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
                $db1->query_insert('notifications',$data_record);
            }
        }
        else if($row_loggedin['type'] == 'S')
        {
            //--first message to the cm---
            $sql_cm = "SELECT admin_id,cm_id FROM site_setting where type='A' and cm_id='".$_SESSION['cm_id_notification']."'";
            $row_cm =$db1->fetch_array($db1->query($sql_cm));
            //print_r();
            if($row_cm['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_cm['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $db1->query_insert('notifications',$data_record);
            }
            //--second message to the Councellor---
            $sql_councellor = "SELECT admin_id,cm_id FROM site_setting where type='C' and cm_id='".$_SESSION['cm_id_notification']."'";
            $row_Councellor =$db1->fetch_array($db1->query($sql_councellor));
            if($row_Councellor['cm_id'])
            {
                $data_record['notification'] = 'New inquiry added by '.$row_loggedin['name'];
                $data_record['redirect_page_url'] = 'add_student.php?record_id='.$args['reference_id'];
                $data_record['added_by'] = $_SESSION['admin_id'];
                $data_record['added_for'] = $row_Councellor['admin_id'];
                $data_record['on_action'] = $args['on_action'];
                $data_record['is_read'] = 'No';
                $data_record['added_date'] = date("Y-m-d H:i:s");
                $db1->query_insert('notifications',$data_record);
            }
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