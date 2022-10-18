<?php 
 include 'inc_classes.php';
 
 isset( $_POST['username'] ) ? $username = $username = mysql_real_escape_string( $_POST['username'] ) : $username = "";
	if($username == null){
		echo "<b>Note-</b><div style='color: red; font-weight: bold;' id='user_text'> Please enter a username.</div>";
	}else{
		//echo $username . " " ;
		 $split = explode(' ',$username);
		// echo count($split);
		 if(count($split)>1)
		 {
			 ?>
                <script> 
                document.getElementById('username').style.border = '1px solid #f00';
				</script>
                <?php echo "<div style='color: red; font-weight: bold;' id='user_text'>Space Not Allowd.</div>";
		 }
		elseif(!preg_match('/^([a-z0-9])+$/iD',$username))
		{
		  ?>
                <script> 
                document.getElementById('username').style.border = '1px solid #f00';
				</script>
                <?php echo "<div style='color: red; font-weight: bold;' id='user_text'>Special Characters Or Symbol Not Allowd.</div>";
		}
		else
		{
		$sql = "select * from enrollment where username = '$username'";
					
		$rs = mysql_query( $sql );
		$num = mysql_num_rows( $rs );
		if($num == 1 ){
			while($row = mysql_fetch_array( $rs )){
				$fn = $row['name'];
				?>
                <script> 
                document.getElementById('username').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;' id='user_text'>Username already taken.</div>";
			}
		}else{
			?>
                <script> 
                document.getElementById('username').style.border = '1px solid #0F0';
				</script>
            <?
				echo "<span style='font-weight: bold;color: green;' id='user_text'>$username</span> is available!";
		}
		}
	}
		?>		  