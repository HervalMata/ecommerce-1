<?php
if (!defined('LIVE')) DEFINE('LIVE', false);
DEFINE('CONTACT_EMAIL', 'you@example.com');
if (strtoupper(substr(php_uname('s'), 0, 3)) == 'WIN') {
	define ('BASE_URI', 'C:\xampp\xamppfiles\htdocs\ecommerce\working_ex1\includes\\');
} else {
	define ('BASE_URI', '/Applications/XAMPP/xamppfiles/htdocs/ecommerce/working_ex1/includes/');
}
define('BASE_URL', 'localhost/ecommerce/working_ex1/');
define('MYSQL', BASE_URI . 'mysql.inc.php');
session_start();
// define error handling
function my_error_handler($e_number, $e_message, $e_file,
 $e_line, $e_vars) {
	$message = "An error occured in script '$e_file' on e_line
			$e_line:\n$e_message\n";
	$message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";
	if (!LIVE) {
		echo '<div class="aler alert-danger">' . nl2br($message)
		 . '</div>';
	} else {
		error_log($message, 1, CONTACT_EMAIL,
		 'From:admin@example.com');
		if ($e_number != E_NOTICE) {
			echo '<div class="alert alert-danger">A system error
					occured. We apologize for the incnvenience.</div>';
		}
	} // end of live if/else
} // end of my_error_handler() def
// define redirect function
function redirect_invalid_user($check = 'user_id', $destination = 'index.php', $protocol = 'http://') {
	if (!isset($_SESSION[$check])) {
		$url = $protocol . BASE_URL . $destination;
		header("Location: $url");
		exit();
	} 
}
// set error handler
set_error_handler('my_error_handler');