<?php
//Please fill the details below as asked.
$db_host = ''; // Your MySQL host address. usually localhost. if you use different port, please use "129.0.0.1:port" (your port after the colon)
$db_name = ''; // Your MySQL database name. must exist.
$db_user = ''; // Your MySQL username.
$db_pass = ''; // Your MySQL password.


// DON'T TOUCH!!!
try {
        $con = new PDO("mysql:host=$db_host;dbname=$db_name', $db_user, $db_pass");
        $con->exec('SET CHARACTER SET utf8');
} catch (PDOException $e) {
    print 'Error!: ' . $e->getMessage() . '<br/>';
    die();
}
?>
