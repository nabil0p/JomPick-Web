<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'api/db_connection.php'; // Include your database connection

$userrole= $_SESSION["role_id"];
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
            <h1 class="mt-4">Staff Registration</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Staff Registration</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fa fa-address-card me-1"></i>&nbsp;&nbsp;Staff Registration</div>
                    </div>
                    <form method="post" action="function/add-staff.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="text" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="phonenumber">Phone Number:</label>
                                        <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="icnumber">IC Number:</label>
                                        <input type="text" class="form-control" id="icnumber" name="icnumber" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="email">E-Mail</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class = "form-control" id="fullname" name="fullname" required>
                                    </div>
                                </div>
                                <?php
                                    if ($userrole == '1') {
                                        echo '<div class="col-xl-3 col-md-6">
                                                <div class="form-group">
                                                    <label for="userpic">Location Incharge</label>
                                                    <select class="custom-select" id="userpic" name="userpic" required>
                                                        <option value="">Please Select</option>';
                                                        
                                                        // Assuming $conn is your database connection
                                                        $query = "SELECT user_id, userName FROM user WHERE role_id = 2;";
                                                        $result = $conn->query($query);

                                                        if ($result && $result->num_rows > 0) {
                                                            while ($row1 = $result->fetch_assoc()) {
                                                                $userid = $row1['user_id'];
                                                                $userName = $row1['userName'];
                                                                echo "<option value='$userid'>$userName</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='' disabled>No locations available</option>";
                                                        }

                                                        // Close the result set
                                                        $result->close();
                                                        
                                        echo '</select>
                                            </div>
                                        </div>';
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><a href="staff-list.php" class="btn btn-primary btn-sm">View Staffs</a></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #087EA4">Register</button>
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