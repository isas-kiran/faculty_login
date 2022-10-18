<?php include 'inc_classes.php';

$product_id = $_POST['product_id'];
$type=$_POST['type'];
$id=$_POST['id'];

if($product_id)
{
	$quantitiy="*";
	if($type=="shelf")
	{
		$quantitiy="quantity_in_shelf";
	}
	else if($type=="consumable")
	{
		$quantitiy="quantity_in_consumable";
	}
    $select_name="select ".$quantitiy." as quantities from product where product_id='".$product_id."'";
	$ptr_query=mysql_query($select_name);
	$data_name=mysql_fetch_array($ptr_query);
	echo $data_name['quantities'];
	//echo "-".$data_name['price']."#".$data_name['brand']."#".$data_name['description'];
}
echo"###";
if($type=="shelf")
{
echo "<table width='100%'><tr><td><select name='type".$id."' id='select_to".$id."' ><option value=''>Select</option><option value='stock'>Stock</option><option value='consumable'>Consumable</option></select></td></tr></table>";
}
else if($type=="consumable")
{
echo"<table width='100%'><tr><td><select name='type".$id."' id='select_to".$id."'><option value=''>Select</option><option value='shelf'>Shelf</option><option value='stock'>Stock</option></select></td></tr></table>";
}