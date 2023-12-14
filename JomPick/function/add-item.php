<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION["id"];

$userrole= $_SESSION["role_id"];

$locationid = $_SESSION["jp_location_id"];

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jpid = $_POST["jpid"];
    $ownername = $_POST["ownername"];
    $itemType_id = $_POST["itemType_id"];
    $tracknum = $_POST["tracknum"];

    if($userrole == '1'){
        $location = $_POST["location"];
    }

    if($userrole == '2' || $userrole == '3'){
        $location = $locationid;
    }


    // header("Location: ../item-register.php?error1=Please Enter $location Tracking Number");
    // exit();

    // Handle image file upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

        // You should validate and sanitize user inputs here

        // Generate the tracking number based on the item type
        if ($itemType_id == 1) {
            // If item type is Document (ID 1), set the tracking number to '-'
            $tracknum = '-';
        } elseif ($itemType_id == 2) {
            if($tracknum == ''){
                header("Location: ../item-register.php?error1=Please Enter Tracking Number");
                exit();
            }
        }

        
        // Fetch the current maximum value from the 'item' table
        $query = "SELECT MAX(CAST(SUBSTRING(jp_item_id, 9) AS UNSIGNED)) AS max_id FROM item";
        $result = $conn->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            $maxId = $row['max_id'];
            // Increment the maximum value
            $nextId = $maxId + 1;

            // Format the next ID with leading zeros
            $jp_item_id = 'JPI' . str_pad($nextId, 9, '0', STR_PAD_LEFT);
        } else {
            // Default value if there are no existing records
            $jp_item_id = 'JPI000000001';
        }

        // Use $jp_item_id in your SQL query or wherever needed

        // Insert the new item into the database using prepared statement
        $stmt = $conn->prepare("INSERT INTO item (jp_item_id, name, location, image, trackingNumber, itemType_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $jp_item_id, $ownername, $location, $imageData, $tracknum, $itemType_id);

        if ($stmt->execute()) {

            // Fetch the current maximum value from the 'payment' table
            $query = "SELECT MAX(CAST(SUBSTRING(jp_payment_id, 9) AS UNSIGNED)) AS max_id FROM payment";
            $result = $conn->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $maxId = $row['max_id'];
                // Increment the maximum value
                $nextId = $maxId + 1;

                // Format the next ID with leading zeros
                $jp_payment_id = 'JPP' . str_pad($nextId, 9, '0', STR_PAD_LEFT);
            } else {
                // Default value if there are no existing records
                $jp_payment_id = 'JPP000000001';
            }
            $paymentAmount = 0;
            $sql2 = "INSERT INTO payment (jp_payment_id, paymentAmount, status) VALUES ('$jp_payment_id', $paymentAmount, 1);";
            $result2 = mysqli_query($conn, $sql2); 

            // Fetch the current maximum value from the 'due_date' table
            $query = "SELECT MAX(CAST(SUBSTRING(jp_dueDate_id, 9) AS UNSIGNED)) AS max_id FROM due_date";
            $result = $conn->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $maxId = $row['max_id'];
                // Increment the maximum value
                $nextId = $maxId + 1;

                // Format the next ID with leading zeros
                $jp_dueDate_id = 'JPD' . str_pad($nextId, 9, '0', STR_PAD_LEFT);
            } else {
                // Default value if there are no existing records
                $jp_dueDate_id = 'JPD000000001';
            }
            
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentDate = date("Y-m-d H:i:s");
            // Calculate the due date 5 days from now
            $dueDate = date("Y-m-d H:i:s", strtotime($currentDate . "+5 days"));


            $sql3 = "INSERT INTO due_date (jp_dueDate_id, dueDate, payment_id, status) VALUES ('$jp_dueDate_id', '$duedate', (SELECT payment_id FROM payment WHERE jp_payment_id = '$jp_payment_id' LIMIT 1), 1);";
            $result3 = mysqli_query($conn, $sql3); 
            

            // Fetch the current maximum value from the 'confirmation' table
            $query = "SELECT MAX(CAST(SUBSTRING(jp_confirmation_id, 9) AS UNSIGNED)) AS max_id FROM confirmation";
            $result = $conn->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $maxId = $row['max_id'];
                // Increment the maximum value
                $nextId = $maxId + 1;

                // Format the next ID with leading zeros
                $jp_confirmation_id = 'JPC' . str_pad($nextId, 9, '0', STR_PAD_LEFT);
            } else {
                // Default value if there are no existing records
                $jp_confirmation_id = 'JPC0001';
            }
            $sql4 = "INSERT INTO confirmation (jp_confirmation_id, pickUpLocation_id, status) VALUES ('$jp_confirmation_id', $location,3);";
            $result4 = mysqli_query($conn, $sql4); 

            

            // Fetch the current maximum value from the 'item_management' table
            $query = "SELECT MAX(CAST(SUBSTRING(resit_id, 9) AS UNSIGNED)) AS max_id FROM item_management";
            $result = $conn->query($query);

            if ($result && $row = $result->fetch_assoc()) {
                $maxId = $row['max_id'];
                // Increment the maximum value
                $nextId = $maxId + 1;

                // Format the next ID with leading zeros
                $resit_id = 'JPR' . str_pad($nextId, 9, '0', STR_PAD_LEFT);
            } else {
                // Default value if there are no existing records
                $resit_id = 'JPR000000001';
            }
            $sql4 = "INSERT INTO item_management (userManager_id, item_id, dueDate_id, confirmation_id, resit_id, JomPick_ID, registerDate)
                        VALUES (
                            $user_id,
                            (SELECT item_id FROM item WHERE jp_item_id = '$jp_item_id' LIMIT 1),
                            (SELECT dueDate_id FROM due_date WHERE jp_dueDate_id = '$jp_dueDate_id' LIMIT 1),
                            (SELECT confirmation_id FROM confirmation WHERE jp_confirmation_id = '$jp_confirmation_id' LIMIT 1),
                            '$resit_id',
                            '$jpid',
                            '$currentDate'
                        );";
            $result4 = mysqli_query($conn, $sql4); 



            header("Location: ../item-register.php?error1=Register Successful");
            exit();
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
