
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
//Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
$id = $_GET['id'];

//Create a prepared statement. This uses the $id value to select a specific film
$stmt = $conn->prepare("SELECT id, title, year, duration FROM films WHERE films.id = :id");
$stmt->bindValue(':id',$id);
$stmt->execute();
// Get hold of a single row so use fetch()
$film = $stmt->fetch();

//Close the connection to the database
$conn = NULL;
?>


<!DOCTYPE HTML>
<html>
<head>
<title>Show the details for a film</title>
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
<?php

// Display the film's details. There is a single film, so we don't need a foreach loop
echo "<h1>{$film['title']}</h1>";
echo "<p>Year:{$film['year']}</p>";
echo "<p>Duration:{$film['duration']}</p>";


// Link to the edit page, passing the film's id in the query string e.g. edit.php?id=3
echo "<a href='edit.php?id={$film['id']}/edit'><button>Edit</button></a> ";
?>

<!-- For delete we need to use a POST action -->
<form method='POST' action='destroy.php'>
<!-- 
	A hidden field (not visible to the user) inspect the page or view source in the HTML page to see it. 
	The field contains the id number of the film.
-->
<input type="hidden" name="id" value="<?php echo $film['id'];?>">
<button type='submit'>Delete</button>
</form>


</body>
</html>
