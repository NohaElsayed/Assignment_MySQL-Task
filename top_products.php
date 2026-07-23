<?php 
// 1. Setup & Authentication
require_once 'includes/auth_check.php'; // Ensure the user is logged in
require_once 'db.php';                  // Include database connection
$pageTitle = 'المنتجات الأكثر مبيعاً';  // Set page title for the header

// 2. Database Query: Get Top Selling Products
// Joins 'products' and 'orders' to calculate total sold and total revenue per product
$stmt = $pdo->query("SELECT p.id, p.name, p.price, 
                     SUM(o.quantity) as total_sold, 
                     SUM(o.quantity * p.price) as total_revenue 
                     FROM products p 
                     JOIN orders o ON p.id = o.product_id 
                     GROUP BY p.id, p.name, p.price 
                     ORDER BY total_sold DESC"); // Sort by highest sold first
                     
$products = $stmt->fetchAll(); // Fetch all results into an array

include 'includes/header.php'; // Load the top navigation and header
?>

<!-- 3. Page Header Section -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-star"></i> المنتجات الأكثر مبيعاً</h2>
        <p>عرض المنتجات مع عدد القطع المباعة والإيرادات</p>
    </div>
</div>

<!-- 4. Data Table Section -->
<div class="container">
    <div class="table-container fade-in">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-box me-1"></i> المنتج</th>
                    <th><i class="fas fa-tag me-1"></i> السعر</th>
                    <th><i class="fas fa-cubes me-1"></i> القطع المباعة</th>
                    <th><i class="fas fa-dollar-sign me-1"></i> الإيرادات</th>
                </tr>
            </thead>
            <tbody>
            <!-- 5. Loop Through Products -->
            <?php foreach ($products as $i => $p): ?>
                <tr>
                    <td>
                        <!-- Highlight Top 3 products with a gold/warning badge -->
                        <?php if ($i < 3): ?>
                            <span class="badge-rank badge bg-warning text-dark"><?= $i + 1 ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= $i + 1 ?></span>
                        <?php endif; ?>
                    </td>
                    
                    <!-- Display Data (Sanitized and Formatted) -->
                    <td><strong><?= htmlspecialchars($p['name']) ?></strong></td> <!-- Prevent XSS -->
                    <td>$<?= number_format($p['price'], 2) ?></td>               <!-- Format price -->
                    <td><span class="badge bg-info"><?= $p['total_sold'] ?> قطعة</span></td>
                    <td><span class="badge bg-success">$<?= number_format($p['total_revenue'], 2) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->