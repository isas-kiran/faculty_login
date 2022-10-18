<?php 
 include 'inc_classes.php';

 isset( $_POST['user'] ) ? $user = $user = mysql_real_escape_string( $_POST['user'] ) : $user = "";
	if($user == null){
		echo "<b>Note-</b> Please enter a username.";
	}elseif(strlen( $user ) < 5){
		echo " Username is too short.";
	}
	 
	else{
		//echo $username . " " ;
		 $split = explode(' ',$user);
		// echo count($split);
		 if(count($split)>1)
		 {
			 ?>
                <script> 
                document.getElementById('user').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;'>Space Not Allowd.</div>";
		 }
		elseif(!preg_match('/^([a-z0-9])+$/iD',$user))
		{
		  ?>
                <script> 
                document.getElementById('user').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;'>Special Characters Or Symbol Not Allowd.</div>";
		}
		else
		{
		$sql = "select * from enrollment where username = '$user'";
					
		$rs = mysql_query( $sql );
		$num = mysql_num_rows( $rs );
		if($num == 1 ){
			while($row = mysql_fetch_array( $rs )){
				$fn = $row['name'];
				?>
                <script> 
                document.getElementById('user').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;'>Username already taken.</div>";
			}
		}else{
			?>
                <script> 
                document.getElementById('user').style.border = '1px solid #0F0';
				</script>
            <?
				echo "<span style='font-weight: bold;color: green;'>$user</span> is available!";
		}
		}
	}
		?>		  