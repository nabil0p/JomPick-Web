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
    $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
    $availabilityId = "1";

    $stmt = $conn->prepare("INSERT INTO pickup_location (address, image, availability_id) VALUES (?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssi", $location, $imageData, $availabilityId);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../location-register.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    
}

$conn->close();
