# CRUD Operation using PDO

These examples demonstrate the use of PDO to implement CRUD (Create, Read, Update, Delete) functionality for a simple web application.

- [Follow these instructions if you are using Codespaces](#codespaces)
- [Follow these instruction if you are using XAMPP](#xampp)

## If you are using Codespaces <a name="codespaces"></a>

- Open your existing codespace (you shouldn't create a new one) [https://github.com/codespaces](https://github.com/codespaces).
- In the terminal enter

```
git clone https://github.com/CHT2520-web-prog/basic-CRUD-in-PHP
```

This will copy the contents of this repository into your codespace.

### Setting up the database

The codespace has a database installed. It also has a database management tool installed called Adminer.

Select the 'ports' tab (next to terminal).
Hover over the Forwarded port for 8081 and click 'Open in Browser'
A new tab should open for Adminer.

Adminer is like a lightweight version of phpmyadmin.
To log into Adminer enter the following:-
username: root
password: secret
database: cht2520

This will give you access to a database called cht2520.
Select 'SQL Command' and enter the following SQL

```sql
CREATE TABLE films (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  year smallint(6) NOT NULL,
  duration smallint(6) NOT NULL,
  CONSTRAINT PRIMARY KEY (id)
)
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

Hit 'Execute'
from near the top of the page select the database (cht2520) and then select the films table and then Select data to confirm this has worked.

### Getting started

Back in the codespace, from the basic-CRUD-in-PHP folder, open index.php
change the connection settings to match your database and enviornment. This is the line you need to change

```
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
```

You will need to change it to:

```
    $conn = new PDO('mysql:host=db;dbname=cht2520', 'root', 'secret');
```

Start Apache (`apache2ctl start`)
Browse to the basic-CRUD-in-PHP folder. You should see the index.php page displayed. it should be showing the list of films from the database.

Now move onto [Completing the practical work](#practical)

## If you are using XAMPP <a name="xampp"></a>

- Download this repository and unzip it. Move the folder into your htdocs directory on XAMPP.

### Setting up a database

MySQL is part of XAMPP. To complete these exercises you will need Apache to be running and MySQL (check your control panel).

- In a web browser enter http://localhost/phpmyadmin/ and you will be taken to admin home screen for phpMyAdmin. It should also be available as the 'admin' link from the control panel.

It's a good idea to set up a database where you can do all your work for the module. You will also need to set up a user with access to this database.

- From the navigation bar along the top select 'User accounts'.
- Select 'Add user account' and then enter the following details:
  - Username: Enter a username (and remember it)
  - Host name: select 'Local'. It should fill the second field with 'localhost'.
  - Password: Enter a password (and remember it!)
  - Scroll down a bit and select the checkbox that says _'Create database with same name and grant all privileges.'_
  - Scroll down to the bottom of the page and select 'Go'.

A database named cht2520 should appear on the left-hand side.

- Select this database. At the moment it will tell you 'No tables found'

- Click on the SQL tab, paste in the following code:

```SQL
CREATE TABLE films (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  year smallint(6) NOT NULL,
  duration smallint(6) NOT NULL,
  CONSTRAINT PRIMARY KEY (id)
)
```

- Click 'Go'
- A 'films' table should be created
- Select the table and click 'structure' to check the table you have created
- Select the SQL tab again. Paste in the following:

```SQL
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

- Click 'go'
- Select browse to make sure this worked. You should be able to see the list of films.

### Getting started

- Start with _index.php_. In the PHP code, change the connection settings to match your database. This is the line you need to change

```
    $conn = new PDO('mysql:host=localhost;dbname=MyDatabase', 'MyUsername', 'MyPassword');
```

You will need to change _MyDatabase_ to cht2520, and _MyUsername_ and _MyPassword_ to match your the username and password you entered.

- View _index.php_ in a browser. You should see a list of films.

Now move onto [Completing the practical work](#practical).

## Completing the practical work <a name="practical"></a>

- Have a good look through the code in _index.php_. Make sure you understand what each line of code is doing. Refer to [Form Processing](form-processing.md) and [PHP, Databases and PDO](pdo.md) for explanations.

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

### Optional extra

- Make sure you really understand the basic CRUD code is this repository, this is the basis for future examples we will look at (inluding Laravel). However, if you fully understand the code, try the following:
- These examples are as simple as they can be. How could you perform some basic user input validation i.e. testing that the user has completed all the fields when adding a new film. Hint: You will need to add some code in _store.php_ to test the values from the form. If you detect a problem, `echo` out a message to the user and use `die();` to prevent the INSERT code from running.
