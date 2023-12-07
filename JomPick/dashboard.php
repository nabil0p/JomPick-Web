<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'api/db_connection.php'; // Include your database connection

// Fetch user's name from the database
$user_id = $_SESSION["id"];
$sql_user = "SELECT userName, role_id FROM user WHERE user_id = '$user_id'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user_row = $result_user->fetch_assoc();
    $user_name = $user_row["userName"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Head -->
    <?php include 'includecode/head.php' ?>
    <!-- Head -->
</head>
<style>

</style>
    
<body class="sb-nav-fixed">
<!-- Top nav -->   
<?php include 'function/topnav.php' ?>
<!-- Top nav -->

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" >
            <?php include 'function/sidenav.php' ?>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                    <h1 class="mt-4">Analytics</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                        </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <p>Hello, <?php echo $user_name; ?>! You have successfully logged in.</p>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div></div>
                    <div class="text-muted">Copyright &copy; JomPick 2023</div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Foot -->
    <?php include 'includecode/foot.php' ?>
    <!-- Foot -->

</body>
</html>