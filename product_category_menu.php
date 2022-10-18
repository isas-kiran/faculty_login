 <?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
    if($_SESSION['type'] =='S')
   {
	   ?>
       <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_product_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_product_category.php" style="color:#7CA32F;">Manage product category</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_product_category.php" style="color:#666666;">Manage product category</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_product_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_product_category.php" style="color:#7CA32F;">Add product category</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_product_category.php" style="color:#666666;"> Add product category</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_brand.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_brand.php" style="color:#7CA32F;">Manage Brand</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_brand.php" style="color:#666666;">Manage Brand</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
  	if($page_name == 'add_brand..php')
    {
		?>
		<tr>
			<td class="tab2_left"></td>
			<td class="tab2_mid"><a href="add_brand.php" style="color:#7CA32F;">Add Brand</a></td>
			<td class="tab2_right"></td>
		</tr>
		<?php
		}
		else
		{
		?>
		<tr>
			<td class="tab_left"></td>
			<td class="tab_mid"><a href="add_brand.php" style="color:#666666;">Add Brand</a></td>
			<td class="tab_right"></td>
		</tr>
		<?php
	}
	?>
</table>
	</td>
        
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_product.php" style="color:#7CA32F;">Manage product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_product.php" style="color:#666666;">Manage product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_product.php" style="color:#7CA32F;">Add Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_product.php" style="color:#666666;">Add Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

  
  <td class="width5"></td>  
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_checkout.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_checkout.php" style="color:#7CA32F;">Manage Checkout</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_checkout.php" style="color:#666666;">Manage Checkout</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_checkout.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_checkout.php" style="color:#7CA32F;">Add checkout</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_checkout.php" style="color:#666666;">Add checkout</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_inventory.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_inventory.php" style="color:#7CA32F;">Manage Purchase</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_inventory.php" style="color:#666666;">Manage Purchase</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_inventory.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_inventory.php" style="color:#7CA32F;">Purchase</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_inventory.php" style="color:#666666;">Purchase</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_sales_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sales_product.php" style="color:#7CA32F;">Mangae Sales Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sales_product.php" style="color:#666666;">Mangae Sales Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'sales_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="sales_product.php" style="color:#7CA32F;">Sales Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="sales_product.php" style="color:#666666;">Sales Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>



<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'manage_vendor.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_vendor.php" style="color:#7CA32F;">Manage Vendor</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_vendor.php" style="color:#666666;">Manage Vendor</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'add_vendor.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_vendor.php" style="color:#7CA32F;">Add Vendor</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_vendor.php" style="color:#666666;">Add Vendor</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'consumption_qty.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="consumption_qty.php" style="color:#7CA32F;">Add Consumption</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="consumption_qty.php" style="color:#666666;">Add Consumption</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'manage_inword.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_inword.php" style="color:#7CA32F;">Manage Inword</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_inword.php" style="color:#666666;">Manage Inword</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'product_inword.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="product_inword.php" style="color:#7CA32F;">Add Inword</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="product_inword.php" style="color:#666666;">Add Inword</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'import_products.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_products.php" style="color:#7CA32F;">Import Products</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_products.php" style="color:#666666;">Import Products</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'dsr_product_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="dsr_product_report.php" style="color:#7CA32F;">DSR Product Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="dsr_product_report.php" style="color:#666666;">DSR Product Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
	</table>
</td>
       <?php
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==19) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==129)
				{
			?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_product_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_product_category.php" style="color:#7CA32F;">Manage product category</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_product_category.php" style="color:#666666;">Manage product category</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
        </table>
        </td>
        <td class="width5"></td>
        <?php 
}
else if($array_prev[$e][$f]['privilege_id']==130)
{
?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
    if($page_name == 'add_product_category.php')
    {
    	?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="add_product_category.php" style="color:#7CA32F;">Add product category</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="add_product_category.php" style="color:#666666;"> Add product category</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
	}
	?>
	</table>
	</td>
	<td class="width5"></td>
	<?php 
}
else if($array_prev[$e][$f]['privilege_id']==291)
{
?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
    if($page_name == 'manage_brand.php')
    {
    	?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="manage_brand.php" style="color:#7CA32F;">Manage Brand</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="manage_brand.php" style="color:#666666;">Manage Brand</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
	}
	?>
	</table>
	</td>
	<td class="width5"></td>
	<?php 
}
else if($array_prev[$e][$f]['privilege_id']==290)
{
?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
    <?php
    if($page_name == 'add_brand.php')
    {
    	?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="add_brand.php" style="color:#7CA32F;">Add Brand</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="add_brand.php" style="color:#666666;">Add Brand</a></td>
            <td class="tab_right"></td>
        </tr>
        <?php
	}
	?>
	</table>
	</td>
	<td class="width5"></td>
	<?php 
}
else if($array_prev[$e][$f]['privilege_id']==131)
{
?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_product.php" style="color:#7CA32F;">Manage product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_product.php" style="color:#666666;">Manage product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==132)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_product.php" style="color:#7CA32F;">Add Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_product.php" style="color:#666666;">Add Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

  
  <td class="width5"></td>  
  <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==133)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_checkout.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_checkout.php" style="color:#7CA32F;">Manage Checkout</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_checkout.php" style="color:#666666;">Manage Checkout</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<?php 
	}
	else if($array_prev[$e][$f]['privilege_id']==134)
	{
	?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_checkout.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_checkout.php" style="color:#7CA32F;">Add checkout</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_checkout.php" style="color:#666666;">Add checkout</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
 <?php 
	}
	else if($array_prev[$e][$f]['privilege_id']==135)
	{
	?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_inventory.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_inventory.php" style="color:#7CA32F;">Manage Purchase</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_inventory.php" style="color:#666666;">Manage Purchase</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
 <?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==136)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_inventory.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_inventory.php" style="color:#7CA32F;">Purchase</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_inventory.php" style="color:#666666;">Purchase</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
