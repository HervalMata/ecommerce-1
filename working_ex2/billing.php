<?php
require('./includes/config.inc.php');
session_start();
$uid = session_id();
if (!isset($_SESSION['customer_id'])) {
	$location = 'https://' . BASE_URL . 'checkout.php';
	header("Location: $location");
	exit();
}
require(MYSQL);
$billing_errors = array();
$page_title = 'Coffee - Checkout - Your Billing Information';
if (SERVER['REQUEST_METHOD'] === 'POST') {
	if (get_magic_quotes_gpc()) {
		$_POST['cc_first_name'] = stripslashes($_POST['cc_first_name']);
		// repeat for other variables that may be affected
	}
	if (preg_match('/^[A-Z \'.-]{2,20}$/i', $_POST['cc_first_name'])) {
		$cc_first_name = $_POST['cc_first_name'];
	} else {
		$billing_errors['cc_first_name'] = 'Please enter your first name!';
	}
	if (preg_match('/^[A-Z \'.-]{2,20}$/i', $_POST['cc_last_name'])) {
		$cc_last_name = $_POST['cc_last_name'];
	} else {
		$billing_errors['cc_last_name'] = 'Please enter your lastt name!';
	}
	$cc_number = str_replace(array(' ', '-'), '', $_POST['cc_number']);
	if (!preg_match ('/^4[0-9]{12}(?:[0-9]{3})?$/', $cc_number) // Visa
		&& !preg_match ('/^5[1-5][0-9]{14}$/', $cc_number) // MasterCard
		&& !preg_match ('/^3[47][0-9]{13}$/', $cc_number) // American Express
		&& !preg_match ('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $cc_number)) // Discover 
	{
		$billing_errors['cc_number'] = 'Please enter your credit card number!';
	}
	if (($_POST['cc_exp_month'] < 1 || $_POST['cc_exp_month'] > 12)) {
		$billing_errors['cc_exp_month'] = 'Please enter your expiration month!';
	}
	if ($_POST['cc_exp_month'] < date('Y')) {
		$billing_errors['cc_exp_month'] = 'Please enter your expiration year!';
	}
	if (preg_match ('/^[0-9]{3,4}$/', $_POST['cc_cvv'])) {
		$cc_cvv = $_POST['cc_cvv'];
	} else {
		$billing_errors['cc_cvv'] = 'Please enter your CVV!';
	}
	if (preg_match ('/^[A-Z0-9 \',.#-]{2,160}$/i', $_POST['cc_address'])) {
		$cc_address = $_POST['cc_address'];
	} else {
		$billing_errors['cc_address'] = 'Please enter your street address!';
	}
	if (preg_match ('/^[A-Z \'.-]{2,60}$/i', $_POST['cc_city'])) {
		$cc_city = $_POST['cc_city'];
	} else {
		$billing_errors['cc_city'] = 'Please enter your city!';
	}
	if (preg_match ('/^[A-Z]{2}$/', $_POST['cc_state'])) {
		$cc_state = $_POST['cc_state'];
	} else {
		$billing_errors['cc_state'] = 'Please enter your state!';
	}
	if (preg_match ('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['cc_zip'])) {
		$cc_zip = $_POST['cc_zip'];
	} else {
		$billing_errors['cc_zip'] = 'Please enter your zip code!';
	}
	if (empty($billing_errors)) {
		$c_exp = sprintf('%02d%d', $_POST['cc_exp_month'], $_POST['cc_exp_year']);
		if (isset($_SESSION['order_id'])) {
			$order_id = $_SESSION['order_id'];
			$order_total = $_SESSION['order_total'];
		} else {
			$cc_last_four = substr($cc_number, -4);
			$shipping = $_SESSION['shipping'] * 100;
			$r = mysqli_query($dbc, "CALL add_order({$_SESSION['customer_id']}, '$uid', $shipping, $cc_last_four, @total, @oid)");
		}
		if($r) {
			$r = mysqli_query($dbc, 'SELECT @total, @oid');
			if (mysqli_num_rows($r) == 1) {
				list($order_total, $order_id) = mysqli_fetch_array($r);
				$_SESSION['order_total'] = $order_total;
				$_SESSION['order_id'] = $order_id;
			} else { // could not retrieve the order id and total
				unset($cc_number, $cc_cvv, $_POST['cc_number'], $_POST['cc_cvv']);
				trigger_error('Your order could not be processed due to a system error. We apologize for the inconvenience.');
			} else { // the add_order() procedure failed
				unset($cc_number, $cc_cvv, $_POST['cc_number'], $_POST['cc_cvv']);
				trigger_error('Your order could not be processed due to  system error. We apologize for the inconvenience.');
			}
		} // end of isset($_SESSION['order_id']) if-else
		if (isset($order_id, $order_total)) {
			require('includes/vendor/anet_php_sdk/AuthorizeNet.php');
			$aim = new AuthorizeNetAIM(API_LOGIN_ID, TRANSACTION_KEY);
			$aim->amount = $order_total/100;
			$aim->invoice_num = $order_id;
			$aim->cust_id = $_SESSION['customer_id'];
			$aim->card_num = $cc_number;
			$aim->exp_date = $cc_exp;
			$aim->card_code = $cc_cvv;
			$aim->first_name = $cc_first_name;
			$aim->last_name = $cc_last_name;
			$aim->address = $cc_address;
			$aim->state = $cc_state;
			$aim->city = $cc_city;
			$aim->zip = $cc_zip;
			$aim->email = $_SESSION['email'];
			$response = $aim->authorizeOnly();
			$reason = addslashes($response->respone_reason_text);
			$full_response = addslashes($response->response);
			$r =mysqli_query($dbc, "CALL add_transaction($order_id, '{$response->transaction_type}', $order_total, {$response->response_code}, '$reason', {$response->transaction_id}, '$full_response')");
			if ($response->approved) {
				$_SESSION['response_code'] = $response_code;
				$location = 'https://' . BASE_URL . 'final.php';
				header("Location: $location");
				exit();
			} else {
				switch ($response->response_code) {
					case '2'; // declined
						$message = 	$response->response_reason_text . ' Please fix the error or try another card.';
						break;
					case '3': // error
						$message = $response->response_reason_text . ' Please fix the error or try another card.';
						break;
					case '4': // held for review
						$message = "The transaction is being held for review. You will be contacted ASAP about your order. We aplogize for any inconvenience.";
						break;
				}
			} // end of $response_array[0] if-else
		}
	} // errors occured if
} // end of REQUEST_METHOD if
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