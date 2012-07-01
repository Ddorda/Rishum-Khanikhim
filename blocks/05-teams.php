<div class="block" id="teams-block"><h3 class="block-title">קבוצות בקן</h3><div class="block-content">
<?php
require(__DIR__.'/../con.php');
//$myregion = mysql_query("SELECT region_id FROM ken WHERE id = {$myken};"); //check what is the region of $myken

$myteams = $con->query("SELECT DISTINCT team.name FROM team, membersInTeams WHERE team.id = membersInTeams.team_id");
if (!$myteams) {
    die("Query to show fields from table failed myken=$myken");
}

$rows_num = $con->query("SELECT DISTINCT count(team.name) FROM team, membersInTeams WHERE team.id = membersInTeams.team_id");
$rows_num = $rows_num->fetchColumn();

while ($row = $myteams->fetch(PDO::FETCH_ASSOC))
{
	echo "- {$row['name']}<br>";
}
$rows_num = null;
$myteams = null;
$con = null;
?>
</div></div>

