<?php
require 'database.php';

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
