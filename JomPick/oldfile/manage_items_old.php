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
    <title>JomPick | Manage Items</title>
    <!-- Include Bootstrap CSS link (you'll need to download Bootstrap or use a CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Staff Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    
<div class="row ">
            <!-- Side Nav -->
            <div class="col-md-2">
                <div class="list-group">
                    <?php include 'sidenav.php' ?>
                </div>
            </div>
             <!-- Side Nav -->
    <div class="container mt-4">
        <h1 class="text-center" >Manage Items</h1>
        <div class="row">
        <div class="d-flex justify-content-between mb-3 mt-4">
        <a href="#addUserModal" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fas fa-plus"></i> Register</a>
        </div>
        </div>
        <div class="row">
            <div >
                <div class="table-responsive">
                <table class="table table-bordered text-center table-striped" style="margin-bottom: 80px;">
    <thead class="table-dark">
        <tr>
            <th>Item ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Image</th>
            <th>Tracking number</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) { ?>
    <tr>
        <td><?php echo $item["item_id"]; ?></td>
        <td><?php echo $item["name"]; ?></td>
        <td><?php echo $item["location"]; ?></td>
        <td><img src="data:image/jpeg;base64,<?php echo htmlspecialchars(base64_encode($item['image']), ENT_QUOTES, 'UTF-8'); ?>" width="150" height="150" /></td>
        <td><?php echo $item["trackingNumber"]; ?></td>
        <td><?php echo $item["type_name"]; ?></td>
        <td>
            <a href="#" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Update</a>
            <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</a>
        </td>
    </tr>
<?php } ?>
    </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="addUserModalLabel">Register item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="add_item.php" enctype="multipart/form-data">
                <div class="form-group">
                     <label for="name">Name</label>
                     <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="form-group">
                     <label for="location">Location</label>
                     <input type="text" class="form-control" id="location" name="location" required>
               </div>
               <div class="form-group">
                    <label for="image">Select image file:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
               </div>
               <div class="form-group">
            <label>Type:</label><br>
            <input type="radio" name="itemType_id" value="1" required>
            <label for="itemType_id">Document</label>
            <input type="radio" name="itemType_id" value="2" required>
            <label for="itemType_id">Parcel</label>
        </div>

                <button type="submit" class="btn btn-primary btn-block" style="background-color: #087EA4">Add</button>
            </form>
            </div>
        </div>
    </div>
</div>

    <!-- Include Bootstrap JavaScript (jQuery and Popper.js) links here -->
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/popper.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>
    <!-- Include Bootstrap JavaScript (jQuery and Popper.js) links here -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
