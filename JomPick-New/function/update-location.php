<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

include '../api/db_connection.php'; // Include your database connection

// Variables for location and image
$location_id = isset($_GET['location']) ? $_GET['location'] : '';
$user_id = $_SESSION["id"];
$location = $_POST['locations'];

if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
    // Get image data
    $image = file_get_contents($_FILES["image"]["tmp_name"]);

    // Update the database with the new image data
    if (!empty($location_id) && is_numeric($location_id)) {

        // Use prepared statement to prevent SQL injection
        $update_image_query = "UPDATE pickup_location SET address = ?, image = ? WHERE pickupLocation_id = ?";
        $stmt = $conn->prepare($update_image_query);
        $stmt->bind_param("ssi", $location, $image, $location_id);

        if ($stmt->execute()) {
            header("Location: ../location-list.php?location=");
            exit;
        } else {
            echo "Error updating image: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid or missing location_id parameter.";
    }
} else {
    // Insert the new user into the database with the determined role_id
    $dlt = "UPDATE pickup_location SET address  = '$location' WHERE pickupLocation_id = '$location_id';";

    $aa  = mysqli_query($conn, $dlt);

    if ($conn->query($dlt) === TRUE) {
        header("Location: ../location-list.php?location=");
        $conn->close();
        exit;
    } else {
        echo "Error update location: " . $conn->error;
    }

}
$conn->close();

?>

