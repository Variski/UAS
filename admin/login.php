<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Hardcoded admin credentials (HANYA UNTUK DEVELOPMENT!)
$valid_username = 'admin';
$valid_password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password = "password"

// Proses login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi';
    } else {
        // Verifikasi credentials
        if ($username === $valid_username && password_verify($password, $valid_password_hash)) {
            // Set session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = 'Administrator';
            $_SESSION['admin_role'] = 'superadmin';
            
            // Redirect ke dashboard
            header('Location: admin/dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <style>
        .login-page {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-box {
            width: 360px;
        }
        .login-logo a {
            color: #fff;
            font-weight: 300;
            letter-spacing: 1px;
        }
        .login-card-body {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .input-group-text {
            background-color: rgba(0,0,0,0.03);
        }
        .demo-credentials {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body class="login-page">
<div class="login-box">
    <!-- Login Logo -->
    <div class="login-logo text-center mb-4">
        <a href="index.php"><b>Admin</b>Panel</a>
    </div>
    
    <!-- Login Card -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silakan login untuk mengakses panel admin</p>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat Saya</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>

            <!-- Demo credentials (Hanya untuk development) -->
            <div class="demo-credentials">
                <strong>Demo Credentials:</strong><br>
                Username: <code>admin</code><br>
                Password: <code>password</code>
            </div>

            <p class="mb-1 mt-3 text-center">
                <a href="forgot-password.php">Lupa password?</a>
            </p>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>