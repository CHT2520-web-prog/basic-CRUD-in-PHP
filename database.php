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