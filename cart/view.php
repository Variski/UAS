<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../include/auth_functions.php';

require_login();

$user_id = $_SESSION['user_id'];

// Handle messages
$status_message = '';
if (isset($_GET['status'])) {
    $messages = [
        'updated' => 'Cart updated successfully',
        'removed' => 'Item removed from cart'
    ];
    $status_message = $messages[$_GET['status']] ?? '';
}

$error_message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

// Get cart items
try {
    $stmt = $pdo->prepare("
        SELECT 
            c.id as cart_id, 
            c.quantity, 
            p.id as product_id, 
            p.name, 
            p.price, 
            p.image_path, 
            (c.quantity * p.price) as total_price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

    $total = array_sum(array_column($cart_items, 'total_price'));
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <h1>Your Shopping Cart</h1>
    
    <?php if (!empty($status_message)): ?>
        <div class="alert alert-success"><?= $status_message ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-error"><?= $error_message ?></div>
    <?php endif; ?>

    <div class="cart-container">
        <div class="cart-items">
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty</p>
                <a href="../index.php">Continue Shopping</a>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        
                        <div class="product-details">
                            <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="product-price">$<?= number_format($item['price'], 2) ?></div>
                            <div>In stock</div>
                            
                            <form action="update.php" method="POST" class="quantity-form">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <div class="quantity-control">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantity-input">
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                                <button type="submit" class="update-btn">Update</button>
                            </form>
                            
                            <form action="update.php" method="POST" class="remove-form">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <input type="hidden" name="quantity" value="0">
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </div>
                        <div class="product-total">
                            $<?= number_format($item['total_price'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="cart-summary">
            <div class="summary-title">Order Summary</div>
            
            <div class="summary-row">
                <span>Subtotal</span>
                <span>$<?= number_format($total, 2) ?></span>
            </div>
            
            <div class="summary-row">
                <span>Shipping</span>
                <span>FREE</span>
            </div>
            
            <div class="summary-row total-row">
                <span>Total</span>
                <span>$<?= number_format($total, 2) ?></span>
            </div>
            
            <div>incl. VAT</div>
            
            <div class="button-container">
    <a href="../orders/order.php" class="checkout-btn">CHECKOUT</a>
    <a href="../index.php" class="back-to-shop">
        <i class="fas fa-arrow-left"></i> Back to Shop
    </a>
</div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                let value = parseInt(input.value);
                
                if (this.classList.contains('minus')) {
                    if (value > 1) input.value = value - 1;
                } else {
                    input.value = value + 1;
                }
            });
        });
        
        // Auto-submit forms when quantity changes
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
        
        // Confirm before removing
        document.querySelectorAll('.remove-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to remove this item?')) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>