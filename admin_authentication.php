<?php
if($_REQUEST['show_records'])
	$_SESSION['show_records']=$_REQUEST['show_records'];
else if(!$_SESSION['show_records'])
	$_SESSION['show_records']=10;
if($_REQUEST['show_records_pages'])
	$_SESSION['show_records_pages']=$_REQUEST['show_records_pages'];
else
	$_SESSION['show_records_pages']=5;
//echo time()-$_SESSION['last_login_time'];
//if((time()-$_SESSION['last_login_time'])>120)
//echo $_SESSION['last_login_time'];
		$select_acitve_logins ="select last_login_time, admin_id from site_setting where  status= 'Active' and admin_id='".$_SESSION['admin_id']."' ";
		$ptr_activr = mysql_query($select_acitve_logins);
		if(mysql_num_rows($ptr_activr))
		{
			$found_active_login = 'n';
			while($data_active = mysql_fetch_array($ptr_activr))
			{
				$timess = strtotime ($data_active['last_login_time']);
				//echo "<br/>cur_time-".time();
				$time_diff =time()-$timess ;
				
				if($time_diff>3600)
   				{
					$my_query_status="UPDATE site_setting SET status ='Inactive' WHERE admin_id='".$data_active['admin_id']."'";
					$ptr_query_status=mysql_query($my_query_status);
					
					$sel_histroy_id ="select login_id from  login_history where  admin_id='".$data_active['admin_id']."' order by login_id desc limit 0,1  ";
					$ptr_lastId = mysql_query($sel_histroy_id);
					if(mysql_num_rows($ptr_lastId))
					{
						$data_histroy_id = mysql_fetch_array($ptr_lastId);
						$update_histroy="Update login_history set logout_time='".date('Y-m-d H:i:s')."',status='expired' where login_id='".$data_histroy_id['login_id']."'  ";		
						$ptr_update = mysql_query($update_histroy);	
						if($data_active['admin_id']==$_SESSION['admin_id'])
						{
							$found_active_login='y';
						}
					}
				}
				else
				{
					if($data_active['admin_id']==$_SESSION['admin_id'])
					$my_query_status="UPDATE site_setting SET last_login_time = '".date('Y-m-d H:i:s')."' WHERE admin_id='".$_SESSION['admin_id']."'";
					$ptr_query_status=mysql_query($my_query_status);
				}
				
				
			}
			
		}
		
		
if($found_active_login=='y')
{
		
    session_destroy();
    ?><script language="javascript">document.location.href='login.php';</script><?
}

if($_SESSION['name']=="")
{
    session_destroy();
    ?><script language="javascript">document.location.href='login.php';</script>
	<?
}


/*$select_still_active = " select admin_id  from site_setting where status='Active' and admin_id='".$_SESSION['admin_id']."' ";
$ptr_active = mysql_query($select_still_active);
if(!mysql_num_rows($ptr_active))
{
	 session_destroy();
    ?><script language="javascript">document.location.href='login.php';</script>
	<?
}
*/
?>