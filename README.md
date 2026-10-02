# CRUD Operation using PDO

These examples demonstrate the use of PDO to implement CRUD (Create, Read, Update, Delete) functionality for a simple web application.

The following instructions explain how to get started if you are using Codespace - skip straight to 'Setting up the database'. 

If you are using Herd, you will need to install a database. 
- My advice is to use https://dbngin.com/ to install a relational database.
- I'd also recommend installing TablePlus (https://tableplus.com/) as visual tool for managing your databases. Alternatively you could simply use the SQLTools extension for VS Code. 
- Once you have set-up a database, execute the SQL below to create a simple `films` table. 
- You should then be able to follow the instructions from 'Getting started' onwards.

## Setting up the database

Open your existing codespace (DON'T CREATE A NEW ONE) [https://github.com/codespaces](https://github.com/codespaces).

Your codespace already has a database installed (MariaDB). It also has a database management tool installed called Adminer.

Select the 'ports' tab (next to terminal).
Hover over the forwarded port for 8080 and click 'Open in Browser'
A new tab should open for Adminer.

Adminer is like a lightweight version of phpmyadmin.
To log into Adminer enter the following:-
- username: **student**
- password: **secret**
- database: **webdev**

This will give you access to a database called **webdev**.
Select 'SQL Command' and enter the following SQL

```sql
CREATE TABLE films (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  year smallint(6) NOT NULL,
  duration smallint(6) NOT NULL,
  CONSTRAINT PRIMARY KEY (id)
);
```

Then click 'Execute'.
This SQL command creates a new table.
Next, we'll populate the table with some sample data. Enter the following SQL:

```sql
INSERT INTO `films` (`id`, `title`, `year`, `duration`) VALUES
(NULL, 'Winter\'s Bone', 2010, 100),
(NULL, 'Do The Right Thing', 1989, 120),
(NULL, 'The Incredibles', 2004, 115),
(NULL, 'The Godfather', 1972, 177),
(NULL, 'Dangerous Minds', 1995, 99),
(NULL, 'Spirited Away', 2001, 124),
(NULL, 'Moonlight', 2016, 111),
(NULL, 'Life of PI', 2012, 127),
(NULL, 'Gravity', 2013, 91),
(NULL, 'Arrival', 2016, 116),
(NULL, 'Wonder Woman', 2017, 141),
(NULL, 'Mean Girls', 2004, 97),
(NULL, 'Inception', 2010, 108),
(NULL, 'Donnie Darko', 2001, 113),
(NULL, 'Get Out', 2017, 117);
```

- Hit 'Execute'
- From near the top of the page select the database (`webdev`) and then select the `films` table and then 'select data' to confirm this has worked.

## Getting started

In the terminal, clone this repo.

```
git clone https://github.com/CHT2520-web-prog/basic-CRUD-in-PHP
```

- Open *index.php*. Change the connection settings to match your database and environment. This is the line you need to change.

```php
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
```

If you are on Codespaces, you will need to change it to:

```php
    $conn = new PDO('mysql:host=db;dbname=webdev', 'student', 'secret');
```
- Back in the terminal, navigate to this folder

```
cd basic-CRUD-in-PHP
```

- Start the web server
```
php -S 0.0.0.0:8000
```

- You should see the *index.php* page displayed. It should be showing the list of films from the database.


## Completing the app

- Have a good look through the code in _index.php_. Make sure you understand what each line of code is doing. Refer to the comments in the code, [Form Processing](form-processing.md) and [PHP, Databases and PDO](pdo.md) for explanations.

### Getting the other operations to work

- If you click on one of the links in _index.php_, this takes you to _show.php_, and you'll get an error. Open up _show.php_ and edit the connection settings just like you did in _index.php_. The _show.php_ page should then work.
- Continue by changing the connection settings in the other files to get the whole application to work. Make sure you look carefully through the code so you understand how the application has been built.

## Testing your understanding

### Questions
- _create.php_ doesn't connect to the database. Why?
- In _show.php_ the details for a single film are shown, how does this page 'know' which film to display i.e. how is data passed from _index.php_ to _show.php_?
- _destroy.php_ (and _update.php_) also operate on a single film. How do these pages know which film to delete/update e.g. how is data passed from _show.php_ to _destroy.php_? How is this different to the way in which data is passed from _index.php_ to _show.php_?
- _index.php_ uses the `$conn->query()` method to execute SQL, why does _show.php_ use `$stmt->execute()`? Why isn't `$conn->query()` used in _show.php_?
- Why isn't there any HTML code in _update.php_ and _destroy.php_?

### Editing the code

- In _index.php_ how can we display the year for the film alongside the title e.g. Jaws (1975)
- How would you edit the code so that the list of films in _index.php_ appears in date order with the most recent first.

## Re-factoring the code
One obvious issue in this application is the huge amount of duplicate code in both the PHP and HTML.

In the next two weeks we will look at design patterns for writing more maintainable code, for now think how can you use `require` statements to structure the app and reduce the amount of duplication. 

### Removing the duplicate database connection code
- Place the code for connecting to the database in a separate PHP file and `require` it in any page that needs it. 

**database.php**
```php
try{
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}
```
- From _show.php_  `require` this file e.g.

**show.php**
```php
<?php
//Loads the code in database.php
require 'database.php';

//Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
$id = $_GET['id'];

//Create a prepared statement. This uses the $id value to select a specific film
$stmt = $conn->prepare("SELECT id, title, year, duration FROM films WHERE films.id = :id");
$stmt->bindValue(':id',$id);
$stmt->execute();
//the rest of the code would follow below
...
```
- Try and get this to work in _show.php_ first, then `require` the _database.php_ in all the php files that need to connect to a database. 

### Separating logic from presentation
A simple way to structure our code is by splitting into logic (processing input, working with the database etc.) and presentation (`echo` statements and HTML).

- Create separate view files for each page. The view should contain the presentation code e.g. for _index.php_ I would create an _index.view.php_ file

**views/index.view.php**
```html
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
```
- I would then `require` this view files in _index.php_.

**index.php**
```php
<?php
// Require the database connection
require "database.php";
//An SQL statement for selecting all the rows in the films table
$query = "SELECT id, title, year, duration FROM films";
// Execute this SQL query
$resultset = $conn->query($query);

$films = $resultset->fetchAll();
//We no longer need the database so close the connection
$conn=NULL;
// require the index.view.php file
require 'views/index.view.php';
```

- The code in _index.php_ then becomes cleaner and focussed on a single task.
- Try and get this to work and the create view files for your other pages. 

### Removing duplicate HTML code
Many of the pages feature very similar HTML code. 
Try and create separate _header.php_ and _footer.php_ files e.g.

**views/partials/header.php**

```html
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $pageTitle; ?></title>
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
```
- We can then require this HTML snippet from our view files e.g.

**views/index.view.php**

```php
$pageTitle = "Amazing film app";

//Loads the header.php file
require("./views/partials/header.php");

echo "<h1>Here's a list of films</h1>";

// The results from the database are returned as an array
// Use a foreach loop to iterate over the array and display the each film
foreach ($films as $film) {
    echo "<p>";
    // Construct a link to the show.php page e.g. <a href="show.php?id=2">Winter's Bone</a>
    echo "<a href='./index.php?action=show&id={$film['id']}'>";
    // Display the film's title
    echo $film['title'];
    echo "</a>";
    echo "</p>";
}

//loads a footer.php file
require("./views/partials/footer.php");
```
- Again, if you can get this to work, edit the other view files to also use header and footer file. 

## Optional extra
Make sure you really understand the basic CRUD code is this repository, this is the basis for future examples we will look at (including Laravel). However, if you fully understand the code, try the following:
- These examples are as simple as they can be. How could you perform some basic error checking e.g. if we try and access a film that doesn't exist on the _show.php_ page we should return a 404 status code and 404 page. 
