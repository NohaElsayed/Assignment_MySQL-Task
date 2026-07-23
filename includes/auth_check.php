<?php
// 1. Safe Session Initialization
// Check if a session is already active before starting one. 
// This prevents the "A session had already been started" warning 
// if this file is included in a script that already called session_start().
if (!isset($_SESSION)) session_start();

// 2. Authentication Check
// Check if the 'user_id' session variable is NOT set (meaning the user is not logged in)
if (!isset($_SESSION['user_id'])) {
    
    // Redirect the user to the login page
    header("Location: login.php");
    
    // CRITICAL: Terminate the script immediately.
    // Without exit(), the rest of the protected page code would still execute in the background!
    exit();
}
?>