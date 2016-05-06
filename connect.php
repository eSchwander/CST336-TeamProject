<?php
$host     = "localhost";
$dbname   = "schw3177";
$username = "schw3177"; 
$password = "secret";

$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

session_start();

if(!isset($_SESSION['username'])){
	header("Location: login.php");
}

?>