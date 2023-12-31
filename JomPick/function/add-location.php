<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $location = $_POST["location"];
    $image = $_POST["image"];

    // Insert the new user into the database with the determined role_id
    $sql = "INSERT INTO pickup_location (address) 
            VALUES ('$location')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../location-register.php");
        exit;
    } else {
        echo "Error adding user: " . $conn->error;
    }
}

$conn->close();
