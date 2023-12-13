<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

$userid = $_SESSION["id"];
$userrole= $_SESSION["role_id"];
include 'api/db_connection.php'; // Include your database connection

// Fetch item data from the database 
$sql_item = "SELECT item.*, item_type.name AS type_name FROM item
             LEFT JOIN item_type ON item.itemType_id = item_type.itemType_id";
$result_item = $conn->query($sql_item);
$items = array();

if ($result_item->num_rows > 0) {
    while ($item_row = $result_item->fetch_assoc()) {
        $items[] = $item_row;
    }
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
    /* Custom styles for select */
    .custom-select-label {
        margin-bottom: 5px;
        display: block;
        font-size: 14px;
        color: #555;
    }

    .custom-select {
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }

    .custom-select:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
            <h1 class="mt-4">JomPick Register</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">JomPick Register</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fa fa-file-text me-1"></i>&nbsp;&nbsp;JomPick Register</div>
                    </div>
                    <form method="post" action="function/add-item.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="jpid">JomPick ID</label>
                                            <input type="text" class="form-control" id="jpid" name="jpid" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="ownername">Owner Name</label>
                                            <input type="text" class="form-control" id="ownername" name="ownername" required>
                                    </div>
                                </div>
                                <?php  if ($userrole == '1'){
                                echo `<div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <select class="custom-select" id="location" name="location" required>
                                            <option value=''>Please Select</option>`;
                                            // Assuming $conn is your database connection
                                            $query = "SELECT pickupLocation_id, address FROM pickup_location WHERE pickupLocation_id != 1;";
                                            $result = $conn->query($query);

                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $location_id = $row['pickupLocation_id'];
                                                    $address = $row['address'];
                                                    echo "<option value='$location_id'>$address</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No locations available</option>";
                                            }

                                            // Close the result set
                                            $result->close();
                                   echo `</select>
                                    </div>
                                </div>`;
                                }
                                
                                else if ($userrole == '2' || $userrole == '3') {
                                    echo '<div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label for="ex">Location:</label>';
                                
                                                $sql9 = "SELECT jp_location_id FROM user WHERE user_id = $userid;";
                                                $result9 = mysqli_query($conn, $sql9);
                                                $row9 = mysqli_fetch_array($result9, MYSQLI_ASSOC);
                                                $location = $row9['jp_location_id'];
                                
                                                $sql8 = "SELECT address FROM pickup_location WHERE pickupLocation_id = $location;";
                                                $result8 = mysqli_query($conn, $sql8);
                                                $row8 = mysqli_fetch_array($result8, MYSQLI_ASSOC);
                                                $address = $row8['address'];
                                
                                                echo '<input type="text" value="' . $address . '" class="form-control" id="ex" name="ex" required readonly>
                                            </div>
                                        </div>';
                                }
                                ?>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="image">Take Image Item:</label>
                                            <input type="file" class="form-control" id="image" name="image" required>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label>Type:</label><br>
                                        <input type="radio" name="itemType_id" value="1" id="documentType" required>
                                        <label for="documentType">Document</label>
                                        <input type="radio" name="itemType_id" value="2" id="parcelType" required>
                                        <label for="parcelType">Parcel</label>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6" id="trackingNumberSection" style="display: none;">
                                    <div class="form-group">
                                        <label for="tracknum">Tracking Number:</label>
                                        <input type="text" class="form-control" id="tracknum" name="tracknum">
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Hide tracking number section on page load
                                        $("#trackingNumberSection").hide();

                                        // Show/hide tracking number section based on radio button selection
                                        $("input[name='itemType_id']").change(function () {
                                            if ($("#parcelType").prop("checked")) {
                                                $("#trackingNumberSection").show();
                                            } else {
                                                $("#trackingNumberSection").hide();
                                            }
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><a href="item-report.php" class="btn btn-primary btn-sm">View Items</a></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #087EA4">Add Item</button>
                    </form>
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
    <?php
    // Retrieve the error message from the URL
    $error = isset($_GET['error1']) ? $_GET['error1'] : '';

    // Display an alert using JavaScript if an error is present
    if ($error) {
        echo "<script>alert('$error');</script>";
    }
    ?>
</body>
</html>