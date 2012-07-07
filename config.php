<?php
$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

try {
        $con = new PDO('mysql:host=$db_host;dbname=$db_name', $db_user, $db_pass);
        $con->exec('SET CHARACTER SET utf8');
} catch (PDOException $e) {
    print 'Error!: ' . $e->getMessage() . '<br/>';
    die();
}
?>
