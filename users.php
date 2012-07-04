<?php
	require('con.php');
        $tbl_name='users'; // Table name

        // To protect MySQL injection (more detail about MySQL injection)
        // username and password sent from form 

        $username = $con->quote($_POST['username']);
        $password = $con->quote(md5($_POST['password']));

	$query = "SELECT count(*) FROM $tbl_name WHERE name = $username AND pass = $password;";
	$result = $con->query($query);
        $users_count=$result->fetchColumn();
	$result = null;

        $query = "SELECT * FROM $tbl_name WHERE name = $username AND pass = $password;";
        $result = $con->query($query);

	if ($users_count != 0) { $users_row = $result->fetch(PDO::FETCH_ASSOC)or die('ERROR!'); }
	$default_ken = $users_row['default_ken'];
	$uid = $users_row['id'];
	$result = null;

	$query="SELECT header_id FROM table_settings WHERE user_id = $uid;";
	$result=$con->query($query);

	$headers = array();
	foreach($result as $row) {
		foreach ($row as $cell)
		$headers[$cell] = true;
	}
	$result = null;
	$con = null;
?>
