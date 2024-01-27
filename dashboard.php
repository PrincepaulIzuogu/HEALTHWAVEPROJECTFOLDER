<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

$doctor_id = $_SESSION['id'];

// Fetch the list of patients associated with the logged-in doctor from the database
$query = "SELECT * FROM patients WHERE doctor_id = ?";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's EHR System - Dashboard</title>
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


    <div class="container mt-5">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <h2>Your Patients</h2>
        <div class="btn-container">
            <a href="process_patient.php" class="btn btn-add-patient mb-3">Add New Patient</a>
        </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Date of Birth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['patient_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['date_of_birth']; ?></td>
                        <td>
                            <a href="view_patient.php?patient_id=<?php echo $row['patient_id']; ?>" class="btn btn-action btn-view">View Patient</a>
                            <a href="update.php?patient_id=<?php echo $row['patient_id']; ?>" class="btn btn-action btn-update">Update Patient</a>
                            <a href="delete.php?patient_id=<?php echo $row['patient_id']; ?>" class="btn btn-action btn-delete">Delete Patient</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="styles.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
