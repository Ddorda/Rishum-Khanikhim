<?php
if ( !file_exists(  __DIR__ . '/../config.php' ) ) { // if config.php doesn't exist
        header('Location: setup-config.php');
        exit();
}
else {
ini_set('memory_limit', '5120M');
set_time_limit ( 0 );
/***************************************************************************
*
*          code based on sql_parse.php, phpBB. Released ubder GNU terms. Thanks to The phpBB Group!
*
\***************************************************************************/

//
// remove_comments will strip the sql comment lines out of an uploaded sql file
// specifically for mssql and postgres type files in the install....
//
function remove_comments(&$output)
{
   $lines = explode("\n", $output);
   $output = "";

   // try to keep mem. use down
   $linecount = count($lines);

   $in_comment = false;
   for($i = 0; $i < $linecount; $i++)
   {
      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
      {
         $in_comment = true;
      }

      if( !$in_comment )
      {
         $output .= $lines[$i] . "\n";
      }

      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
      {
         $in_comment = false;
      }
   }

   unset($lines);
   return $output;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
   $lines = explode("\n", $sql);

   // try to keep mem. use down
   $sql = "";

   $linecount = count($lines);
   $output = "";

   for ($i = 0; $i < $linecount; $i++)
   {
      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
      {
         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
         {
            $output .= $lines[$i] . "\n";
         }
         else
         {
            $output .= "\n";
         }
         // Trading a bit of speed for lower mem. use here.
         $lines[$i] = "";
      }
   }

   return $output;

}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter)
{
   // Split up our string into "possible" SQL statements.
   $tokens = explode($delimiter, $sql);

   // try to save mem.
   $sql = "";
   $output = array();

   // we don't actually care about the matches preg gives us.
   $matches = array();

   // this is faster than calling count($oktens) every time thru the loop.
   $token_count = count($tokens);
   for ($i = 0; $i < $token_count; $i++)
   {
      // Don't wanna add an empty string as the last thing in the array.
      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
      {
         // This is the total number of single quotes in the token.
         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
         // Counts single quotes that are preceded by an odd number of backslashes,
         // which means they're escaped quotes.
         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

         $unescaped_quotes = $total_quotes - $escaped_quotes;

         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
         if (($unescaped_quotes % 2) == 0)
         {
            // It's a complete sql statement.
            $output[] = $tokens[$i];
            // save memory.
            $tokens[$i] = "";
         }
         else
         {
            // incomplete sql statement. keep adding tokens until we have a complete one.
            // $temp will hold what we have so far.
            $temp = $tokens[$i] . $delimiter;
            // save memory..
            $tokens[$i] = "";

            // Do we have a complete statement yet?
            $complete_stmt = false;

            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
            {
               // This is the total number of single quotes in the token.
               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
               // Counts single quotes that are preceded by an odd number of backslashes,
               // which means they're escaped quotes.
               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

               $unescaped_quotes = $total_quotes - $escaped_quotes;

               if (($unescaped_quotes % 2) == 1)
               {
                  // odd number of unescaped quotes. In combination with the previous incomplete
                  // statement(s), we now have a complete statement. (2 odds always make an even)
                  $output[] = $temp . $tokens[$j];

                  // save memory.
                  $tokens[$j] = "";
                  $temp = "";

                  // exit the loop.
                  $complete_stmt = true;
                  // make sure the outer loop continues at the right point.
                  $i = $j;
               }
               else
               {
                  // even number of unescaped quotes. We still don't have a complete statement.
                  // (1 odd and 1 even always make an odd)
                  $temp .= $tokens[$j] . $delimiter;
                  // save memory.
                  $tokens[$j] = "";
               }

            } // for..
         } // else
      }
   }

   return $output;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>מערכת רישום חניכים - התקנה</title>
<link rel="stylesheet" href="setup.css" type="text/css">
</head>
<body class='rtl'>
<?php
require(__DIR__.'/../config.php');

$admins_num = $con->query("SELECT count(*) FROM `users` WHERE id = 1;")->fetchColumn();
$test = true;

if ( $admins_num > 0 ) { // There's already an admin!
	die("נראה כי המערכת כבר הותקנה!</body></html>"); 
}
else {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$dbms_schema = 'basic.sql';

		$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
		$sql_query = remove_remarks($sql_query);
		$sql_query = split_sql_file($sql_query, ';');

		$i=1;
		foreach($sql_query as $sql){
		//      $con->query($sql);
		}
		
		foreach ($_POST as $key => $value)
			$_POST[$key] = $con->quote($value);
		
		$query = "INSERT INTO users (id, name, pass, default_ken, register_date) VALUES (1, {$_POST['uname']}, md5({$_POST['pwd']}), 66, now());"; // !!! Currently Zafit (66) is the default ken!
		$con->query($query) or die("error!");
?>
ההתקנה הסתיימה בהצלחה!<br />
מומלתץ בחום למחוק את התיקייה Install או לשנות את שמה כדי למנוע תקיפות!<br />
<p class="step"><a href="../login.php" class="button">התחברות!</a></p>
<?php
	}
	else {
?>
<form method="post" action="install.php">
        <p>אנא מלאו את פרטי משתמש האדמין בשדות הבאים:</p>
        <table class="form-table">
                <tbody><tr>
                        <th scope="row"><label for="uname">שם משתמש</label></th>
                        <td><input name="uname" id="uname" type="text" size="25" placeholder="שם משתמש"></td>
                        <td>שם משתמש לאדמין</td>
                </tr>
                <tr>
                        <th scope="row"><label for="pwd">ססמה</label></th>
                        <td><input name="pwd" id="pwd" type="text" size="25" placeholder="ססמה"></td>
                        <td>סיסמת האדמין</td>
                </tr>
        </tbody></table>
                <p class="step"><input name="submit" type="submit" value="שלח" class="button"></p>
</form>
<?php
	}
}
}
?>
</body></html>
