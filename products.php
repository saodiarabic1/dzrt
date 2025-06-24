<?php
// تحميل المنتجات من JSON
$jsonFile = 'products.json';
$products = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// هذه هي الفئات المعرّفة مسبقًا في admin.php
$allCategories = [
    'electronics' => 'إلكترونيات',
    'clothing' => 'ملابس',
    'home_appliances' => 'أجهزة منزلية',
    'books' => 'كتب',
    'toys' => 'ألعاب'
];

// الفئة المحددة (إن وجدت)
$selectedCategory = $_GET['category'] ?? '';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض المنتجات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            direction: rtl;
        }
        .category-boxes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .category-box {
            padding: 10px 20px;
            border: 1px solid #007BFF;
            background-color: #f0f8ff;
            color: #007BFF;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .category-box:hover {
            background-color: #007BFF;
            color: white;
        }
        .category-box.active {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
        }
        .product {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 15px;
            width: 200px;
            text-align: center;
        }
        .product img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>المنتجات</h1>

<!-- صناديق الفئات -->
<div class="category-boxes">
    <a href="?" class="category-box <?= $selectedCategory == '' ? 'active' : '' ?>">جميع الفئات</a>
    <?php foreach ($allCategories as $key => $label): ?>
        <a href="?category=<?= urlencode($key) ?>" class="category-box <?= $selectedCategory == $key ? 'active' : '' ?>">
            <?= htmlspecialchars($label) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- عرض المنتجات -->
<div class="product-list">
    <?php
    $found = false;
    foreach ($products as $product) {
        if ($selectedCategory && $product['category'] !== $selectedCategory) continue;

        $found = true;
        echo '<div class="product">';
        echo '<img src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
        echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
        echo '<p>' . htmlspecialchars($product['description']) . '</p>';
        echo '<p>السعر: ' . htmlspecialchars($product['price']) . ' ريال</p>';
        echo '<p>الفئة: ' . htmlspecialchars($allCategories[$product["category"]] ?? $product["category"]) . '</p>';
        echo '</div>';
    }

    if (!$found) {
        echo "<p>لا توجد منتجات ضمن هذه الفئة.</p>";
    }
    ?>
</div>

</body>
</html>
