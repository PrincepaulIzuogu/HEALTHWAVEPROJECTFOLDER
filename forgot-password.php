<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'db.php'; // Include your database connection file

$mail = new PHPMailer(true);

function generateRandomCode($length = 8) {
    $bytes = random_bytes($length / 2);
    return strtoupper(bin2hex($bytes));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reset'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $resetToken = generateRandomCode(20);

        $insertStmt = $conn->prepare("INSERT INTO password_reset (email, token, created_at) VALUES (?, ?, NOW())");
        $insertStmt->bind_param("ss", $email, $resetToken);
        $insertStmt->execute();

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;  
            $mail->Username   = 'baelee570@gmail.com'; // Update with your email
            $mail->Password   = 'bdta hlgx qfka njcv'; // Update with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; // Change the port if needed

            $mail->setFrom('baelee570@gmail.com', 'HealthWave'); // Update with your details
            $mail->addAddress($email, $username);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Hello ' . $username . ', To reset your password, use this code: ' . $resetToken;

            if ($mail->send()) {
                echo 'Email has been sent with instructions for password reset.';
                // Redirect to the reset password form
                header("Location: token.php?email=" . urlencode($email) . "&token=" . urlencode($resetToken));
                exit();
            } else {
                echo 'Error: Email could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo; // Display the specific error message
            }
        } catch (Exception $e) {
            echo 'Error: Email could not be sent.';
            echo 'Exception Message: ' . $e->getMessage(); // Display the specific exception message
        }
    } else {
        echo 'Error: User with this email does not exist.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="CSS_files/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <h1>Forgot Password</h1>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="reset">Get Token</button>
                    </form>
            </div>
        </div>
    </div>
</body>
</html>

