<?php
$pageTitle = "Show details for a film";
require("./views/partials/header.php");

echo "<h1>Edit the details for {$film['title']}</h1>"; ?>
<form action="update.php" method="POST">
    <!-- 
	A hidden field (not visible to the user) inspect the page or view source in the HTML page to see it. 
	The field contains the id number of the film.
-->
    <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
    <div>
        <label for="title">Title:</label>
        <!--
    The text boxes are populated with values from the database ready for the user to edit
-->
        <input type="text" id="title" name="title" value="<?php echo $film['title']; ?>">
    </div>
    <div>
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" value="<?php echo $film['year']; ?>">
    </div>
    <div>
        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" value="<?php echo $film['duration']; ?>">
    </div>
    <div>
        <button type="submit">Save Changes</button>
    </div>
</form>

<?php
require("./views/partials/footer.php");
?>