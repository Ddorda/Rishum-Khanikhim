<?php
	require('con.php');
        $tbl_name='users'; // Table name

        // To protect MySQL injection (more detail about MySQL injection)
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);


        $sql="SELECT * FROM $tbl_name WHERE name = '$username' AND pass = '$password';";
        $result=mysql_query($sql);

        $users_count=mysql_num_rows($result);
	if ($users_count != 0) { $users_row = mysql_fetch_array($result)or die(mysql_error()); }
	$default_ken = $users_row['default_ken'];
	$uid = $users_row['id'];

	$sql="SELECT header_id FROM table_settings WHERE user_id = $uid;";
	$result=mysql_query($sql);

	$headers = array();
	while($row = mysql_fetch_array($result)) {
		foreach ($row as $cell)
		$headers[$cell] = true;
	}

        // Mysql_num_row is counting table row
        // If result matched $username and $password, table row must be 1 row
        mysql_free_result($result);
        mysql_close($con);

?>
