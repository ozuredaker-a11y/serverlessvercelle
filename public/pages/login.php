<?php
    error_reporting(E_ALL);
    session_start();
    
    echo "<!DOCTYPE html><html><head><title>Login Page Test</title></head><body>";
    echo "<h1>Login Page is Loading!</h1>";
    echo "<p>This is a test to see if the login page executes properly.</p>";
    
    // Test includes one by one
    try {
        echo "<p>Loading antibots.php...</p>";
        include "../antibots-debug/antibots.php";
        echo "<p>antibots.php loaded successfully</p>";
    } catch (Exception $e) {
        echo "<p>Error loading antibots.php: " . $e->getMessage() . "</p>";
    }
    
    try {
        echo "<p>Loading functions.php...</p>";
        include '../setting/functions.php';
        echo "<p>functions.php loaded successfully</p>";
    } catch (Exception $e) {
        echo "<p>Error loading functions.php: " . $e->getMessage() . "</p>";
    }
    
    try {
        echo "<p>Loading current-page.php...</p>";
        include '../includes/current-page.php';
        echo "<p>current-page.php loaded successfully</p>";
    } catch (Exception $e) {
        echo "<p>Error loading current-page.php: " . $e->getMessage() . "</p>";
    }
    
    echo "<p>Basic login page test complete.</p>";
    echo "<p><a href='/'>Back to Captcha</a></p>";
    echo "</body></html>";
    exit;
?>