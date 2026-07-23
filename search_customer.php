<?php 
// 1. Includes & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
require_once 'validation.php';          // Validation helper functions
$pageTitle = 'بحث عن عميل بالاسم';

// Initialize variables for the view
$results = [];
$searched = false;
$error = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    
    // Validate input (max 100 chars, not empty)
    $errors = validateString($name, 100);
    
    if (empty($errors)) {
        $searched = true;
        
        // Prepare SQL query using LIKE for partial name matching
        // Using prepare() prevents SQL Injection attacks
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        $results = $stmt->fetchAll();
    } else {
        $error = $errors[0]; // Store the first validation error
    }
}

include 'includes/header.php'; // Load header
?>

<!-- 3. Page Header & Search Form -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-search"></i> البحث عن عميل بالاسم</h2>
        <p>ابحث عن أي عميل باستخدام جزء من اسمه</p>
    </div>
</div>

<div class="container">
    <div class="form-container fade-in">
        <h5><i class="fas fa-user-search"></i> نموذج البحث</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">اسم العميل</label>
                    <input type="text" name="name" class="form-control" placeholder="مثال: Ahmed" required maxlength="100">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> بحث
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

    <!-- 5. Display Search Results -->
    <?php if ($searched): ?>
        <div class="alert alert-info fade-in">
            <i class="fas fa-info-circle"></i> تم العثور على <strong><?= count($results) ?></strong> نتيجة
        </div>
        
        <!-- Empty State -->
        <?php if (empty($results)): ?>
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <h5>لا يوجد عملاء بهذا الاسم</h5>
            </div>
        <?php else: ?>
        
        <!-- Results Table -->
        <div class="table-container fade-in">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="fas fa-user me-1"></i> الاسم</th>
                        <th><i class="fas fa-money-bill me-1"></i> المرتب</th>
                        <th><i class="fas fa-city me-1"></i> المدينة</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $i => $c): ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                        <!-- htmlspecialchars() is used to prevent XSS attacks -->
                        <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                        <td><span class="badge bg-success">$<?= number_format($c['salary'], 2) ?></span></td>
                        <td><?= htmlspecialchars($c['city']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->