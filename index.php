<?php
require 'connect.php';

function getBooks() {
	global $dbConn;

	$sql = "SELECT isbn, title, genre, a.authorId, firstName, lastName, pubYear, p.pubId, companyName
			FROM books b
			INNER JOIN authors a ON a.authorId = b.authorId
			INNER JOIN publishers p ON p.pubId = b.publisherId
			WHERE 1";

	$escarray = array();
	if (isset($_POST['author']) && $_POST['author'] != '') {
		$sql .= " AND a.authorID = :author ";
		$escarray[":author"] = $_POST['author'];
	}
	if (isset($_POST['genre']) && $_POST['genre'] != '') {
		$sql .= " AND genre = :genre ";
		$escarray[":genre"] = $_POST['genre'];
	}
	if (isset($_POST['publisher']) && $_POST['publisher'] != '') {
		$sql .= " AND pubId = :publisher ";
		$escarray[":publisher"] = $_POST['publisher'];
	}
	if (isset($_POST['year']) && $_POST['year'] != '') {
		$sql .= " AND pubYear = :year ";
		$escarray[":year"] = $_POST['year'];
	}

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute($escarray);
	return $stmt -> fetchAll();
}



function getAuthors() {
	global $dbConn;

	$sql = "SELECT authorId, firstName, lastName
			FROM authors
			ORDER BY lastName";

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute();
	return $stmt -> fetchAll();
}

function getPublishers() {
	global $dbConn;

	$sql = "SELECT pubId, companyName
			FROM publishers
			ORDER BY companyName";

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute();
	return $stmt -> fetchAll();
}

function getGenres() {
	global $dbConn;

	$sql = "SELECT DISTINCT genre
			FROM books
			ORDER BY genre";

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute();
	return $stmt -> fetchAll();
}

function getYears() {
	global $dbConn;

	$sql = "SELECT DISTINCT pubYear
			FROM books
			ORDER BY pubYear";

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute();
	return $stmt -> fetchAll();
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Team Project</title>
		<meta name="description" content="">
		<meta name="author" content="Chelsea, Daniel, Evan, and Matt">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<script>
			function confirmLogout(){
          	var logout = confirm("Do you really want to logout?");
          	if (!logout){
              event.preventDefault();
          }
		</script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>

	<body>
		<div id="main">
			<h1>Library Catalog</h1>
			<form method="post">
				<div class="inline">
					<h3>Author:</h3>
					<select name="author">
						<option value="" selected>all</option>
						<?php
						foreach (getAuthors() as $author) {
							echo "<option value='" . $author['authorId'] . "'>" . $author['lastName'] . ", " . $author['firstName'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="inline">
					<h3>Genre:</h3>
					<select name="genre">
						<option value="" selected>all</option>
						<?php
						foreach (getGenres() as $genre) {
							echo "<option value='" . $genre['genre'] . "'>" . $genre['genre'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="inline">
					<h3>Publisher:</h3>
					<select name="publisher">
						<option value="" selected>all</option>
						<?php
						foreach (getPublishers() as $publisher) {
							echo "<option value='" . $publisher['pubId'] . "'>" . $publisher['companyName'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="inline">
					<h3>Year:</h3>
					<select name="year">
						<option value="" selected>all</option>
						<?php
						foreach (getYears() as $year) {
							echo "<option value='" . $year['pubYear'] . "'>" . $year['pubYear'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="inline">
					<input class="button" type="submit" value="Select" />
				</div>
			</form>
			<br />
			<table>
				<tr>
					<th>ISBN</th>
					<th>Title</th>
					<th>Genre</th>
					<th>Author</th>
					<th>Publisher</th>
					<th>Published</th>
				</tr>
				<?php
				foreach (getBooks() as $book) {
				?>
				<tr>
					<td>
						<form method="post" action="book.php">
							<input hidden type="text" name="isbn" value="<?= $book['isbn'] ?>" />
							<input class="button" type='submit' value="<?= $book['isbn']?>" />
						</form>
					</td>
					<td>
						<form method="post" action="book.php">
							<input hidden type="text" name="isbn" value="<?= $book['isbn'] ?>" />
							<input class="button" type='submit' value="<?= $book['title']?>" />
						</form>
					</td>
					<td>
						<?= $book['genre'] ?>
					</td>
					<td>
						<form method="post" action="author.php">
							<input hidden type="text" name="authorId" value="<?= $book['authorId'] ?>" />
							<input class="button" type='submit' value="<?= $book['lastName'] . ", " . $book['firstName'] ?>" />
						</form>
					</td>
					<td>
						<form method='post' action='publisher.php'>
							<input hidden type="text" name="pubId" value="<?= $book['pubId'] ?>" />
							<input class="button" type='submit' value="<?= $book['companyName'] ?>" />
						</form>
					</td>
					<td>
						<?= $book['pubYear'] ?>
					</td>
				</tr>
				<?php } ?>
			</table>
			<br />
			<form action="change.php">
				<input class="button" type="submit" value="Change Password">
			</form>
			<br />
		<form action="logout.php" onsubmit="confirmLogout()">
		<input class="button" type="submit" value ="Logout">
		</form>
		</div>
	</body>
</html>
