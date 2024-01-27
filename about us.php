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

    <nav class="navbar navbar-expand-lg">
        <!-- Navigation menu, as before -->
    </nav>
    <div class="Us-container">
        <h1>About Us</h1>
        <p>Our team is a passionate collective of healthcare professionals and technology enthusiasts with a mission to transform healthcare delivery. With a deep commitment to patient well-being, we bring innovative solutions to the medical field. By merging medical expertise with cutting-edge technology, we aim to enhance patient care, streamline operations, and drive better health outcomes. We believe that a seamless, efficient healthcare system can improve lives, and that's what inspires our work every day.</p>
        <!-- Additional content for the About Us page, if needed -->
    
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