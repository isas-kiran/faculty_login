<?php 
include 'inc_classes.php';
$action=trim($_POST['action']);
if($action =="campaign_code")
{
 	isset( $_POST['codes'] ) ? $codes = $codes = mysql_real_escape_string( $_POST['codes'] ) : $codes = "";
	if($codes == null)
	{
		echo "<b>Note-</b> Please Enter Campaign Code.";
	}
	else
	{
		//echo $username . " " ;
		$split = explode(' ',$codes);
		// echo count($split);
		if(count($split)>1)
		{
			?>
			<script> 
			document.getElementById('camp_code').style.border = '1px solid #f00';
			</script>
			<? echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Space Not Allowd.</div>";
		}
		else
		{
			$sql = "select campaign_id from campaign where c_id = '".$codes."'";
			$rs = mysql_query( $sql );
			if($num = mysql_num_rows($rs))
			{
				while($row = mysql_fetch_array( $rs ))
				{
					$fn = $row['campaign_id'];
				?>
                <script>document.getElementById('camp_code').style.border = '1px solid #f00';</script>
				<?php echo "<div style='color: red; font-weight: bold;' id='user_mobile'>Campaign Code already taken.</div>";
				}
			}
			else
			{
				?>
                <script> 
                document.getElementById('camp_code').style.border = '1px solid #0F0';
				</script>
            	<?php
				echo "<span style='font-weight: bold;color: green;' id='user_mobile'>$codes</span> is available!";
			}
		}
	}
}

		?>		  