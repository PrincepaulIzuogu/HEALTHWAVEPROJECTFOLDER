<?php
session_start();
require_once "db.php";

// Check if the form is submitted for patient update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["patient_id"])) {
    // Retrieve form data
    $patient_id = $_POST["patient_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $date_of_birth = $_POST["date_of_birth"];
    $medical_history = $_POST["medical_history"];
    $medication = $_POST["medication"];
    $allergies = $_POST["allergies"];
    $immunization_status = $_POST["immunization_status"];
    $lab_results = $_POST["lab_results"];
    $vital_signs = $_POST["vital_signs"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];
    $billing_info = $_POST["billing_info"];
    $gender = $_POST["gender"];
    $blood_type = implode(',', $_POST["blood_type"]); // Assuming blood_type is an array
    $last_updated_date = $_POST["last_updated_date"];
    $next_meeting = $_POST["next_meeting"];
    $comment = $_POST["comment"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $languages = implode(',', $_POST["languages"]); 



    // Construct an UPDATE SQL query
    $updateQuery = "UPDATE patients SET first_name=?, last_name=?, date_of_birth=?, medical_history=?, medication=?, allergies=?, immunization_status=?, lab_results=?, vital_signs=?, age=?, weight=?, billing_info=?, gender=?, blood_type=?, last_updated_date=?, next_meeting=?, comment=?, phone=?, email=?, address=?, languages = ? WHERE patient_id=?";

    // Prepare the update statement
    if ($stmt = mysqli_prepare($conn, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssi", $first_name, $last_name, $date_of_birth, $medical_history, $medication, $allergies, $immunization_status, $lab_results, $vital_signs, $age, $weight, $billing_info, $gender, $blood_type, $last_updated_date, $next_meeting, $comment, $phone, $email, $address, $languages, $patient_id);

        if (mysqli_stmt_execute($stmt)) {
            // Handle image update if necessary
            if (!empty($_FILES["patient_picture"]["name"])) {
                $targetDir = "uploads/patient_pictures/";
                $patientPicture = basename($_FILES["patient_picture"]["name"]);
                $targetFilePath = $targetDir . $patientPicture;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["patient_picture"]["tmp_name"], $targetFilePath)) {
                        // Update patient picture in the database
                        $updatePictureQuery = "UPDATE patients SET patient_picture=? WHERE patient_id=?";
                        if ($stmtPicture = mysqli_prepare($conn, $updatePictureQuery)) {
                            mysqli_stmt_bind_param($stmtPicture, "si", $patientPicture, $patient_id);
                            mysqli_stmt_execute($stmtPicture);
                            mysqli_stmt_close($stmtPicture);
                        }
                    } else {
                        echo "Error uploading patient picture.";
                    }
                } else {
                    echo "Invalid file format for patient picture.";
                }
            }

            // Redirect to dashboard after successful update
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error updating patient: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error in the prepared statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} elseif (isset($_GET["patient_id"])) {
    $patient_id = $_GET["patient_id"];

    $query = "SELECT * FROM patients WHERE patient_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $patientData = mysqli_fetch_assoc($result);
        }
    }
    // Fetch radiology images for the patient
    $radiologyImages = array();
    $fetchRadiologyQuery = "SELECT radiology_images FROM patients WHERE patient_id = ?";
    if ($stmtRadiology = mysqli_prepare($conn, $fetchRadiologyQuery)) {
        mysqli_stmt_bind_param($stmtRadiology, "i", $patient_id);
        if (mysqli_stmt_execute($stmtRadiology)) {
            $resultRadiology = mysqli_stmt_get_result($stmtRadiology);
            $rowRadiology = mysqli_fetch_assoc($resultRadiology);
            $radiologyImages = explode(';', $rowRadiology['radiology_images']);
        }
    }


    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - Update Patient</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="CSS_files/ehr_style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Navigation menu -->
        <a class="navbar-brand" href="#">Healthwave EHR Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ml-auto">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
</header>
<div class="form-container">
    <h1>Update Patient</h1>
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

        
        <div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $patientData['first_name']; ?>" required>
    </div>
    <div style="width: 48%;">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patientData['last_name']); ?>" required>
    </div>
</div>
<br>

        <!-- Display existing patient picture -->
        <?php if (!empty($patientData['patient_picture'])) { ?>
            <img src="uploads/patient_pictures/<?php echo $patientData['patient_picture']; ?>" alt="Patient Picture" width="150">
        <?php } ?>

        <!-- Allow user to upload a new patient picture -->
        <label for="patient_picture">Update Patient Picture:</label>
        <input type="file" id="patient_picture" name="patient_picture" accept="image/*"><br><br>


