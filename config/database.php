<?php

$host = 'localhost';
$dbname = 'zombos_skateshop';
$username = 'root'; // Ganti dengan username MySQL Anda
$password = '';     // Ganti dengan password MySQL Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fungsi untuk menambahkan produk sepatu
    function insertShoesProducts($pdo) {
        $shoesProducts = [
            [
                'name' => 'Dead Low Pro Show',
                'description' => 'High-performance skate shoes with durable construction and excellent board feel',
                'price' => 113.50,
                'brand' => 'NINE 50',
                'image' => 'img/Shoes/174379-0-NikeSB-DunkLowProB.jpg',
                'stock' => 50
            ],
            [
                'name' => '482-000',
                'description' => 'Classic skate shoes with vulcanized sole for better board control',
                'price' => 59.50,
                'brand' => 'NEW BALANCE NUMERIC',
                'image' => 'img/Shoes/172127-0-NewBalanceNumeric-480.jpg',
                'stock' => 75
            ],
            [
                'name' => 'Chief Company OMs Sheva',
                'description' => 'Premium skate shoes with suede upper and cushioned insole',
                'price' => 113.50,
                'brand' => 'ADIDAS',
                'image' => 'img/Shoes/172203-0-adidas-SkateboardingTyshawnII.jpg',
                'stock' => 40
            ],
            [
                'name' => '1011 Hope Sheva',
                'description' => 'Professional skate shoes with impact-absorbing technology',
                'price' => 109.50,
                'brand' => 'NEW BALANCE NUMERIC',
                'image' => 'img/Shoes/172127-0-NewBalanceNumeric-480.jpg',
                'stock' => 60
            ],
            [
                'name' => 'Stationomogy Pupi Sheva',
                'description' => 'Affordable entry-level skate shoes with good durability',
                'price' => 59.50,
                'brand' => 'ADIDAS',
                'image' => 'img/Shoes/137134-0-adidas-SkateboardingGazelleADV.jpg',
                'stock' => 85
            ],
            [
                'name' => 'Stationomogy Typhoon & Sheva',
                'description' => 'Lightweight shoes designed for street skating',
                'price' => 59.50,
                'brand' => 'ADIDAS',
                'image' => 'img/Shoes/173901-0-NikeSB-DunkLowPro.jpg',
                'stock' => 65
            ],
            [
                'name' => 'Dead Low Pro Show V2',
                'description' => 'Updated version with improved cushioning and durability',
                'price' => 113.50,
                'brand' => 'NINE 50',
                'image' => 'img/Shoes/174379-0-NikeSB-DunkLowProB.jpg',
                'stock' => 55
            ],
            [
                'name' => 'Skate Pro 5000',
                'description' => 'Professional skate shoes with advanced cushioning technology and durable suede upper',
                'price' => 129.99,
                'brand' => 'VANS',
                'image' => 'img/Shoes/173901-0-NikeSB-DunkLowPro.jpg',
                'stock' => 45
            ]
        ];

        // Cek apakah produk sudah ada
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = ? AND brand = ?");
        $insertStmt = $pdo->prepare("INSERT INTO products 
                                    (name, description, price, category, brand, image_path, stock_quantity) 
                                    VALUES (?, ?, ?, 'shoes', ?, ?, ?)");

        foreach ($shoesProducts as $product) {
            $checkStmt->execute([$product['name'], $product['brand']]);
            $exists = $checkStmt->fetchColumn();
            
            if (!$exists) {
                $insertStmt->execute([
                    $product['name'],
                    $product['description'],
                    $product['price'],
                    $product['brand'],
                    $product['image'],
                    $product['stock']
                ]);
            }
        }
    }

    // Fungsi untuk menambahkan produk clothing
    function insertClothingProducts($pdo) {
        $clothingProducts = [
            [
                'name' => 'Atlas T-Shirt',
                'description' => 'Antix Atlas graphic t-shirt',
                'price' => 119.90,
                'brand' => 'Antix',
                'image' => 'img/Clothing/165067-3-Antix-Atlas.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Slack Hoodie',
                'description' => 'Antix Slack pullover hoodie',
                'price' => 589.90,
                'brand' => 'Antix',
                'image' => 'img/Clothing/133242-2-Antix-Slack.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Sunessy Sweater',
                'description' => 'Aniell Sunessy knitted sweater',
                'price' => 589.90,
                'brand' => 'ANIELL',
                'image' => 'img/Clothing/174775-0-Anuell-Sunessy.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Lightessy Sweater',
                'description' => 'Aniell Lightessy lightweight knit',
                'price' => 589.90,
                'brand' => 'ANIELL',
                'image' => 'img/Clothing/174776-0-Anuell-Lightessy.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Herber Organic T-Shirt',
                'description' => 'Aniell Herber organic cotton tee',
                'price' => 589.90,
                'brand' => 'ANIELL',
                'image' => 'img/Clothing/174121-0-Anuell-HerberOrganic.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Femina Organic Knit',
                'description' => 'Antix Femina organic knit top',
                'price' => 118.90,
                'brand' => 'Antix',
                'image' => 'img/Clothing/171030-0-Antix-FeminaOrganicKnit.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Majesty Light Organic',
                'description' => 'Aniell Majesty Light organic knit',
                'price' => 119.90,
                'brand' => 'ANIELL',
                'image' => 'img/Clothing/174595-0-Anuell-MajestyLightOrganicKnit.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Riley II Coach Jacket',
                'description' => 'Vans Riley II coach jacket',
                'price' => 119.90,
                'brand' => 'Vans',
                'image' => 'img/Clothing/169646-5-Vans-RileyIICoach.jpg',
                'stock' => 10
            ]
        ];

        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = ? AND brand = ?");
        $insertStmt = $pdo->prepare("INSERT INTO products 
                                    (name, description, price, category, brand, image_path, stock_quantity) 
                                    VALUES (?, ?, ?, 'clothing', ?, ?, ?)");

        foreach ($clothingProducts as $product) {
            $checkStmt->execute([$product['name'], $product['brand']]);
            $exists = $checkStmt->fetchColumn();
            
            if (!$exists) {
                $insertStmt->execute([
                    $product['name'],
                    $product['description'],
                    $product['price'],
                    $product['brand'],
                    $product['image'],
                    $product['stock']
                ]);
            }
        }
    }

    // Fungsi untuk menambahkan produk accessories
    function insertAccessoriesProducts($pdo) {
        $accessoriesProducts = [
            [
                'name' => 'Scriptum Mid Socks 3 Pack',
                'description' => 'Antix Scriptum Mid socks (3 pairs)',
                'price' => 14.99,
                'brand' => 'ANTIX',
                'image' => 'img/Accesories/171495-0-Antix-ScriptumMid.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Athletic Socks 3 Pack',
                'description' => 'Skatedeluxe Athletic socks (3 pairs)',
                'price' => 14.99,
                'brand' => 'SKATEDELUX',
                'image' => 'img/Accesories/171483-0-skatedeluxe-Athletic.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Plain Boxer Shorts',
                'description' => 'Lousy Livin plain black boxers',
                'price' => 14.99,
                'brand' => 'Lousy Livin',
                'image' => 'img/Accesories/173165-0-LousyLivin-Plain.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Script Leather Belt',
                'description' => 'Carhartt WIP script leather belt',
                'price' => 14.99,
                'brand' => 'CARHARTT WIP',
                'image' => 'img/Accesories/157392-0-CarharttWIP-ScriptLeather.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Avocado Boxer Shorts',
                'description' => 'Lousy Livin avocado print boxers',
                'price' => 14.99,
                'brand' => 'Lousy Livin',
                'image' => 'img/Accesories/130697-0-LousyLivinUnderwear-Avocado.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Flowers Boxer Shorts',
                'description' => 'Lousy Livin psychedelic flower boxers',
                'price' => 14.99,
                'brand' => 'Lousy Livin',
                'image' => 'img/Accesories/167395-0-LousyLivin-Flowers.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Aper Boxer Shorts',
                'description' => 'Aniell Aper swirl print boxers',
                'price' => 14.99,
                'brand' => 'ANIELL',
                'image' => 'img/Accesories/167405-0-Anuell-Aper.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Sculp Boxer Shorts',
                'description' => 'Antix Sculp gothic print boxers',
                'price' => 14.99,
                'brand' => 'Antix',
                'image' => 'img/Accesories/167406-0-Antix-Sculp.jpg',
                'stock' => 20
            ]
        ];

        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = ? AND brand = ?");
        $insertStmt = $pdo->prepare("INSERT INTO products 
                                    (name, description, price, category, brand, image_path, stock_quantity) 
                                    VALUES (?, ?, ?, 'accessories', ?, ?, ?)");

        foreach ($accessoriesProducts as $product) {
            $checkStmt->execute([$product['name'], $product['brand']]);
            $exists = $checkStmt->fetchColumn();
            
            if (!$exists) {
                $insertStmt->execute([
                    $product['name'],
                    $product['description'],
                    $product['price'],
                    $product['brand'],
                    $product['image'],
                    $product['stock']
                ]);
            }
        }
    }

// Fungsi untuk menambahkan produk Skateboard
// Fungsi untuk menambahkan produk skateboard
    // function insertSkateboardProducts($pdo) {
    //     $skateProducts = [
    //         [
    //             'name' => 'Bird Kids Deck',
    //             'description' => 'Skatedeluxe Bird Kids skateboard deck - 8.25" width',
    //             'price' => 99.00,
    //             'brand' => 'SKATEDELUX',
    //             'image' => 'img/Skate/173949-0-skatedeluxe-BirdKids.jpg',
    //             'stock' => 15
    //         ],
    //         [
    //             'name' => 'Mystery Deck',
    //             'description' => 'Skatedeluxe Mystery skateboard deck - 8.25" width',
    //             'price' => 99.00,
    //             'brand' => 'SKATEDELUX',
    //             'image' => 'img/Skate/173951-0-skatedeluxe-Mystery.jpg',
    //             'stock' => 15
    //         ],
    //         [
    //             'name' => 'Panther Old School Deck',
    //             'description' => 'Panther Old School skateboard deck - 8.5" width',
    //             'price' => 99.00,
    //             'brand' => 'PANTHER',
    //             'image' => 'img/Skate/173952-0-Panther-Oldschool.jpg',
    //             'stock' => 15
    //         ],
    //         [
    //             'name' => 'Fisherman Egg Deck',
    //             'description' => 'Skatedeluxe Fisherman Egg skateboard deck - 8.0" width',
    //             'price' => 99.00,
    //             'brand' => 'SKATEDELUX',
    //             'image' => 'img/Skate/177144-0-skatedeluxe-FishermanEgg.jpg',
    //             'stock' => 15
    //         ]
    //     ];

    //     $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = ? AND brand = ?");
    //     $insertStmt = $pdo->prepare("INSERT INTO products 
    //                                 (name, description, price, category, brand, image_path, stock_quantity) 
    //                                 VALUES (?, ?, ?, 'skateboard', ?, ?, ?)");

    //     foreach ($skateProducts as $product) {
    //         $checkStmt->execute([$product['name'], $product['brand']]);
    //         $exists = $checkStmt->fetchColumn();
            
    //         if (!$exists) {
    //             $insertStmt->execute([
    //                 $product['name'],
    //                 $product['description'],
    //                 $product['price'],
    //                 $product['brand'],
    //                 $product['image'],
    //                 $product['stock']
    //             ]);
    //         }
    //     }
    // }

    // Panggil semua fungsi untuk menambahkan produk
    insertShoesProducts($pdo);
    insertClothingProducts($pdo);
    insertAccessoriesProducts($pdo);
    // insertSkateboardProducts($pdo);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>