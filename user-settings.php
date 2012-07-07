<?php
require('check.php');
if (isset($_GET["ken"])) {
$myken = $_GET['ken'];
} else {
$myken = $_SESSION['ken'];
}

$uid = $_SESSION['uid'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
<title>מערכת רישום חניכים - השומר הצעיר</title>
<?php require('cssjs.php'); ?>
</head>
<body>
<?php require 'toolbar.php'; ?>
<div id="container">
<div id="sidebar">
<?php
foreach (glob("blocks/*.php") as $filename)
{
    include $filename;
}
?>
</div>
<div id="content">
<?php
echo '<h2>בקרוב כאן יהיה עמוד הגדרות משתמש.</h2>';
require('config.php');

$query = "SELECT column_name FROM information_schema.columns WHERE table_name = 'members';";
$result=$con->query($query);

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	foreach($row as $cell) {
		if ($cell != 'id')
			echo $cell.'<br>';
	}
}
$result = null;
$con = null;
?>
</div>
</div>
</body>
</html>
