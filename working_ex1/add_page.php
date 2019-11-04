<?php
require('./includes/config.inc.php');
redirect_invlaid_user('user_admin');
require(MYSQL);
$page_title = 'Add a Site Content Page';
include('./includes/header.html');
$add_page_errors = array();
if (!empty($_POST['title'])) {
	$t = escape_data(strip_tags($_POST['title']), $dbc);
} else {
	$add_page_errors['title'] = 'Please enter the title!';
}