<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $patientData['date_of_birth']; ?>" required>
    </div>
    <div style="width: 48%;">
    <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($patientData['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($patientData['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($patientData['gender'] === 'Other') echo 'selected'; ?>>Other</option>
            </select>
    </div>
</div>
<br>


<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($patientData['phone']); ?>" required>
    </div>
    <div style="width: 48%;">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patientData['email']); ?>" required>
    </div>
</div>
<br>

    <!-- Contact Information -->

        <label for="address">Address:</label>
        <textarea id="address" name="address"><?php echo htmlspecialchars($patientData['address']); ?></textarea>
    
       

        <!-- Existing form elements... -->
        <label for="languages">Languages:</label><br>
        <div class="checkbox-container">
            <?php
            $languages = !empty($patientData['languages']) ? explode(',', $patientData['languages']) : [];
            $languagesOptions = ['English', 'German'];

            foreach ($languagesOptions as $option) {
                $isChecked = in_array($option, $languages) ? 'checked' : '';
            ?>
           <input type="checkbox" id="lang<?php echo $option; ?>" name="languages[]" value="<?php echo $option; ?>" <?php echo $isChecked; ?>>
           <label for="lang<?php echo $option; ?>"><?php echo $option; ?></label><br>
            <?php } ?>
        </div>



        <!-- Input field for patient's blood type -->
        
        <label for="blood_type">Blood Type:</label><br>
        <div class="checkbox-container">
            <?php
            $bloodTypes = !empty($patientData['blood_type']) ? explode(',', $patientData['blood_type']) : [];
            $bloodTypeOptions = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

            foreach ($bloodTypeOptions as $option) {
                $isChecked = in_array($option, $bloodTypes) ? 'checked' : '';
            ?>
            <input type="radio" id="blood_type_<?php echo $option; ?>" name="blood_type[]" value="<?php echo $option; ?>" <?php echo $isChecked; ?>>
            <label for="blood_type_<?php echo $option; ?>"><?php echo $option; ?></label><br>
            <?php } ?>
        </div>
        <!-- Medical History -->
        <label for="medical_history">Medical History:</label>
        <textarea id="medical_history" name="medical_history"><?php echo $patientData['medical_history']; ?></textarea><br><br>

        <!-- Medication and Allergies -->
        <label for="medication">Medication:</label>
        <input type="text" id="medication" name="medication" value="<?php echo $patientData['medication']; ?>"><br><br>

        <label for="allergies">Allergies:</label>
        <input type="text" id="allergies" name="allergies" value="<?php echo $patientData['allergies']; ?>"><br><br>


        <!-- immunization_status -->
        <label for="immunization_status">Immunization Status:</label>
        <input type="text" id="immunization_status" name="immunization_status" value="<?php echo $patientData['immunization_status']; ?>"><br><br>

        <!-- Laboratory Test Results -->
        <label for="lab_results">Laboratory Test Results:</label>
        <input type="text" id="lab_results" name="lab_results" value="<?php echo $patientData['lab_results']; ?>"><br><br>

        <!-- Radiology Images -->
        <!-- Display existing radiology images and allow updating them -->
        <label for="radiology_images">Update Radiology Images:</label>
        <input type="file" id="radiology_images" name="radiology_images[]" multiple accept="image/*">
    
        <div class="radiology-images-preview">
            <h3> Radiology Images:</h3>
            <?php foreach ($radiologyImages as $image): ?>
                <img src="uploads/radiology/<?php echo basename($image); ?>" alt="Radiology Image" width="150">
            <?php endforeach; ?>
        </div>
        <label for="vital_signs">Vital Signs:</label>
        <input type="text" id="vital_signs" name="vital_signs" value="<?php echo $patientData['vital_signs']; ?>"><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $patientData['age']; ?>"><br><br>

        <label for="weight">Weight (lbs):</label>
        <input type="number" id="weight" name="weight" value="<?php echo $patientData['weight']; ?>"><br><br>

        <!-- Billing Information -->
        <label for="billing_info">Billing Information:</label>
        <textarea id="billing_info" name="billing_info"><?php echo $patientData['billing_info']; ?></textarea><br><br>

<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="last_updated_date">Last Updated Date:</label>
        <input type="date" id="last_updated_date" name="last_updated_date" value="<?php echo $patientData['last_updated_date']; ?>" required><br><br>
    </div>
    <div style="width: 48%;">
        <label for="next_meeting">Next Meeting:</label>
        <input type="date" id="next_meeting" name="next_meeting" value="<?php echo $patientData['next_meeting']; ?>" required><br><br>
    </div>
</div>
<br>

        <!-- Comment -->
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment"><?php echo $patientData['comment']; ?></textarea><br><br>

        <input type="submit" value="Update Patient">
    </form>
</div>
</body>
</html>
