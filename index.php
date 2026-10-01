<?php
// The following try..catch block attempts to create a connection to the database
// We use the same code every time we want to use a database, we just change the connection settings to match our database
try{
    $conn = new PDO('mysql:host=localhost;dbname=webdev', 'student', 'secret');
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}

//An SQL statement for selecting all the rows in the films table
$query = "SELECT id, title, year, duration FROM films;";

// Execute this SQL query
$resultset = $conn->query($query);

/*
Grab hold of the results
We expect to get more than a single row back so we use fetchAll()
*/
$films = $resultset->fetchAll();

//We no longer need the database so close the connection
$conn=NULL;

require "views/index.view.php";
