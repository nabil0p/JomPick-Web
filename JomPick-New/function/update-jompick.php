<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$userid = $_SESSION["id"];
$userrole = $_SESSION["role_id"];
$resitid = isset($_GET['resitid']) ? $_GET['resitid'] : '';

include '../api/db_connection.php'; // Include your database connection

$updateResultItemManagement = $updateResultItem = $updateResultConfirmation = $updateResultImage = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have form fields for jpid, ownername, itemType_id, tracknum, and pickUpLocation_id
    $resitida = $_POST["resit"];
    $jpid = $_POST["jpid"];
    $ownername = $_POST["ownername"];
    $itemType_id = $_POST["type"];
    $tracknum = $_POST["tnum"];
    $location = $_POST["location"];

    // Check if the user specified by jpid exists
    $checkUserQuery = "SELECT * FROM user WHERE JomPick_ID = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $jpid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // User doesn't exist, exit the code or redirect to an error page
        header("Location: ../jompick-update.php?resitid=$resitid&errorjpid='user is not found'");
        exit();
    }

    // Perform the UPDATE operation on item_management table
    $updateQueryItemManagement = "UPDATE item_management 
                                  SET 
                                      JomPick_ID = '$jpid' 
                                  WHERE 
                                      resit_id = $resitida;";

    $updateResultItemManagement = mysqli_query($conn, $updateQueryItemManagement);

    // Perform the UPDATE operation on item table
    $updateQueryItem = "UPDATE item 
                        SET 
                            name = '$ownername', 
                            trackingNumber = '$tracknum', 
                            itemType_id = '$itemType_id' 
                        WHERE 
                            item_id = (SELECT item_id FROM item_management WHERE resit_id = $resitida LIMIT 1);";

    $updateResultItem = mysqli_query($conn, $updateQueryItem);

    // Perform the UPDATE operation on confirmation table
    $updateQueryConfirmation = "UPDATE confirmation 
                                SET 
                                    pickUpLocation_id = '$location' 
                                WHERE 
                                    confirmation_id = (SELECT confirmation_id FROM item_management WHERE resit_id = $resitida LIMIT 1);";

    $updateResultConfirmation = mysqli_query($conn, $updateQueryConfirmation);

    // Perform the image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

        // Update item table with the new image data
        $updateQueryImage = "UPDATE item 
                             SET 
                                 image = ? 
                             WHERE 
                                 item_id = (SELECT item_id FROM item_management WHERE resit_id = $resitida LIMIT 1);";

        $stmt = $conn->prepare($updateQueryImage);
        $stmt->bind_param("s", $imageData);

        $updateResultImage = $stmt->execute();
        $stmt->close();
    }
}

if ($updateResultItemManagement && $updateResultItem && $updateResultConfirmation) {
    header("Location: ../jompick-update.php?resitid=$resitid");
    exit();
} else {
    echo "Error updating item: " . mysqli_error($conn);
}

$conn->close();
?>