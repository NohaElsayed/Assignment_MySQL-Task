<?php
/**
 * Validation & Sanitization Helpers
 * ---------------------------------
 * Reusable functions to check user input and prevent security issues.
 */

// Validates numbers and checks min/max limits
function validateNumber($input, $min = null, $max = null) {
    $errors = [];
    
    // Must be a valid number
    if (!is_numeric($input)) {
        $errors[] = "يجب إدخال رقم صحيح";
        return $errors; // Stop checking if it's not a number
    }
    
    // Check minimum limit
    if ($min !== null && $input < $min) {
        $errors[] = "الرقم يجب أن يكون أكبر من أو يساوي $min";
    }
    
    // Check maximum limit
    if ($max !== null && $input > $max) {
        $errors[] = "الرقم يجب أن يكون أقل من أو يساوي $max";
    }
    
    return $errors;
}

// Validates strings for empty values and max length
function validateString($input, $maxLength = 100) {
    $errors = [];
    $input = trim($input); // Remove extra spaces from start/end
    
    // Cannot be empty
    if (strlen($input) === 0) {
        $errors[] = "الحقل لا يمكن أن يكون فارغاً";
        return $errors;
    }
    
    // Check max length
    if (strlen($input) > $maxLength) {
        $errors[] = "عدد الحروف يجب أن يكون أقل من $maxLength حرف";
    }
    
    return $errors;
}

// Cleans input to prevent XSS attacks (Cross-Site Scripting)
function sanitize($input) {
    // Trims spaces and converts special characters (like <, >, ") to safe HTML entities
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>