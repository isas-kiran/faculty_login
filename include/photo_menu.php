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
            if($page_name == 'manage_photo.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_photo.php" style="color:#7CA32F;">Manage Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_photo.php" style="color:#666666;">Manage Photo Gallery </a></td>
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
  if($page_name == 'add_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_gallery.php" style="color:#7CA32F;">Add Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_gallery.php" style="color:#666666;">Add Photo Gallery </a></td>
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
            if($page_name == 'add-images-in-gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add-images-in-gallery.php" style="color:#7CA32F;"> Add Images to Gallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-images-in-gallery.php" style="color:#666666;">Add Images to Gallery </a></td>
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
            if($page_name == 'manage_vedio_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_vedio_gallery.php" style="color:#7CA32F;">Manage Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="manage_vedio_gallery.php" style="color:#666666;">Manage Video Gallery </a></td>
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
  if($page_name == 'add_vedio_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_vedio_gallery.php" style="color:#7CA32F;">Add Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_vedio_gallery.php" style="color:#666666;">Add Video Gallery </a></td>
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
            if($page_name == 'add-videos-in-gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add-videos-in-gallery.php" style="color:#7CA32F;"> Add Video to Gallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-videos-in-gallery.php" style="color:#666666;">Add Video to Gallery </a></td>
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
        if($array_previ_parent[$e]['privilege_id']==6) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==54)
				{
			?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_photo.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_photo.php" style="color:#7CA32F;">Manage Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_photo.php" style="color:#666666;">Manage Photo Gallery </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==55)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_gallery.php" style="color:#7CA32F;">Add Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_gallery.php" style="color:#666666;">Add Photo Gallery </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==56)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add-images-in-gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add-images-in-gallery.php" style="color:#7CA32F;"> Add Images to Gallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-images-in-gallery.php" style="color:#666666;">Add Images to Gallery </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==57)
				{
				?>
 <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_vedio_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_vedio_gallery.php" style="color:#7CA32F;">Manage Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="manage_vedio_gallery.php" style="color:#666666;">Manage Video Gallery </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==58)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_vedio_gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_vedio_gallery.php" style="color:#7CA32F;">Add Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_vedio_gallery.php" style="color:#666666;">Add Video Gallery </a></td>
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
				else if($array_prev[$e][$f]['privilege_id']==59)
				{
				?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'add-videos-in-gallery.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add-videos-in-gallery.php" style="color:#7CA32F;"> Add Video</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-videos-in-gallery.php" style="color:#666666;">Add Video</a></td>
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