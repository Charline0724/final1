<?php
// Categorized menu items
$menuItems = [
    'Food' => [
        ['name' => 'Chicken Curry', 'price' => 120, 'image' => 'OIP (3).jpg'],
        ['name' => 'Beef Steak', 'price' => 250, 'image' => 'th.jpg'],
        ['name' => 'Vegetable Salad', 'price' => 80, 'image' => '.webp'],
        ['name' => 'Shrimp', 'price' => 100, 'image' => 'Shrimp.jpg'],
        ['name' => 'Adobo', 'price' => 300, 'image' => 'Adobo.jpg'],
    ],
    'Drinks' => [
       
        ['name' => 'Shake', 'price' => 50, 'image' => 'OIP (2).jpg'],
        ['name' => 'Iced Tea', 'price' => 30, 'image' => 'tea.jpg'],
        ['name' => 'Iced Coffe', 'price' => 95, 'image' => 'icecoffe.png'],
        ['name' => 'Sprite', 'price' => 45, 'image' => 'OIP (7).jpg'],
        ['name' => 'Coke', 'price' => 25, 'image' => 'OIP (1).jpg'],

        
       
    ],
    'Dessert' => [
        ['name' => 'fruits', 'price' => 200, 'image' => 'des.jpg'],
        ['name' => 'halo-halo', 'price' => 100, 'image' => 'R.jpg'],
         ['name' => 'Iced Cream', 'price' => 300, 'image' => 'icecream.webp'],
         ['name' => 'Cake', 'price' => 350, 'image' => 'OIP (4).jpg'],
         ['name' => 'Stawberry Cake', 'price' => 310, 'image' => 'OIP (6).jpg'],
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Menu | Our Food Catering</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px auto;
            max-width: 1200px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        h2 {
            color: #16a085;
            margin-top: 50px;
            margin-bottom: 15px;
            text-align: left;
            padding-left: 10px;
            font-size: 1.8em;
            border-left: 5px solid #16a085;
        }

        .menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .menu-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 220px;
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .menu-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .menu-content {
            padding: 15px;
            text-align: center;
        }

        .menu-name {
            font-size: 1.2em;
            margin-bottom: 6px;
            font-weight: 600;
            color: #34495e;
        }

        .menu-price {
            font-size: 1em;
            font-weight: 700;
            color: #27ae60;
        }

        .back-link {
            display: block;
            width: fit-content;
            margin: 60px auto 0;
            text-decoration: none;
            color: #2980b9;
            font-weight: 600;
            border: 2px solid #2980b9;
            padding: 10px 18px;
            border-radius: 6px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .back-link:hover {
            background-color: #2980b9;
            color: white;
        }

        .category-section {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <h1>Our Menu</h1>

    <?php foreach ($menuItems as $category => $items): ?>
        <div class="category-section">
            <h2><?php echo htmlspecialchars($category); ?></h2>
            <div class="menu-container">
                <?php foreach ($items as $item): ?>
                    <div class="menu-card">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="menu-image" />
                        <div class="menu-content">
                            <div class="menu-name"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="menu-price">₱<?php echo number_format($item['price'], 2); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <a href="index.php" class="back-link">&larr; Back to Home</a>

</body>
</html>
