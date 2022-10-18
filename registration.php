<?php session_start();?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <!-- The rest of your page's header here -->
</head>
<body>
<?php

$hostname = "localhost";
$username = "root";
$password = "";
$databasename = "sonali";


$connect=mysql_connect($hostname,$username,$password);
mysql_select_db($databasename,$connect);


echo " Welcome " .$_SESSION['username']. "<br>";

$error="no";
$errv="";
if(isset($_POST['save']))
{	
  	if(empty($_POST['name']))
  	{
   		$errv.="name is required\n";
   		$error='yes';
  	}
  	else
  	{
   		$name=$_POST['name'];
  	}
  
  	if(empty($_POST['email']))
  	{
    	$errv.="email is required\n";
    	$error='yes';
  	}
  	else
 	{
  		$email=$_POST['email'];
  	}
  
  
	if(empty($_POST['phone']))
  	{
    	$errv.="mobile no is required\n";
    	$error='yes';
	}	
  	else
  	{
   		$phone=$_POST['phone'];
  	}
  
  
  	if(empty($_POST['Address']))
  	{
    	$errv.="address is required\n";
    	$error='yes';
  	}
  	else
	{
  		$address=$_POST['Address'];
  	}
  
  
  	if(empty($_POST['Username']))
  	{
    	$errv.="username is required\n";
  		$error='yes';
	}
  	else
  	{
  		$username=$_POST['Username'];
  	}
  
  
  	if(empty($_POST['Password']))
  	{
    	$errv.="password is required\n";
  		$error='yes';
  	}	
  	else
	{
  		$password=$_POST['Password'];
  	}
  
  
  	if(empty($_POST['ConformPassword']))
  	{
    	$errv.="conformpassword is required\n";
  		$error='yes';
  	}
  	else
	{
  		$conformpassword=$_POST['ConformPassword'];
  	}
  
  
  	if(empty($_POST['gender']))
  	{
    	$errv.="gender is required\n";
  		$error='yes';
	}
  	else
	{
		$gender=$_POST['gender'];
  	}
  
  
  	if(empty($_POST['Hobby0']))
  	{
    	$errv.="hobby0 is required\n";
  		$error='yes';
  	}
  	else
	{
  		$hobby0=$_POST['Hobby0'];
  	}
  
  
  	if(empty($_POST['Hobby1']))
  	{
    	$errv.="hobby1 is required\n";
  		$error='yes';
  	}
  	else
	{
  		$hobby1=$_POST['Hobby1'];
  	}
  
  
  	if(empty($_POST['qualification']))
  	{
    	$errv.="qualification is required\n";
  		$error='yes';
	}
  	else
	{
  		$qualification=$_POST['qualification'];
  	}
  
  
  	/*if(empty(basename($_FILES['file']['name'])))
  	{
    	$errv.="File is required\n";
  		$error='yes';
  	}
  	else
	{
  		$file=$_FILES['file']['name'];
	}

    if(empty(basename($_FILES['image']['name'])))
  	{
    	$errv.="Image is required\n";
    	$error='yes';
   	}*/
  
    echo $errv;
    if($error=='no')
	{  
		if($_SESSION['Username'] !='')
		{
			if($file !='' and $image !='')
			{
		    	move_uploaded_file($_FILES['file']['tmp_name'],'uploaded_file/'.$file);
				move_uploaded_file($_FILES['image']['tmp_name'],'uploaded_file/'.$image);
	   			$update_query = "update register set name='$name1',email='$email1',address='$address1',file='$file1,image='$image1' where 'Username='".$_SESSION['Username']."' ";
				$ptr_update = mysql_query($update_query);
				echo "Record Update Successfully";
			}  
		}
    	else
		{
		  
      		$dup = mysql_query("SELECT Username FROM register WHERE Username = '".$_POST['Username']."'");
	    	if(mysql_num_rows($dup)>0)
			{
			  echo "Username Already Exists..";
	       
        	}
			else
			{
				if($file !='' and $image !='')
              	move_uploaded_file($_FILES['file']['tmp_name'],'uploaded_file/'.$file);
			  	move_uploaded_file($_FILES['image']['tmp_name'],'uploaded_file/'.$image);
				$query = "INSERT INTO register (`name`, `email`, `mobile_no`, `address`, `username`, `password`, `gender`,`playing_cricket`,`listening_music`, `qualification`, `file`, `image`) 
VALUES ('".$name."', '".$email."', '".$phone."', '".$address."', '".$username."', '".$password."', '".$gender."', '".$hobby0."', '".$hobby1."', '".$qualification."', '".$file."','".$image."')";
$ptr_insert = mysql_query($query);
      			echo "Successfully Registration";  
			}
		}
 	}
}
?>

