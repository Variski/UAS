<?php
include '../includes/header.php';

// Check if user ID is provided
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    $_SESSION['error'] = 'Invalid user ID';
    header('Location: list.php');
    exit;
}

// Prevent deletion of primary admin (ID 1)
if ($user_id === 1) {
    $_SESSION['error'] = 'Primary admin cannot be deleted';
    header('Location: list.php');
    exit;
}

// In a real application, you would fetch user data from database
$user = [
    'id' => $user_id,
    'username' => 'user' . $user_id,
    'name' => 'User ' . $user_id,
    'email' => 'user' . $user_id . '@example.com',
    'role' => 'user',
    'created_at' => date('Y-m-d H:i:s', strtotime('-'.($user_id+1).' days'))
];

// Process deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        try {
            // In a real application:
            // 1. Check if user has any associated data (orders, posts, etc.)
            // 2. Either:
            //    a) Perform cascade delete of all related data, or
            //    b) Set user status to "deleted" (soft delete)
            // 3. Delete user from database
            
            $_SESSION['success'] = 'User "' . htmlspecialchars($user['name']) . '" has been deleted successfully';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error deleting user: ' . $e->getMessage();
        }
        
        header('Location: list.php');
        exit;
    } else {
        header('Location: list.php');
        exit;
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delete User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="list.php">Users</a></li>
                        <li class="breadcrumb-item active">Delete User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Confirm User Deletion</h3>
                </div>
                <form method="post">
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
                            Are you sure you want to delete the following user account?
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">User ID</th>
                                    <td><?php echo $user['id']; ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?php echo ucfirst($user['role']); ?></td>
                                </tr>
                                <tr>
                                    <th>Registered Since</th>
                                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-ban"></i> Important Note</h5>
                            <p>This action will permanently delete the user account and all associated data.</p>
                            <p class="mb-0">Consider deactivating the account instead if you want to preserve the data.</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="confirm_delete" value="1" class="btn btn-danger">Delete Permanently</button>
                        <a href="list.php" class="btn btn-default">Cancel</a>
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-info float-right">
                            <i class="fas fa-user-edit"></i> Edit Instead
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>