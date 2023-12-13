<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

$location_id = isset($_GET['location']) ? $_GET['location'] : '';

include 'api/db_connection.php'; // Include your database connection

// Ensure $location_id is not empty and is a valid integer
if (!empty($location_id) && is_numeric($location_id)) {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT address FROM pickup_location WHERE pickupLocation_id = ?");
    $stmt->bind_param("i", $location_id);
    $stmt->execute();
    $stmt->bind_result($location_address);

    // Fetch the result
    if ($stmt->fetch()) {
        $location_address;
    } else {
        echo "Location not found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid or missing location_id parameter.";
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
    label{
        margin-bottom:5px;
    }
    input{
        margin-bottom:5px;
    }
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
            <h1 class="mt-4">Update Location</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Update Location</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fa fa-address-card me-1"></i>&nbsp;&nbsp;Update Location</div>
                    </div>
                    <form method="post" action="function/update-location.php?location=<?php echo $location_id?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="location">Location Name:</label>
                                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $location_address?>" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><a href="location-list.php?location=" class="btn btn-primary btn-sm">Back</a></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #087EA4">Update</button>
                    </form>
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