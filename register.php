<?php
// 1. Setup & Initialization
require_once 'db.php';          // Database connection
require_once 'validation/validation.php';  // Validation helper functions
$error = '';
$success = '';

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract and sanitize input data
    $name = $_POST['name'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $city = $_POST['city'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Run validation rules and merge all errors into one array
    $errors = array_merge(
        validateString($name, 100),
        validateNumber($salary, 0), // Salary must be 0 or greater
        validateString($city, 100)
    );
    
    // Custom password length check
    if (strlen($password) < 6) {
        $errors[] = "كلمة المرور يجب أن تكون 6 أحرف على الأقل";
    }
    
    // 3. Process Registration if No Errors
    if (empty($errors)) {
        // SECURITY: Hash the password before saving to database
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // SECURITY: Use prepared statement to prevent SQL Injection
        $stmt = $pdo->prepare("INSERT INTO customers (name, salary, city, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $salary, $city, $hashed]);
        
        $success = "تم التسجيل بنجاح! <a href='login.php' class='alert-link'>سجل دخولك الآن</a>";
    } else {
        // Join all error messages with a line break for display
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب | ShopDB</title>
    
    <!-- External Resources -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- 4. Authentication UI Wrapper -->
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            <h3>إنشاء حساب جديد</h3>
        </div>
        <div class="card-body">
            
            <!-- Display Validation Errors -->
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                </div>
            <?php endif; ?>
            
            <!-- Display Success Message -->
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?= $success ?>
                </div>
            <?php endif; ?>
            
            <!-- 5. Registration Form -->
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-1"></i> الاسم</label>
                    <input type="text" name="name" class="form-control" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-dollar-sign me-1"></i> المرتب</label>
                    <input type="number" name="salary" class="form-control" required min="0">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-city me-1"></i> المدينة</label>
                    <input type="text" name="city" class="form-control" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-1"></i> كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-user-plus me-1"></i> تسجيل
                </button>
            </form>
            
            <!-- Login Redirect Link -->
            <div class="text-center mt-4">
                <span class="text-muted">لديك حساب بالفعل؟</span>
                <a href="login.php" class="text-decoration-none fw-bold text-primary">سجل دخولك</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>