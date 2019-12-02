<?php
require('../includes/config.inc.php');
if (isset($_GET['page_id'], $_GET['action'], $_SESSION['user_id']) && filter_var($_GET['page_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) && filter_var($_SESION['user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    if ($_GET['action'] === 'add') {
        $q = 'REPLACE INTO favorite_pages (user_id, page_id) VALUES (?, ?)';
    } elseif ($_GET['action'] === 'remove') {
        $q = 'DELETE FROM favorite_pages WHERE user_id=? AND page_id=?';
    }
    if (isset($q)) {
        require(MYSQL);
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_id'], $_GET['page_id']);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo 'true';
            exit;
            }
        }
    }
}