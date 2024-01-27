<?php
session_start();
require_once "db.php";

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = md5($password); // Hashing the password using MD5

    $query = "SELECT id, username, password FROM users WHERE username = ?";
    if($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)) {
                    if($password === $hashed_password) { // Comparing the MD5 hashed password
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        header("location: dashboard.php");
                        exit();
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System</title>
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
    <nav class="navbar navbar-expand-lg">
        <!-- Navigation menu, same as index.html -->
    </nav>
    <div class="container">
            <h1><i class="fas fa-user-md"></i> Doctor Login</h1>
                    <?php 
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }        
                    ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group col">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" class="form-control" required  <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?> >
                    <span class="invalid-feedback" ><?php echo $username_err; ?></span>
                </div>
                <div class="form-group col">
                    <label for="password"><i class="fas fa-lock"></i> Password</label> 
                    <input type="password" name="password" class="form-control" required <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <a href="forgot-password.php" class="forgot-password-link">Forgot Password?</a></p>
            </form>
            <p class="my-link">Don't have an account? <a href="register.php" class="register-link">Register</a></p>
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
</body>
</html>