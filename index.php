<?php
// Debugging - pastikan ini ada di bagian paling atas
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

try {
    // Debug query shoes
    $stmt = $pdo->query("SELECT * FROM products WHERE category = 'shoes' LIMIT 8");
    $shoes_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get clothing
    $stmt = $pdo->query("SELECT * FROM products WHERE category = 'clothing' LIMIT 8");
    $clothing_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get accessories
    $stmt = $pdo->query("SELECT * FROM products WHERE category = 'accessories' LIMIT 8");
    $accessories_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get skateboards
    $stmt = $pdo->query("SELECT * FROM products WHERE category = 'skateboard' LIMIT 6");
    $skateboard_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Font -->
    
    <!-- Icon -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap -->

    <!-- Swiper -->
     <link rel="stylesheet"   href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
     >

     <!-- Di head -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Sebelum penutup body -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <title>Kiyano Skateshop</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Zombos <span style="color: red;">Skateshop</span></div>

            <div class="main-nav">
            <a href="#brands">BRANDS</a>
            <a href="#skateboard">SKATEBOARDS</a>
            <a href="#shoes">SHOES</a>
            <a href="#clothing">CLOTHING</a>
            <a href="#accessories">ACCESSORIES</a>
            <a href="#">NEW</a>
            <a href="#">% SALE</a>
            </div>

            <div class="search">
                <form action="#"><input type="text" placeholder="Search"></form>
            </div>

            <div class="search-button">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="profile">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                    <?php if ($_SESSION['is_admin']): ?>
                        <a href="admin/dashboard.php"><i class="fa-solid fa-user-shield"></i></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="auth/login.php"><i class="fa-regular fa-user"></i></a>
                <?php endif; ?>
            </div>

            <div class="cart">
                <a href="cart/view.php"><i class="fa-solid fa-basket-shopping"></i>
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
    <section class="home-promo">
        <div class="banner-promo">
            <div class="content-wrapper">
                <div class="text-content">
                    <p>Find your Easter deal: <br>
                    Get an extra 20% discount on all reduced items! Only until 16.04.2025!</p>
                    <br>
                    <p><strong>DISCOUNT CODE: <span style="font-size: larger;">RAMADHANSALE</span></strong></p>
                </div>
                <img src="img/Skateshop.jpg" alt="Skateshop" class="foto-skateshop">
            </div>
        </div>
    </section>

    <section class="news-container">
        <h1>NE<span style="color: red;">WS</span></h1>
        <div class="news-slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1" checked>
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                
                <div class="slide first">
                    <a href=""><img src="img/1.jpg" alt=""></a>
                </div>
                <div class="slide">
                    <a href=""><img src="img/2.jpg" alt=""></a>
                </div>
                
                <div class="nav-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                </div>
            </div>
            
            <div class="nav-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
            </div>
        </div>
    </section>

    <section class="brands" id="brands">
        <div class="brands-wrapper">
        <h1>POPULAR SKATEBOARDS & STREAT BRANDS</h1>
        <br>
        <hr>
        <br>
        <p>As your skate shop, we know that the list of skateboard and streetwear brands on the current market seems to be endless. To make it easier for you, we have the best and most famous European and American skateboard and skatewear brands at the Zombos skate shop. Besides the biggest and best companies in the world, we also have a selection of smaller and uprising companies in stock that are worthy to represent your lifestyle.
        <br><br>
        To get to the brand shops, just hit the logo or browse for your favorite company in our list below!
        </p>
        <br>
        <br>
        <h1>TOP BRANDS</h1>
        <br>
        <hr>
        <br>
        <p>
            This is a selection of the best and most famous skateboard, skatewear, and streetwear brands at Zombos. Hit the brand logos to find all products of your favorite brands at the Zombos skate shop.
        </p>
        <br>
        <br>
        </div>

        <div class="list-brands">
            <div class="top-brands">
                <img src="img/Brands/adidas.jpg" alt="Adidas">
                <img src="img/Brands/carhartt-wip.jpg" alt="Carhartt">
                <img src="img/Brands/converse.jpg" alt="Converse">
                <img src="img/Brands/nike-sb.jpg" alt="Nike SB">
                <img src="img/Brands/thrasher.jpg" alt="Thrasher">
            </div>
        
            <div class="second-brands">
                <img src="img/Brands 2/baker.jpg" alt="Baker">
                <img src="img/Brands 2/dickies.jpg" alt="Dickies">
                <img src="img/Brands 2/huf.jpg" alt="HUF">
                <img src="img/Brands 2/independent.jpg" alt="Independent">
                <img src="img/Brands 2/spitfire.jpg" alt="Spitfire">
            </div>
        </div>
    </section>

    <section class="skateboard" id="skateboard">
        <div class="skateboard-container">
            <div class="logo-skate">
                <img src="img/Icon/skateboard.png" alt="logo-skate" >
            </div>
            <h1 style="display: flex; justify-content: center;">SKATEBOARDS</h1>
            <br>
            <hr style="margin: 0px 200px 0px 200px;">
            <br>
            <br>
            <!-- <img src="img/thrasher poster.jpg" alt="poster"> -->
            <p>Are you looking for a new skateboard or need a new deck or wheels? In the Zombos skate shop you'll find everything you need for skating. Whether you're a beginner or up-and-coming pro - we have the top skateboard brands and lots of information to help you along the way.</p>
            
            <div class="skate-content">
            <a href="#"><img src="img/Skateboards.jpg" alt="Skateboard Complate"> <br><strong>Skateboard</strong></a>
            <a href="#"><img src="img/Skatebag.jpg" alt="Skateboard"><br><strong>Accessories</strong></a>
            <a href="#"><img src="img/tools.jpg" alt="Tools"><br><strong>Tools</strong></a>
            </div>
            
            <hr style="margin: 100px 200px 0px 200px;">
            
        </div>
</section>

<!-- Skateboard Section -->
<!-- <section class="Skateboard" id="skateboard">
    <h1>Skateboard</h1>
    <div class="product-grid">
        <?php if (!empty($skateboard_products)): ?>
            <?php foreach ($skateboard_products as $product): ?>
                <div class="product-card">
                    <a href="products/view.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="product-image"
                             onerror="this.src='img/placeholder.jpg'">
                    </a>
                    <div class="brand"><?= htmlspecialchars($product['brand']) ?></div>
                    <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="price">$<?= number_format($product['price'], 2) ?></div>
                    <div class="rating">★★★★★ <span class="review-count">(<?= rand(1, 100) ?>)</span></div>
                    <form action="/UTS-main/cart/update.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products">No skateboard products available at the moment.</p>
        <?php endif; ?>
    </div>
</section> -->


<!-- Shoes Section (existing) -->
<section class="Shoes" id="shoes">
    <h1>Shoes</h1>
    <div class="product-grid">
        <?php if (!empty($shoes_products)): ?>
            <?php foreach ($shoes_products as $product): ?>
                <div class="product-card">
                    <a href="products/view.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="product-image"
                             onerror="this.src='img/placeholder.jpg'">
                    </a>
                    <div class="brand"><?= htmlspecialchars($product['brand']) ?></div>
                    <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="price">$<?= number_format($product['price'], 2) ?></div>
                    <div class="rating">★★★★★ <span class="review-count">(<?= rand(1, 100) ?>)</span></div>
                    <form action="/UTS-main/cart/update.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products">No shoes products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Clothing Section (new) -->
<section class="Clothing" id="clothing">
    <h1>Clothing</h1>
    <div class="product-grid">
        <?php if (!empty($clothing_products)): ?>
            <?php foreach ($clothing_products as $product): ?>
                <div class="product-card">
                    <a href="products/view.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="product-image"
                             onerror="this.src='img/placeholder.jpg'">
                    </a>
                    <div class="brand"><?= htmlspecialchars($product['brand']) ?></div>
                    <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="price">$<?= number_format($product['price'], 2) ?></div>
                    <div class="rating">★★★★★ <span class="review-count">(<?= rand(1, 100) ?>)</span></div>
                    <form action="/UTS-main/cart/update.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products">No clothing products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Accessories Section (corrected) -->
<section class="accessories" id="accessories">
    <h1>Accessories</h1>
    <div class="product-grid">
        <?php if (!empty($accessories_products)): ?>
            <?php foreach ($accessories_products as $product): ?>
                <div class="product-card">
                    <a href="products/view.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="product-image"
                             onerror="this.src='img/placeholder.jpg'">
                    </a>
                    <div class="brand"><?= htmlspecialchars($product['brand']) ?></div>
                    <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="price">$<?= number_format($product['price'], 2) ?></div>
                    <div class="rating">★★★★★ <span class="review-count">(<?= rand(1, 100) ?>)</span></div>
                    <form action="/UTS-main/cart/update.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products">No accessories products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


    <footer class="footer">
        <?php include 'include/footer.php'; ?>
        
</body>
</html>