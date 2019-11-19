<?php
require('./includes/config.inc.php');
session_start();
$uid = session_id();
if (!isset($_SESSION['customer_id'])) {
	$location = 'https://' . BASE_URL . 'checlout.php';
	header("Location: $location");
	exit();
}
require(MYSQL);
$billing_errors = array();
$page_title = 'Coffee - Checkout - Your Billing Information';
include('./includes/checkout_header.php');
$r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
if (mysqli_num_rows($r) > 0) {
	if (isset($_SESSION['shipping_for_billing']) && ($_SERVER['REQUEST_METHOD'] !== 'POST')) {
		$values = 'SESSION';
	} else {
		$values = 'POST';
	}
	include('./views/billing_view.php');
} else { // empty cart
	include('./views/emptycart.php');
}
include('./includes/footer.php');
?>