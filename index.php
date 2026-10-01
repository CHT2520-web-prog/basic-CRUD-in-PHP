<?php
// The following try..catch block attempts to create a connection to the database
// We use the same code every time we want to use a database, we just change the connection settings to match our database
try{
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}

//An SQL statement for selecting all the rows in the films table
$query = "SELECT id, title, year, duration FROM films";

// Execute this SQL query
$resultset = $conn->query($query);

/*
Grab hold of the results
We expect to get more than a single row back so we use fetchAll()
*/
$films = $resultset->fetchAll();

//We no longer need the database so close the connection
$conn=NULL;

?>
<!DOCTYPE HTML>
<html>
<head>
<title>List the films</title>
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

<h1>Here's a list of films</h1>
<?php


// The results from the database are returned as an array
// Use a foreach loop to iterate over the array and display the each film
foreach ($films as $film) {
    echo "<p>";
    // Construct a link to the show.php page e.g. <a href="show.php?id=2">Winter's Bone</a>
    echo "<a href='show.php?id={$film["id"]}'>";
    // Display the film's title
    echo $film["title"];
    echo "</a>";
    echo "</p>";
}

?>

</body>
</html>