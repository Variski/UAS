<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: ../auth/login.php');  // Path relatif yang benar
        exit;
    }
}

function require_admin() {
    require_login();
    if (!$_SESSION['is_admin']) {
        header('Location: /');
        exit;
    }
}
?>