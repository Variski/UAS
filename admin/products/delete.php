<?php
include '../includes/header.php';

// Check if product ID is provided
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    $_SESSION['error'] = 'Invalid product ID';
    header('Location: list.php');
    exit;
}

// In a real application, you would fetch product data from database
$product = [
    'id' => $product_id,
    'name' => 'Sample Product ' . $product_id,
    'image' => 'default-product.jpg'
];

// Process deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        try {
            // In a real application:
            // 1. Delete product from database
            // 2. Delete product image file if it's not the default
            
            $uploadDir = '../../uploads/products/';
            if ($product['image'] !== 'default-product.jpg' && file_exists($uploadDir . $product['image'])) {
                @unlink($uploadDir . $product['image']);
            }
            
            $_SESSION['success'] = 'Product "' . htmlspecialchars($product['name']) . '" has been deleted successfully';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error deleting product: ' . $e->getMessage();
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
                    <h1 class="m-0">Delete Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="list.php">Products</a></li>
                        <li class="breadcrumb-item active">Delete Product</li>
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
                    <h3 class="card-title">Confirm Deletion</h3>
                </div>
                <form method="post">
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
                            Are you sure you want to delete the product <strong>"<?php echo htmlspecialchars($product['name']); ?>"</strong>?
                            <p class="mt-2">This action cannot be undone.</p>
                        </div>
                        
                        <?php if ($product['image'] !== 'default-product.jpg'): ?>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_image" name="delete_image" checked>
                                <label for="delete_image" class="custom-control-label">Also delete product image</label>
                            </div>
                            <div class="mt-2">
                                <img src="../../uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="Product Image" style="max-height: 100px;">
                                <p class="text-muted mt-1">Current image: <?php echo htmlspecialchars($product['image']); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="confirm_delete" value="1" class="btn btn-danger">Delete Permanently</button>
                        <a href="list.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>