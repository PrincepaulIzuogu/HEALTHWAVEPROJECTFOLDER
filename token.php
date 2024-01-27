<?php
// token.php

require 'vendor/autoload.php';
require 'db.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $inputToken = $_POST['input_token'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    if ($newPassword !== $confirmNewPassword) {
        echo 'Passwords do not match. Please make sure the passwords match.';
        exit();
    }

    // Validate the token against the database
    $stmt = $conn->prepare("SELECT * FROM password_reset WHERE email = ? AND token = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    $stmt->bind_param("ss", $email, $inputToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token is valid - Proceed with password reset
        $hashedPassword = md5($newPassword);

        // Update the user's password in the users table
        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $email);
        $updateStmt->execute();

        // Delete the used token from the password_reset table
        $deleteStmt = $conn->prepare("DELETE FROM password_reset WHERE email = ?");
        $deleteStmt->bind_param("s", $email);
        $deleteStmt->execute();

        echo 'Password has been successfully reset. You can now <a href="login.php">login</a> with your new password.';
        exit(); // Exit after password reset
    } else {
        echo 'Invalid or expired token. Password reset failed.';
    }
} else {
    // Check if the token is received via GET parameters
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <link rel="stylesheet" type="text/css" href="CSS_files/styles.css">
        </head>
        <body>
        <div class="container reset-password">
            <h2>Reset Password</h2>
            <p>Please reset your password for: <?php echo htmlspecialchars($email); ?></p>
            <div class="form-group">
            <form method="POST" action="token.php">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <label for="input_token">Enter Token:</label>
                <input type="text" id="input_token" name="input_token" required>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                <button type="submit" class="btn btn-primary" name="reset_password">Reset Password</button>
            </form>
            </div>
        </div>
        </body>
        </html>

        <?php
    } else {
        echo 'Email not provided. Access denied.';
    }
}
?>
