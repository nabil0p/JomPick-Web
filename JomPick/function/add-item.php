<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $location = $_POST["location"];
    $itemType_id = $_POST["itemType_id"];

    // Handle image file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

        // You should validate and sanitize user inputs here

        // Generate the tracking number based on the item type
        if ($itemType_id == 1) {
            // If item type is Document (ID 1), set the tracking number to '-'
            $trackingNumber = '-';
        } elseif ($itemType_id == 2) {
            // If item type is Parcel (ID 2), generate a unique tracking number (you can implement a function for this)
            $trackingNumber = generateParcelTrackingNumber(); // Implement this function
        }

        // Insert the new item into the database
        $stmt = $conn->prepare("INSERT INTO item (name, location, image, trackingNumber, itemType_id) VALUES (?, ?, ?, ?, ?)");
        $null = null; // Null for binding binary data

        $stmt->bind_param("ssbss", $name, $location, $null, $trackingNumber, $itemType_id);
        $stmt->send_long_data(2, $imageData);

        if ($stmt->execute()) {
            header("Location: ../item-register.php"); // Redirect to the items management page
            exit;
        } else {
            echo "Error adding item: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the image file.";
    }

    $conn->close();
}

// Function to generate a unique parcel tracking number
function generateParcelTrackingNumber() {
    // Implement your logic to generate a unique tracking number for parcels
    // You can use timestamps, random numbers, or a combination of both
    $timestamp = time();
    $rand = rand(10000, 99999);
    $trackingNumber = "PARCEL-" . $timestamp . "-" . $rand;

    return $trackingNumber;
}
?>
