<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["id"];

include 'api/db_connection.php'; // Include your database connection

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
            <h1 class="mt-4">Profile</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-user me-1"></i>Details</div>
                    </div>
                    <form method="post" action="function/update-profile.php" enctype="multipart/form-data">
                        <div class="card-body">
                             <?php
                                    $sql = "SELECT u.*, r.rolename FROM user u JOIN role r ON u.role_id = r.role_id WHERE user_id = '$user_id'"; 
                                    $result = mysqli_query($conn, $sql);
                                    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

                                    $username = $row['userName'];
                                    $password = $row['password'];
                                    $phoneNumber = $row['phoneNumber'];
                                    $icNumber = $row['icNumber'];
                                    $emailAddress = $row['emailAddress'];
                                    $fullName = $row['fullName'];
                                    $role_id = $row['role_id'];

                                    if($role_id == 1){
                                        $role_id = "Admin";
                                    }else if($role_id == 2){
                                        $role_id = "Manager";
                                    }else if($role_id == 3){
                                        $role_id = "Staff";
                                    }

                                    $mgrStaff = $row['mgrStaff'];
                                        if($mgrStaff == ''){
                                            $mgrStaff = "Admin";
                                        }
                                        if($mgrStaff !== ''){
                                            $sql1 = "SELECT userName FROM user WHERE user_id = '$mgrStaff'"; 
                                            $result1 = mysqli_query($conn, $sql1);
                                            $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
                                            $mgrStaff = $row1['userName'];
                                        }


                                ?>
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class = "form-control" id="fullname" name="fullname" value="<?php echo $fullName; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="phonenumber">Phone Number:</label>
                                        <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phoneNumber; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="icnumber">IC Number:</label>
                                        <input type="text" class="form-control" id="icnumber" name="icnumber" value="<?php echo $icNumber; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="email">E-Mail</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $emailAddress; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" class = "form-control" id="role" name="role" value="<?php echo $role_id; ?>" required readonly>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="manager">Manager</label>
                                        <input type="text" class = "form-control" id="manager" name="manager" value="<?php echo $mgrStaff; ?>" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #087EA4">Update</button>
                    </form>
                </div>
            </div>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-lock me-1"></i> Reset Password</div>
                    </div>
                    <form method="post" action="function/update_password.php" enctype="multipart/form-data">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="password">Old Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="password">New Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                        <label for="password">Confirm Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div></div>
                            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #DC3545">Change</button>
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