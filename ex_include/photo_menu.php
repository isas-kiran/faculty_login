<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name == 'manage_photo.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_photo.php" style="color:white;">Manage Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_photo.php" style="color:white;">Manage Photo Gallery </a></td>
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
                <td class="tab2_mid"><a href="add_gallery.php" style="color:white;">Add Photo Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_gallery.php" style="color:white;">Add Photo Gallery </a></td>
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
                <td class="tab2_mid"><a href="add-images-in-gallery.php" style="color:white;"> Add Images to Gallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-images-in-gallery.php" style="color:white;">Add Images to Gallery </a></td>
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
                <td class="tab2_mid"><a href="manage_vedio_gallery.php" style="color:white;">Manage Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
            <td class="tab_left"></td>
            <td class="tab_mid"><a href="manage_vedio_gallery.php" style="color:white;">Manage Video Gallery </a></td>
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
                <td class="tab2_mid"><a href="add_vedio_gallery.php" style="color:white;">Add Video Gallery </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_vedio_gallery.php" style="color:white;">Add Video Gallery </a></td>
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
                <td class="tab2_mid"><a href="add-videos-in-gallery.php" style="color:white;"> Add Video to Gallery</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add-videos-in-gallery.php" style="color:white;">Add Video to Gallery </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
  
</table>
</td>
<td class="width5"></td>
  </tr>
</table>