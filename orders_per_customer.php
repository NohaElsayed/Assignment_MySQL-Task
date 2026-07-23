<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
$pageTitle = 'عدد الطلبات لكل عميل';

// 2. Database Query: Count orders per customer
// LEFT JOIN ensures customers with 0 orders are still included in the list
$stmt = $pdo->query("SELECT c.id, c.name, c.city, COUNT(o.id) as order_count 
                     FROM customers c 
                     LEFT JOIN orders o ON c.id = o.customer_id 
                     GROUP BY c.id, c.name, c.city 
                     ORDER BY order_count DESC"); // Sort by highest number of orders first

$customers = $stmt->fetchAll(); // Fetch all results into an array
include 'includes/header.php';   // Load header
?>

<!-- 3. Page Header Section -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-shopping-cart"></i> عدد الطلبات لكل عميل</h2>
        <p>عرض عدد الأوردرات التي قام بها كل عميل</p>
    </div>
</div>

<!-- 4. Data Table Section -->
<div class="container">
    <div class="table-container fade-in">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-user me-1"></i> اسم العميل</th>
                    <th><i class="fas fa-city me-1"></i> المدينة</th>
                    <th><i class="fas fa-shopping-bag me-1"></i> عدد الطلبات</th>
                </tr>
            </thead>
            <tbody>
            <!-- 5. Loop Through Customers -->
            <?php foreach ($customers as $i => $c): ?>
                <tr>
                    <!-- Display Row Number (starts at 1) -->
                    <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                    
                    <!-- SECURITY: Sanitize output to prevent Cross-Site Scripting (XSS) attacks -->
                    <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                    <td><?= htmlspecialchars($c['city']) ?></td>
                    
                    <!-- Display Order Count with a styled Bootstrap badge -->
                    <td>
                        <span class="badge bg-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">
                            <?= $c['order_count'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->