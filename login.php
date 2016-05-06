<?php
session_start();
$host     = "localhost";
$dbname   = "schw3177";
$username = "schw3177"; 
$password = "secret";

$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


if(isset($_SESSION['username'])){
	header("Location: index.php");
}

if (isset($_POST['loginCheck'])){
	
	$sql = "SELECT *
			FROM bookUser
			WHERE username = :username
			AND password = :password";
			
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":username"=>$_POST['username'],
							":password"=>$_POST['password']));
	$record = $stmt->fetch();
	
	if (empty ($record)){
		echo "Wrong username or password";
	}
	else{ // if login is successful, record username, name, user id, and log time
		header("Location: index.php");// sends user to index.php
	
		$_SESSION['username'] = $record['username'];
		$_SESSION['name'] = $record['firstName'] . " " . $record['lastName'];
		$_SESSION['userId'] = $record['userId'];
		
		 $date = date('Y/m/d H:i:s');
		$_SESSION['loginLog'] = $date;// record the current time for use in log keeping
		
		// logging user log in happens here
		$sql = "INSERT INTO bookLog (userId, logTime)
				VALUES (:userId, :logTime)";
			
	 	$stmt = $dbConn -> prepare($sql);
   		$stmt -> execute(array(":userId"=>$_SESSION['userId'],
   								":logTime"=>$_SESSION['loginLog']
								));
								
		
		
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

  <title>Login</title>
  <meta name="description" content="">
  <meta name="author" content="jazzb_000">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <div id="main">
  	
  	<h2>Login</h2>
  	
  	<form method="post">
  		Username: <input type="text" name="username" /> <br>
  		Password: <input type="password" name="password" /> <br>
  		<input class="button" type="submit" name="loginCheck" value="Login" />
  	</form>
  	<br />
  	<br />
  	Test username: test <br />
  	Test password: test<br />
  	
  </div>
</body>
</html>
