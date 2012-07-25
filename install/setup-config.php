<?php
/* Setup proccess is based on Wordpress Installation. Long live open source :) */

$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : 0;
define('ABSPATH', dirname(__FILE__).'/');

if ( ! file_exists( ABSPATH . '../config-sample.php' ) )
	die( 'סליחה, אבל אני צריך את הקובץ config-sample.php כדי לעבוד. אנא בידקו את ההורדה.' );
$config_file = file( ABSPATH . '../config-sample.php' );

if ( file_exists(  ABSPATH . '../config.php' ) ) { // if config.php already created.
	header('Location: install.php');
	exit();
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>מערכת רישום חניכים - התקנה</title>
<link rel="stylesheet" href="setup.css" type="text/css">
</head>
<?php
switch($step) {
	case 0:
?>
<body class='rtl'>
<p>ברוכים הבאים למערכת רישום חניכים. נא להזין את הגדרות מסד הנתונים.</p>
<ol>
	<li>שם מסד הנתונים</li>
	<li>משתמש במסד הנתונים</li>
	<li>סיסמת מסד נתונים</li>
	<li>שרת (host) מסד נתונים</li>
	<li>קידומת טבלה (להפעלת יותר מאתר אחד על מסד הנתונים)</li>
</ol>
<p><strong>אם מסיבה כלשהי הקובץ לא יווצר באופן אוטומטי, אל תדאג. כל שזה עושה הוא למלא את פרטי מסד הנתונים לקובץ התצורה. ניתן לעשות זאת ידנית על ידי פתיחת הקובץ <code>config-sample.php</code> בכל עורך טקסט, למלא את הפרטים ולשמור בשם <code>config.php</code>.</strong></p>
<p>סביר להניח, כי פריטים אלה סופקו על ידי הספק המארח. אם אין לך את המידע הזה, ניתן לפנות אל הספק לפני שתוכל להמשיך. אם אתה מוכן...</p>
<p class="step"><a href="setup-config.php?step=1" class="button">המשך</a></p>
<?php
	break;
	case 1:
?>
<body class='rtl'>
<form method="post" action="setup-config.php?step=2">
	<p>יש להזין את פרטי ההתחברות למסד הנתונים. אם אינכם בטוחים, צרו קשר עם חברת האכסון שלכם.</p>
	<table class="form-table">
		<tbody><tr>
			<th scope="row"><label for="dbname">בסיס נתונים</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="rishum"></td>
			<td>שם בסיס הנתונים בו תשתמש המערכת.</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">שם משתמש</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="שם משתמש"></td>
			<td>משתמש MySQL</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">ססמה</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="ססמה"></td>
			<td>סיסמת MySQL</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">שרת מסד נתונים</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost"></td>
			<td>אם <code>localhost</code> לא עובד, צרו קשר עם חברת האיחסון</td>
		</tr>
	</tbody></table>
		<p class="step"><input name="submit" type="submit" value="שלח" class="button"></p>
</form>
<?php
	break;
	case 2:
	foreach ( array( 'dbname', 'uname', 'pwd', 'dbhost' ) as $key )
		$$key = trim( stripslashes( $_POST[ $key ] ) );

	try{
		$dbh = new pdo( "mysql:host=$dbhost;dbname=$dbname", $uname, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		// succeed connecting to the DB!

		print_r($config_file);
		echo "\n\n";


		foreach ( $config_file as &$line ) {

			if ( ! preg_match( '/^define\(\'([A-Z_]+)\',\ \'(.+)\'/', $line, $match ) ) {
				continue;
			}

			$constant = $match[1];
			$padding  = $match[2];

			switch ( $constant ) {
				case 'DB_NAME'     :
					$padding = $dbname;
					break;
				case 'DB_USER'     :
					$padding = $uname;
					break;
				case 'DB_PASS'     :
					$padding = $pwd;
					break;
				case 'DB_HOST'     :
                                        $padding = $dbhost;
					break;
			}
			$line = "define('" . $constant . "', '" . $padding . "');\r\n";
		}
		print_r($config_file);
		unset( $line );

		if ( ! is_writable(ABSPATH) ) :
?>
<body class="rtl">
<p>לא ניתן ליצור את הקובץ <code>config.php</code>.</p>
<p>ניתן ליצור את <code>config.php</code> באופן ידני ולהדביק לתוכו את הטקסט הבא.</p>
<textarea cols="98" rows="15" class="code"><?php
		foreach( $config_file as $line ) {
			echo htmlentities($line, ENT_COMPAT, 'UTF-8');
		}
?></textarea>
<p>בסיום, הקישו "התקנה".</p>
<p class="step"><a href="setup-config.php?step=3" class="button">התקנה</a></p>
<?php
		else :
			$handle = fopen(ABSPATH . '../config.php', 'w');
			foreach( $config_file as $line ) {
				fwrite($handle, $line);
			}
			fclose($handle);
			chmod(ABSPATH . '../config.php', 0666);
?>
<body class="rtl">
<p>שלב ההגדרות הושלם, ונמצא חיבור עובד לבסיס הנתונים. בשלב הבא תבוצע התקנה של המערכת.</p>
<p class="step"><a href="setup-config.php?step=3" class="button">התקנה</a></p>
<?php
		endif;
	}
	catch(PDOException $ex){ // couldn't connect to the DB
?>
<body id="error-page">
	<p></p><div dir="rtl" style="direction:rtl; text-align:right;">

<h1>שגיאת התחברות למסד הנתונים</h1>
<p>שם המשתמש ו/או הסיסמה שהוגדרו בקובץ <code>config.php</code> אינם נכונים, או שאי אפשר להתחבר לשרת בכתובת <code>localhost</code>. ייתכן גם שהשרת לא זמין כרגע.</p>
<ul>
	<li>יש לוודא ששם המשתמש והסיסמה נכונים, ושהם הוקלדו ללא שגיאות בקובץ ההגדרות.</li>
	<li>יש לוודא שכתובת שרת בסיס הנתונים נכונה.</li>
	<li>יש לוודא שהשרת אכן פעיל וזמין.</li>
</ul>
<p>אם אינך איש טכני, מומלץ לפנות למחלקת התמיכה של ספקית האחסון שלך.</p>

</div><p></p><p class="step"><a href="setup-config.php?step=1" onclick="javascript:history.go(-1);return false;" class="button">לנסות שוב</a></p>
<?php
	}
	break;
}
?>
</body></html>
