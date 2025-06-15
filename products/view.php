<?php
require_once __DIR__ . '/../config/database.php';

$product_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /');
    exit;
}

// Get related products
$stmt = $pdo->prepare("
    SELECT * FROM products 
    WHERE category = ? AND id != ? 
    ORDER BY RAND() 
    LIMIT 4
");
$stmt->execute([$product['category'], $product_id]);
$related_products = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<section class="product-detail">
    <div class="product-container">
        <div class="product-gallery">
            <div class="main-image">
                <img src="/assets/img/products/<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
        </div>
        
        <div class="product-info">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <div class="product-meta">
                <span class="brand">Brand: <?= htmlspecialchars($product['brand']) ?></span>
                <span class="sku">SKU: <?= $product['id'] ?></span>
            </div>
            
            <div class="product-price">
                <span>$<?= number_format($product['price'], 2) ?></span>
                <?php if ($product['stock_quantity'] > 0): ?>
                    <span class="in-stock">In Stock</span>
                <?php else: ?>
                    <span class="out-of-stock">Out of Stock</span>
                <?php endif; ?>
            </div>
            
            <div class="product-description">
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
            
            <?php if ($product['stock_quantity'] > 0): ?>
                <form action="/cart/update.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>">
                    </div>
                    <button type="submit" class="add-to-cart-btn">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (!empty($related_products)): ?>
        <div class="related-products">
            <h2>You May Also Like</h2>
            <div class="product-grid">
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card">
                        <a href="/products/view.php?id=<?= $related['id'] ?>">
                            <img src="/assets/img/products/<?= htmlspecialchars($related['image_path']) ?>" alt="<?= htmlspecialchars($related['name']) ?>" class="product-image">
                        </a>
                        <div class="brand"><?= htmlspecialchars($related['brand']) ?></div>
                        <div class="name"><?= htmlspecialchars($related['name']) ?></div>
                        <div class="price">$<?= number_format($related['price'], 2) ?></div>
                        <a href="/products/view.php?id=<?= $related['id'] ?>" class="view-details">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>