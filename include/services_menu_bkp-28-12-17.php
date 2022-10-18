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
            if($page_name == 'manage_cust_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_cust_services.php" style="color:#7CA32F;">Manage Cust Service</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_cust_services.php" style="color:#666666;">Manage Cust Service</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
			
</table>
</td>
<!--<td class="width5"></td>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            /*if($page_name == 'add_cust_services.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_cust_services.php" style="color:#7CA32F;">Add Cust Service</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_cust_services.php" style="color:#666666;">Add Cust Service</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}            
            ?>  
</table>
</td>-->
<td class="width5"></td>
<td>
<table border="0" cellspacing="0" cellpadding="0">
        <?php
        if($page_name == 'book_service.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="book_service.php" style="color:#7CA32F;">Book services</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="book_service.php" style="color:#666666;">Book Services</a></td>
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
            if($page_name == 'manage_services_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_services_category.php" style="color:#7CA32F;">Manage Service Cat.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_services_category.php" style="color:#666666;">Manage Service Cat.</a></td>
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
            if($page_name == 'add_service_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_service_category.php" style="color:#7CA32F;">Add Category</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_service_category.php" style="color:#666666;">Add Category</a></td>
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
            if($page_name == 'manage_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_services.php" style="color:#7CA32F;">Manage Services </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_services.php" style="color:#666666;">Manage Services </a></td>
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
            if($page_name == 'add_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_services.php" style="color:#7CA32F;">Add Services </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_services.php" style="color:#666666;">Add Services </a></td>
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
            if($page_name == 'manage_customer.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_customer.php" style="color:#7CA32F;">Manage Cust</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_customer.php" style="color:#666666;">Manage Cust</a></td>
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
            if($page_name == 'add_customer.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_customer.php" style="color:#7CA32F;">Add Cust</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_customer.php" style="color:#666666;">Add Cust</a></td>
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
            if($page_name == 'manage_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_membership.php" style="color:#7CA32F;">Manage Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_membership.php" style="color:#666666;">Manage Memb</a></td>
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
            if($page_name == 'add_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_membership.php" style="color:#7CA32F;">Add Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_membership.php" style="color:#666666;">Add Memb</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    <td class="width5"></td><td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_customer_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_customer_membership.php" style="color:#7CA32F;">Add Cust Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_customer_membership.php" style="color:#666666;">Add Cust Memb</a></td>
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
            if($page_name =='manage_package.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_package.php" style="color:#7CA32F;">Manage Package</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_package.php" style="color:#666666;">Manage Package</a></td>
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
  if($page_name == 'add_package.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_package.php" style="color:#7CA32F;">Add Package</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_package.php" style="color:#666666;">Add Package </a></td>
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
            if($page_name == 'add_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_voucher.php" style="color:#7CA32F;">Add Voucher</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_voucher.php" style="color:#666666;">Add Voucher</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
 <td class="width5"></td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_memb_package_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_memb_package_voucher.php" style="color:#7CA32F;">Manage Vou./Pack./Memb.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_memb_package_voucher.php" style="color:#666666;">Manage Vou./Pack./Memb.</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
    <td class="width5"></td>
    <td class="width5"></td>
<td class="width5"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'sale_memb_package_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="sale_memb_package_voucher.php" style="color:#7CA32F;">Sale Voucher/Package/Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="sale_memb_package_voucher.php" style="color:#666666;">Sale Voucher/Package/Memb</a></td>
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
           	if($page_name == 'import_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_services.php" style="color:#7CA32F;">Import Services</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_services.php" style="color:#666666;">Import Services</a></td>
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
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==18) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==111)
				{
			?>
   <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_cust_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_cust_services.php" style="color:#7CA32F;">Manage Cust Service</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_cust_services.php" style="color:#666666;">Manage Cust Service</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }            
            ?>  
</table>
</td>
<td class="width5"></td>
<!--<?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==112)
					{
					*/
					?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            /*if($page_name == 'add_cust_services.php')
            {*/
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_cust_services.php" style="color:#7CA32F;">Add Cust Service</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            /*}
            else
            {*/
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_cust_services.php" style="color:#666666;">Add Cust Service</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
          //  }            
            ?>  
</table>
</td>
<td class="width5"></td>-->
<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==112)
					{
					
					?>
<td>
<table border="0" cellspacing="0" cellpadding="0">
        <?php
        if($page_name == 'book_service.php')
        {
        ?>
        <tr>
            <td class="tab2_left"></td>
            <td class="tab2_mid"><a href="book_service.php" style="color:#7CA32F;">Book services</a></td>
            <td class="tab2_right"></td>
        </tr>
        <?php
        }
        else
        {
        ?>
        <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="book_service.php" style="color:#666666;">Book Services</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==113)
					{
					
					?>
  <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_services_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_services_category.php" style="color:#7CA32F;">Manage Service Cat.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_services_category.php" style="color:#666666;">Manage Service Cat.</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==114)
					{
					
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_service_category.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_service_category.php" style="color:#7CA32F;">Add Category</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_service_category.php" style="color:#666666;">Add Category</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==115)
					{
					
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_services.php" style="color:#7CA32F;">Manage Services </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_services.php" style="color:#666666;">Manage Services </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==116)
					{
					
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_services.php" style="color:#7CA32F;">Add Services </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_services.php" style="color:#666666;">Add Services </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==117)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_customer.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_customer.php" style="color:#7CA32F;">Manage Cust</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_customer.php" style="color:#666666;">Manage Cust</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==118)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_customer.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_customer.php" style="color:#7CA32F;">Add Cust</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_customer.php" style="color:#666666;">Add Cust</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==119)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'manage_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_membership.php" style="color:#7CA32F;">Manage Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_membership.php" style="color:#666666;">Manage Memb</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==120)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_membership.php" style="color:#7CA32F;">Add Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_membership.php" style="color:#666666;">Add Memb</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
        </table>
	</td>
    <!--<td class="width5"></td>
     <?php
					/*}
					else if($array_prev[$e][$f]['privilege_id']==121)
					{*/
					
					?>
     
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
           // if($page_name == 'manage_customer_membership.php')
            //{
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_customer_membership.php" style="color:#7CA32F;">Manage Cust Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            //}
            //else
            //{
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_customer_membership.php" style="color:#666666;">Manage Cust Memb</a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            //}
            ?>
        </table>
	</td>-->
    <td class="width5"></td>
      <?php
		}
		else if($array_prev[$e][$f]['privilege_id']==122)
		{
		
		?>       
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
            if($page_name == 'add_customer_membership.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_customer_membership.php" style="color:#7CA32F;">Add Cust Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_customer_membership.php" style="color:#666666;">Add Cust Memb</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==123)
					{
					
					?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_package.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_package.php" style="color:#7CA32F;">Manage Package</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_package.php" style="color:#666666;">Manage Package</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==124)
					{
					
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_package.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_package.php" style="color:#7CA32F;">Add Package</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_package.php" style="color:#666666;">Add Package </a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==125)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_voucher.php" style="color:#7CA32F;">Add Voucher</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_voucher.php" style="color:#666666;">Add Voucher</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==126)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_memb_package_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_memb_package_voucher.php" style="color:#7CA32F;">Manage Vou./Pack./Memb.</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_memb_package_voucher.php" style="color:#666666;">Manage Vou./Pack./Memb.</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==127)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'sale_memb_package_voucher.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="sale_memb_package_voucher.php" style="color:#7CA32F;">Sale Voucher/Package/Memb</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="sale_memb_package_voucher.php" style="color:#666666;">Sale Voucher/Package/Memb</a></td>
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
					else if($array_prev[$e][$f]['privilege_id']==128)
					{
					
					?>
<td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
           	if($page_name == 'import_services.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="import_services.php" style="color:#7CA32F;">Import Services</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="import_services.php" style="color:#666666;">Import Services</a></td>
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
			}
		}
	}
   }
					?>
    
  </tr>
</table>