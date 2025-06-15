<?php
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body>
    <div class="login-page">
        <div class="login-box">
            <div class="login-logo">
                Admin Login
            </div>
            
            <div class="login-card-body">
                <form action="proses_login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>