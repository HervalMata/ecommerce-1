<?php
require('../includes/config.inc.php');
if (isset($_POST['page_id'], $_POST['notes'], $_SESSION['user_id']) && filter_var($_POST['page_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) && filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    require(MYSQL);
    if (empty($_POST['notes'])) {
        $q ='DELETE FROM notes WHERE user_id=? AND page_id=?';
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'li', $_SESSION['user_id'], $_POST['page_id']);
    } else {
        $q = 'REPLACE INTO notes (user_id, page_id, note) VALUES (?, ?, ?)';
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'iis', $_SESSION['user_id'], $_POST['page_id'], $_POST['notes']);
    }
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo 'true';
        exit;
    }
} // invalid values or didn't work
echo 'false';