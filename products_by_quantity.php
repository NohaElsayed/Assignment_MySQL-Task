<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
require_once 'validation/validation.php';          // Validation helper functions
$pageTitle = 'المنتجات حسب الكمية';

$results = [];
$error = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate quantity input (100-5000 range)
    $errors = validateNumber($_POST['qty'] ?? '', 100, 5000);
    
    if (empty($errors)) {
        // SQL Query: Get products with total quantity > input value
        // HAVING clause filters after aggregation (GROUP BY)
        // ORDER BY total DESC shows highest selling products first
        $stmt = $pdo->prepare("SELECT p.name, SUM(o.quantity) as total 
                               FROM products p 
                               JOIN orders o ON p.id = o.product_id 
                               GROUP BY p.id, p.name 
                               HAVING total > ? 
                               ORDER BY total DESC");
        
        $stmt->execute([$_POST['qty']]); // Prepared statement prevents SQL Injection
        $results = $stmt->fetchAll();
    } else {
        $error = $errors[0];
    }
}

include 'includes/header.php'; // Load header
?>

<!-- 3. Page Header & Search Form -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-boxes"></i> المنتجات حسب إجمالي الكمية</h2>
        <p>أدخل رقماً من 100 إلى 5000 لعرض المنتجات التي تجاوزت هذه الكمية</p>
    </div>
</div>

<div class="container">
    <div class="form-container fade-in">
        <h5><i class="fas fa-calculator"></i> أدخل الرقم</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">الحد الأدنى للكمية (100 - 5000)</label>
                    <input type="number" name="qty" class="form-control" placeholder="مثال: 200" min="100" max="5000" required>
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

    <!-- 5. Display Results Table -->
    <?php if (!empty($results)): ?>
    <!-- 1. Results Container: Only renders if the database returned data -->
    <div class="table-container fade-in">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-box me-1"></i> المنتج</th>
                    <th><i class="fas fa-cubes me-1"></i> إجمالي الكمية المباعة</th>
                </tr>
            </thead>
            <tbody>
            <!-- 2. Loop Through Results: $i is the index (starts at 0), $r is the current row data -->
            <?php foreach ($results as $i => $r): ?>
                <tr>
                    <!-- Display Row Number: Add 1 to $i so the count starts at 1 instead of 0 -->
                    <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                    
                    <!-- SECURITY: Sanitize output to prevent Cross-Site Scripting (XSS) attacks -->
                    <td><strong><?= htmlspecialchars($r['name']) ?></strong></td>
                    
                    <!-- Display Total Quantity with a styled Bootstrap badge -->
                    <td><span class="badge bg-info"><?= $r['total'] ?> قطعة</span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->