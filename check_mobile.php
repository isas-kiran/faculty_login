<?php 
include 'inc_classes.php';
$action=trim($_POST['action']);
if($action =="inquiry")
{
 	isset( $_POST['mobile1'] ) ? $mobile1 = $mobile1 = mysql_real_escape_string( $_POST['mobile1'] ) : $mobile1 = "";
	if($mobile1 == null)
	{
		echo "<b>Note-</b> Please Enter a Mobile No.";
	}
	else
	{
		//echo $username . " " ;
		$split = explode(' ',$mobile1);
		// echo count($split);
		if(count($split)>1)
		{
			?>
			<script> 
			document.getElementById('mobile1').style.border = '1px solid #f00';
			</script>
			<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Space Not Allowd.</div>";
		}
		else
		{
			$i_id=$_REQUEST['i_id'];
			$sql = "select inquiry_id from inquiry where mobile1 = '".$mobile1."' AND inquiry_id!='".$i_id."'";
			$rs = mysql_query( $sql );
			$num = mysql_num_rows($rs);
			if($num > 0)
			{
				while($row = mysql_fetch_array( $rs ))
				{
					$fn = $row['mobile1'];
					?>
					<script>document.getElementById('mobile1').style.border = '1px solid #f00';</script>
					<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken.</div>";
				}
			}
			else
			{
				$sql12= "select inquiry_id,mobile1 from inquiry where mobile2 ='".$mobile1."' AND inquiry_id!='".$i_id."'";
				$rs12= mysql_query( $sql12 );
				$num1 = mysql_num_rows($rs12);
				if($num1 > 0)
				{
					while($row1 = mysql_fetch_array( $rs12 ))
					{
						$fn = $row1['mobile1'];
						?>
						<script>document.getElementById('mobile2').style.border = '1px solid #f00';</script>
						<?php echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken as a alternate no. Please check with ".$row1['mobile1']." mobile no.</div>";
					}
				}
				else
				{
					?>
					<script> 
					document.getElementById('mobile1').style.border = '1px solid #0F0';
					</script>
					<?php
					echo "<span style='font-weight: bold;color: green;' id='user_mobile'>$mobile1</span> is available!";
				}
			}
		}
	}
}
else if($action =="inquiry_mobile2")
{
 	isset( $_POST['mobile1'] ) ? $mobile1 = $mobile1 = mysql_real_escape_string( $_POST['mobile1'] ) : $mobile1 = "";
	if($mobile1 == null)
	{
		echo "<b>Note-</b> Please Enter a Mobile No.";
	}
	else
	{
		//echo $username . " " ;
		$split = explode(' ',$mobile1);
		// echo count($split);
		if(count($split)>1)
		{
			?>
			<script> 
			document.getElementById('mobile2').style.border = '1px solid #f00';
			</script>
			<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Space Not Allowd.</div>";
		}
		else
		{
			$i_id=$_REQUEST['i_id'];
			$sql = "select inquiry_id from inquiry where mobile1 = '".$mobile1."' AND inquiry_id!='".$i_id."'";
			$rs = mysql_query( $sql );
			$num = mysql_num_rows($rs);
			if($num > 0)
			{
				while($row = mysql_fetch_array( $rs ))
				{
					$fn = $row['mobile1'];
					?>
					<script>document.getElementById('mobile2').style.border = '1px solid #f00';</script>
					<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken.</div>";
				}
			}
			else
			{
				$sql12= "select inquiry_id,mobile1 from inquiry where mobile2 ='".$mobile1."' AND inquiry_id!='".$i_id."'";
				$rs12= mysql_query( $sql12 );
				$num1 = mysql_num_rows($rs12);
				if($num1 > 0)
				{
					while($row1 = mysql_fetch_array( $rs12 ))
					{
						$fn = $row1['mobile1'];
						?>
						<script>document.getElementById('mobile2').style.border = '1px solid #f00';</script>
						<?php echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken as a alternate no. Please check with ".$row1['mobile1']." mobile no.</div>";
					}
				}
				else
				{
					?>
					<script> 
					document.getElementById('mobile2').style.border = '1px solid #0F0';
					</script>
					<?php
					echo "<span style='font-weight: bold;color: green;' id='user_mobile'>$mobile1</span> is available!";
				}
			}
		}
	}
}
else
{
	isset( $_POST['mobile1'] ) ? $mobile1 = $mobile1 = mysql_real_escape_string( $_POST['mobile1'] ) : $mobile1 = "";
	if($mobile1 == null)
	{
		echo "<b>Note-</b> Please Enter a Mobile No.";
	}
	else
	{
		//echo $username . " " ;
		$split = explode(' ',$mobile1);
		// echo count($split);
		if(count($split)>1)
		{
			 ?>
                <script> 
                document.getElementById('mobile1').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Space Not Allowd.</div>";
		}
		else
		{
			$sql = "select enroll_id from enrollment where contact='".$mobile1."'";
			$rs = mysql_query( $sql );
			if($num = mysql_num_rows( $rs ))
			{
				/*while($row = mysql_fetch_array( $rs )){*/
				$fn = $row['mobile1'];
				?>
                <script> 
                document.getElementById('mobile1').style.border = '1px solid #f00';
				</script>
                <? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken in Enrollment.</div>";
				//}
			}
			else
			{
				$sql = "select inquiry_id from inquiry where mobile1 = '".$mobile1."'";
				$rs = mysql_query( $sql );
				if($num = mysql_num_rows($rs))
				{
					while($row = mysql_fetch_array( $rs ))
					{
						$fn = $row['mobile1'];
					?>
					<script>document.getElementById('mobile1').style.border = '1px solid #f00';</script>
					<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Mobile No already taken in Enquiry Form. Please enroll through enquiry .</div>";
					}
				}
				else
				{
					?>
					<script> 
					document.getElementById('mobile1').style.border = '1px solid #0F0';
					</script>
					<?
					echo "<span style='font-weight: bold;color: green;' id='user_mobile'>".$mobile1."</span> is available!";
				}
			}
		}
	}
}
		?>		  