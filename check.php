<?php
if ( file_exists( __dir__ . '/install' ) )
	die("Install folder still exists! Please delete it to start using the system.<br />If you didn't install the system yet, do it from <a href='/install'>here!</a>");

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
