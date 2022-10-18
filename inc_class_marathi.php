<?php session_start();
	include("../include/config.php");
	include("../classes/Database.class.php");
	function __autoload($className)
	{
		require_once("../classes/{$className}.php");
	}
    //make db connection for all files
    $db = new Database();
    $db->connect();
?>