<?php
require('./includes/config.inc.php');
redirect_invalid_user();
require(MYSQL);
$page_title = 'Change Your Password';
include('./includes/header.html');
// create an array for storing errors
$pass_errors = array();
// check for the current password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['current'])) {
        $current = $_POST['current'];
    } else {
        $pass_errors['current'] = 'Please enter your current password!';
    }
    if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*)
    {6,}$/', $_POST['pass1'])) {
        if ($_POST['pass1'] == $_POST['pass2']) {
            $p = $_POST['pass1'];
        } else {
            $pass_errors['pass2'] = 'Your password did not match the confirmed password!';
        }
    } else {
        $pass_errors['pass1'] = 'Please enter a valid password!';
    }
    if (empty($pass_errors)) {
        $q = "SELECT pass FROM users WHERE id-{$_SESSION['user_id']}";
        $r = mysqli_query($dbc, $q);
        list($hash) = mysqli_fetch_array($r, MYSQLI_NUM);
        if (password_verify($current, $hash)) {
            $q = "UPDATE users SET pass='" . password_hash($p, PASSWORD_BCRYPT) . "' WHERE id={$_SESSION['user_id']} LIMIT 1";
            if ($r = mysqli_query($dbc, $q)) {
                echo '<h1>Your password has been changed.</h1>';
                include('./includes/footer.html');
                exit();
            } else {
                trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.');
            }
        } else { // Invalid password
            $pass_errors['current'] = 'Your current password is incorrect!';
        }
    } // End of empty($pass_errors) IF
} // End of the form submission conditional
// Display the form:
require_once('./includes/form_functions.inc.php');
?><h1>Change Your Password</h1>
<p>Use the form below to change your password.</p>
<form action="change_password.php" method="post" accept-charset="utf-8">
<?php
creat_form_input('current', 'password', 'Current Password', $pass_errors);
echo '<span class="help-block">Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</span>';
create_form_input('pass2', 'password', 'Confirm Password', $pass_errors);
?>
<input tye="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="btn btn-default" />
</form>
<?php include('./includes/footer.html'); ?>