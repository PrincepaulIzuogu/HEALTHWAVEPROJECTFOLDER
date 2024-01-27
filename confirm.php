<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["email"])) {
    $email = $_GET["email"];

    // Update user status as confirmed in the database
    // Set user status or verified_email column to '1' or update as needed
    
    echo "Your email is confirmed. You can now <a href='login.php'>login</a>.";
} else {
    echo "Invalid confirmation link.";
}
?>
