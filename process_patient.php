<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
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
    $languages = implode(',', $_POST["languages"]); // Assuming languages is an array
    $blood_type = $_POST["blood_type"]; 
    $last_updated_date = $_POST["last_updated_date"];
    $next_meeting = $_POST["next_meeting"];
    $comment = $_POST["comment"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $doctor_id = $_SESSION['id']; // Assuming 'id' holds the ID of the logged-in doctor

    // Handling the checkbox values for languages
if (isset($_POST['languages']) && !empty($_POST['languages'])) {
    // Ensure at most 2 languages are selected
    if (count($_POST['languages']) <= 2) {
        $selectedLanguages = $_POST['languages']; // Get the values of the selected languages
    }
}
    // Handling the checkbox values for blood type
    if (isset($_POST['blood_type']) && !empty($_POST['blood_type'])) {
        $selectedBloodType = $_POST['blood_type'][0]; // Get the value of the selected blood type
    }

    // File Upload Handling - Patient Picture
    $targetDir = "uploads/patient_pictures/";
    $patientPicture = basename($_FILES["patient_picture"]["name"]);
    $targetFilePath = $targetDir . $patientPicture;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["patient_picture"]["tmp_name"], $targetFilePath)) {
            $insertQuery = "INSERT INTO patients (first_name, last_name, phone, email, address, date_of_birth, medical_history, medication, allergies, immunization_status, lab_results, vital_signs, age, weight, billing_info, patient_picture, gender, blood_type, doctor_id, last_updated_date, next_meeting, comment, languages) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $insertQuery)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssss", $first_name, $last_name, $phone, $email, $address, $date_of_birth, $medical_history, $medication, $allergies, $immunization_status, $lab_results, $vital_signs, $age, $weight, $billing_info, $patientPicture, $gender, $selectedBloodType, $doctor_id, $last_updated_date, $next_meeting, $comment, $languages);

                if (mysqli_stmt_execute($stmt)) {
                    $lastInsertId = mysqli_insert_id($conn);

                    // Handling Radiology Images
                    $radiologyImagePaths = array(); // Array to store radiology image paths

                    if (!empty($_FILES['radiology_images']['name'][0])) {
                        $radiologyImages = $_FILES['radiology_images'];

                        foreach ($radiologyImages['tmp_name'] as $key => $tmpName) {
                            $radiologyImageName = basename($radiologyImages['name'][$key]);
                            $radiologyImageType = pathinfo($radiologyImageName, PATHINFO_EXTENSION);

                            $radiologyTargetDir = "uploads/radiology/";
                            $radiologyTargetFilePath = $radiologyTargetDir . uniqid('radiology_') . '.' . $radiologyImageType;

                            if (in_array(strtolower($radiologyImageType), $allowedTypes)) {
                                if (move_uploaded_file($tmpName, $radiologyTargetFilePath)) {
                                    // Add radiology image path to the array
                                    $radiologyImagePaths[] = $radiologyTargetFilePath;
                                } else {
                                    echo "Error uploading radiology image.";
                                }
                            } else {
                                echo "Invalid file format for radiology image.";
                            }
                        }
                    }

                    // Join the radiology image paths to store in the database
                    $radiologyImagesString = implode(';', $radiologyImagePaths);

                    // Update patients table with radiology image paths
                    $updateRadiologyQuery = "UPDATE patients SET radiology_images = ? WHERE patient_id = ?";

                    if ($stmtRadiology = mysqli_prepare($conn, $updateRadiologyQuery)) {
                        mysqli_stmt_bind_param($stmtRadiology, "si", $radiologyImagesString, $lastInsertId);

                        if (!mysqli_stmt_execute($stmtRadiology)) {
                            echo "Error updating radiology images: " . mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmtRadiology);
                    }

                    // Redirect to the dashboard upon successful addition of a patient
                    header("Location: dashboard.php");
                    exit(); // Ensure script stops here to prevent further execution
                } else {
                    echo "Error adding patient: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error in the prepared statement: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading patient picture.";
        }
    } else {
        echo "Invalid file format for patient picture.";
    }

    mysqli_close($conn);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - EHR Management</title>
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
    <h1>Add New Patient</h1>
    <form action="process_patient.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
        <!-- Demographics -->
        <!--  input fields for First Name and Last Name -->
