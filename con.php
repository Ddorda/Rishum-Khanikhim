<?php
$db_host = 'localhost';
$db_name = '';
$db_user = '';
$db_pass = '';

$con = mysql_connect($db_host,$db_user,$db_pass);

if (!$con) // Make sure connected to the server
  die('Could not connect to the server! ' . mysql_error());

if (!mysql_select_db($db_name)) // Make sure DB selected
  die('Can\'t select database');

mysql_set_charset('utf8', $con); // Make sure it's UTF8
?>
