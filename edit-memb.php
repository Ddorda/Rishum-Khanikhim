<?php
if (!isset($_POST['id'])) { header("Location: index.php"); } // make sure there's id to change;

require('con.php');

$con = mysql_connect($db_host,$db_user,$db_pass);
if (!$con)
  {
  die('Could not connect to the server! ' . mysql_error());
  }
if (!mysql_select_db($db_name))
  die("Can't select database");

$query = 'UPDATE members SET ';
foreach ($_POST as $name => $value) {
	$_POST["$name"] = mysql_real_escape_string("$value"); // clean the $_POSTs
	if ($name != 'id') { $query = $query.sprintf("$name = '{$_POST["$name"]}', "); } // Add $_POST item to $query
}
$query = substr_replace($query ,"",-2); //remove the last comma
$query = $query." WHERE id = {$_POST['id']}";
$result = mysql_query($query);
if (!$result) {
    die("$query");
}
mysql_close($con);
header("Location: index.php?ken={$_POST['ken']}");
?>
