# PHP, Databases and PDO
In previous weeks we have looked at key PHP concepts e.g. form processing and arrays. We have also looked at databases and using SQL.

This week is all about running SQL statements using PHP, and building database driven PHP applications.

## PHP database extensions
There are several different PHP database extensions (pre-written code that allows us to communicate with a database from our own PHP code). These are:-

* MySQL
* MySQLi (MySQL improved)
* PDO (PHP Data Objects)

We will use PDO. This is for two reasons:
1. The MySQL extension has security weaknesses
2. PDO offers some advantages over MySQLi e.g. it can work with many different databases not just MySQL.

## Connecting to a database using PDO
The following code will create a connection to a MySQL database. We have to specify
* The name of the database we want to connect to.
* The mysql username for this database.
* The mysql password for this database.

The connection will be stored in the ``` $conn``` variable.
```php
<?php
try{
     $conn = new PDO('mysql:host=localhost;dbname=nameOfDatabase', 'username', 'password');
     $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
    echo "Oh no, there was a problem" . $exception->getMessage();
}
?>
```
### try...catch
This code features a ```try...catch``` block.

```php
<?php
try{
	//some code
}
catch(Exception $ex){
	echo $ex->getMessage();
}
?>
```

This allows us to run a piece of code that might go wrong e.g. the DBMS isn't running, the user account details have been changed. If there is a problem we can 'catch' the problem (exception) and display an error message.

### Error reporting
The line of code

```php
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
```

Switches on error reporting for SQL errors. This is useful for us when debugging our code. However, it's not a good idea to display errors in a live website. The error message could reveal information about our database structure that could be used to attack the site.

## query()
There are a number different ways of running SQL from PHP. The first of these we will look at is the ```query()``` method. This is used for SELECT queries that **don't** involve user input e.g. selecting all the rows from a table.

Here's an example that uses a *countries* table.

| id | name    | population |
|----|---------|------------|
| 1  | England | 55000000   |
| 2  | France  | 67000000   |
| 3  | Germany | 82000000   |

```php
<?php
try{
       $conn = new PDO('mysql:host=localhost;dbname=cit2202', 'cit2202', 'letmein');
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}

$query = "SELECT * FROM countries"; // a simple string that contains our SQL query
$resultset = $conn->query($query); //run the query
$countries  = $resultset->fetchAll(); //retrieve all the rows from the resultset
$conn=NULL; //close the connection to the database

foreach ($countries as $country) {
    echo "<p>";
    echo "{$country['name']} "; //displays each country name
    echo "</p>";
}
?>
```
* ```$conn->query($query);``` executes a query against the database. Note that this uses exactly the same SQL code that we used previously.

* The ```query()``` method returns a resultset, a collection of rows.

* ```$countries  = $resultset->fetchAll();``` fetches all the rows from the resultset as an array of associative arrays i.e.

```php
[
    ["id"=>1,"name"=>"England", "population"=>55000000],
    ["id"=>2,"name"=>"France", "population"=>67000000],
    ["id"=>3,"name"=>"Germany", "population"=>82000000]
]
```
* We can then use a ```foreach``` loop to display each country name.

```php
foreach ($countries as $country) {
    echo "<p>";
    echo "{$country['name']} ";
    echo "</p>";
}
```
It is worth taking a few moments and trying to understand what each line is doing. We will use code like this over and over again.

## fetchAll() vs fetch()

The previous example used ```fetchAll()```. ```fetchAll()``` retrieves all the rows from a resultset. However, sometimes we only want a single row. Have a look at the following example.

```php
<?php
try{
       $conn = new PDO('mysql:host=localhost;dbname=cit2202', 'cit2202', 'letmein');
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}
$query = "SELECT * FROM countries WHERE id = 2;"; // a simple string that contains our SQL query
$resultset = $conn->query($query); //run the query
$country  = $resultset->fetch(); //retrieve a single row
$conn=NULL; //close the connection

echo $country['name']; //outputs France
?>
```

```fetch()``` returns a single row e.g.

```php
["id"=>2,"name"=>"France", "population"=>66000000]
```

So if we use ```fetch()``` we don't need a ```foreach``` loop to output the result.  

## Prepared Statements
The second way in which we will run SQL statements is using prepared statements. Whenever the query involves user input we need to use a prepared statement e.g. the user enters a search term that we use to query the database or the user enters a username and password that we need to check against details in a database table. Have a look at the following example:
```php
<?php
try{
       $conn = new PDO('mysql:host=localhost;dbname=cit2202', 'cit2202', 'letmein');
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}
$query = "SELECT * FROM countries WHERE name=:countryName;";
$preparedStmt = $conn->prepare($query);
$preparedStmt->bindValue(':countryName','France');
$preparedStmt->execute();
$country = $preparedStmt->fetch();
$conn=NULL;

echo "<p>{$country['name']} has a population {$country['population']}.</p>"; //outputs France has a population of 66000000

?>
```
This looks very similar to the previous example that used ```query()``` but there are some key differences.

The SQL features a placeholder, the bit that says ```:countryName```

```
$query = "SELECT * FROM countries WHERE name=:countryName;";
```

We then bind an actual value to this placeholder when we want to execute the query.
```php
$preparedStmt->bindValue(':countryName','France');
```
In this example we have hard-coded in the word 'France'. Typically this value would come from a PHP form.

We still use ```fetch()``` or ```fetchAll()``` to retrieve the result of our query.

Take a bit of time to compare the use of the ```query()``` method and prepared statements.

