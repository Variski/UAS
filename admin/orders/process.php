<?php 
include '../includes/header.php';

// Check if order ID is provided
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// In a real application, you would fetch order details from database
$order = [
    'id' => $order_id,
    'order_number' => 'ORD-' . str_pad($order_id, 4, '0', STR_PAD_LEFT),
    'customer_name' => 'John Doe',
    'order_date' => date('Y-m-d'),
    'status' => 'Pending',
    'total' => 120.00
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'] ?? '';
    $notes = $_POST['notes'] ?? '';
    
    // Validate status
    $valid_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
    if (!in_array($new_status, $valid_statuses)) {
        $_SESSION['error'] = 'Invalid order status';
    } else {
        // In a real application, you would update the database here
        $order['status'] = $new_status;
        
        // Also save the processing notes
        $order['processing_notes'] = $notes;
        
        $_SESSION['success'] = 'Order #' . $order['order_number'] . ' has been updated to ' . $new_status;
        
        // Redirect back to order list
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
                    <h1 class="m-0">Process Order #<?php echo $order['order_number']; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="list.php">Orders</a></li>
                        <li class="breadcrumb-item active">Process Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Order Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Order Number</label>
                                <input type="text" class="form-control" value="<?php echo $order['order_number']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Customer</label>
                                <input type="text" class="form-control" value="<?php echo $order['customer_name']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Order Date</label>
                                <input type="text" class="form-control" value="<?php echo $order['order_date']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Total Amount</label>
                                <input type="text" class="form-control" value="$<?php echo number_format($order['total'], 2); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card card-primary">
                        <form method="post">
                            <div class="card-header">
                                <h3 class="card-title">Update Order Status</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Current Status</label>
                                    <input type="text" class="form-control" value="<?php echo $order['status']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="status">New Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Shipped">Shipped</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notes">Processing Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any notes about this order processing"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Order</button>
                                <a href="list.php" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Items</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sample Product 1</td>
                                <td>$50.00</td>
                                <td>2</td>
                                <td>$100.00</td>
                            </tr>
                            <tr>
                                <td>Sample Product 2</td>
                                <td>$10.00</td>
                                <td>2</td>
                                <td>$20.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>