<?php 
 include 'inc_classes.php';
 
 isset( $_POST['mail'] ) ? $mail = $mail = mysql_real_escape_string( $_POST['mail'] ) : $mail = "";
	if($mail == null){
		echo "<b>Note-</b> Please Enter Email ID.";
	}else{
		//echo $username . " " ;
		 $split = explode(' ',$mail);
		// echo count($split);
		 if(count($split)>1)
		 {
			 ?>
                <script> 
                document.getElementById('mobile1').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;' id='user_email'>Space Not Allowd.</div>";
		 }
		else
		{
		$sql = "select enroll_id from enrollment where mail = '$mail'";
		$rs = mysql_query( $sql );
		if($num = mysql_num_rows( $rs ))
		{
			/*while($row = mysql_fetch_array( $rs )){*/
				//$fn = $row['mail'];
				?>
                <script> 
                document.getElementById('mail').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;' id='user_email'>Email already taken.</div>";
			//}
		}else
		{
			?>
                <script> 
                document.getElementById('mail').style.border = '1px solid #0F0';
				</script>
            <?
				echo "<span style='font-weight: bold;color: green;' id='user_email'>$mail</span> is available!";
		}
		}
	}
		?>		  