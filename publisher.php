<?php
require 'conect.php';
function getPub($pubId){
	global $dbConn;
	
	$sql = "SELECT companyName, city, state
			FROM publishers
			WHERE pubId = :pubId";
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":pubId"=>$pubId));
	return $stmt->fetch();        
}

function bookCount($pubId){
	global $dbConn;
	
	$sql = "SELECT COUNT(title)
			FROM books
			WHERE publisherId = :pubId";
	
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":pubId"=>$pubId));
	return $stmt->fetch();   
}

function listBooks($pubId){
	global $dbConn;
	
	$sql = "SELECT title
			FROM books
			WHERE publisherId = :pubId
			ORDER BY title";
			
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":pubId"=>$pubId));
	return $stmt->fetchAll();     
}


$pubInfo = getPub($_POST['pubId']);
$bookList = listBooks($_POST['pubId']);
$published = bookCount($_POST['pubId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>More on <?=$pubInfo['companyName']?></title>
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
	<h1><?=$pubInfo['companyName']?></h1>
	<span><?=$pubInfo['companyName']?> is based in <?=$pubInfo['city']?>
		<?php 
			if($pubInfo['state'] != NULL){
				echo ", " . $pubInfo['state'];
			}
		?>
		.
		<br> <br>
		<?=$pubInfo['companyName']?> has published the <?=$published['COUNT(title)']?> following books in our database:
		<ul>
			<?php
			foreach($bookList as $book){
				echo "<li>" . $book['title'] . "</li>";
			}
			?>
		</ul>
	</span>
  </div>
</body>
</html>
