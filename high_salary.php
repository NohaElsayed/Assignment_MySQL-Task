<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
$pageTitle = 'العملاء ذوو المرتبات العالية';

// 2. Database Query: Fetch high-salary customers
// Filters for salary > 20000 and sorts results from highest to lowest salary
$stmt = $pdo->query("SELECT * FROM customers WHERE salary > 20000 ORDER BY salary DESC");
$customers = $stmt->fetchAll(); // Fetch all matching records into an array

include 'includes/header.php'; // Load header
?>

<!-- 3. Page Header Section -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-money-bill-wave"></i> العملاء ذوو المرتبات العالية</h2>
        <p>عرض جميع العملاء الذين تتجاوز مرتباتهم 20,000</p>
    </div>
</div>

<!-- 4. Data Display Section -->
<div class="container">
    <!-- Empty State: Shown if no customers match the > 20000 criteria -->
    <?php if (empty($customers)): ?>
        <div class="empty-state">
            <i class="fas fa-user-slash"></i>
            <h5>لا يوجد عملاء بهذا المعيار</h5>
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
            <!-- 5. Loop Through Results: $i is the index, $c is the current customer data -->
            <?php foreach ($customers as $i => $c): ?>
                <tr>
                    <!-- Display Row Number (starts at 1) -->
                    <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                    
                    <!-- SECURITY: Sanitize output to prevent Cross-Site Scripting (XSS) attacks -->
                    <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                    
                    <!-- Format salary with 2 decimal places for clean currency display -->
                    <td><span class="badge bg-success">$<?= number_format($c['salary'], 2) ?></span></td>
                    
                    <td><?= htmlspecialchars($c['city']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->