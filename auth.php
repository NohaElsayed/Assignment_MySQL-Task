<?php
// 1. Start or resume the session to access session variables
session_start();

// 2. Authentication Check
// Check if the 'user_id' session variable is NOT set (meaning the user is not logged in)
if (!isset($_SESSION['user_id'])) {
    
    // Redirect the user to the login page
    header("Location: login.php");
    
    // SECURITY: Terminate the script immediately. 
    // If you forget exit(), the rest of the protected page code will still execute in the background!
    exit();
}
?>