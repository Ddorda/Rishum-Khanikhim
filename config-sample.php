<?php
//Please fill the details below as asked and save under "config.php".

// Your MySQL host address. usually localhost. if you use different port, please use "129.0.0.1:port" (your port after the colon).
define('DB_HOST', 'localhost');

// Your MySQL database name. must exist.
define('DB_NAME', 'database_name');

// Your MySQL username.
define('DB_USER', 'your_username');

// Your MySQL password.
define('DB_PASS', 'your_password');


// DON'T TOUCH!!!
try {
        $con = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
} catch (PDOException $e) {
    print 'Error!: ' . $e->getMessage() . '<br/>';
    die();
}
?>
