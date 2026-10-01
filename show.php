<?php
//Connect to the database
require 'database.php';
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

// Load the view
require "views/show.view.php";

