<div class="block" id="regions-block"><h3 class="block-title">קנים ואזורים</h3><div class="block-content">
<ul id="browser" class="treeview">
<ul><li class="open"><span id="shmutz-treeview">השומר הצעיר</span>
<?php
require('../con.php');

$con = mysql_connect($db_host,$db_user,$db_pass);
if (!$con)
  {
  die('Could not connect to the server! ' . mysql_error());
  }
if (!mysql_select_db($db_name))
  die("Can't select database");
$myregion = mysql_query("SELECT region_id FROM ken WHERE id = {$myken};"); //check what is the region of $myken
if (!$myregion) {
    die("Query to show fields from table failed myken=$myken");
}
$row = mysql_fetch_array($myregion);
$myregion = $row[0];
if ($uid == 1) {
$regions = mysql_query("SELECT id, name FROM region;"); // Get regions
} else {
$query = "SELECT DISTINCT region.id, region.name FROM region INNER JOIN permissions INNER JOIN ken WHERE region.id = ken.region_id AND permissions.ken_id = ken.id AND permissions.user_id = {$uid};";
$regions = mysql_query($query); // Get regions
}
if (!$regions) {
    die("Query to show fields from table failed");
}
while($reg_row = mysql_fetch_array($regions))
{
    if ($reg_row['id'] == $myregion) { // if it's the region of your ken, open it.
      $region_open = " class='open'";
    } else {
      $region_open = '';
    }
    echo "<ul><li$region_open><span id='region-{$reg_row['id']}' class='region'>{$reg_row['name']}</span>";
    echo "<ul>"; // for the ken
    if ($uid == 1) {
      $kens = mysql_query("SELECT id, name FROM ken WHERE ken.region_id = {$reg_row['id']};"); // Get kens
    } else {
      $kens = mysql_query("SELECT id, name FROM ken INNER JOIN permissions WHERE ken.id = permissions.ken_id AND ken.region_id = {$reg_row['id']} AND permissions.user_id = {$uid};"); // Get kens
    }
    if (!$kens) {
      die("Query to show fields from table failed");
    }
    while($ken_row = mysql_fetch_array($kens))
    {
      if ($ken_row['id'] == $myken) { // if it's your ken color it.
        $ken_open = "ken selected-ken";
    } else {
      $ken_open = 'ken';
    }
      echo "<li><span id='ken-{$ken_row['id']}' class='$ken_open'><a href='index.php?ken={$ken_row['id']}'>{$ken_row['name']}</a></span></li>";
    }
    mysql_free_result($kens);
    echo "</ul>"; // for the ken again
    echo "</li></ul>"; // for the region
}
mysql_free_result($regions);
mysql_close($con);
?>
</ul>
</ul>
</div></div>

