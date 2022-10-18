<?php 
 include 'inc_classes.php';
 
 isset( $_POST['discount_coupon'] ) ? $discount_coupon = $discount_coupon = mysql_real_escape_string( $_POST['discount_coupon'] ) : $discount_coupon = "";
	if($discount_coupon == null){
		echo "<b>Note-</b> Please enter a Discount Coupon Code, If available.";
	}elseif(strlen( $discount_coupon ) < 2){
		echo " Discount Coupon is too short.";
	}
	 
	else{
		//echo $username . " " ;
		 $split = explode(' ',$discount_coupon);
		// echo count($split);
		 if(count($split)>1)
		 {
			 ?>
                <script> 
                document.getElementById('discount_coupon').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;'>Space Not Allowd.</div>";
		 }
		 elseif(!preg_match('/^([a-zA-Z0-9])+$/iD',$discount_coupon))
		{
		  ?>
                <script> 
                document.getElementById('discount_coupon').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;'>Special Characters Or Symbol Not Allowd.</div>";
		}
		else
		{
		$sql = "select * from discount_coupon where code = '$discount_coupon'";
		$rs = mysql_query( $sql );
		$num = mysql_num_rows( $rs );
		if($num == 1 ){
			while($row = mysql_fetch_array( $rs )){
				$fn = $row['name'];
				?>
                <script> 
                document.getElementById('discount_coupon').style.border = '1px solid #0F0';
				</script>
                <? echo "<div style='color: green; font-weight: bold;'>$discount_coupon is available.</div>";
			}
		}else{
			?>
                <script> 
                document.getElementById('discount_coupon').style.border = '1px solid #f00';
				</script>
            <?
				echo "<span style='font-weight: bold;color: red;'>$discount_coupon</span> is not available!";
		}
		}
	}
		?>		  