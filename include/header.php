<!--link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery.min.js"></script-->
<script>
	//define your time in second
	var c=3600;
	var t;
	timedCount();

	function timedCount()
	{
		var hours = parseInt( c / 3600 ) % 24;
		var minutes = parseInt( c / 60 ) % 60;
		var seconds = c % 60;

		var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);

		$('#timer').html(result);
		if(c == 0 )
		{
			//setConfirmUnload(false);
			//$("#quiz_form").submit();
			//window.location="logout.html";
			//alert('time complete');
		}
		c = c - 1;
		t = setTimeout(function()
		{
		 timedCount()
		},
		1000);
	}
</script>
<script type="text/javascript" >
$(document).ready(function()
{
    $("#notificationLink").click(function()
    {
        var data1="action=mark_read";
        //alert(data1);
        $.ajax({
            url: "notifications_process.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
                //----marked successfully----
            }
        });
        
        $("#notificationContainer").fadeToggle(300);
        $("#notification_count").fadeOut("slow");
        return false;
    });

//Document Click
$(document).click(function()
{
$("#notificationContainer").hide();
});
//Popup Click
$("#notificationContainer").click(function()
{
return false
});

});

</script>

<style>

#nav{list-style:none;margin: 0px;
padding: 0px;}
#nav li {
float: left;
margin-right: 20px;
font-size: 14px;
font-weight:bold;
}
#nav li a{color:#333333;text-decoration:none}
#nav li a:hover{color:#006699;text-decoration:none}
#notification_li{position:relative}
#notificationContainer {
background-color: #fff;
border: 1px solid rgba(100, 100, 100, .4);
-webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
overflow:visible;
position: absolute;
top: 30px;
margin-left: 00px;
width: 320px;
z-index: 12;
display: none;
}
#notificationContainer:before {
content: '';
display: block;
position: absolute;
width: 0;
height: 0;
color: transparent;
border: 10px solid black;
border-color: transparent transparent white;
margin-top: -20px;
margin-left: 188px;
}
#notificationTitle {
z-index: 1000;
font-weight: bold;
text-decoration: underline;
padding: 8px;
font-size: 12px;
/*width: 100px;*/
float: right;
/*border: 1px solid rgba(100, 100, 100, .4);*/
}
#notificationsBody {
padding: 33px 0px 0px 0px !important;
max-height:auto;
}
#notificationFooter {
background-color: #e9eaed;
text-align: center;
font-weight: bold;
padding: 8px;
font-size: 12px;
border-top: 1px solid #dddddd;
}
#notification_count {
padding: 3px 7px 3px 7px;
background: #cc0000;
color: #ffffff;
font-weight: bold;
margin-left: 49px;
border-radius: 9px;
position: absolute;
margin-top: -11px;
font-size: 11px;
}
.notification_list
{
    border-top: 1px solid rgba(100, 100, 100, .4);
    height: 25px;
    width: 300px;
    vertical-align: middle;
    font-weight: 500!important;
    padding: 8px;
}
</style>


<div id="head">
    <table width="100%">
        <tr>
            <td>
            	<div class="client_logo">
            		<a href="index.php" target="_blank" ><img src="images/logo.jpg" border="0" height="40px" width="60px"/></a>
                </div>
            </td>
            <td>
            	<h1 style="text-align:center; color:#06F !important; margin-right: 195px;">ISAS BEAUTY SCHOOL PVT LTD</h1>
            </td>
        	<!--<td><div class="logo"><img src="images/logo.png" border="0" /></div></td>-->
        </tr>
    </table>
