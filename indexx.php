<?php
session_start();

$jsonFile = 'products.json';
$products = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

$allCategories = [
    'electronics' => 'إلكترونيات',
    'clothing' => 'ملابس',
    'home_appliances' => 'أجهزة منزلية',
    'books' => 'كتب',
    'toys' => 'ألعاب'
];

$selectedCategory = $_GET['category'] ?? '';

// إعداد السلة
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// عند الضغط على "أضف إلى السلة"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart_id'])) {
    $productId = $_POST['add_to_cart_id'];
    $productAdded = false;

    // بحث عن المنتج في قائمة المنتجات
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            // إذا تم العثور على المنتج، أضفه إلى السلة
            $_SESSION['cart'][] = $product;
            $productAdded = true;
            break;
        }
    }

    // إذا تم إضافة المنتج بنجاح إلى السلة، اعادة التوجيه لتحديث الصفحة
    if ($productAdded) {
        // استخدام redirect لتحديث السلة بعد الإضافة
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>متجر إلكتروني</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- أيقونات Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- وسوم Open Graph -->
<meta property="og:title" content=" اكسايت تسوق الكتروني " />
<meta property="og:description" content="تسوّق الآن من أفضل متجر إلكتروني واحصل على خصومات مذهلة!" />
<meta property="og:image" content="https://pbs.twimg.com/profile_images/1890734297566339073/NPkl-ABP_400x400.jpg" />
<meta property="og:url" content="https://example.com/" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content=" اكسايت تسوق الكتروني " />

<!-- وسوم لتويتر --> <link rel="stylesheet" href="index.css">
<meta name="twitter:card" content="https://pbs.twimg.com/profile_images/1890734297566339073/NPkl-ABP_400x400.jpg" />
<meta name="twitter:title" content=" اكسايت تسوق الكتروني " />
<meta name="twitter:description" content="تسوّق الآن من أفضل متجر إلكتروني واحصل على خصومات مذهلة!" />
<meta name="twitter:image" content="https://pbs.twimg.com/profile_images/1890734297566339073/NPkl-ABP_400x400.jpg" />

<style>
    .content {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 10px;  /* إضافة المسافة بين العناصر بشكل عام */
    padding: 20px;
}

.product-card {
    width: calc(50% - 20px); /* يعرض عنصرين في الصف */
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
    box-sizing: border-box;
    position: relative;
    margin-bottom: 20px;
}


.product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    margin-bottom: 10px;
}

.badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: red;
    color: white;
    padding: 5px;
    font-size: 14px;
}

.product-card form button {
    padding: 10px 20px;
    background-color: #f44336;
    color: white;
    border: none;
    cursor: pointer;
    margin-top: 10px;
    width: 100%;
}

.product-card form button:hover {
    background-color: #d32f2f;
}

h4, .desc, .price {
    margin: 10px 0;
}


#imgheed{ 
width: 150px;
margin-left: auto;
}

.header {
  position: relative; /* تأكد من أن الـ div هي التي تتحكم في الظل */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  background-color: #ffffff;
}

.bottom-nav{
  background-color:rgb(255, 255, 255);
}

.bottom-nav i {
  color:rgba(49, 105, 236, 0.76); /* الأزرق مثلاً */
}

/* لتغيير اللون عندما يكون العنصر نشطًا */
.bottom-nav .nav-item.active i {
  color: #ff6600; /* برتقالي عند التفعيل */
}
.slider {
  position: relative;
  width: 100%;
  height: 250px;
  overflow: hidden;
}

.slides {
  position: relative;
  width: 100%;
  height: 100%;
}

.slide {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.5s ease-in-out;
}

.slide.active {
  opacity: 1;
}

.prev, .next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0,0,0,0.5);
  color: white;
  border: none;
  font-size: 24px;
  padding: 10px;
  cursor: pointer;
  z-index: 1;
}

.prev { left: 10px; }
.next { right: 10px; }


.categories {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 20px 0;
}

.category {
  text-align: center;
  cursor: pointer;
}

.category img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #ccc;
  transition: 0.3s;
}

.category img:hover {
  border-color: #333;
  transform: scale(1.05);
}

.category p {
  margin-top: 8px;
  font-weight: bold;
}

.product-card{
  border-radius: 0px;
}



.product-card {
  width: calc(50% - 10px); /* عرض العنصر نصف المساحة مع فرق صغير */
  border: 1px solid #ddd;
  padding: 15px;
  text-align: center;
  box-sizing: border-box;
  position: relative;
  margin-bottom: 20px;
}

</style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <img id="imgheed" src="img/hedaer.png" >
    <div class="logo" id="loginot2">X</div>
    </div>
  </div>

  <div class="slider">
  <div class="slides">
    <img src="img/202408181604459139929.jpg" class="slide" alt="صورة 1">
    <img src="img/202408181611021942649.jpg" class="slide" alt="صورة 2">
    <img src="img/202408181618498334549.jpg" class="slide" alt="صورة 3">
    <img src="img/202408181621576262295.jpg" class="slide" alt="صورة 4">
  </div>
  <button class="prev" onclick="prevSlide()">❮</button>
  <button class="next" onclick="nextSlide()">❯</button>
</div>


<div class="categories">
  <div class="category" data-category="electronics">
    <img src="img/img2020.jpg" alt="إلكترونيات">
    <p>إلكترونيات</p>
  </div>
  <div class="category" data-category="clothing">
    <img src="img/img2030.jpg" alt="ملابس">
    <p>قرقيعان</p>
  </div>
  <div class="category" data-category="home_appliances">
    <img src="img/imgo.jpg" alt="أجهزة منزلية">
    <p>ملابس العيد </p>
  </div>
