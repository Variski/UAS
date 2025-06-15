<?php 
include '../includes/header.php';

// In a real application, you would fetch product data from database
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Sample product data - replace with database query
$product = [
    'id' => $product_id,
    'name' => 'Sample Product ' . $product_id,
    'description' => 'This is a sample product description.',
    'price' => 99.99,
    'stock' => 50,
    'category' => 'electronics',
    'image' => 'default-product.jpg'
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $category = htmlspecialchars($_POST['category'] ?? '');
    
    // Validate input
    if (empty($name) || $price <= 0 || $stock < 0) {
        $_SESSION['error'] = 'Please fill all required fields with valid data';
    } else {
        // Handle image upload
        $image = $product['image']; // keep old image by default
        
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = '../../uploads/products/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            
            // Check if image file is valid
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = basename($_FILES['image']['name']);
                    // Delete old image if it's not the default
                    if ($product['image'] !== 'default-product.jpg') {
                        @unlink($uploadDir . $product['image']);
                    }
                } else {
                    $_SESSION['error'] = 'Failed to upload image';
                }
            } else {
                $_SESSION['error'] = 'Only JPG, JPEG, PNG & GIF files are allowed';
            }
        }
        
        if (!isset($_SESSION['error'])) {
            // In a real app, update database here
            $product = [
                'id' => $product_id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'category' => $category,
                'image' => $image
            ];
            
            $_SESSION['success'] = 'Product updated successfully';
            // Redirect to product list
            header('Location: list.php');
            exit;
        }
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
                    <h1 class="m-0">Edit Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="list.php">Products</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
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
            
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Product Details</h3>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price *</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                           value="<?php echo htmlspecialchars($product['price']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock Quantity *</label>
                                    <input type="number" class="form-control" id="stock" name="stock" 
                                           value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="electronics" <?php echo $product['category'] === 'electronics' ? 'selected' : ''; ?>>Electronics</option>
                                <option value="clothing" <?php echo $product['category'] === 'clothing' ? 'selected' : ''; ?>>Clothing</option>
                                <option value="home" <?php echo $product['category'] === 'home' ? 'selected' : ''; ?>>Home</option>
                                <option value="other" <?php echo $product['category'] === 'other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                            <?php if (!empty($product['image'])): ?>
                                <div class="mt-2">
                                    <img src="../../uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="Current Product Image" style="max-height: 100px;">
                                    <p class="text-muted mt-1">Current image: <?php echo htmlspecialchars($product['image']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="list.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>

<?php include '../includes/footer.php'; ?>