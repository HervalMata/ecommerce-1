<?php
DEFINE ('DB_USER', 'nf0164323');
DEFINE ('DB_PASSWORD', 'red28car');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'ecommerce1');
// connect to the database
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($dbc, 'utf8');
// sanitize data to prevent SQL injection
function escape_data ($data, $dbc) {
	if (get_magic_quotes_gpc()) $data = stripslashes($data);
	return mysqli_real_escape_string ($dbc, trim ($data));
}