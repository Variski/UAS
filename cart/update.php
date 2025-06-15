<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../include/auth_functions.php';

require_login();

// Debug paths (comment out in production)
// echo "Current directory: " . __DIR__ . "<br>";
// echo "Database path: " . __DIR__ . '/../config/database.php' . "<br>";
// echo "Auth functions path: " . __DIR__ . '/../include/auth_functions.php' . "<br>";
// var_dump(file_exists(__DIR__ . '/../config/database.php'));
// var_dump(file_exists(__DIR__ . '/../include/auth_functions.php'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine if this is an add or update operation
    if (isset($_POST['product_id'])) {
        // Add to cart operation
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        
        if ($product_id && $quantity) {
            try {
                // 1. Check if product exists
                $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                
                if (!$stmt->fetch()) {
                    throw new Exception("Product not found");
                }

                // 2. Check if product already in cart
                $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$_SESSION['user_id'], $product_id]);
                $cart_item = $stmt->fetch();
                
                if ($cart_item) {
                    // Update quantity
                    $new_quantity = $cart_item['quantity'] + $quantity;
                    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                    $stmt->execute([$new_quantity, $cart_item['id']]);
                } else {
                    // Add new item
                    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->execute([$_SESSION['user_id'], $product_id, $quantity]);
                }
                
                header('Location: /UTS-main/cart/view.php?status=added');
                exit;
                
            } catch (Exception $e) {
                error_log("Cart error: " . $e->getMessage());
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=' . urlencode($e->getMessage()));
                exit;
            }
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=invalid_input');
            exit;
        }
    } elseif (isset($_POST['cart_id'])) {
        // Update cart quantity operation
        $cart_id = filter_input(INPUT_POST, 'cart_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        $user_id = $_SESSION['user_id'];

        if ($cart_id === false || $quantity === false) {
            $_SESSION['error'] = "Invalid input data";
            header("Location: view.php?error=invalid_input");
            exit();
        }

        try {
            $pdo->beginTransaction();
            
            if ($quantity > 0) {
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$quantity, $cart_id, $user_id]);
                $status = 'updated';
            } else {
                $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
                $stmt->execute([$cart_id, $user_id]);
                $status = 'removed';
            }

            $pdo->commit();
            header("Location: view.php?status=$status");
            exit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Cart update error: " . $e->getMessage());
            $_SESSION['error'] = "Failed to update cart: " . $e->getMessage();
            header("Location: view.php?error=1");
            exit();
        }
    }
}

// Default redirect if nothing matched
header("Location: /UTS-main/");
exit();
?>