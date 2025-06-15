<?php
require_once __DIR__ . '/../config/database.php';

$category = $_GET['category'] ?? '';
$valid_categories = ['skateboard', 'shoes', 'clothing', 'accessories'];

if (!in_array($category, $valid_categories)) {
    header('Location: /');
    exit;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 8;
$offset = ($page - 1) * $per_page;

// Get products for the category
$stmt = $pdo->prepare("
    SELECT * FROM products 
    WHERE category = ? 
    LIMIT ? OFFSET ?
");
$stmt->execute([$category, $per_page, $offset]);
$products = $stmt->fetchAll();

// Get total count for pagination
$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category = ?");
$stmt->execute([$category]);
$total = $stmt->fetchColumn();
$pages = ceil($total / $per_page);

$category_names = [
    'skateboard' => 'Skateboards',
    'shoes' => 'Shoes',
    'clothing' => 'Clothing',
    'accessories' => 'Accessories'
];

require_once __DIR__ . '/../includes/header.php';
?>

<section class="category-section">
    <h1><?= htmlspecialchars($category_names[$category]) ?></h1>
    
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="/products/view.php?id=<?= $product['id'] ?>">
                    <img src="/assets/img/products/<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                </a>
                <div class="brand"><?= htmlspecialchars($product['brand']) ?></div>
                <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="price">$<?= number_format($product['price'], 2) ?></div>
                <a href="/products/view.php?id=<?= $product['id'] ?>" class="view-details">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?category=<?= $category ?>&page=<?= $page - 1 ?>" class="page-link">Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?category=<?= $category ?>&page=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $pages): ?>
                <a href="?category=<?= $category ?>&page=<?= $page + 1 ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>