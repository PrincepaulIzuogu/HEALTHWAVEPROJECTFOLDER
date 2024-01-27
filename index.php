<!DOCTYPE html>
<html lang="en">
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System</title>
    <link rel="stylesheet" href="CSS_files/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<section class="header">
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

        
        <div class="text-box">
            <h1>Healthwave EHR System</h1>
            <p>Welcome to Healthwave Doctor's EHR</p>
        
            <a href="login.php" class="hero-btn">Sign here if Registered</a>

            <div class="note">
                <i class="fas fa-exclamation-circle"></i>
                <p class="warning">Note: Only registered doctors are allowed to access our system.</p>
            </div>
        </div>
    </section>

    
    <!---------MOREOPTIONS---------->
    <section class="MOREOPTIONS">
        <h1>MORE OPTIONS</h1>
        <p>Choose from the following options</p>
        <div class="row">
            <a href="about us.php" class="MOREOPTIONS-col">
                <h3>About Us</h3>
                <p>Get to know more about us</p>
            </a>
            <a href="about ehr.php" class="MOREOPTIONS-col">
                <h3>About App</h3>
                <p>Get to know all about this EHR</p>
            </a>
        </div>
    </section>

    <section class="Testimonials">
<h1>Contact Us</h1>
<p>Contact our web developers to report issues or give feedbacks</p>
<div class="row"> 
<div class = "Testimonials-col">
    <div>
        <p>am really humbled to be part of this project, it has really helped me to nurture my career path</p>
        <h3> Princepaul</h3>
        <p> Princepaul.izuogu@stud.th-deg.de</p>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star-half"></i>
    </div>
</div>
    <div class = "Testimonials-col">
    <div>
        <p>am really humbled to be part of this project, it has really helped me to nurture my career path</p>
        <h3> Ekanem</h3>
        <p> Ekanem.obo@stud.th-deg.de</p>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star-half"></i>
    </div>
</div>
    <div class = "Testimonials-col">
    <div>
        <p>am really humbled to be part of this project, it has really helped me to nurture my career path</p>
        <h3> Tabitha</h3>
        <p> Tabitha.wangaruro@stud.th-deg.de</p>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star-half"></i>
    </div>
</div>
</div>
    </section >



   
   
    
    <!----------javasscript for Toggle Menu ---------->
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