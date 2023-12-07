<?php
include '../api/db_connection.php';
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Fetch user data from the database, including role_id
    $sql = "SELECT * FROM user WHERE LOWER(userName) = LOWER('$username')";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["password"] === $password) {
            // Check if the user has a valid role (role_id 1 or 2)
            if ($row["role_id"] == 1 || $row["role_id"] == 2 || $row["role_id"] == 3) {
                // Admin role
                $_SESSION["id"] = $row["user_id"];
                $_SESSION["username"] = $row["userName"];
                header("Location: ../dashboard.php");
                exit;
            } else {
                header("Location: ../index.php?error=Unauthorized access");
            }
        } 
    } else {
        header("Location: ../index.php?error=Login Invalid");
    }

    $conn->close();
}

?>