<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../include/auth_functions.php';

require_login();

$user_id = $_SESSION['user_id'];

// Get cart items and calculate total
try {
    $stmt = $pdo->prepare("
        SELECT 
            c.id as cart_id, 
            c.quantity, 
            p.id as product_id, 
            p.name, 
            p.price, 
            (c.quantity * p.price) as total_price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

    $total_amount = array_sum(array_column($cart_items, 'total_price'));
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart_items)) {
    try {
        $pdo->beginTransaction();

        // 1. Create order record
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_amount, status) 
            VALUES (?, ?, 'pending')
        ");
        $stmt->execute([$user_id, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // 2. Create order items
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        
        foreach ($cart_items as $item) {
            $stmt->execute([
                $order_id,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        // 3. Clear the cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $pdo->commit();
        
        // Redirect to order confirmation
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Checkout failed: " . $e->getMessage();
        header("Location: view.php");
        exit();
    }
}

// If cart is empty, redirect back to cart
if (empty($cart_items)) {
    header("Location: view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .checkout-container {
            display: flex;
            gap: 30px;
        }
        
        .checkout-form {
            flex: 2;
        }
        
        .order-summary {
            flex: 1;
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #eee;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .total-row {
            font-weight: bold;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        
        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: #000;
            color: white;
            text-align: center;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>
    
    <div class="checkout-container">
        <form method="POST" class="checkout-form">
            <h2>Shipping Information</h2>
            
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="address">Shipping Address</label>
                <textarea id="address" name="address" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>
            
            <div class="form-group">
                <label for="zip_code">ZIP Code</label>
                <input type="text" id="zip_code" name="zip_code" required>
            </div>
            
            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="">Select Country</option>
                    <option value="US">United States</option>
                    <option value="UK">United Kingdom</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            
            <h2>Payment Method</h2>
            <div class="form-group">
                <label>
                    <input type="radio" name="payment_method" value="credit_card" checked> Credit Card
                </label>
                <label>
                    <input type="radio" name="payment_method" value="paypal"> PayPal
                </label>
                <label>
                    <input type="radio" name="payment_method" value="bank_transfer"> Bank Transfer
                </label>
            </div>
            
            <button type="submit" class="submit-btn">Place Order</button>
        </form>
        
        <div class="order-summary">
            <h2>Order Summary</h2>
            
            <?php foreach ($cart_items as $item): ?>
                <div class="order-item">
                    <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
                    <span>$<?= number_format($item['total_price'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            
            <div class="order-item">
                <span>Shipping</span>
                <span>FREE</span>
            </div>
            
            <div class="order-item total-row">
                <span>Total</span>
                <span>$<?= number_format($total_amount, 2) ?></span>
            </div>
        </div>
    </div>
</body>
</html>