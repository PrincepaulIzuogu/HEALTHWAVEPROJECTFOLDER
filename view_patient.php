<?php
session_start();
require_once "db.php";

// Check if a specific patient ID is provided through GET parameter
if (isset($_GET['patient_id']) && !empty($_GET['patient_id'])) {
    $patientId = $_GET['patient_id'];

    $query = "SELECT * FROM patients WHERE patient_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $patientId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $patient = mysqli_fetch_assoc($result)) {
            // Patient found, proceed to display details
        } else {
            echo "No patient found with the provided ID.";
        }
    } else {
        echo "Error in prepared statement: " . mysqli_error($conn);
    }
} else {
    echo "Patient ID not provided or empty.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS_files/view.css">
</head>
<body>
<header>
<div class="navbar">
            <a href="export_patient.php?patient_id=<?php echo $patient['patient_id']; ?>">File</a>
            <a href="help.php">Help</a>
            <a href="update.php?patient_id=<?php echo $patient['patient_id']; ?>">Edit 
    </a>         
</div>
        <div class="ml-auto">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="logout.php">Logout</a>
        </div>
</div>
</header>



<div class="container mt-4">
        <h1>Patient Details</h1>

        <div class="comment">
            <i class="fas fa-exclamation-circle"></i>
            <p><bold>Comment:</bold> <?php echo $patient['comment']; ?></p>
        </div>

        <?php if (!empty($patient)) : ?>
            <div class="details row">
                
                <div class="col-md-6">
                    <!-- Right Side: Patient's Medical Details, Picture, and Radiology Images -->
                    
                    <div class="data-box">
                        <h3>Medical History:</h3>
                        <p><?php echo $patient['medical_history']; ?></p>
                    </div>
                        
                    <div class="data-box">
                        <h3>Medication:</h3>
                        <p><?php echo $patient['medication']; ?></p>
                    </div>
                        
                    <div class="data-box">
                        <h3>Allergies:</h3>
                        <p><?php echo $patient['allergies']; ?></p>
                    </div>
                        
                    <div class="data-box">
                        <h3>Immunization Status:</h3>
                        <p><?php echo $patient['immunization_status']; ?></p>
                    </div>
                    <div class="data-box lab-results-box">
                        <h3>Lab Results:</h3>
                        <p><?php echo $patient['lab_results']; ?></p>
                    </div>
                       
                    <div class="data-box signs">
                        <h3>Vital Signs:</h3>
                        <p><?php echo $patient['vital_signs']; ?></p>
                    </div>
                        
                    <!-- Display radiology images -->
                  
                    <div class="image">
                        <?php
                        $radiologyImages = explode(';', $patient['radiology_images']);
                        foreach ($radiologyImages as $image) {
                            if (!empty($image)) {
                                echo '<img src="' . $image . '" alt="Radiology Image" width="200">';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Left Side: Patient's General Information -->
                <div class="image-container">
                    <img src="uploads/patient_pictures/<?php echo $patient['patient_picture']; ?>" alt="Patient Picture" width="200" height="200">
                </div>
                <div class="others">
                    <p><strong>First_name:</strong> <?php echo $patient['first_name']; ?></p> 
                    <p><strong>Last_name:</strong> <?php echo $patient['last_name']; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo $patient['date_of_birth']; ?></p>
                    <p><strong>Age:</strong> <?php echo $patient['age']; ?></p>
                    <p><strong>Gender:</strong> <?php echo $patient['gender']; ?></p> 
                    <p><strong>Weight:</strong> <?php echo $patient['weight']; ?></p>
                </div>
                <div class="base">
                    <p><strong>Blood Type:</strong> <?php echo $patient['blood_type']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $patient['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $patient['email']; ?></p>
                    <p><strong>Address:</strong> <?php echo $patient['address']; ?></p>
                    <p><strong>Languages:</strong> <?php echo $patient['languages']; ?></p>
                    <p><strong>Billing Info:</strong> <?php echo $patient['billing_info']; ?></p>
                    <p><strong>Last_updated_date:</strong> <?php echo $patient['last_updated_date']; ?></p>
                    <p><strong>Next_meeting:</strong> <?php echo $patient['next_meeting']; ?></p>
                </div>
                </div>         
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>