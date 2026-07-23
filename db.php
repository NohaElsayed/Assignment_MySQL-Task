<?php
/**
 * Database Configuration and Connection
 * --------------------------------------
 * This file establishes a connection to the MySQL database using PDO (PHP Data Objects).
 * It is included in other files to access the $pdo variable.
 */

// --- 1. Database Credentials ---
$host = 'localhost';      // The database server (default is localhost for Laragon/XAMPP)
$dbname = 'shop_db';      // The name of your database
$username = 'root';       // Database username (default is 'root' in Laragon)
$password = '';           // Database password (default is empty in Laragon)

try {
    // --- 2. Establish the Connection ---
    // We use charset=utf8 to ensure Arabic characters and special symbols display correctly.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // --- 3. Configure PDO Settings ---
    
    // Set error mode to Exception. 
    // This means if a SQL query fails, PHP will throw a catchable error instead of failing silently.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to Associative Array.
    // This allows you to fetch data using column names (e.g., $row['user_name']) 
    // instead of numeric indexes (e.g., $row[0]).
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // --- 4. Handle Connection Errors ---
    // If the connection fails (e.g., wrong password or database doesn't exist), 
    // stop the script and display the specific error message.
    die("Connection failed: " . $e->getMessage());
}
?>