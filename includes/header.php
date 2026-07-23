<?php
// 1. Safe Session & Authentication Check
// Prevents "session already started" warnings if included multiple times
if (!isset($_SESSION)) session_start();

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // CRITICAL: Stops script execution immediately after redirect
}
?>

<!DOCTYPE html>
<!-- 2. HTML Setup: Arabic Language and Right-to-Left (RTL) Direction -->
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic Page Title: Uses $pageTitle if set, otherwise defaults to 'Shop' -->
    <title><?= $pageTitle ?? 'Shop' ?></title>
    
    <!-- 3. External Stylesheets (CDNs) -->
    <!-- Bootstrap 5 CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts: Cairo (Optimized for Arabic text) -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Project Styles -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- 4. Navigation Bar -->
    <!-- Includes the top menu (must be placed AFTER session start so it can access $_SESSION data) -->
    <?php include 'includes/navbar.php'; ?>

    <!-- 5. Main Content Area -->
    <!-- Child pages will inject their specific content here or after this block -->
    <main class="main-content">
        <!-- Page-specific content goes here -->
    </main>

    <!-- Note: The closing </main>, footer, and JS scripts are typically included via 'includes/footer.php' -->