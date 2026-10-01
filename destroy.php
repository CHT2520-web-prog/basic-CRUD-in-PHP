<?php
//Connect to the database
require 'database.php';

//Get the id from the hidden fiedl in the form
$id = $_POST['id'];

//SQL UPDATE for updating a new row
//Use a prepared statement to bind the id from the form
$stmt = $conn->prepare("DELETE FROM films WHERE films.id = :id");
$stmt->bindValue(':id',$id);
$stmt->execute();
//Close the connect
$conn=NULL;
//Redirect to the home page
header('Location: index.php');
die();
?>
