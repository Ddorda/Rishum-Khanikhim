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
<script type="text/javascript" src="scripts/feedback.js"></script>
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
if ($_SESSION['uid'] == 1) {
	require('con.php');

	$query = 'SELECT * FROM feedback;';
	$result=$con->query($query);
	if (!$result) {
	    die("$query");
	}
	echo "<table id='feedback-table'>";
	// printing table rows
	//while($row = mysql_fetch_row($result))
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
	    echo "<tr>";

	    // $row is array... foreach( .. ) puts every element
	    // of $row to $cell variable
	    foreach($row as $cell)
		echo "<td>$cell</td>";

	    echo "</tr>";
	}
	//mysql_free_result($result);
	$result = null;
	echo '</table>';
	//mysql_close($con); 
	$con = null;
}
else {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		require('con.php');

		$_POST['data'] = $con->quote($_POST['data']);
		$query = "INSERT INTO feedback (data) VALUES ('{$_POST['data']}');";
		$result=$con->query($query);
		echo "הודעתך נשלחה בהצלחה, תודה רבה!";
		//mysql_close($con);	
		$con = null;
	}
	else {
		echo "<form id='feedback-form' action='feedback.php' method='post'>
		<h2>יש לך רעיון קטלני? נתקלת בתקלה? שתפו אותי!</h2>
		<textarea id='feedback-data' name='data'></textarea><br>
		<input type='submit' value='שליחה' />
		</form>";
	}
} ?>
</div>
</div>
</body>
</html>
