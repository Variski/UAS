<?php
session_start();
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zombos Skateshop</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Zombos <span style="color: red;">Skateshop</span></div>

            <div class="main-nav">
                <a href="/products/category.php?category=skateboard">SKATEBOARDS</a>
                <a href="/products/category.php?category=shoes">SHOES</a>
                <a href="/products/category.php?category=clothing">CLOTHING</a>
                <a href="/products/category.php?category=accessories">ACCESSORIES</a>
                <a href="#">NEW</a>
                <a href="#">% SALE</a>
            </div>

            <div class="search">
                <form action="/products/search.php" method="GET">
                    <input type="text" name="query" placeholder="Search">
                </form>
            </div>

            <div class="profile">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                    <?php if ($_SESSION['is_admin']): ?>
                        <a href="/admin/dashboard.php"><i class="fa-solid fa-user-shield"></i></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/auth/login.php"><i class="fa-regular fa-user"></i></a>
                <?php endif; ?>
            </div>

            <div class="cart">
                <a href="/cart/view.php"><i class="fa-solid fa-basket-shopping"></i>
                <?php if (isset($_SESSION['user_id'])): 
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    $count = $stmt->fetchColumn();
                    if ($count > 0): ?>
                        <span class="cart-count"><?= $count ?></span>
                    <?php endif; ?>
                <?php endif; ?>
                </a>
            </div>
        </nav>
    </header>