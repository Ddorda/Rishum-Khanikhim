<div class="block" id="teams-block"><h3 class="block-title">קבוצות בקן</h3><div class="block-content">
<?php
require('../con.php');

$con = mysql_connect($db_host,$db_user,$db_pass);
if (!$con)
  {
  die('Could not connect to the server! ' . mysql_error());
  }
if (!mysql_select_db($db_name))
  die("Can't select database");
//$myregion = mysql_query("SELECT region_id FROM ken WHERE id = {$myken};"); //check what is the region of $myken
$myteams = mysql_query("SELECT DISTINCT team.name FROM team, membersInTeams WHERE team.id = membersInTeams.team_id");
if (!$myteams) {
    die("Query to show fields from table failed myken=$myken");
}
$rows_num = mysql_num_rows($myteams);
while($row = mysql_fetch_array($myteams)) {
	echo "- {$row['name']}<br>";
}
mysql_free_result($myteams);
mysql_close($con);
?>
</div></div>

