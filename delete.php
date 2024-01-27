<?php
// Include your database connection file (db.php)
require_once "db.php";

// Check if the patient ID is set and a numeric value
if (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Prepare a DELETE statement
    $delete_query = "DELETE FROM patients WHERE patient_id = ?";

    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_patient_id);

        // Set the parameter
        $param_patient_id = $patient_id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records deleted successfully. Redirect to the previous page.
            header("location: dashboard.php");
            exit();
        } else {
            echo "Error deleting the patient record: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
} else {
    // Redirect to error page if the patient ID is not provided or invalid
    header("location: error:page.php");
    exit();
}

// Close the connection (if not already closed in db.php)
mysqli_close($conn);
?>
