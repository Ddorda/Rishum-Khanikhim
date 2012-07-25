<?php
if ( file_exists(  __DIR__ . '/../config.php' ) ) { // if config.php already created.
        header('Location: install.php');
        exit();
}
else {
        header('Location: setup-config.php');
        exit();
}
?>
