<?php
if (!isset($_POST['id'])) { header("Location: index.php"); } // make sure there's id to change;

require('config.php');

$query = 'UPDATE members SET ';
foreach ($_POST as $name => $value) {
	$_POST["$name"] = $con->quote("$value"); // clean the $_POSTs
	if ($name != 'id') { $query = $query.sprintf("$name = {$_POST["$name"]}, "); } // Add $_POST item to $query
}
$query = substr_replace($query ,"",-2); //remove the last comma
$query = $query." WHERE id = {$_POST['id']}";
$result = $con->query($query);
if (!$result) {
    die('There was an error while sending the data!');
}
$con = null;
?>
