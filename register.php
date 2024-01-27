<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "db.php";
require 'vendor/autoload.php';

if(isset($_SESSION['user_id'])!="") {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $workid = mysqli_real_escape_string($conn, $_POST['workid']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!preg_match("/^[a-zA-Z ]+$/", $username)) {
        $username_error = "Username must contain only alphabets and space";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
        $password_error = "Password must be minimum of 6 characters";
    }
    if(strlen($workid) < 10) {
        $workid_error = "Workid number must be minimum of 10 characters";
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $firstname)) {
        $firstname_error = "firstname must contain only alphabets and space";
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $lastname)) {
        $lastname_error = "lastname must contain only alphabets and space";
    }

    // Hash the password before storing in the database using MD5
    $hashed_password = md5($password);

    $query = "INSERT INTO users(username, email, workid, password, firstname, lastname) 
              VALUES('$username', '$email', '$workid', '$hashed_password', '$firstname', '$lastname')";

if (mysqli_query($conn, $query)) {
    // Email configuration
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;  
        $mail->Username   = 'baelee570@gmail.com'; // Update with your email
        $mail->Password   = 'bdta hlgx qfka njcv'; // Update with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465; // Change the port if needed

        //Recipients
        $mail->setFrom('baelee570@gmail.com', 'HealthWave'); // Update with your details
        $mail->addAddress($email, $username);

        //Email content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation';
        $mail->Body = 'Hello ' . $username . ',<br><br>'
            . 'Thank you for registering!<br>'
            . 'Best regards,<br>'
            . 'Your Website Team';

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header("location: login.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="CSS_files/styles.css">
</head>
<header>
    <nav>
        <a href="index.html"><img src="logo.png "></a>
        <i class="fas fa-bars" id="barsIcon" onclick="toggleMenu()"></i>
        <div class="nav-links" id="navLinks">
            <i class="fas fa-times" id="timesIcon" onclick="toggleMenu()"></i>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="about ehr.php">About EHR</a></li>
            </ul>
        </div>
    </nav>
</header>
<body>
    <nav class a="navbar navbar-expand-lg">
        <!-- Navigation menu, same as index.html -->
    </nav>
    <div class="container">
        <h1><i class="fas fa-user-md"></i> Doctor Registration</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
         <div class="form-row">
            <div class="form-group col">
                <label for="firstname"><i class="fas fa-user"></i> First Name</label>
                <input type="text" name="firstname" class="form-control" required>
                <span class="text-danger"><?php if (isset($firstname_error)) echo $firstname_error; ?></span>
            </div>
            <div class="form-group col">
                <label for="lastname"><i class="fas fa-user"></i> Last Name</label>
                <input type="text" name="lastname" class="form-control" required>
                <span class="text-danger"><?php if (isset($lastname_error)) echo $lastname_error; ?></span>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" required>
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
            </div>
            <div class="form-group col">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" name="username" class="form-control" required>
                <span class="text-danger"><?php if (isset($username_error)) echo $username_error; ?></span>
            </div>
         </div>
         <div class="form-row">
            <!-- Inside the <body> section -->
            <div class="form-group col">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                <button id="toggleButton">view suggested Password</button>
                <p id="passwordLabel" class="text-muted"></p>
            </div>
            <div class="form-group col">
                <label for="workid"><i class="fas fa-id-card"></i> Work ID</label>
                <input type="text" name="workid" class="form-control" required>
                <span class="text-danger"><?php if (isset($workid_error)) echo $workid_error; ?></span>
            </div>
         </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
        <p class="custom-link">Already have an account? <a href="login.php" class="login-link">Login</a></p>
    </div>
         </div>
         <script>
    function toggleMenu() {
    var navLinks = document.getElementById("navLinks");
    var barsIcon = document.getElementById("barsIcon");
    var timesIcon = document.getElementById("timesIcon");

    if (navLinks.style.opacity === "1") {
        navLinks.style.opacity = "0"; // Hide the nav-links
        navLinks.style.transform = "translateX(200px)";
        barsIcon.style.display = "block";
        timesIcon.style.display = "none";
    } else {
        navLinks.style.opacity = "1"; // Show the nav-links
        navLinks.style.transform = "translateX(0)";
        barsIcon.style.display = "none";
        timesIcon.style.display = "block";
    }
}
</script> 

<!-- Inside the <script> tag in your HTML -->
<script>
    window.onload = function() {
    const passwordField = document.getElementById('password');
    const toggleButton = document.getElementById('toggleButton');

    // Initially hide the button
    toggleButton.style.display = 'none';

    // Automatically generate a password when the page loads
    suggestPassword();

    // Attach event listener to the button
    toggleButton.addEventListener('click', function() {
        showPasswordForOneSecond();
    });

    function suggestPassword() {
        const length = 10; // You can adjust the length of the suggested password
        const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let password = '';

        // Generate a random password
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            password += characters.charAt(randomIndex);
        }

        // Set the generated password in the password input field
        passwordField.value = password;
        passwordField.setAttribute('data-generated', 'true');

        // Display the button only if there's a generated password
        toggleButton.style.display = 'block';
    }

    function showPasswordForOneSecond() {
        const isGenerated = passwordField.getAttribute('data-generated');

        if (isGenerated === 'true') {
            passwordField.type = 'text';

            // Set a timeout to hide the password after 1 seconds
            setTimeout(function() {
                passwordField.type = 'password';
            },1000);
        }
    }

    // Check if the autogenerated password is cleared
    passwordField.addEventListener('input', function() {
        const isGenerated = passwordField.getAttribute('data-generated');

        if (passwordField.value === '' && isGenerated === 'true') {
            // If the autogenerated password is cleared, hide the button
            toggleButton.style.display = 'none';
            passwordField.setAttribute('data-generated', 'false');
        }
    });
};

</script>             
</body>
</html>
