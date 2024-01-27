<?php
require_once "db.php"; // Include your database connection file

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch specific patient data based on the provided patient_id
    $query = "SELECT patient_id, doctor_id, first_name, last_name, age, gender, blood_type, allergies, medication, immunization_status, date_of_birth, billing_info, patient_picture, radiology_images, created_at, medical_history, lab_results, vital_signs, weight, last_updated_date, next_meeting, comment, phone, email, address FROM patients WHERE patient_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Create and download CSV file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="patient_data.csv"');
        $output = fopen('php://output', 'w');

        // CSV header with column names
        fputcsv($output, array('patient_id', 'doctor_id', 'first_name', 'last_name', 'age', 'gender', 'blood_type', 'allergies', 'medication', 'immunization_status', 'date_of_birth', 'billing_info', 'patient_picture', 'radiology_images', 'created_at', 'medical_history', 'lab_results', 'vital_signs', 'weight', 'last_updated_date', 'next_meeting', 'comment', 'phone', 'email', 'address'));

        // Fetch patient data and write to CSV
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }

        fclose($output);
    } else {
        echo "Failed to prepare the statement.";
    }

    mysqli_close($conn);
} else {
    echo "Patient ID not provided.";
}
?>
