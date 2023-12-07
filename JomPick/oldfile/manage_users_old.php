<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'api/db_connection.php'; // Include your database connection

// Fetch user data from the database and join with the role table to get role names
$sql_user = "SELECT u.*, r.rolename FROM user u
            JOIN role r ON u.role_id = r.role_id
            WHERE u.role_id = 2 || u.role_id = 3";
$result_user = $conn->query($sql_user);
$users = array();

if ($result_user->num_rows > 0) {
    while ($user_row = $result_user->fetch_assoc()) {
        $users[] = $user_row;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>JomPick | Manage Users</title>
    <!-- Include Bootstrap CSS link (you'll need to download Bootstrap or use a CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="text-center" >Manage Users</h1>
        <div class="row">
        <div class="d-flex justify-content-between mb-3 mt-4">
        <a href="#addUserModal" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fas fa-user-plus"></i> Register</a>
        </div>
        </div>
        <div class="row">
            <div >
                <div class="table-responsive">
                <table class="table table-bordered text-center table-striped">
    <thead class="table-dark">
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>IC Number</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th> <!-- Add a new column for Role -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user["user_id"]; ?></td>
                <td><?php echo $user["userName"]; ?></td>
                <td><?php echo $user["phoneNumber"]; ?></td>
                <td><?php echo $user["icNumber"]; ?></td>
                <td><?php echo $user["fullName"]; ?></td>
                <td><?php echo $user["emailAddress"]; ?></td>
                <td><?php echo $user["rolename"]; ?></td> <!-- Display the role name from the joined table -->
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

    <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="addUserModalLabel">Register staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="add_user.php">
                <div class="form-group">
                     <label for="username">Username</label>
                     <input type="text" class="form-control" id="username" name="username" required>
               </div>
               <div class="form-group">
                     <label for="password">Password</label>
                     <input type="text" class="form-control" id="password" name="password" required>
               </div>
               <div class="form-group">
                    <label for="phonenumber">Phone number</label>
                    <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
               </div>
               <div class="form-group">
                     <label for="icnumber">IC number</label>
                     <input type="text" class="form-control" id="icnumber" name="icnumber" required>
               </div>
               <div class="form-group">
                   <label for="email">Email address</label>
                   <input type="text" class="form-control" id="email" name="email" required>
               </div>
               <div class="form-group">
                    <label for="fullname">Full name</label>
                    <input type="text" class = "form-control" id="fullname" name="fullname" required>
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
