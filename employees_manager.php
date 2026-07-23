<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
$pageTitle = 'هيكل الموظفين والمديرين';

// 2. Database Query: Self-Join
// Joins the 'employees' table to ITSELF to link each employee (e) with their manager (m)
// LEFT JOIN ensures that the top-level manager (who has no manager_id) is still included
$stmt = $pdo->query("SELECT e.id, e.name AS employee, m.name AS manager 
                     FROM employees e 
                     LEFT JOIN employees m ON e.manager_id = m.id 
                     ORDER BY e.id");
                     
$employees = $stmt->fetchAll(); // Fetch all results into an array
include 'includes/header.php';   // Load header
?>

<!-- 3. Page Header Section -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-sitemap"></i> هيكل الموظفين والمديرين</h2>
        <p>عرض كل موظف مع اسم المدير الخاص به (Self-Join)</p>
    </div>
</div>

<!-- 4. Data Table Section -->
<div class="container">
    <div class="table-container fade-in">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-user-tie me-1"></i> الموظف</th>
                    <th><i class="fas fa-user-shield me-1"></i> المدير</th>
                </tr>
            </thead>
            <tbody>
            <!-- 5. Loop Through Employees -->
            <?php foreach ($employees as $i => $e): ?>
                <tr>
                    <!-- Display Row Number -->
                    <td><span class="badge bg-secondary"><?= $i + 1 ?></span></td>
                    
                    <!-- SECURITY: Sanitize employee name to prevent XSS -->
                    <td><strong><?= htmlspecialchars($e['employee']) ?></strong></td>
                    
                    <!-- Conditional Display: Check if manager exists -->
                    <td>
                        <?php if ($e['manager']): ?>
                            <!-- Regular employee: Show manager's name -->
                            <span class="badge bg-primary">
                                <i class="fas fa-user-shield me-1"></i> <?= htmlspecialchars($e['manager']) ?>
                            </span>
                        <?php else: ?>
                            <!-- Top-level employee (manager_id is NULL): Show as General Manager -->
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i> المدير العام
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->