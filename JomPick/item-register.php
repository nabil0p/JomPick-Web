<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

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
            <h1 class="mt-4">Add Item</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Add Item</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fa fa-file-text me-1"></i>&nbsp;&nbsp;Add Item</div>
                    </div>
                    <form method="post" action="function/add_item.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="location">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="image">Select image file:</label>
                                            <input type="file" class="form-control" id="image" name="image" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label>Type:</label><br>
                                        <input type="radio" name="itemType_id" value="1" required>
                                        <label for="itemType_id">Document</label>
                                        <input type="radio" name="itemType_id" value="2" required>
                                        <label for="itemType_id">Parcel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><a href="item-report.php" class="btn btn-primary btn-sm" data-toggle="modal">View Items</a></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #087EA4">Add Item</button>
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