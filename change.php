<?php
require"connect.php";

if(isset($_POST['newPass'])){
	global $dbConn;
	
	$sql = "SELECT userId, password
			FROM bookUser
			Where username = :username
			AND password = :password";
			
	$stmt = $dbConn ->prepare($sql);
	$stmt -> execute(array(":username"=>$_SESSION['username'],
							":password"=>$_POST['oldPass']));
	$record = $stmt->fetch();
	
	if(empty($record)){
		echo "Incorrect password, try again.";
	}
	else{
		$sql = "UPDATE bookUser
				SET password = :password
				WHERE username = :username";
		$stmt -> execute(array(":password"=>$_POST['newPass'],
								":username"=>$_SESSION['username']));
		
		header("Location: logout.php");
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Change Password</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
</head>

<body>
  <div>
  		
  		<form method="post">
  			Enter old password:
  			<input type="password" name="oldPass"/> <br />
  			Enter new password:
  			<input type="password" name="newPass"/> <br />
  			<input type="submit" value="Submit"/>
  		</form>
  </div>
</body>
</html>
