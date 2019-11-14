<?php
require('./includes/config.inc.php');
if (isset($_GET['type']) && ($_GET['type'] === 'goodies')) {
	$page_title = 'Our Goodies, by Category';
	$type = 'goodies';
} else {
	$page_title = 'Our Coffee Products';
	$type = 'coffee';
}
include('./includes/header.php');
require(MYSQL);
$r = mysqli_query($dbc, "CALL select_categories('$type')");
if (mysqli_num_rows($r) > 0) {
	include('./views/list_categories.php');
} else {
	include('./views/error.php');
}
include('./includes/footer.php');