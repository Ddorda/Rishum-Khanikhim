<?php
require('check.php');
if (isset($_GET["ken"])) {
$myken = $_GET['ken'];
} else {
$myken = $_SESSION['ken'];
}

$uid = $_SESSION['uid'];
//print_r $_SESSION['headers'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
<title>מערכת רישום חניכים - השומר הצעיר</title>
<?php require('cssjs.php'); ?>
</head>
<body onload="loadTable(<?php echo $myken; ?>)">
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
include 'site-updates.php';
include 'table-content.php';
?>
</div>
</div>
<?php include 'memb-table.php'; ?>
</body>
</html>
