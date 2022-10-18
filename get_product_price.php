<?php include 'inc_classes.php';?>
<?php
	
	$sales_product_ids=$_POST['sales_product_ids'];
	 //$quantity=$_POST['quantity'];
	
	if($sales_product_ids=='')
	    {
		echo "Please select product...!!!";
		}
	else
	    {	
			$result = array();
			if($sales_product_ids !='')
			{
				/************************************************/
				$result_seprated =explode(',',$sales_product_ids);
				$quantity_separated=explode(',',$quantity);
				// echo count($result_seprated);
				//$concat = ' and  (';
				for($i=0;$i<count($result_seprated);$i++)
				{
					
					 $sel_tel = "select product_id,product_name,price,quantity from product where product_id='".$result_seprated[$i]."'";	 
					 $query_tel = mysql_query($sel_tel);
					 $data_srvice = mysql_fetch_array($query_tel);
					 $price +=trim($data_srvice['price']);
					 
					// echo $data_srvice['quantity'];
				}
				echo $price;
				
			}
	
		}
?>	
