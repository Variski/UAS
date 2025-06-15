<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../include/auth_functions.php';

if (is_logged_in()) {
    header('Location: ../index.php');  // Diperbaiki
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header('Location: ../index.php');  // Diperbaiki
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class="auth-section">
        <div class="auth-container">
            <div class="signin-container">
                <h2>SIGN IN</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="warning"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="input-group">
                        <label for="username">Username or Email</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit">Sign in</button> <!-- Diperbaiki -->
                </form>
                
                <div class="links">
                    <a href="register.php">Don't have an account? Register</a><br>
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>