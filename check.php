<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header("Location: login.php");
	exit;
} else {
	// the session variable exists, let's check it's valid:
	$userexists = false;
	if (md5($_SESSION['username'].'hashmutz'.date('Ymd')) == $_SESSION['loggedin']) {
		$userexists = true;
	}

	if ($userexists == false) {
		header("Location: login.php");
		exit;
	}
}
?>