</div>
<div id="nav">
    <?php
	if($_SESSION['name'])
	{
		$sql_notification= "SELECT * FROM stud_regi where not_status='signs_on' ";
		$ptr_notification=mysql_query($sql_notification);
		$count=mysql_num_rows($ptr_notification);
		?>
    	<script type="text/javascript">
        function redirectTo()
        {
            window.location.href='manage_notifications.php';
        }
    	</script>
        <table border="0" cellspacing="5" cellpadding="0" align="right">  
			<!--<tr>
                <td colspan="6" align="right" style="color:#7CA32F;"><?php// echo "Welcome ".$_SESSION['name'];?> </td>
            </tr>-->
          	<tr>
				<?php
                if($_SESSION['status']=='expired')
                  $status="Session Expired";
                else
                  $status="Logout";
                $last_login_date=date('l jS F Y h:i:s A', strtotime($_SESSION['last_login_time']));
                $last_logout_date=date('l jS F Y h:i:s A', strtotime($_SESSION['logout_time']));
                $box="<span style='color:#000; font-size:12px; font-weight:700'>Last Login time: </span><span >".$last_login_date."</span> <br /><span style='color:#000; font-size:12px; font-weight:700'>Logout Time: </span><span>".$last_logout_date."</span><br /><span style='color:#000; font-size:12px; font-weight:700'>Last Status: </span><span>".$status."</span></div>"; ?>
                <td style="color:#09C;font-size:13px; padding-right:22px; font-weight:500"><strong><a href="https://www.isasbeautyschool.org/staff_login/index_home.php" target="_blank" style="color:#09C">Personal Login</a></strong> </td>
                <td style="color:#09C;font-size:12px; padding-right:22px; font-weight:500"><strong><?php echo "Welcome ".ucwords($_SESSION['name']).' - '.$_SESSION['branch_name'];?></strong> </td>
                <td style="color:#09C;font-size:12px; padding-right:20px; font-weight:700">You will be logged out in : <span id='timer'></span></td>
                <td class="menu_font" style="color:#09C;font-size:12px; padding-right:20px; font-weight:700">
                    <div class="DemoContainer">
                        <span class="tooltip" title="<?php echo $box; ?>">Last Login Info</span>
                    </div>
                </td>
                <td>
                    <?php
                   	$select_notifications = "select notification_id from notifications where added_for='".$_SESSION['admin_id']."' and is_read='No'";
                    $ptr_notifications=mysql_query($select_notifications);
                    $unread_notifications = mysql_num_rows($ptr_notifications);            
                    ?>
                    <li id="notification_li">
                        <?php if($unread_notifications) echo '<span id="notification_count">'.$unread_notifications.'</span>';?>
                        <a href="javascript:void(0);" style="color:#09C" id="notificationLink">Notifications</a>
                        <div id="notificationContainer">
                            <div id="notificationTitle">
                            	<a href="manage_notifications.php" onclick="redirectTo()">View All</a>
                            </div>
                            <div id="notificationsBody" class="noti fications">
                              	<?php
                              	$select_notifications = "select notification,redirect_page_url,added_date from notifications where added_for='".$_SESSION['admin_id']."' order by notification_id desc limit 10";
                                $ptr_notifications = mysql_query($select_notifications);
                                while($data_notifications = mysql_fetch_array($ptr_notifications))
                                {
                                    $sep_date=explode(" ",$data_notifications['added_date']);
                                    $notification = $data_notifications['notification'];
                                    if(strlen($data_notifications['notification'])>35)
                                        $notification = $data_notifications['notification'];
                                    if($data_notifications['redirect_page_url'])
                                        echo '<div class="notification_list"><a href="#" style="padding-bottom:3px" onclick= "document.location.href=\''.$data_notifications['redirect_page_url'].'\'">'.$notification.' on '.$sep_date[0].'</a></div>';
                                    else
                                        echo '<div class="notification_list">'.$notification.'</div>';
                                }
                                ?>
                            </div>
                            <div id="notificationFooter"></div>
                        </div>
                    </li>
                </td>
                
                <!--<td><a href="index.php"><img src="images/adm_home_icon.png" border="0" /></a></td>-->
                <!--<td ><a href="index.php" style="color:#09C !important;font-size:12px; padding-right:22px; font-weight:500" class="menu_font">Administrator Home</a></td>-->
                <td><a href="http://isasbeautyschool.com" target="_blank"><img src="images/home_icon.png" /></a></td>
                <td ><a href="index.php" style="color:#09C !important;font-size:12px; padding-right:22px; font-weight:500" target="_blank" class="menu_font">Home</a></td>
                <td><a href="login.php?action=logout"><img src="images/logout_icon.png" /></a></td>
                <td ><a href="login.php?action=logout" style="color:#F03 !important;font-size:12px; padding-right:22px; font-weight:600" class="menu_font">Logout</a></td>
            </tr>
        </table>
        <?php
	}
	else
	{
		?>
		<table width="100" align="right" border="0" cellpadding="0" cellspacing="2">
			<tr>
			  <td><a href="../index.php" target="_blank"><img src="images/home_icon.png" /></a></td>
				<td><a href="../index.php" target="_blank" class="menu_font">Site Home</a></td>
			</tr>
		</table>
		<?php
	}
	?>
</div>