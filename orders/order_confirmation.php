<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../include/auth_functions.php';

require_login();

if (!isset($_GET['order_id'])) {
    header("Location: ../index.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Get order details
try {
    $stmt = $pdo->prepare("
        SELECT o.*, oi.product_id, oi.quantity, oi.price, p.name as product_name
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.id = ? AND o.user_id = ?
    ");
    $stmt->execute([$order_id, $user_id]);
    $order_items = $stmt->fetchAll();

    if (empty($order_items)) {
        throw new Exception("Order not found");
    }

    // First row contains order info
    $order = $order_items[0];
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .confirmation-container {
            text-align: center;
            padding: 40px 20px;
        }
        
        .confirmation-icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .order-details {
            margin-top: 30px;
            text-align: left;
            border: 1px solid #eee;
            padding: 20px;
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
        
        .btn-continue {
            display: inline-block;
            padding: 10px 20px;
            background: #000;
            color: white;
            text-decoration: none;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1>Thank You for Your Order!</h1>
        <p>Your order #<?= $order_id ?> has been placed successfully.</p>
        <p>We've sent a confirmation email to your registered email address.</p>
        
        <div class="order-details">
            <h2>Order Summary</h2>
            
            <?php foreach ($order_items as $item): ?>
                <div class="order-item">
                    <span><?= htmlspecialchars($item['product_name']) ?> × <?= $item['quantity'] ?></span>
                    <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            
            <div class="order-item total-row">
                <span>Total</span>
                <span>$<?= number_format($order['total_amount'], 2) ?></span>
            </div>
            
            <div class="order-item">
                <span>Status</span>
                <span><?= ucfirst($order['status']) ?></span>
            </div>
        </div>
        
        <a href="../index.php" class="btn-continue">Continue Shopping</a>
    </div>
</body>
</html>