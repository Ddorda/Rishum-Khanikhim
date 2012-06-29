<?php
if ($_SERVER['PHP_SELF'] == '/toolbar.php') {
	header('HTTP/1.0 404 Not Found');
	header('Location: index.php');
	exit();
}
?>

<div id="toolbar">
<?php
tbItem('home', 'index.php', 'דף הבית', 'toolbar-right');
tbItem('newmemb', '#', 'חניך חדש', '');
tbItem('editmemb', '#', 'עריכה', 'toolbar-memb-action');
tbItem('printTable', '#', 'הדפסה', 'toolbar-memb-action');
tbItem('exportTable', '#', 'ייצוא', 'toolbar-memb-action');

tbItem('logout', 'logout.php', 'ניתוק', 'toolbar-left'); 
tbItem('user-settings', 'user-settings.php', 'הגדרות', 'toolbar-left');
tbItem('feedback', 'feedback.php', 'פידבק!', 'toolbar-left');

function tbItem ($machine, $link, $title, $class) { // create a toolbar item
	if (!isset($class))
		$class == '';

	if ($_SERVER["PHP_SELF"] == "/$link") { // if you're on the page $link
		 echo "<ul id='toolbar-$machine' class='$class'><li class='$machine active'><a href='$link' title='$title' class='active'><span class='$machine-link'>$title</span></a></li></ul>";
	} else {
	echo "<ul id='toolbar-$machine' class='$class'><li class='$machine'><a href='$link' title='$title'><span class='$machine-link'>$title</span></a></li></ul>";
	}
}
?>
</div>
