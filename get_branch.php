<?php include 'inc_classes.php';?>
<?php
	
	$user_type=$_POST['user_type'];
	
	$result = array();
	  if($_POST['user_type'] !='')
		  {
			  	$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
				$query_branch = mysql_query($sel_branch);
				$total_Branch = mysql_num_rows($query_branch);
				echo '<table width="100%"><tr><td width="35%">';
				echo 'Select branch</td><td>';
				echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
				while($row_branch = mysql_fetch_array($query_branch))
					{
						?>
						<option value="<? if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <? echo $row_branch['branch_name']; ?> 
                        </option>
						<?
					
					}
					echo '</select>';
					echo "</td></tr></table>";
				
				
          
        }
            ?>
               