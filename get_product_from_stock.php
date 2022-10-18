<?php include 'inc_classes.php';

$product_id=$_POST['product_id'];
$type=$_POST['type'];
 $id=$_POST['id'];
if($product_id)
{
    $select_name="select product_id,quantity,size,unit,description,price,brand from product where product_id='".$product_id."' ";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	//echo $data_name['size']." ".$data_name['unit'];
	echo $data_name['quantity'];
	//echo "-".$data_name['price']."#".$data_name['brand']."#".$data_name['description'];
}
echo"###";
echo "<table width='100%'><tr><td><select name='type".$id."' id='type".$id."' style='width:100%'><option value=''>Select</option><option value='shelf'>Shelf</option><option value='consumable'>Consumable</option></select></td></tr></table>";