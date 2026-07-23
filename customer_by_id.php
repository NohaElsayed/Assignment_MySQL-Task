<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
require_once 'validation/validation.php';          // Validation helper functions
$pageTitle = 'بحث عميل بالـ ID';

$customer = null; // Will hold the single customer record if found
$error = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate ID (must be a number >= 1)
    $errors = validateNumber($_POST['id'] ?? '', 1);
    
    if (empty($errors)) {
        // SECURITY: Use prepared statement to prevent SQL Injection
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        
        // fetch() is used instead of fetchAll() because an ID is unique and returns only 1 row
        $customer = $stmt->fetch();
        
        if (!$customer) {
            $error = "لم يتم العثور على العميل";
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
        <h2><i class="fas fa-hashtag"></i> البحث عن عميل بالـ ID</h2>
        <p>أدخل رقم العميل لعرض بياناته الكاملة</p>
    </div>
</div>

<div class="container">
    <div class="form-container fade-in">
        <h5><i class="fas fa-search"></i> نموذج البحث</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">رقم العميل (ID)</label>
                    <input type="number" name="id" class="form-control" placeholder="مثال: 1" min="1" required>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 4. Display Validation/Not Found Error -->
    <?php if ($error): ?>
        <div class="alert alert-danger fade-in">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- 5. Display Customer Details Card -->
    <?php if ($customer): ?>
    <div class="card fade-in">
        <div class="card-header">
            <i class="fas fa-user-circle"></i> بيانات العميل
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Customer ID -->
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #1a237e, #3949ab);">
                            <i class="fas fa-hashtag"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $customer['id'] ?></h3>
                            <p>رقم العميل</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Name (Sanitized for XSS prevention) -->
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #2e7d32, #43a047);">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="small"><?= htmlspecialchars($customer['name']) ?></h3>
                            <p>الاسم</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Salary -->
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f57c00, #fb8c00);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>$<?= number_format($customer['salary'], 0) ?></h3>
                            <p>المرتب</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer City (Sanitized for XSS prevention) -->
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #c62828, #e53935);">
                            <i class="fas fa-city"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="small"><?= htmlspecialchars($customer['city']) ?></h3>
                            <p>المدينة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->