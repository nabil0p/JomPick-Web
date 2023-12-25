<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$resitid = isset($_GET['resitid']) ? $_GET['resitid'] : '';
$user_id = $_SESSION["id"];

include '../api/db_connection.php'; // Include your database connection

// Insert the new user into the database with the determined role_id
$dlt = "UPDATE item_management SET availability_id  = 2 WHERE resit_id = '$resitid';";

$aa  = mysqli_query($conn, $dlt);

if ($conn->query($dlt) === TRUE) {
    header("Location: ../jompick-list.php");
    exit;
} else {
    echo "Error adding user: " . $conn->error;
}

$conn->close();
?>

