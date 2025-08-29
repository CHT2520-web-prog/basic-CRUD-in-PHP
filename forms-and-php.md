# PHP Form Processing
Nearly all useful web applications involve form processing. The user enters something into a form and we use PHP to process this data in some way.

## A simple example
### The HTML
Before looking at the PHP, we need to know about a couple of HTML attributes. Have a look at the following form.

```html
<form action="somepage.php" method="POST">
<p>
<label for="uname">Name:</label>
<input type="text" name="uname" id="uname">
<label for="col">Favourite colour:</label>
<input type="text" name="col" id="col">
<input type="submit" name="submitBtn">
</p>
</form>

```
You should be familiar with most of the HTML in the above form. Two things we haven't really discussed previously are the *action* and *method* attributes. The *action* attribute specifies where the data will be sent. So in the above example, when the user clicks the submit button, the data will be sent to *somepage.php*.  

The data is sent as name-value pairs e.g. if the user entered *Fred* into the first text field and *red* into the second, the browser will send:

| name   |       value       |       
|:--:|:-------------:|
|uname|Fred|
|col|red|

Look carefully at the HTML in the form to see how these name-value pairs are constructed.

* The method attribute specifies how the data will be sent. In this example we used a value of POST. See below for an alternative to POST.

### The PHP
PHP in *somepage.php* has access to the form data through something called the ```$_POST``` variable. The text in quotes specifies which value we want to retrieve.

```php
…
<?php
$uname = $_POST["uname"]; //gets hold of whatever the user typed into the uname text field text box
$col = $_POST["col"]; //gets hold of whatever the user typed into the col text field
?>
<!DOCTYPE HTML>
<html>
<head>
<title>This is somepage.php</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
<body>
<?php
echo "Welcome {$uname}. Your favourite colour is {$col}.</p>";
?>
</body>
</html>
```

This example uses text boxes but other form controls e.g. radio buttons, select menus work in the same way.

## The method attribute
The previous example used the POST method. The other method we will use is the GET method. Here's an example:

HTML
```html
<form action="somepage.php" method="GET">
<p>
<label for="uname">Name:</label>
<input type="text" name="uname" id="uname">
<label for="col">Favourite colour:</label>
<input type="text" name="col" id="col">
<input type="submit" name="submitBtn">
</p>
</form>
```
Note this is nearly identical to the first example. The only difference is in the ```method``` attribute that has been changed to *GET*.


somepage.php

```php
<?php
$uname = $_GET["uname"]; //gets hold of whatever the user typed into the uname text field text box
$col = $_GET["col"]; //gets hold of whatever the user typed into the col text field
?>
```

* Again this is nearly identical to the previous example, we have just swapped the word POST to GET.
* The difference is how the data is sent. With a GET request the data is sent as part of the URL.
* When the user clicks the submit button, the browser will generate the  url like the following:

```
http://localhost/CIT2202/somepage.php?uname=Fred&col=red
```

* The name-value pairs are appended to the URL.
* This part of the URL (```uname=Fred&col=red```) is called a query string
    * A question mark (?) separates the URL from the query string
    * Each name-value pair is separated by an ampersand(&) symbol

### GET vs POST
* Data sent by GET is visible in the URL as a query string:
  * This can be bookmarked or accessed through the browser history, meaning users don't have to re-enter form information as they navigate back and forth in the browser.
  * There are some security issues when using GET, the data sent is visible in the URL, and simply by looking back in the browser history the data will be visible.
  * There are limitations in terms of how much data can be sent. see https://stackoverflow.com/questions/2659952/maximum-length-of-http-get-request.

* POST is used for:
  * Submitting data for inclusion is a database.
  * Ordering a product.
  * Submitting usernames/passwords.

Generally GET requests should be used when retrieving data e.g. submitting a search term. For most form processing applications POST should be used.
