<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!preg_match('[^A-Za-z0-9]', $_POST['username'])) {
		$err_msg = 'שם המשתמש יכול להכיל רק אותיות לועזיות ומסםרים';
	}

        // username and password sent from form 
        $username=$_POST['username'];
        $password=md5($_POST['password']);

	require("users.php");
        if ($users_count == 1) { // username and password matches
                session_start();
                $_SESSION['loggedin'] = md5($username.'hashmutz'.date('Ymd'));
		$_SESSION['username'] = $username;
		$_SESSION['uid'] = $uid;
		$_SESSION['ken'] = $default_ken;
		$_SESSION['headers'] = $headers;
                header("Location: index.php?ken={$default_ken}");
                exit;
        }
        else {
                $err_msg = 'שם המשתמש או הססמה שגויים! אנא נסו שוב או ליחצו על "שכחתי את הססמה".';
        }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
<title>מערכת רישום חניכים - השומר הצעיר</title>
<link href="styles/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="post" id="login">
    <h1>מערכת רישום חניכים</h1>
    <fieldset id="inputs">
        <input name="username" id="username" type="text" placeholder="Username" autofocus required>
        <input name="password" id="password" type="password" placeholder="Password" required>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="התחברות">
        <a href="">שכחתי את הססמה</a>
    </fieldset>
<?php if (isset($err_msg)) { echo "<div id='err-msg'>$err_msg</div>"; } ?>
</form>
<div id='bottom-credit'>המערכת פותחה על־ידי דור דנקנר. כל הזכויות שמורות.</div>
</body>
</html>