<?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==137)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_sales_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_sales_product.php" style="color:#7CA32F;">Mangae Sales Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_sales_product.php" style="color:#666666;">Mangae Sales Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>

<td class="width5"></td>
<?php 
					}
					else if($array_prev[$e][$f]['privilege_id']==138)
					{
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'sales_product.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="sales_product.php" style="color:#7CA32F;">Sales Product</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="sales_product.php" style="color:#666666;">Sales Product</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>



<td class="width5"></td>
<?php
					}
					else if($array_prev[$e][$f]['privilege_id']=='139')
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'manage_vendor.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_vendor.php" style="color:#7CA32F;">Manage Vendor</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_vendor.php" style="color:#666666;">Manage Vendor</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
					}
					else if($array_prev[$e][$f]['privilege_id']=='140')
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'add_vendor.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_vendor.php" style="color:#7CA32F;">Add Vendor</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_vendor.php" style="color:#666666;">Add Vendor</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']=='175')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'consumption_qty.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="consumption_qty.php" style="color:#7CA32F;">Add Consumption</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="consumption_qty.php" style="color:#666666;">Add Consumption</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']=='249')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'manage_inword.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_inword.php" style="color:#7CA32F;">Manage Inword</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_inword.php" style="color:#666666;">Manage Inword</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']=='250')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'product_inword.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="product_inword.php" style="color:#7CA32F;">Add Inword</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="product_inword.php" style="color:#666666;">Add Inword</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']=='141')
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'import_products.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_products.php" style="color:#7CA32F;">Import Products</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_products.php" style="color:#666666;">Import Products</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<?php
}
else if($array_prev[$e][$f]['privilege_id']=='288')
{
	?>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
       <?php 
            if($page_name == 'dsr_product_report.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="dsr_product_report.php" style="color:#7CA32F;">DSR Product Report</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="dsr_product_report.php" style="color:#666666;">DSR Product Report</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>         
</table>
</td>
<?php
}
					

			}
		}
	}
}
					?>
  </tr>
</table>