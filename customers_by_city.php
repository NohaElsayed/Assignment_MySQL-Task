<?php 
// 1. Setup & Initialization
require_once 'includes/auth_check.php'; // Ensure user is logged in
require_once 'db.php';                  // Database connection
$pageTitle = 'العملاء حسب المدينة';

// 2. Fetch Unique Cities for Dropdown
// PDO::FETCH_COLUMN returns a simple 1D array of values (e.g., ['Cairo', 'Alex', ...])
// This is highly efficient and perfect for populating <option> tags
$cities = $pdo->query("SELECT DISTINCT city FROM customers ORDER BY city")->fetchAll(PDO::FETCH_COLUMN);

$results = [];
$selectedCity = '';

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['city'])) {
    $selectedCity = $_POST['city'];
    
    // SECURITY: Use prepared statement to prevent SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE city = ? ORDER BY name");
    $stmt->execute([$selectedCity]);
    $results = $stmt->fetchAll();
}

include 'includes/header.php'; // Load header
?>

<!-- 4. Page Header Section -->
<div class="page-header">
    <div class="container">
        <h2><i class="fas fa-city"></i> العملاء حسب المدينة</h2>
        <p>اختر مدينة لعرض عملائها مرتبين حسب الاسم</p>
    </div>
</div>

<div class="container">
    <!-- 5. Search Form -->
    <div class="form-container fade-in">
        <h5><i class="fas fa-map-marker-alt"></i> اختر المدينة</h5>
        <form method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">المدينة</label>
                    <select name="city" class="form-select" required>
                        <option value="">-- اختر مدينة --</option>
                        
                        <!-- Populate Dropdown: Retain selected value after form submission -->
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= htmlspecialchars($city) ?>" <?= $selectedCity == $city ? 'selected' : '' ?>>
                                <?= htmlspecialchars($city) ?>
                            </option>
                        <?php endforeach; ?>
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> عرض
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 6. Display Results -->
    <?php if (!empty($results)): ?>
        <!-- Info Alert showing the count of results -->
        <div class="alert alert-info fade-in">
            <i class="fas fa-info-circle"></i> عدد العملاء في <strong><?= htmlspecialchars($selectedCity) ?></strong>: <strong><?= count($results) ?></strong>
        </div>
        
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
                        <!-- SECURITY: Sanitize output to prevent Cross-Site Scripting (XSS) -->
                        <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
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