<?php 
    include 'inc_classes.php';
 
    $action = $_POST['action'];
    if($action=='mark_read')
    {	  
        $update_notifications="update ".$GLOBALS["pre_db"]."notifications set is_read='Yes' where added_for='".$_SESSION['admin_id']."'";
        $db->query($update_notifications); 
    }
?>		  