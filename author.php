<?php
require 'connect.php';

function getAuthor($authorId){
	global $dbConn;
	
	$sql = "SELECT firstName, lastName, dob
			FROM authors	
			WHERE authorId = :authorId";
			
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":authorId"=>$authorId));
	return $stmt->fetch();     
}

function booksWriten($authorId){
	global $dbConn;
	
	$sql = "SELECT title
			FROM books
			WHERE authorId = :authorId";
	
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":authorId"=>$authorId));
	return $stmt->fetchAll();   
}

function bookCount($authorId){
	global $dbConn;
	
	$sql = "SELECT COUNT(title)
			FROM books
			WHERE authorId = :authorId";
	
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":authorId"=>$authorId));
	return $stmt->fetch();   
}


$authorInfo = getAuthor($_POST['authorId']);
$books = booksWriten($_POST['authorId']);
$written = bookCount($_POST['authorId']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?=$authorInfo['firstName']?> <?=$authorInfo['lastName']?></title>
  <meta name="description" content="">
  <meta name="author" content="Chelsea, Daniel, Evan, and Matt">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <div id="main">
    <h1><?=$authorInfo['firstName']?> <?=$authorInfo['lastName']?></h1>
    <span><?=$authorInfo['firstName']?> <?=$authorInfo['lastName']?> was born on <?=$authorInfo['dob']?> and has written <?=$written['COUNT(title)']?> books in our database.
    <br><br>
    These books are:
    <ul>
    	<?php
			foreach($books as $book){
				echo "<li>" . $book['title'] . "</li>";
			}
			?>
    </ul>
    </span>
  </div>
</body>
</html>
