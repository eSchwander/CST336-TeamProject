<?php
require 'connect.php';

function getBook($isbn){
	global $dbConn;
	
	$sql = "SELECT *
			FROM books
			INNER JOIN authors ON books.authorId=authors.authorId
			INNER JOIN publishers ON books.publisherId=publishers.pubId
			WHERE isbn = :isbn";
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array(":isbn"=>$isbn));
    		return $stmt->fetch();        
}

$bookInfo = getBook($_POST['isbn']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>More on <?=$bookInfo['title']?></title>
  <meta name="description" content="Chelsea, Daniel, Evan, and Matt">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <div id="main">
	<h1><?=$bookInfo['title']?></h1>
	<span><?=$bookInfo['title']?>'s genre is <?=$bookInfo['genre']?>, was written by <?=$bookInfo['firstName']?> <?=$bookInfo['lastName']?>, and was publish in <?=$bookInfo['pubYear']?> by <?=$bookInfo['companyName']?>.</span>
  </div>
</body>
</html>
