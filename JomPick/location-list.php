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
            <h1 class="mt-4">Location List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Location List</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-search me-1"></i>Search</div>
                    </div>
                    <form method="GET" action="location-list.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="locationid">Location ID:</label><br/>
                                            <input type="text" class="form-control" id="locationid" name="locationid">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="name">Location Name:</label><br/>
                                            <input type="text" class="form-control" id="name" name="name">
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
                        <div><i class="fas fa-table me-1"></i> Location List</div>
                        <div class="small text-white"><a href="location-register.php" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                    <?Php
                        $sql = "SELECT l.* FROM pickup_location l"; 
                            //filtering listing
                            if (isset($_GET['carian'])) {
                                $locationid=$_GET['locationid'];
                                $name=$_GET['name'];


                            if($locationid!=""){
                                $sql= $sql . " and pickupLocation_id = '$locationid'";
                                $statement = $sql;
                            } 
                            if($name!=""){
                                $sql= $sql . " and address = '$name'";
                                $statement = $sql;
                            }
                    

                                //$statement = $sql . " ORDER BY ord_ID DESC ";
                                $rec_count = mysqli_num_rows($result);
                                    
                                $sql= $sql . " ORDER BY pickupLocation_id asc";          
                                $statement = $sql;
                                //print $sql;
                                $result = mysqli_query($conn, $sql);

                            }else{
                                //set semula tanpa filtering
                                $sql = "SELECT l.* FROM pickup_location l ORDER BY pickupLocation_id asc"; 
                                $result = mysqli_query($conn, $sql);
                                //print $sql;
                            }

                    
                        ?>
                        <table id="datatablesSimple" style=" --bs-table-hover-bg: none;">
                            <thead>
                                <tr>
                                    <th>Num.</th>
                                    <th>Location ID</th>
                                    <th>Location Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Num.</th>
                                    <th>Location ID</th>
                                    <th>Location Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $x=1;
                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                                    $location_id = $row['pickupLocation_id'];
                                    $address = $row['address'];
                                    ?>
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $location_id; ?></td>
                                        <td><?php echo $address; ?></td>
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