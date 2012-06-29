<?php
require('check.php');

$ken = intval($_GET["ken"]);
$uid = intval($_SESSION["uid"]);

$return_arr = Array();

$anydata = true;
require('con.php');

$con = mysql_connect($db_host,$db_user,$db_pass);
if (!$con)
  {
  die('Could not connect to the server! ' . mysql_error());
  }
if (!mysql_select_db($db_name))
  die("Can't select database");

$details = 'members.id, pname, members.fname, gender.shortname AS gender, members.id_num,members.birth_date, members.team, class.name AS class, city.name AS city, members.address, members.zip_code, members.phone, members.cell_phone, members.email, shirt.name AS shirt, members.medical, members.notes, members.dad, members.dad_cell, members.dad_job, members.mom, members.mom_cell, members.mom_job, members.parent_email FROM members, class, ken, city, shirt, gender';
if ($uid == 1) {
$query = "SELECT $details WHERE members.class = class.id AND members.ken = ken.id AND members.city = city.id AND members.shirt = shirt.id AND gender.id = members.gender AND members.ken = {$ken};";
} else {
$query = "SELECT $details INNER JOIN permissions WHERE members.class = class.id AND members.ken = ken.id AND members.city = city.id AND members.shirt = shirt.id AND gender.id = members.gender AND members.ken = {$ken} AND ken.id = permissions.ken_id AND permissions.user_id = {$uid};";
}
$result = mysql_query($query);
if (!$result) {
    die("Query to show fields from table failed $query");
}
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    array_push($return_arr,$row);
}
echo json_encode($return_arr);

mysql_free_result($result);
mysql_close($con);
?>
