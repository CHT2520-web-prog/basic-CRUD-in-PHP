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


//This is a simple example we would normally do some form validation here

//Basic form processing
//Look at the name values of the form controls in create.php to see where these values 
// e.g. $_POST['title'] comes from <input type="text" id="title" name="title">
$id = $_POST['id'];
$title = $_POST['title'];
$year = $_POST['year'];
$duration = $_POST['duration'];

//SQL UPDATE for updating a new row
//Use a prepared statement to bind the values from the form
$query = "UPDATE films SET title=:title, year=:year, duration=:duration WHERE id=:id";
$stmt = $conn->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->bindValue(':title', $title);
$stmt->bindValue(':year', $year);
$stmt->bindValue(':duration', $duration);
$stmt->execute();
//Close the connection
$conn = NULL;
//Redirect the user to the home page
header('Location: index.php');
die();

?>
