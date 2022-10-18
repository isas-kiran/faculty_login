<!--<link rel="stylesheet" href="css/animate.css">-->
<link rel="stylesheet" href="css/style.css">
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
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

</style>
<div id="head">
<table width="100%"><tr><td>
<div class="client_logo"><a href="index.php" target="_blank" ><img src="images/logo.jpg" border="0" height="30px" width="60px"/></a></div>
</td>
<!--<td><div class="logo"><img src="images/logo.png" border="0" /></div></td>-->
</tr></table>
</div>
<div id="nav">
        <?php
            if($_SESSION['name'])
            {
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
						<td ><?php echo "Welcome ". $_SESSION['admin_name'].'-'.$_SESSION['designation'];?> </td>
						<td ><a href="index.php"><img src="images/adm_home_icon.png" border="0" /></a></td>
						<td ><a  href="index.php" class="menu_font">Administrator Home</a></td>
						<!--<td><a href="../index.php" target="_blank"><img src="images/home_icon.png" /></a></td>
						<td><a style="color:white;border:1px solid black; border-radius:2px;" href="../index.php" target="_blank" class="menu_font">Site Home</a></td>-->
						<td><a href="login.php?action=logout"><img src="images/logout_icon.png" /></a></td>
						<td><a   href="login.php?action=logout" class="menu_font">Logout</a></td>
					</tr>
				</table>
				<?php
            }
            else
            {
               
            }
            ?>
           
</div>