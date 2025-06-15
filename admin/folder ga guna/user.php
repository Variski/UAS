<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth_functions.php';
require_admin();

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    // Don't allow deletion of current user
    if ($user_id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['message'] = 'User deleted successfully';
    } else {
        $_SESSION['message'] = 'You cannot delete your own account';
    }
    header('Location: /admin/users.php');
    exit;
}

// Toggle admin status
if (isset($_GET['toggle_admin'])) {
    $user_id = (int)$_GET['toggle_admin'];
    // Don't allow demoting yourself
    if ($user_id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("UPDATE users SET is_admin = NOT is_admin WHERE id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['message'] = 'User admin status updated';
    } else {
        $_SESSION['message'] = 'You cannot change your own admin status';
    }
    header('Location: /admin/users.php');
    exit;
}

// Get all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>

<section class="admin-users">
    <h1>User Management</h1>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <table class="admin