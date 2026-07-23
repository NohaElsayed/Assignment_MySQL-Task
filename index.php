<?php 
// 1. Session & Authentication Check
session_start();
// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = 'الرئيسية | ShopDB';
require_once 'db.php'; // Include database connection

// 2. Dashboard Statistics Queries
// fetchColumn() is highly efficient for retrieving a single value (like a count or sum)
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$totalProducts  = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders    = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

// Calculate total revenue by joining orders and products, then summing (quantity * price)
$totalRevenue   = $pdo->query("SELECT SUM(o.quantity * p.price) FROM orders o JOIN products p ON o.product_id = p.id")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    
    <!-- 3. External Resources -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- 4. Navigation Bar -->
<?php include 'includes/navbar.php'; ?>

<main class="main-content">

    <!-- 5. Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>مرحباً بكم في ShopDB</h1>
            <p>نظام إدارة متكامل باستخدام PHP + MySQL + Bootstrap 5</p>
            <a href="#stats" class="btn btn-outline-light btn-hero">
                <i class="fas fa-rocket me-2"></i> استكشف النظام
            </a>
        </div>
    </section>

    <!-- 6. Statistics Cards Section -->
    <section id="stats" class="container my-5">
        <div class="row g-4">
            <!-- Total Customers Card -->
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #1a237e, #3949ab);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalCustomers ?></h3>
                        <p>العملاء</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Products Card -->
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #2e7d32, #43a047);">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalProducts ?></h3>
                        <p>المنتجات</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Orders Card -->
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f57c00, #fb8c00);">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalOrders ?></h3>
                        <p>الطلبات</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Revenue Card -->
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #c62828, #e53935);">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <!-- number_format() ensures the revenue is displayed cleanly (e.g., 1,250 instead of 1250.00) -->
                        <h3>$<?= number_format($totalRevenue, 0) ?></h3>
                        <p>الإيرادات</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. System Features Section -->
    <section class="container my-5">
        <h3 class="text-center mb-4 fw-bold" style="color: var(--primary-dark);">
            <i class="fas fa-star text-warning me-2"></i> مميزات النظام
        </h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrap"><i class="fas fa-database"></i></div>
                    <h5>MySQL متقدم</h5>
                    <p>استعلامات معقدة، Joins، Self-Joins، وتصنيفات.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>
                    <h5>أمان عالي</h5>
                    <p>Validation، Prepared Statements، Sessions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-wrap"><i class="fas fa-mobile-alt"></i></div>
                    <h5>تصميم متجاوب</h5>
                    <p>يعمل على جميع الأجهزة بسلاسة.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- 8. Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>