<?php
if(isset($_POST['Submit']))
{
	header("location:Login.php");
}
if(isset($_POST['Logout']))
{
	session_destroy();
	return true;
}
?>


<style>
table {
     border:1px solid blue;
     border-collapse:collapse;
}
th,td {
    padding:10px;
    text-align:left;
}
</style>
<?php

if($_SESSION['Username'] !='')
{
  $querey="SELECT `student_id`, `name`, `email`, `mobile_no`, `address`, `username`, `password`, `gender`, `playing_cricket`, `listening_music`, `qualification`,`file`,`image`,`added_date_time` FROM `register` WHERE username='".$_SESSION['Username']."'";
$ptr_query= mysql_query($querey);
$val_data = mysql_fetch_array($ptr_query);
}


?>


<h1  style="text-align:center;color:Red ">Registration</h1>
<form name="myform" action="" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
<table style="width:40%; background-color:Aqua" align="center">



<tr>
<td>Name</td><td><input type="text" name="name" value="<?php echo $val_data['name'] ?>" /></td>
</tr>
<tr>
<td>Email</td><td><input type="text" name="email" value="<?php echo $val_data['email'] ?>"/></td>
</tr>
<tr>
<td>Mobile No</td><td><input type="text" name="phone" maxlength="10" value="<?php echo $val_data['mobile_no'] ?>" /></td>
</tr>
<tr>
<td>Address</td><td><textarea name="Address"><?php echo $val_data['address'] ?></textarea></td>
</tr>
<tr>
<td>Username</td><td><input type="text" name="Username" value="<?php echo $val_data['username'] ?>"  /></td>
</tr>
<tr>
<td>Password</td><td><input type="password" name="Password" value="<?php echo $val_data['password'] ?>"  /></td>
</tr>
<tr>
<td>ConformPassword</td><td><input type="password" Name="ConformPassword" value=""  /></td>
</tr>
<tr>
<td>Gender</td>
<td>male<input type="radio" name="gender" value="male" <?php if($val_data['gender']=='male'){ echo 'checked';}?> />
Female<input type="radio" name="gender" value="female" <?php if($val_data['gender']=='female'){ echo 'checked';}?> /></td>
</tr>
<tr>
<td>Hobby</td>
<td><input type="Checkbox" name="Hobby0" value="cricket" <?php if($val_data['playing_cricket']=='cricket'){echo 'checked';}  ?> >Playing cricket
<input type="Checkbox" Name="Hobby1" value="music" <?php if($val_data['listening_music']=='music'){echo 'checked';}  ?> >listening_music
</td>
</tr>
<tr>
<td>Qualification</td>
<td>
<select title="op" name="qualification">
<option value=''>select</option>
<option value='Engineering'<?php if($val_data['qualification']=='Engineering'){ echo "selected='selected'";}?>>Engineering </option>
<option value='BTech'<?php if($val_data['qualification']=='BTech'){ echo "selected='selected'";} ?>>BTech</option>
<option value='MCA'<?php if($val_data['qualification']=='MCA'){echo "selected='selected'";} ?>>MCA</option>
</select></td></tr>
<tr>
<td>Upload File</td>
<td><input type="file" Name="file"/><?php if($val_data['file'] !='') echo "<img src='uploaded_file/".$val_data['file']."'
height='50' width='100' />";?> </td>
</tr>
<tr>
<td>Upload Image</td>
<td><input type="file" Name="image"/><?php if($val_data['image'] !='') echo "<img src='uploaded_file/".$val_data['image']."'
height='50' width='100' />";?> </td>
</tr>
<tr>
<td><input type="submit" value="Submit" name="save" /></td>

<td><input type="reset" value="Reset"   /></td>

<th><?php if($_SESSION['Username'] ==''){ ?><input type="submit" name="Submit"  value="Login" /><?php } ?></th>

<td><?php if($_SESSION['Username'] !=''){ ?><input type="Submit" name="Logout" value="Logout" /><?php } ?></td>
</tr>
</table>
</form>
</body>
</html>