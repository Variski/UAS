<?php 
include '../includes/header.php';
require_once '../../config/database.php';

try {
    // Query alternatif yang lebih aman
    $stmt = $pdo->query("
        SELECT 
            o.id AS order_id, 
            o.created_at AS order_date,
            o.total AS total_amount,
            o.status,
            u.name AS customer_name,
            u.email AS customer_email
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
    ");
    
    if ($stmt === false) {
        throw new Exception("Query error: " . implode(" ", $pdo->errorInfo()));
    }
    
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    $orders = [];
}
?>

<!-- Bagian HTML tetap sama -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Orders</h3>
                </div>
                <div class="card-body">
                    <table id="ordersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= date('d M Y H:i', strtotime($order['order_date'])) ?></td>
                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                <td><?= htmlspecialchars($order['customer_email']) ?></td>
                                <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $order['status'] == 'completed' ? 'bg-success' : 
                                           ($order['status'] == 'processing' ? 'bg-primary' : 
                                           ($order['status'] == 'cancelled' ? 'bg-danger' : 'bg-secondary')) ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view.php?id=<?= $order['order_id'] ?>" class="btn btn-info btn-sm">View</a>
                                    <a href="edit.php?id=<?= $order['order_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>

<!-- DataTables Script -->
<script>
$(document).ready(function() {
    $('#ordersTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "desc"]]
    });
});
</script>