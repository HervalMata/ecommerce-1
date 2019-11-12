<?php
// are we live?
if (!defined('LIVE')) DEFINE('LIVE'), false);

// errors are emailed here:
DEFINE('CONTACT_EMAIL', 'njferrari14@gmail.com');

// use IF to set path differently if working on Windows:
if (strtoupper(substr(php_uname('s'), 0, 3)) == 'WIN') {
	define ('BASE_URI', 'C:\xampp\xamppfiles\htdocs\ecommerce\working_ex2\includes\\');
} else {
	define ('BASE_URI', '/Applications/XAMPP/xamppfiles/htdocs/ecommerce/working_ex2/includes/');
}