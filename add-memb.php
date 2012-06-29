<?php
require('con.php');

$query_data = '';
$query = 'INSERT INTO members (';

foreach ($_POST as $name => $value) {
	$_POST["$name"] = mysql_real_escape_string("$value");
	$query_data = $query_data.sprintf("'$name', ");
	$query = $query.sprintf("$name, ");
}
$query_data = $query_data.'CURDATE()';
$query_data = strtr($query_data, $_POST);
$query = $query."register_date) VALUES ({$query_data});";

$result = mysql_query($query);
if (!$result) {
    die("$query");
}
mysql_close($con);
header("Location: index.php?ken={$_POST['ken']}");
?>
