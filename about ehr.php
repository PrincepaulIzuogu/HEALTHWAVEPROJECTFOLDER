<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
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
    <!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and Bootstrap as before -->
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <!-- Navigation menu, as before -->
    </nav>
    <div class="Us-container">
        <h1>About Electronic Health Records (EHR)</h1>
        <p>Electronic Health Records (EHR) represent the future of healthcare documentation. These digital records are the modern evolution of traditional paper-based patient charts. They encompass a comprehensive history of patient health, including diagnoses, treatments, medications, and test results. EHRs are central to improving patient care coordination, reducing errors, and enhancing accessibility to medical information. With the power to store, manage, and exchange patient data securely, EHRs facilitate data-driven decisions that ultimately result in more personalized, effective healthcare. EHRs empower healthcare providers to deliver the best possible care while ensuring patient privacy and data security.</p>
        <!-- Additional content for the About EHR page, if needed -->
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