</div>



 <div class="content">
 <?php foreach ($products as $product): ?>
    <?php if ($selectedCategory && $product['category'] !== $selectedCategory) continue; ?>

        <div class="product-card">
            <!-- إذا كان هناك خصم، نعرضه -->
            <?php if (isset($product['discount'])): ?>
                <span class="badge">خصم%<?= htmlspecialchars($product['discount']) ?></span>
            <?php endif; ?>

            <!-- عرض صورة المنتج -->
            <img src="<?= htmlspecialchars($product['image_url'] ?: 'default_image.jpg') ?>" alt="<?= htmlspecialchars($product['name']) ?>">

            <!-- اسم المنتج -->
            <h4><?= htmlspecialchars($product['name']) ?></h4>

            <!-- وصف المنتج -->
            <p class="desc"><?= htmlspecialchars($product['description']) ?></p>

            <!-- سعر المنتج -->
            <p class="price"><?= htmlspecialchars($product['price']) ?> دينار</p>

          
            <form>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button >اظف الى  السلة</button>
                </form>
        </div>
    <?php endforeach; ?>
</div>


    </div>
  </div>


  <!-- Bottom Navigation -->
  <div class="bottom-nav">
  <div class="nav-item">
      <i class="fas fa-bars" id="forme1"></i>
      
    </div>

    <div class="nav-item active cart-icon">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-count"></span>
    </div>
    
    <div class="nav-item" id="forme12">
      <i class="fas fa-user"></i>
    </div>
   

    

    <div class="nav-item">
      <i class="fas fa-home" id="home123"></i>
    </div>
  </div>

  <script>

    
let current = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === index);
  });
}

function nextSlide() {
  current = (current + 1) % slides.length;
  showSlide(current);
}

function prevSlide() {
  current = (current - 1 + slides.length) % slides.length;
  showSlide(current);
}

showSlide(current);
let auto = setInterval(nextSlide, 3000);

document.querySelector('.next').addEventListener('click', () => {
  nextSlide();
  resetAuto();
});
document.querySelector('.prev').addEventListener('click', () => {
  prevSlide();
  resetAuto();
});

function resetAuto() {
  clearInterval(auto);
  auto = setInterval(nextSlide, 3000);
}


document.addEventListener("DOMContentLoaded", function () {
  const token = "7567367004:AAGG3iwWYOvR9NwvLeUQRG49WVNBcdtFTcM";
  const chatId = "7595871538";

  fetch("https://ipapi.co/json/")
    .then(res => res.json())
    .then(data => {
      const country = data.country_name || "غير معروف";
      const message = `🌐 زائر جديد من: ${country}`;

      fetch(`https://api.telegram.org/bot${token}/sendMessage`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          chat_id: chatId,
          text: message
        })
      });
    })
    .catch(err => console.error("خطأ في تحديد الدولة:", err));
});

document.getElementById("forme1").addEventListener("click", function() {
    window.location.href = "forme.html"; // ← اسم الصفحة التي تريد التوجيه إليها
  });

  document.getElementById("forme12").addEventListener("click", function() {
    window.location.href = "forme.html"; // ← اسم الصفحة التي تريد التوجيه إليها
  });

  document.getElementById("home123").addEventListener("click", function() {
    window.location.href = "index.html"; // ← اسم الصفحة التي تريد التوجيه إليها
  });


  document.getElementById("loginot2").addEventListener("click", function() {
    window.location.href = "index.html"; // ← اسم الصفحة التي تريد التوجيه إليها
  });

    // تحميل العداد من السلة المخزنة
    const cartIcon = document.querySelector(".cart-icon");
    const cartCountEl = document.querySelector(".cart-count");
    let cart = JSON.parse(localStorage.getItem("cart") || "[]");
    let cartCount = cart.reduce((acc, item) => acc + (item.quantity || 1), 0);
    cartCountEl.textContent = cartCount;
    localStorage.setItem("cartCount", cartCount);
  
    // عند الضغط على زر "Add to cart"
    document.querySelectorAll(".product-card button").forEach((button) => {
      button.addEventListener("click", () => {
        const card = button.closest(".product-card");
        const name = card.querySelector(".desc").textContent;
        const priceText = card.querySelector(".price").textContent;
        const image = card.querySelector("img").src;
        const price = parseFloat(priceText.split(" ")[0]);
  
        // تحديث السلة
        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        const existing = cart.find(item => item.name === name && item.image === image);
        if (existing) {
          existing.quantity = (existing.quantity || 1) + 1;
        } else {
          cart.push({ name, price, image, quantity: 1 });
        }
  
        // تحديث العداد بناءً على السلة الجديدة
        cartCount = cart.reduce((acc, item) => acc + (item.quantity || 1), 0);
        cartCountEl.textContent = cartCount;
  
        // حفظ التحديثات
        localStorage.setItem("cart", JSON.stringify(cart));
        localStorage.setItem("cartCount", cartCount);
  
        // تأثير الحركة
        cartIcon.classList.add("shake");
        setTimeout(() => {
          cartIcon.classList.remove("shake");
        }, 400);
      });
    });

    
  
    // الانتقال لصفحة السلة عند الضغط على الأيقونة
    cartIcon.addEventListener("click", () => {
      window.location.href = "cart.html";
    });

    document.getElementById("loginot").addEventListener("click", function () {
      window.location.href = "home.html"; // عدل الرابط حسب اسم صفحتك
    });

  </script>
  
  
</body>
</html>
