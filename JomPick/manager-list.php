<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

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
            <h1 class="mt-4">Manager List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Manager List</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-search me-1"></i>Search</div>
                    </div>
                    <form method="GET" action="#!" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="userid">User ID:</label><br/>
                                            <input type="text" class="form-control" id="userid" name="userid">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="username">Name:</label><br/>
                                            <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="phnum">Phone Number:</label><br/>
                                            <input type="text" class="form-control" id="phnum" name="phnum">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="icnum">Ic Number:</label><br/>
                                            <input type="text" class="form-control" id="icnum" name="icnum">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="fullname">Full Name:</label><br/>
                                            <input type="text" class="form-control" id="fullname" name="fullname">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="mailaddress">E-Mail:</label><br/>
                                            <input type="text" class="form-control" id="mailaddress" name="mailaddress">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div></div>
                            <button type="submit" class="btn btn-primary btn-sm" name="carian" value="carian" id="carian"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                        </div>
                    </form>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-table me-1"></i> Manager List</div>
                        <div class="small text-white"><a href="manager-register.php" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                    <?Php
                        $sql = "SELECT u.*, r.rolename FROM user u JOIN role r ON u.role_id = r.role_id WHERE u.role_id = 2"; 
                            //filtering listing
                            if (isset($_GET['carian'])) {
                                $userid=$_GET['userid'];
                                $username=$_GET['username'];
                                $phnum=$_GET['phnum'];
                                $icnum=$_GET['icnum'];
                                $fullname=$_GET['fullname'];
                                $mailaddress=$_GET['mailaddress'];


                            if($userid!=""){
                                $sql= $sql . " and user_id = '$userid'";
                                $statement = $sql;
                            } 
                            if($username!=""){
                                $sql= $sql . " and userName = '$username'";
                                $statement = $sql;
                            }
                            if($phnum!=""){
                                $sql= $sql . " and phoneNumber = '$phnum'";
                                $statement = $sql;
                            }
                            if($icnum!=""){
                                $sql= $sql . " and icNumber = '$icnum'";
                                $statement = $sql;
                            }

                            if($fullname!=""){
                                $sql= $sql . " and fullName = '$fullname'";
                                $statement = $sql;
                            }
                            
                            if($mailaddress!=""){
                                $sql= $sql . " and emailAddress = '$mailaddress'";
                                $statement = $sql;
                            }

                                //$statement = $sql . " ORDER BY ord_ID DESC ";
                                $rec_count = mysqli_num_rows($result);
                                    
                                $sql= $sql . " ORDER BY userName asc";          
                                $statement = $sql;
                                //print $sql;
                                $result = mysqli_query($conn, $sql);

                            }else{
                                //set semula tanpa filtering
                                $sql = "SELECT u.*, r.rolename FROM user u JOIN role r ON u.role_id = r.role_id WHERE u.role_id = 2 ORDER BY userName asc"; 
                                $result = mysqli_query($conn, $sql);
                                //print $sql;
                            }

                    
                        ?>
                        <table id="datatablesSimple" style=" --bs-table-hover-bg: none;">
                            <thead>
                                <tr>
                                    <th>Num.</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Ic Number</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Num.</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Ic Number</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $x=1;
                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                                    $user_id = $row['user_id'];
                                    $userName = $row['userName'];
                                    $phoneNumber = $row['phoneNumber'];
                                    $icNumber = $row['icNumber'];
                                    $fullName = $row['fullName'];
                                    $emailAddress = $row['emailAddress'];
                                    $rolename = $row['rolename'];
                                    ?>
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $user_id; ?></td>
                                        <td><?php echo $userName; ?></td>
                                        <td><?php echo $phoneNumber; ?></td>
                                        <td><?php echo $icNumber; ?></td>
                                        <td><?php echo $fullName; ?></td>
                                        <td><?php echo $emailAddress; ?></td>
                                        <td><?php echo $rolename; ?></td> <!-- Display the role name from the joined table -->
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" style="margin-top:3px; color:white;"><i class="fas fa-edit"></i> Update</a>
                                            <a href="#" class="btn btn-danger btn-sm" style="margin-top:3px;"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php $x++;} ?>
                            </tbody>
                        </table>
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