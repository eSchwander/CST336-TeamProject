<?php

if(isset($_POST['username'])){
		
	require'../../db_connection.php';
	
	$sql = "SELECT username, password
			FROM bookUser
			WHERE username = :username
			AND password = :password";
			
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":username" => $_POST['username'],
							":password" => $_POST['password']));
	$record = $stmt->fetch();
	
	$output = array();
	
	if(empty($record)){
		//echo "{\"exists\":\"true\"}";
		//echo "Username is available.";
		$output["exists"] = "flase"; //this is the method to use
	}
	else{
		//echo "{\"exists\":\"true\"}";
		//echo "Username is already taken.";
		$output["exists"] = "true"; //use this method
	}
	
	echo json_encode($output);
	
}
?>