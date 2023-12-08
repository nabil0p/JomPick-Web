<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION["id"];

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $phoneNumber = $_POST["phonenumber"];
    $icNumber = $_POST["icnumber"];
    $emailAddress = $_POST["email"];
    $fullName = $_POST["fullname"];

    // Insert the new user into the database with the determined role_id
    $upd = "UPDATE user SET phoneNumber = '$phoneNumber', icNumber = '$icNumber', emailAddress= '$emailAddress', fullName= '$fullName'
            WHERE user_id = '$user_id';";
    $aa  = mysqli_query($conn, $upd);

    if ($conn->query($upd) === TRUE) {

        header("Location: ../user-profile.php");
        exit;
    } else {
        echo "Error adding user: " . $conn->error;
    }
}

$conn->close();
?>
