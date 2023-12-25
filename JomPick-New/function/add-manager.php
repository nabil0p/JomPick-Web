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
    $location = $_SESSION["location"];
    $image = file_get_contents($_FILES["image"]["tmp_name"]);
    $availability_id = 1;

    // Check if the username already exists
    $checkUsernameQuery = "SELECT user_id FROM user WHERE userName = ?";
    $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
    $checkUsernameStmt->bind_param("s", $userName);
    $checkUsernameStmt->execute();
    $checkUsernameResult = $checkUsernameStmt->get_result();

    if ($checkUsernameResult->num_rows > 0) {
        // Username already exists, handle the error
        echo "Error: Username already exists. Please choose a different username.";
        exit;
    }
    
    // Fetch the current maximum value from the 'item' table
    $query = "SELECT MAX(CAST(SUBSTRING(JomPick_ID, 3) AS UNSIGNED)) AS max_id FROM user WHERE role_id = 2;";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        $maxId = $row['max_id'];
        // Increment the maximum value
        $nextId = $maxId + 1;

        // Format the next ID with leading zeros
        $jp_id = 'EM' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    } else {
        // Default value if there are no existing records
        $jp_id = 'EM001';
    }


    $stmt = $conn->prepare("INSERT INTO user (userName, password, phonenumber, icNumber, emailAddress, fullName, role_id, jp_location_id, mgrStaff, availability_id, image,JomPick_ID) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssssssiiiiss", $userName, $password, $phoneNumber, $icNumber, $emailAddress, $fullName, $role_id, $location, $user_id, $availability_id,$image,$jp_id);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../manager-register.php");
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
