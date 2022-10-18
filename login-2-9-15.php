<?php include 'inc_classes.php';?>
<?php
	$msg="";
	if($_GET['action']=='logout')
	{
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
        //if($type=='admin')
        //{
        if($username && $pass)
        {
			
			/*$sql_notification= "SELECT * FROM stud_regi where not_status='signs_off' ";
			$ptr_notification=mysql_query($sql_notification);
			$_SESSION['not_count']=mysql_num_rows($ptr_notification);*/
			
			///==== S- super admin 
			///-- A - center manage
			///=   C - councellor
			//= B = BOP
			/// F = Faculty
			
             $sql_site_setting= "SELECT * FROM site_setting where username='".$username."' and pass='".$pass."'";
			$ptr_site_setting=mysql_query($sql_site_setting);
           // echo $sql_site_setting;
            if(mysql_num_rows($ptr_site_setting))
            {
                $row_site_setting=mysql_fetch_array($ptr_site_setting);

                $_SESSION['name']=$row_site_setting['username'];
                $_SESSION['email_id']=$row_site_setting['email'];
                $_SESSION['account_type']=$row_site_setting['type'];
                $_SESSION['admin_id']=$row_site_setting['admin_id'];
                $_SESSION['last_login_time']=time();
				$_SESSION['type']=$row_site_setting['type'];
				$_SESSION['type_admin']='admin';
				$_SESSION['designation']=$row_site_setting['designation'];
				$_SESSION['cm_id']=$row_site_setting['cm_id'];
				$_SESSION['branch_name']=$row_site_setting['branch_name'];
				
				
				$sel_tax= "SELECT * FROM general_settings order by setting_id desc limit 0,1";
				$ptr_tax=mysql_query($sel_tax);
				if(mysql_num_rows($ptr_tax))
            	{
					$data_tax=mysql_fetch_array($ptr_tax);
					$_SESSION['service_tax']=$data_tax['service_tax'];
                	$_SESSION['installment_tax']=$data_tax['installment_course_percentage'];
				}
				
				if($row_site_setting['type']=='A')
                {
					
					
					
					$select_prev_admin= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						$array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
						$k++;
					}
				   $_SESSION['privilege_id'] =$array_previ;
				}
				elseif($row_site_setting['type']=='C')
				{
					$select_prev_admin= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						$array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
						$k++;
					}
				   $_SESSION['privilege_id'] =$array_previ;
				}
				elseif($row_site_setting['type']=='F')
				{
					$select_prev_admin= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						$array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
						$k++;
					}
				   $_SESSION['privilege_id'] =$array_previ;
				}
				elseif($row_site_setting['type']=='B')
				{
					$select_prev_admin= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' " ;
					$ptr_previlege = mysql_query($select_prev_admin);
					$array_previ =array();
					$k=0;
					while($data_prevo = mysql_fetch_array($ptr_previlege))
					{
						$array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
						$k++;
					}
				   $_SESSION['privilege_id'] =$array_previ;
				}
                ?>
				<script language="javascript">window.location='index.php';</script><?
            }
            else
            {
				echo "Please Enter Valid Username Or Password";	
				/*
			$sql_site_setting= "SELECT * FROM staff_regi where username='".$username."' and pass='".$pass."'";
			$ptr_site_setting=mysql_query($sql_site_setting);
           // echo $sql_site_setting;
            if(mysql_num_rows($ptr_site_setting))
            {
                $row_site_setting=mysql_fetch_array($ptr_site_setting);
                $_SESSION['name']=$row_site_setting['username'];
                $_SESSION['email_id']=$row_site_setting['staff_mail'];
                $_SESSION['account_type']=$row_site_setting['type'];
                $_SESSION['admin_id']=$row_site_setting['staff_id'];
                $_SESSION['last_login_time']=time();
			    $_SESSION['type_admin']='admin';
				$_SESSION['type']=$row_site_setting['type'];
				 if($row_site_setting['type']=='A')
                        {
                            $select_prev_admin= " select privilege_id from admin_previleges where admin_id='".$_SESSION['admin_id']."' " ;
                            $ptr_previlege = mysql_query($select_prev_admin);
                            $array_previ =array();
                            $k=0;
                            while($data_prevo = mysql_fetch_array($ptr_previlege))
                            {
                                $array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
                                $k++;
                            }
                           $_SESSION['privilege_id'] =$array_previ;
                        }
                        
                ?><script>alert('login')</script>
				<script language="javascript">window.location='index.php';</script><?
			}
			else
			{
			
                $msg='Wrong username or password, please try again';
            }
            */
			}
			
          // $msg='Enter username and password';
	     }
		 else {echo "Please Enter Username Or Password";}
	//}
	/*else
	{
		
        if($username && $pass)
        {
         $sql_site_setting= "SELECT * FROM ".$GLOBALS["pre_db"]."staff_regi where username='".$username."' and pass='".$pass."'";
            //echo $sql_site_setting;
            if(mysql_num_rows($db->query($sql_site_setting)))
            {
                $row_site_setting=$db->fetch_array($db->query($sql_site_setting));

                $_SESSION['name']=$row_site_setting['username'];
                $_SESSION['email_id']=$row_site_setting['staff_mail'];
                $_SESSION['account_type']=$row_site_setting['type'];
                $_SESSION['admin_id']=$row_site_setting['staff_id'];
				$_SESSION['staff_id']=$row_site_setting['staff_id'];
                $_SESSION['last_login_time']=time();
				$_SESSION['type']=$row_site_setting['type'];
				$_SESSION['type_admin']='';
				
				
				 if($row_site_setting['type']=='A')
                        {
                      $select_prev_admin= "select privilege_id from admin_previleges where 
				   staff_id='".$_SESSION['admin_id']."' " ;
                            $ptr_previlege = mysql_query($select_prev_admin);
                            $array_previ =array();
                            $k=0;
                            while($data_prevo = mysql_fetch_array($ptr_previlege))
                            {
                                $array_previ[$k]['privilege_id']= $data_prevo['privilege_id'];
                                $k++;
                            }
                           $_SESSION['privilege_id'] =$array_previ;
                        }
                        
                ?>
				<script language="javascript">window.location='index.php';</script><?
            }
            else
            {
                $msg='Wrong username or password, please try again';
            }
		}
		else
            $msg='Enter username and password';
		}*/
		
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
                <td><input type="submit" name="submit" id="submit" class="input_btn"  value="SIGN IN" /> <input type="checkbox" />Remember me</td>
              </tr>
               <tr>
                 <td class="height10"></td>
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
