<?php include 'inc_classes.php';?>
<?php
////==== CODE FOR LOGOUT AUTOMATICALLY===

$select_acitve_logins = " select last_login_time, admin_id from site_setting where  status= 'Active'  ";
		$ptr_activr = mysql_query($select_acitve_logins);
		if(mysql_num_rows($ptr_activr))
		{
			$found_active_login = 'n';
			while($data_active = mysql_fetch_array($ptr_activr))
			{
				$timess = strtotime ($data_active['last_login_time']);
				//echo date('Y-m-d H:i:s')."<br />";
				$time_diff =time()-$timess ;
				
				if($time_diff>1800)
   				{
					$my_query_status="UPDATE site_setting SET status = 'Inactive' WHERE admin_id='".$data_active['admin_id']."'";
					$ptr_query_status=mysql_query($my_query_status);
					$sel_histroy_id = " select login_id from  login_history where  admin_id='".$data_active['admin_id']."' order by login_id desc limit 0,1  ";
					$ptr_lastId = mysql_query($sel_histroy_id);
					if(mysql_num_rows($ptr_lastId))
					{
					$data_histroy_id = mysql_fetch_array($ptr_lastId);
					$update_histroy = " Update login_history set logout_time='".date('Y-m-d H:i:s')."', status='expired' where login_id='".$data_histroy_id['login_id']."'  ";		
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
///==== 

	$msg="";
	if($_GET['action']=='logout')
	{
		$my_query_status="UPDATE site_setting SET status = 'Inactive' WHERE admin_id='".$_SESSION['admin_id']."'";
		$ptr_query_status=mysql_query($my_query_status);
		
		 $update_histroy = " Update login_history set logout_time='".date('Y-m-d H:i:s')."', status='logout' where login_id='".$_SESSION['histroy_id']."'  ";
		
		$ptr_update = mysql_query($update_histroy);			
		session_destroy();
		$msg='Logout Successfully.';
        ?><script type="text/javascript">window.location.href='login.php?msg=You have signed out';</script><?php
	}
	if(isset($_GET['msg']) && $_GET['msg']!=="")
	{
		$msg=$_GET['msg'];
	}
	if(isset($_POST['submit']))
	{
		$type=$_POST['type'];
		$username=addslashes($_POST['username']);
		$pass=addslashes($_POST['pass']);
		$captch= $_POST['captcha'];
        //if($type=='admin')
        //{
		
        if($username && $pass && $captch )
        {
			
			/*$sql_notification= "SELECT * FROM stud_regi where not_status='signs_off' ";
			$ptr_notification=mysql_query($sql_notification);
			$_SESSION['not_count']=mysql_num_rows($ptr_notification);*/
			
			///==== S- super admin 
			///-- A - center manage
			///=   C - councellor
			//= B = BOP
			/// F = Faculty
			
            $sql_site_setting= "SELECT username, email,  type, admin_id, designation, cm_id, branch_name, status  FROM site_setting where username='".$username."' and pass='".$pass."'";
			$ptr_site_setting=mysql_query($sql_site_setting);
           // echo $sql_site_setting;
            if(mysql_num_rows($ptr_site_setting))
            {
				if((trim(strtolower($_POST['captcha'])) == $_SESSION['captcha']))
				{
                $row_site_setting=mysql_fetch_array($ptr_site_setting);
				
				if($row_site_setting['status']=='Inactive')
				{
                $_SESSION['name']=$row_site_setting['username'];
                $_SESSION['email_id']=$row_site_setting['email'];
                $_SESSION['account_type']=$row_site_setting['type'];
                $_SESSION['admin_id']=$row_site_setting['admin_id'];               
				$_SESSION['type']=$row_site_setting['type'];
				$_SESSION['type_admin']='admin';
				$_SESSION['designation']=$row_site_setting['designation'];
				$_SESSION['cm_id']=$row_site_setting['cm_id'];
				$_SESSION['branch_name']=$row_site_setting['branch_name'];
				
				
				$select_last="select last_login_time,logout_time,last_login_ip,status from login_history where admin_id='".$_SESSION['admin_id']."' order by login_id desc limit 0,1";
				$ptr_last=mysql_query($select_last);
				$data_last=mysql_fetch_array($ptr_last);
				$_SESSION['last_login_time']=$data_last['last_login_time'];
				$_SESSION['logout_time']=$data_last['logout_time'];
				$_SESSION['status']=$data_last['status'];
				
				
				$ip = $_SERVER['REMOTE_ADDR'];				
				$my_query_status="UPDATE site_setting SET status = 'Active', last_login_time = '".date('Y-m-d H:i:s')."'  WHERE admin_id='".$row_site_setting['admin_id']."'";
				$ptr_query_status=mysql_query($my_query_status);
						
					
				$ins_login="insert into login_history (`last_login_time`,`last_login_ip`,`admin_id`) values('".date('Y-m-d H:i:s')."','$ip','".$row_site_setting['admin_id']."')";
				$query_login=mysql_query($ins_login);
				$_SESSION['histroy_id']= mysql_insert_id();
				
				
				$sel_branch_addr= "SELECT branch_address FROM branch where branch_name='".$row_site_setting['branch_name']."'";
				$ptr_branch_addr=mysql_query($sel_branch_addr);
				if(mysql_num_rows($ptr_branch_addr))
            	{
					$data_branch=mysql_fetch_array($ptr_branch_addr);
					$_SESSION['branch_address']=$data_branch['branch_address'];
                	//$_SESSION['installment_tax']=$data_branch['installment_course_percentage'];
				}
				
				
				$sel_tax= "SELECT * FROM general_settings where branch_name='".$row_site_setting['branch_name']."' order by setting_id desc limit 0,1";
				$ptr_tax=mysql_query($sel_tax);
				if(mysql_num_rows($ptr_tax))
            	{
					$data_tax=mysql_fetch_array($ptr_tax);
					$_SESSION['service_tax']=$data_tax['service_tax'];
                	$_SESSION['installment_tax']=$data_tax['installment_course_percentage'];
					$_SESSION['cgst']=$data_tax['cgst'];
                	$_SESSION['sgst']=$data_tax['sgst'];
				}
				/*if($row_site_setting['type']=='S')
                {
					$select_prev_admin= " select * from previleges where privilege_parent_id=0" ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$array_previ_parent =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						
						"<br/>".$select_prev= " select privilege_id from previleges where previlege_parent_id='".$data_prevo['previlege_parent_id']."'" ;
						$ptr_prev = mysql_query($select_prev);
						$s=0;
						while($data_prev1=mysql_fetch_array($ptr_prev))
						{
							$array_previ[$k][$s]['privilege_id']= $data_prev1['privilege_id'];
							$s++;
						}
						
						$array_previ_parent[$k]['privilege_id']= $data_prevo['previlege_parent_id'];
						
						$k++;
					}
					
				   	$_SESSION['privilege_id'] =$array_previ;
					$_SESSION['privilege_id_parent'] =$array_previ_parent;
				}*/
				if($row_site_setting['type']=='A')
                {
					$select_prev_admin= " select DISTINCT(previlege_parent_id) from admin_previleges where admin_id='".$_SESSION['admin_id']."'" ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$array_previ_parent =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						"<br/>".$select_prev= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' and  previlege_parent_id='".$data_prevo['previlege_parent_id']."'" ;
						$ptr_prev = mysql_query($select_prev);
						$s=0;
						
						while($data_prev1=mysql_fetch_array($ptr_prev))
						{
							$array_previ[$k][$s]['privilege_id']= $data_prev1['privilege_id'];
							$s++;
						}
						$array_previ_parent[$k]['privilege_id']= $data_prevo['previlege_parent_id'];
						$k++;
					}
				   	$_SESSION['privilege_id'] =$array_previ;
					$_SESSION['privilege_id_parent'] =$array_previ_parent;
					
					$select_prev= " select privilege_id from staff_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_prev = mysql_query($select_prev);
					$n=0;
					while($data_staff_prev1=mysql_fetch_array($ptr_prev))
					{
						$staff_previ[$n]= $data_staff_prev1['privilege_id'];
						$n++;
					}
					$_SESSION['staff_prev']=$staff_previ;
				}
				elseif($row_site_setting['type']=='C')
				{
					$select_prev_admin= " select DISTINCT(previlege_parent_id) from admin_previleges where admin_id='".$_SESSION['admin_id']."'" ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$array_previ_parent =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						
						"<br/>".$select_prev= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' and  previlege_parent_id='".$data_prevo['previlege_parent_id']."'" ;
						$ptr_prev = mysql_query($select_prev);
						$s=0;
						while($data_prev1=mysql_fetch_array($ptr_prev))
						{
							$array_previ[$k][$s]['privilege_id']= $data_prev1['privilege_id'];
							$s++;
						}
						
						$array_previ_parent[$k]['privilege_id']= $data_prevo['previlege_parent_id'];
						
						$k++;
					}
					
				   	$_SESSION['privilege_id'] =$array_previ;
					$_SESSION['privilege_id_parent'] =$array_previ_parent;
					
					$select_prev= " select privilege_id from staff_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_prev = mysql_query($select_prev);
					$n=0;
					while($data_staff_prev1=mysql_fetch_array($ptr_prev))
					{
						$staff_previ[$n]= $data_staff_prev1['privilege_id'];
						$n++;
					}
					$_SESSION['staff_prev']=$staff_previ;
				}
				elseif($row_site_setting['type']=='F')
				{
					$select_prev_admin= " select DISTINCT(previlege_parent_id) from admin_previleges where admin_id='".$_SESSION['admin_id']."'" ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$array_previ_parent =array();
					$staff_previ=array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						
						"<br/>".$select_prev= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' and  previlege_parent_id='".$data_prevo['previlege_parent_id']."'" ;
						$ptr_prev = mysql_query($select_prev);
						$s=0;
						while($data_prev1=mysql_fetch_array($ptr_prev))
						{
							$array_previ[$k][$s]['privilege_id']= $data_prev1['privilege_id'];
							$s++;
						}
						
						$array_previ_parent[$k]['privilege_id']= $data_prevo['previlege_parent_id'];
						
						
						
						$k++;
					}
					
				        $_SESSION['privilege_id'] =$array_previ;
					$_SESSION['privilege_id_parent'] =$array_previ_parent;
					
					
					$select_prev= " select privilege_id from staff_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_prev = mysql_query($select_prev);
					$n=0;
					while($data_staff_prev1=mysql_fetch_array($ptr_prev))
					{
						$staff_previ[$n]= $data_staff_prev1['privilege_id'];
						$n++;
					}
					$_SESSION['staff_prev']=$staff_previ;
					
				}
				elseif($row_site_setting['type']=='B')
				{
					 $select_prev_admin= " select DISTINCT(previlege_parent_id) from admin_previleges where admin_id='".$_SESSION['admin_id']."'" ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$array_previ_parent =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						
						"<br/>".$select_prev= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' and  previlege_parent_id='".$data_prevo['previlege_parent_id']."'" ;
						$ptr_prev = mysql_query($select_prev);
						$s=0;
						while($data_prev1=mysql_fetch_array($ptr_prev))
						{
							$array_previ[$k][$s]['privilege_id']= $data_prev1['privilege_id'];
							$s++;
						}
						
						$array_previ_parent[$k]['privilege_id']= $data_prevo['previlege_parent_id'];
						
						$k++;
					}
					
				   	$_SESSION['privilege_id'] =$array_previ;
					$_SESSION['privilege_id_parent'] =$array_previ_parent;
					
					 $select_prev= " select privilege_id from staff_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_prev = mysql_query($select_prev);
					$n=0;
					while($data_staff_prev1=mysql_fetch_array($ptr_prev))
					{
						$staff_previ[$n]= $data_staff_prev1['privilege_id'];
						$n++;
					}
					$_SESSION['staff_prev']=$staff_previ;
				}
				
                ?>
				<script language="javascript">window.location='index.php';</script><?
            }
			else
			{
				$msg= "Your login session is active from another machine. wait for expired it or logout from another machine first";	
			}
			
			}else
			{
				$msg="Please Enter Valid Security Code";
			}
			}
            else
            {
				$msg= "Please Enter Valid Username Or Password";	
				
			}
			
          // $msg='Enter username and password';
	     }
		 else {$msg= "Please Enter Username Or Password Or Security Code";}
	
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome on <?php echo $GLOBALS['domainName'];?></title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
  
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
</head>

<body>
<?php include "include/header.php";?>
<div id="login">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="top_left2"></td>
    <td class="top_mid2">
        <table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
           
            <tr>
                <td class="green_head_font" width="30%">Welcome User</td>
              </tr>
        </table>
    </td>
    <td class="top_right2"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <form method="post" id="jqueryForm">
	<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
             <?php   $_SESSION['type']; if($msg!=="") { ?>
              <tr>   
                  <td class="error_msg" align="center" ><?php   echo $msg;?> </td>
              </tr><?php } ?>
              <tr>
                <td class="height10"></td>
              </tr>
              <tr>
    <td class="green_head_font" ><!--<input type="radio" name="type" value="admin" />-->
	<?php /*if($_POST['login'])
    {
    if($_POST['type']=='admin') echo 'checked="checked"';
    }
    else
    {
    //if($row_record['type']=='admin') echo 'checked="checked"';
    }*/?>   
    
   <!-- <input type="radio" name="type" value="staff"  />--><?php /*if($_POST['login']) { if($_POST['type']=='staff') echo 'checked="checked"';
	 }
    else
    {
    //if($row_record['type']=='staff') echo 'checked="checked"';
    }*/?>  
   </td>
    </tr>
              <tr>
                <td>Username</td>
              </tr>
              <tr>
                  <td><input type="text" maxlength="15" class="validate[required] input_text_login" name="username" id="username" /></td>
              </tr>
              <tr>
                <td>Password <a href="forgot-password.php" class="orange_font">(Forgot Password)</a></td>
              </tr>
              <tr>
                  <td><input type="password" maxlength="15" class="validate[required] input_text_login" name="pass" id="password" /></td>
              </tr>
              <tr>
                  <td height="50" ><span class="text-form"><font color="#333333" size="2"> </font></span> 
                  <label> <img  src="captcha/captcha.php" id="captcha" height="35px"/>
                                    <img src="captcha/refresh.png" id="change-image" style="cursor: pointer; padding: 8px 26px;" onClick=			"document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();">
                    </label>
                  </td>
               </tr>
              <tr>
                <td height="50"><span class="text-form"> Security Code:</span></td>
               </tr>
               <tr>
                <td><label> <input type="text" class="validate[required] inputText" name="captcha" id="captcha-form"/>
                   </label> </td>
              </tr>
                  
              <tr>
                <td><input type="submit" name="submit" id="submit" class="input_btn"  value="SIGN IN" /> <input type="checkbox" />Remember me</td>
              </tr>
               
        </table>
        </form>
	</td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<div id="footer"><?php include "include/footer.php";?></div>
</body>
</html>
