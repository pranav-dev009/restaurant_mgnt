<?php
session_start();
// $_root_path = realpath( dirname(__FILE__).'/..' );
// echo $_root_path;
$errorMessage = "";
$itemInfo = "";
$path = "http://".$_SERVER['SERVER_NAME']."/pranavkolharkar";

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url,'backend') !== false) {
    require_once ("../database_connection/database_operations.php");
} 
else {
    require_once ("database_connection/database_operations.php");
}
?>
