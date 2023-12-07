<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = $_POST["username"];
    $password = $_POST["password"];
    $phoneNumber = $_POST["phonenumber"];
    $icNumber = $_POST["icnumber"];
    $emailAddress = $_POST["email"];
    $fullName = $_POST["fullname"];
    $user_id = $_SESSION["id"];
    $role_id = 2; // Set role_id to 2 Manager

    // Insert the new user into the database with the determined role_id
    $sql = "INSERT INTO user (userName, password, phonenumber, icNumber, emailAddress, fullName, role_id) 
            VALUES ('$userName', '$password', '$phoneNumber', '$icNumber', '$emailAddress', '$fullName', $role_id)";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../staff-register.php");
        exit;
    } else {
        echo "Error adding user: " . $conn->error;
    }
}

$conn->close();
