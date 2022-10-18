<?php

include 'inc_classes.php';

$pcategory_id=$_POST['pcategory_id'];

   
	
	echo '<table style="width: 90%"><tr>
	        <td width="25%">Product Sub Category :</td>';
			
	    echo '<td width="70%">';
		
		echo '<select name="sub_id" style="width:200px;" >
                  <option value="0">Select Category</option>';
						 
						    $sql_dest = " select sub_name, sub_id from subcategory where pcategory_id='".$pcategory_id."' order by sub_id asc";
                            $ptr_edes = mysql_query($sql_dest);
                            while($data_dist = mysql_fetch_array($ptr_edes))
                            { 
							  $sql_dest1 = " select * from product where pcategory_id='".$pcategory_id."' ";
                              $ptr_edes1= mysql_query($sql_dest1);
							  $fetch_prodct=mysql_fetch_array($ptr_edes1);
							
                                    $selecteds = '';
                                    if($data_dist['sub_id']==$fetch_prodct['sub_id'])
                                    $selecteds = 'selected="selected"';	
                                       
                                echo "<option value='".$data_dist['sub_id']."' ".$selecteds.">".$data_dist['sub_name']."</option>";
                            }
		echo '</select>
             </td></tr></table>';

?>