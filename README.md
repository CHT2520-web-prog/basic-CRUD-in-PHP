# CRUD Operation using PDO

These examples demonstrate the use of PDO to implement CRUD (Create, Read, Update, Delete) functionality for a simple web application.

The following instructions explain how to get started if you are using Codespace. 

If you are using Herd, you will need to install a database. 
- My advice is to use https://dbngin.com/ to get started with a relational database.
- I'd also recommend installing TablePlus (https://tableplus.com/) as visual tool for managing your databases. Alternatively you could simply use the SQLTools extension for VS Code. 

Once you have set-up a database, execute the SQL below. 

You should then be able to follow the instructions from 'Getting started' onwards.

## Setting up the database

Open your existing codespace (DON'T CREATE A NEW ONE) [https://github.com/codespaces](https://github.com/codespaces).

Your codespace already has a database installed (MariaDB). It also has a database management tool installed called Adminer.

Select the 'ports' tab (next to terminal).
Hover over the Forwarded port for 8080 and click 'Open in Browser'
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
- From near the top of the page select the database (webdev) and then select the films table and then 'select data' to confirm this has worked.

## Getting started

Clone this repo.

```
git clone https://github.com/CHT2520-web-prog/basic-CRUD-in-PHP
```

in the terminal navigate to this folder

```
cd basic-CRUD-in-PHP
```

- Open *index.php*. Change the connection settings to match your database and environment. This is the line you need to change.

```php
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
```

You will need to change it to:

```php
    $conn = new PDO('mysql:host=db;dbname=webdev', 'student', 'secret');
```
- Start the web server
```
php -S 0.0.0.0:8000
```

- You should see the *index.php* page displayed. It should be showing the list of films from the database.


## Completing the practical work

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

### Editing the code

- In _index.php_ how can we display the year for the film alongside the title e.g. Jaws (1975)
- How would you edit the code so that the list of films in _index.php_ appears in date order with the most recent first.

## Re-factoring the code
One obvious issue in this application is the huge amount of duplicate code in both the PHP and HTML.

In the next two weeks we will look at design patterns for writing more maintainable code, for now think how can you use `include`/`require` statements to reduce the amount of duplication. 
- You could place the code for connecting to the database in a separate PHP file and `require` it in any page that needs it. 
- You could take the duplicate HTML code and place this in separate files e.g. `header.php` and include these files to build-up pages. 

## Optional extra
Make sure you really understand the basic CRUD code is this repository, this is the basis for future examples we will look at (including Laravel). However, if you fully understand the code, try the following:
- These examples are as simple as they can be. How could you perform some basic error checking e.g. if we try and access a film that doesn't exist on the _show.php_ page we should return a 404 status code. 
