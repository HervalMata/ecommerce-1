<?php
// are we live?
if (!defined('LIVE')) DEFINE('LIVE', false);

// errors are emailed here:
DEFINE('CONTACT_EMAIL', 'njferrari14@gmail.com');

// use IF to set path differently if working on Windows:
if (strtoupper(substr(php_uname('s'), 0, 3)) == 'WIN') {
	define ('BASE_URI', 'C:\xampp\xamppfiles\htdocs\ecommerce\working_ex2\includes\\');
} else {
	define ('BASE_URI', '/Applications/XAMPP/xamppfiles/htdocs/ecommerce/working_ex2/includes/');
}
define('BASE_URL', 'localhost/ecommerce/working_ex1/');
define('MYSQL', BASE_URI . 'mysql.inc.php');
define('BOX_BEGIN', '<!-- box begin --><div class="box alt"><div class="left-top-corner"><div class="right-top-corner"><div class="border-top"></div></div></div><div class="border-left"><div class="border-right"><div class="inner">');
define('BOX_END', '</div></div></div><div class="left-bot-corner"><div class="right-bot-corner"><div class="border-bot"></div></div></div></div><!-- box end -->');
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
	// build the error message:
	$message = "An error occured in script '$e_file' on line $e_line:\n$e_message\n";

	// add the backtrace:
	$message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";

	if (!LIVE) { // show the error in the browser

		echo '<div class="error">' . nl2br($message) . '</div>';

	} else { // development (print the error)

		// send the error in an email:
		error_log ($message, 1, CONTACT_EMAIL, 'From:admin@example.com');

		// only print an error message in the browser, if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occured. We aplogize for any inconvenience.</div>';
		}

	} // end of $live if-else

	return true; // so that PHP doesn't try to handle the error too.

} // end of my_error_handler() definition

// use my error handler:
set_error_handler ('my_error_handler');

// omit the closing PHP tag to avoid 'headers already sent' errors