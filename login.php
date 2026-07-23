<?php
// 1. Session & Initialization
session_start();            // Start the session to manage user login state
require_once 'db.php';      // Include database connection

// Redirect already logged-in users to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

// 2. Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim whitespace from the name to prevent login issues due to accidental spaces
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Ensure both fields are provided
    if ($name && $password) {
        // SECURITY: Use prepared statement to fetch user by name (Prevents SQL Injection)
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE name = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch();
        
        // Verify user exists AND the provided password matches the hashed password in the database
        if ($user && password_verify($password, $user['password'])) {
            // Create session variables to keep the user logged in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Redirect to the main dashboard
            header("Location: index.php");
            exit();
        } else {
            // Generic error message (prevents username enumeration attacks)
            $error = "الاسم أو كلمة المرور غير صحيحة";
        }
    } else {
        $error = "يرجى ملء جميع الحقول";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | ShopDB</title>
    
    <!-- External Resources -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- 3. Authentication UI Wrapper -->
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="card-header">
            <i class="fas fa-sign-in-alt"></i>
            <h3>تسجيل الدخول</h3>
        </div>
        <div class="card-body">
            
            <!-- Display Login Error (if any) -->
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                </div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-1"></i> الاسم</label>
                    <input type="text" name="name" class="form-control" required autocomplete="username">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-1"></i> كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-1"></i> دخول
                </button>
            </form>
            
            <!-- Registration Redirect Link -->
            <div class="text-center mt-4">
                <span class="text-muted">ليس لديك حساب؟</span>
                <a href="register.php" class="text-decoration-none fw-bold text-primary">سجل الآن</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>