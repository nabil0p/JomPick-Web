<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

$role = $_SESSION["role_id"];

$locationid = $_SESSION["jp_location_id"];

include '../api/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = $_POST["username"];
    $password = $_POST["password"];
    $phoneNumber = $_POST["phonenumber"];
    $icNumber = $_POST["icnumber"];
    $emailAddress = $_POST["email"];
    $fullName = $_POST["fullname"];
    $user_id = $_SESSION["id"];
    $role_id = 3; // Set role_id to 3 Staff
    $userpic = $_POST["userpic"];

    if ($role == 1 ){
        $sql9 = "SELECT jp_location_id FROM user WHERE user_id = $userpic; "; 

        $result9 = mysqli_query($conn, $sql9);
        $row9 =mysqli_fetch_array($result9,MYSQLI_ASSOC);
        
        $location = $row9['jp_location_id'];
        
    }

    if ($role == 2 ){
        $userpic = $user_id;
        $location = $locationid;
    }

    // Insert the new user into the database with the determined role_id
    $sql = "INSERT INTO user (userName, password, phonenumber, icNumber, emailAddress, fullName, role_id, mgrStaff, jp_location_id) 
            VALUES ('$userName', '$password', '$phoneNumber', '$icNumber', '$emailAddress', '$fullName', $role_id, $userpic, $location)";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../staff-register.php");
        exit;
    } else {
        echo "Error adding user: " . $conn->error;
    }
}

$conn->close();
