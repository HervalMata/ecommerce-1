<?php // wishlist.php
require('./includes/config.inc.php');
// check for, or create, a user session:
if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) {
	$uid = $_COOKIE['SESSION'];
} else {
	$uid = openssl_random_pseudo_bytes(16);
	$uid = bin2hex($uid);
}
setcookie('SESSION', $uid, time()+(60*60*24*30), '/', 'www.example.com');
$page_title = 'Coffee - Your Wish List';
include('./includes/header.html');
require(MYSQL);
include('./includes/product_functions.inc.php');
if (isset($_GET['sku'])) {
	list($type, $pid) = parse_sku($_GET['sku']);
}
if (isset ($type, $pid, $_GET['action']) && ($_GET['action'] == 'remove') ) {
	$r = mysqli_query($dbc, "CALL remove_from_wish_list('$uid', '$type', $pid)");
} elseif (isset ($type, $pid, $_GET['action'], $_GET['qty']) && ($_GET['action'] == 'move') ) { // Move it to the wish list.
	$qty = (filter_var($_GET['qty'], FILTER_VALIDATE_INT, array('min_range' => 1)) !== false) ? $_GET['qty'] : 1;
	$r = mysqli_query($dbc, "CALL add_to_wish_list('$uid', '$type', $pid, $qty)");
	$r = mysqli_query($dbc, "CALL remove_from_cart('$uid', '$type', $pid)");
} elseif (isset($_POST['quantity'])) {
	foreach ($_POST['quantity'] as $sku => $qty) {
		list($type, $pid) = parse_sku($sku);
		if (isset($type, $pid)) {
			$qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0)) !== false) ? $qty : 1;
			$r = mysqli_query($dbc, "CALL update_wish_list('$uid', '$type', $pid, $qty)");
		}
	} // end of foreach loop.
} // end of main if.
$r = mysqli_query($dbc, "CALL get_wish_list_contents('$uid')");
if (mysqli_num_rows($r) > 0) {
	include('./views/wishlist.html');
} else { // empty cart!
	include('./views/emptylist.html');
}
	include('./includes/footer.html');
?>