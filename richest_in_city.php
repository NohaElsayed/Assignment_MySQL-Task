<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
require_once 'validation.php';          // Validation helper functions
$pageTitle = 'أغنى 3 أشخاص في المدينة';

$results = [];
$error = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate city name
    $errors = validateString($_POST['city'] ?? '', 100);
    
    if (empty($errors)) {
        // Query: Get top 3 highest salaries in the specified city
        // ORDER BY salary DESC ensures the richest are first, LIMIT 3 restricts to top 3
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE city = ? ORDER BY salary DESC LIMIT 3");
        $stmt->execute([$_POST['city']]); // Prepared statement prevents SQL Injection
        $results = $stmt->fetchAll();
        
        if (empty($results)) {
            $error = "لا يوجد عملاء في هذه المدينة";
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
        <h2><i class="fas fa-crown"></i> أغنى 3 أشخاص في المدينة</h2>
        <p>أدخل اسم المدينة لعرض أغنى 3 عملاء فيها</p>
    </div>
</div>

<div class="container">
    <div class="form-container fade-in">
        <h5><i class="fas fa-city"></i> اسم المدينة</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">اسم المدينة</label>
                    <input type="text" name="city" class="form-control" placeholder="مثال: Cairo" required maxlength="100">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-warning w-100">
                        <i class="fas fa-crown"></i> عرض الأغنى
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

    <!-- 5. Display Results (Top 3 Cards) -->
    <?php if (!empty($results)): ?>
    <div class="row g-4 fade-in">
        <?php 
        // Define Gold, Silver, and Bronze styles for the top 3 ranks
        $colors = [
            ['linear-gradient(135deg, #FFD700, #FFA500)', 'fas fa-trophy'], // 1st Place (Gold)
            ['linear-gradient(135deg, #C0C0C0, #A9A9A9)', 'fas fa-medal'],  // 2nd Place (Silver)
            ['linear-gradient(135deg, #CD7F32, #8B4513)', 'fas fa-award']   // 3rd Place (Bronze)
        ];
        
        foreach ($results as $i => $c): 
        ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    
                    <!-- Dynamic Rank Icon with Gradient Background -->
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: <?= $colors[$i][0] ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                        <i class="<?= $colors[$i][1] ?>"></i>
                    </div>
                    
                    <!-- Customer Details (Sanitized to prevent XSS) -->
                    <h4 class="fw-bold mb-2"><?= htmlspecialchars($c['name']) ?></h4>
                    <p class="text-muted mb-3"><i class="fas fa-city me-1"></i> <?= htmlspecialchars($c['city']) ?></p>
                    
                    <!-- Formatted Salary Badge -->
                    <div class="badge bg-success fs-5 px-3 py-2">
                        <i class="fas fa-dollar-sign me-1"></i> $<?= number_format($c['salary'], 2) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> <!-- Load footer -->