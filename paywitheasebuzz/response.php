<?php
    include_once 'easepay-lib.php';
    $SALT='UO41S1OKXF';
    $result = response( $_POST, $SALT );
    print_r($result);
    print_r($_POST);
    

?>
