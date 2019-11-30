<?php
require('./includes/config.inc.php');
require(MYSQL);
$page_title = 'Forgot Your Password?';
include('./includes/header.php');
$pass_errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$q = 'SELECT id FROM users WHERE email="'.
		escape_data($_POST['email'], $dbc) . '"';
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) === 1) {
			list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
		} else {
			$pass_errors['email'] = 'The submitted email address
			does not match those on file!';
		}
	} else {
		$pass_errors['email'] = 'Please enter a valid email address!';
	} // End of $_POST['email'] IF
	if (empty($pass_errors)) {
		$token = openssl_random_pseudo_bytes(32);
		$token = bin2hex($token);
		$q = 'REPLACE INTO access_tokens (user_id, token, date_expires) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'is', $uid, $token);
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_affected_rows($stmt) === 1) {
			$url = 'https://' . BASE_URL . 'reset.php?t=' . $token;
			$body = "This email is in response to a forgotten password reset request at 'Knowledge is Power'. If you did make this request, click the following link to be able to access your account:
			$url
			For security purposes, you have 15 minutes to do this. If you do not click this link within 15 minutes, you'll need to request a password reset again.
			If you have _not_ forgotten your password, you can safely ignore this message and you will still be able to login with your existing password. ";
			mail($email, 'Password Reset at Knowledge is Power', $body, 'FROM: ' . CONTACT_EMAIL);
			echo '<h1>Reset Your Password</h1><p>You will receive an access code via email. Click the link in that email to gain access to the site. Once you have done that, you may then change your password.</p>';
			include('./includes/footer.html');
			exit();
		} else { // If it did not run OK.
			trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.');
			}
	} // End of $uid IF
} // End of the main Submit conditional
require_once('./includes/form_functions.inc.php');
?><h1>Reset Your Password</h1>
<p>Enter your email address below to reset your password.</p>
<form action="forgot_password.php" method="post" 
accept-charset="utf-8">
<?php create_form_input('email', 'email', 'Email Address',
$pass_errors); ?>
<input type="submit" name="submit_button" value="Reset &rarr;" 
id="submit_button" class="bt btn-default" />
</form>
<?php include('./includes/footer.html'); ?>