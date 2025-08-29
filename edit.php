<?php
//Connect to the database
try{
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}

//Get the id from the query string e.g. edit.php?id=3
$id=$_GET['id'];
//Create a prepared statement. This uses the $id value to select a specific film
$stmt = $conn->prepare("SELECT id, title, year, duration FROM films WHERE films.id = :id");
$stmt->bindValue(':id',$id);
$stmt->execute();

// Get hold of a single row so use fetch()
$film=$stmt->fetch();

//Close the connection to the database
$conn=NULL;

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Edit the film details</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<nav>
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="create.php">Add new film</a></li>
    <li><a href="about.php">About</a></li>
</ul>
</nav>

<?php echo "<h1>Edit the details for {$film['title']}</h1>";?>
<form action="update.php" method="POST">
<!-- 
	A hidden field (not visible to the user) inspect the page or view source in the HTML page to see it. 
	The field contains the id number of the film.
-->
<input type="hidden" name="id" value="<?php echo $film['id'];?>">
<div>
<label for="title">Title:</label>
<!--
    The text boxes are populated with values from the database ready for the user to edit
-->
<input type="text" id="title" name="title" value="<?php echo $film["title"];?>">
</div>
<div>
<label for="year">Year:</label>
<input type="text" id="year" name="year" value="<?php echo $film["year"];?>">
</div>
<div>
<label for="duration">Duration:</label>
<input type="text" id="duration" name="duration" value="<?php echo $film["duration"];?>">
</div>
<div>
<button type="submit">Save Changes</button>
</div>
</form>

</body>
</html>
