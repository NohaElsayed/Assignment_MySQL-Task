<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
require_once 'validation/validation.php';          // Validation helper functions
$pageTitle = 'تفاصيل المنتج';

$product = null;
$orders = [];
$error = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate Product ID (must be a number >= 1)
    $errors = validateNumber($_POST['pid'] ?? '', 1);
    
    if (empty($errors)) {
        $pid = $_POST['pid'];
        
        // Query 1: Get product details and count how many times it was sold
        // LEFT JOIN ensures products with 0 sales are still returned (COUNT will be 0)
        $stmt = $pdo->prepare("SELECT p.*, COUNT(o.id) as times_sold 
                               FROM products p 
                               LEFT JOIN orders o ON p.id = o.product_id 
                               WHERE p.id = ? GROUP BY p.id");
        $stmt->execute([$pid]);
        $product = $stmt->fetch();
        
        // Query 2: If product exists, get all orders for it
        // Joins with 'customers' to get buyer details, sorted by salary (Richest first)
        if ($product) {
            $stmt = $pdo->prepare("SELECT o.id as order_id, c.name, c.salary 
                                   FROM orders o 
                                   JOIN customers c ON o.customer_id = c.id 
                                   WHERE o.product_id = ? 
                                   ORDER BY c.salary DESC");
            $stmt->execute([$pid]);
            $orders = $stmt->fetchAll();
        } else {
            $error = "لم يتم العثور على المنتج";
        }
    } else {
        $error = $errors[0];
    }
}

include 'includes/header.php'; // Load header
?>

<!-- 3. Page Header & Search Form -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-info-circle"></i> تفاصيل المنتج</h2>
        <p>عرض عدد مرات البيع، الأوردرات، والعملاء مرتبين حسب الثراء</p>
    </div>
</div>

<div class="container">
    <div class="form-container fade-in">
        <h5><i class="fas fa-box"></i> رقم المنتج</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">ID المنتج</label>
                    <input type="number" name="pid" class="form-control" placeholder="مثال: 1" min="1" required>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> عرض
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 4. Display Validation Error -->
    <?php if ($error): ?>
        <div class="alert alert-danger fade-in">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- 5. Display Product Stats Cards -->
    <?php if ($product): ?>
    <div class="row g-4 mb-4 fade-in">
        <!-- Product Name Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #1a237e, #3949ab);">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3 class="small"><?= htmlspecialchars($product['name']) ?></h3>
                    <p>اسم المنتج</p>
                </div>
            </div>
        </div>
        <!-- Price Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #2e7d32, #43a047);">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stat-info">
                    <h3>$<?= number_format($product['price'], 2) ?></h3>
                    <p>السعر</p>
                </div>
            </div>
        </div>
        <!-- Times Sold Card -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f57c00, #fb8c00);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $product['times_sold'] ?></h3>
                    <p>مرات البيع</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Display Orders & Customers Table -->
    <?php if (!empty($orders)): ?>
    <div class="table-container fade-in">
        <h5 class="mb-3 fw-bold" style="color: var(--primary-dark);">
            <i class="fas fa-list me-2"></i> الأوردرات والعملاء (مرتبة من الأغنى للأفقر)
        </h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-receipt me-1"></i> رقم الأوردر</th>
                    <th><i class="fas fa-user me-1"></i> اسم العميل</th>
                    <th><i class="fas fa-dollar-sign me-1"></i> مرتب العميل</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $i => $o): ?>
                <tr>
                    <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                    <td><span class="badge bg-primary">#<?= $o['order_id'] ?></span></td>
                    <!-- SECURITY: Sanitize output to prevent XSS -->
                    <td><strong><?= htmlspecialchars($o['name']) ?></strong></td>
                    <td><span class="badge bg-success">$<?= number_format($o['salary'], 2) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->