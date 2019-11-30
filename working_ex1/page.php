<?php
require(./'includes/config.inc.php');
require(MYSQL);
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	$page_id = $_GET['id'];
	$q = 'SELECT title, description, content, FROM pages WHERE id=' . $page_id;
	$r = mysqli_query($dbc, $q);
	if (mysql_num_rows($r) !== 1) {
		$page_title = 'Error!';
		include('./includes/header.php');
		echo '<div class="alert alert-danger">This page has been accessed in error.</div>';
		include('./includes/footer.html');
		exit();
	}
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];
	include('./includes/header.php');
	echo '<h1>' . htmlspecialchars($page_title) . '</h1>';
	if (isset($_SESSION['user_not_expired'])) {
		echo "<div>{$row['content']}</div>";
	} elseif (isset($_SESSION['user_id'])) {
		echo '<div class="alert"><h4>Expired Account</h4>Thank you for your interest in this content, but your account is no longer current. Please <a href="renew.php">renew your account</a> in order to view this page in its entirety.</div>';
		echo '<div>' . htmlspecialchars($row['description']) . '</div>';
	} else {
		echo '<div class="alert">Thank you for your interest in this content. You must be logged in as a registered user to view this page in its entirety.</div>';
		echo '<div>' . htmlspecialchars($row['description']) . '</div>';
	}
} else { // no valid id
	$page_title = 'Error!';
	include('includes/header.php');
	echo '<div class="alert alert-danger">This page has been accessed in error.</div>';
} // end of primary if
if ($_SERVER[‘REQUEST_METHOD’] === ‘POST’) {
	if (isset($_POST[‘notes’]) && !empty($_POST[‘notes’])) {
		$notes = $_POST[‘notes’];
		if (isset($_SESSION[‘user_not_expired’])) {
			echo “<div>{$row[‘content’]}</div>”;
			$q = “REPLACE INTO notes (user_id, page_id, note) VALUES ($user_id, $page_id, ‘” . escape_data($notes, $dbc) . “’)”;
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) > 0) {
			echo ‘<div class=”alert alert-success”>Your notes have been saved.</div>’;
			}
		}
	}
	if (!isset($notes)) {
		$q = “SELECT note FROM notes WHERE user_id=$user_id AND page_id=$page_id”;
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) === 1) {
		list($notes) = mysqli_fetch_array($r, MYSQLI_NUM);
		}
	}
		echo ‘<form action=”page.php ?id=’ . $page_id . ‘” method=”post” accept-charset=”utf-8”><fieldset><legend>Your Notes</legend><textarea name=”notes” class=”form-control”>’;
		if (isset($notes) && !empty($notes)) echo htmlspecialchars($notes);
		echo ‘</textarea><br><input type=”submit” name=”submit_button” value=”Save” id=”submit_button” class=”btn btn-default” /></fieldset></form>’;
}
include('./includes/footer.html');
?>