<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
    </div>
    <div style="width: 48%;">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
    </div>
</div>
<br>

        <!-- Upload Patient Picture -->
        <label for="patient_picture">Upload Patient Picture:</label>
        <input type="file" id="patient_picture" name="patient_picture" accept="image/*"><br><br>

<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>
    </div>
    <div style="width: 48%;">
        <label for="gender" id="gender">Gender:</label>
    <select id="gender" name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>
    </div>
</div>
<br>


<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
    </div>
    <div style="width: 48%;">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>
    </div>
</div>
<br>

    <!-- Contact Information -->

        <label for="address">Address:</label>
        <textarea id="address" name="address" placeholder="Enter address"></textarea><br><br>

    <label>Languages:</label><br>
       <div class="checkbox-container">
           <input type="checkbox" id="lang1" name="languages[]" value="English">
           <label for="lang1"> English</label><br>

           <input type="checkbox" id="lang2" name="languages[]" value="German">
           <label for="lang2"> German</label><br>
    </div>
    <!-- Input field for patient's blood type -->
    <label>Blood Type:</label><br>
        <div class="radio-container">
            <input type="radio" id="blood_type_a_plus" name="blood_type[]" value="A+">
            <label for="blood_type_a_plus">A+</label><br>

            <input type="radio" id="blood_type_a_minus" name="blood_type[]" value="A-">
            <label for="blood_type_a_minus">A-</label><br>

            <input type="radio" id="blood_type_b_plus" name="blood_type[]" value="B+">
            <label for="blood_type_b_plus">B+</label><br>

            <input type="radio" id="blood_type_b_minus" name="blood_type[]" value="B-">
            <label for="blood_type_b_minus">B-</label><br>

            <input type="radio" id="blood_type_o_plus" name="blood_type[]" value="O+">
            <label for="blood_type_o_plus">O+</label><br>

            <input type="radio" id="blood_type_o_minus" name="blood_type[]" value="O-">
            <label for="blood_type_o_minus">O-</label><br>

            <input type="radio" id="blood_type_ab_plus" name="blood_type[]" value="AB+">
            <label for="blood_type_ab_plus">AB+</label><br>

            <input type="radio" id="blood_type_ab_minus" name="blood_type[]" value="AB-">
            <label for="blood_type_ab_minus">AB-</label><br><br>
        </div>


        <!-- Medical History -->
        <label for="medical_history">Medical History:</label>
        <textarea id="medical_history" name="medical_history"></textarea><br><br>

        <!-- Medication and Allergies -->
        <label for="medication">Medication:</label>
        <input type="text" id="medication" name="medication"><br><br>

        <label for="allergies">Allergies:</label>
        <input type="text" id="allergies" name="allergies"><br><br>

        <!-- Immunization Status -->
        <label for="immunization_status">Immunization Status:</label>
        <input type="text" id="immunization_status" name="immunization_status"><br><br>

        <!-- Laboratory Test Results -->
        <label for="lab_results">Laboratory Test Results:</label>
        <input type="text" id="lab_results" name="lab_results"><br><br>

        <!-- Radiology Images -->
        <label for="radiology_images">Radiology Images:</label>
        <input type="file" id="radiology_images" name="radiology_images[]" multiple accept="image/*"><br><br>

        <!-- Vital Signs -->
        <label for="vital_signs">Vital Signs:</label>
        <input type="text" id="vital_signs" name="vital_signs"><br><br>

        <!-- Personal Statistics -->
        <label for="age">Age:</label>
        <input type="number" id="age" name="age"><br><br>

        <label for="weight">Weight (lbs):</label>
        <input type="number" id="weight" name="weight"><br><br>

        <!-- Billing Information -->
        <label for="billing_info">Billing Information:</label>
        <textarea id="billing_info" name="billing_info"></textarea><br><br>

<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <label for="last_updated_date">Last Updated Date:</label>
        <input type="date" id="last_updated_date" name="last_updated_date" required>
    </div>
    <div style="width: 48%;">
        <label for="next_meeting">Next Meeting:</label>
        <input type="date" id="next_meeting" name="next_meeting" required>
    </div>
</div>
<br>

        <!-- Comment -->
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment"></textarea><br><br>



        <!-- Submit Button -->
        <input type="submit" value="Add Patient">
    </form>
</div>
</body>
</html>