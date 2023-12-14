<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'api/db_connection.php'; // Include your database connection

$location_id = $_SESSION['jp_location_id'];

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
            <h1 class="mt-4">JomPick Work</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">JomPick Work</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-search me-1"></i>Search</div>
                    </div>
                    <form method="GET" action="work-jompick.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="resitid">Resit ID:</label><br/>
                                            <input type="text" class="form-control" id="resitid" name="resitid">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="jompickid">JomPick ID:</label><br/>
                                            <input type="text" class="form-control" id="jompickid" name="jompickid">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="registerdate">Register Date:</label><br/>
                                            <input type="text" class="form-control" id="registerdate" name="registerdate">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="itemmanager">Manager:</label><br/>
                                            <input type="text" class="form-control" id="itemmanager" name="itemmanager">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="itemname">Item Name:</label><br/>
                                            <input type="text" class="form-control" id="itemname" name="itemname">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="status">Status:</label><br/>
                                            <input type="text" class="form-control" id="status" name="status">
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
                        <div><i class="fas fa-table me-1"></i> JomPick Work</div>
                        <div class="small text-white"><a href="staff-register.php" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                    <?Php
                        if ($location_id == '1'){
                            $location_id = "'2' or c.pickupLocation_id = '3'";
                        }
                        $sql = "SELECT
                                im.*,
                                u.userName AS username, 
                                i.name AS itemname, 
                                i.image AS image,
                                dd.dueDate AS duedate, 
                                c.status AS status,
                                c.pickupLocation_id AS location
                                FROM
                                item_management im
                                LEFT JOIN user u ON im.userManager_id = u.user_id
                                LEFT JOIN item i ON im.item_id = i.item_id
                                LEFT JOIN due_date dd ON im.dueDate_id = dd.dueDate_id
                                LEFT JOIN confirmation c ON im.confirmation_id = c.confirmation_id WHERE itemManagement_id !='' and c.pickupLocation_id = $location_id"; 

                            //filtering listing
                            if (isset($_GET['carian'])) {
                                $resitid=$_GET['resitid'];
                                $jompickid=$_GET['jompickid'];
                                $registerdate=$_GET['registerdate'];
                                $itemmanager=$_GET['itemmanager'];
                                $itemname=$_GET['itemname'];
                                $status=$_GET['status'];
                                $location=$_GET['location'];


                            if($resitid!=""){
                                $sql= $sql . " and resit_id = '$resitid'";
                                $statement = $sql;
                            } 
                            if($jompickid!=""){
                                $sql= $sql . " and JomPick_ID = '$jompickid'";
                                $statement = $sql;
                            }
                            if($registerdate!=""){
                                $sql= $sql . " and registerDate = '$registerdate'";
                                $statement = $sql;
                            }
                            if($itemmanager!=""){
                                $sql= $sql . " and u.userName = '$itemmanager'";
                                $statement = $sql;
                            }

                            if($itemname!=""){
                                $sql= $sql . " and i.name = '$itemname'";
                                $statement = $sql;
                            }
                            
                            if($status!=""){
                                $sql= $sql . " and c.status = $status";
                                $statement = $sql;
                            }

                            if($location!=""){
                                $sql= $sql . " and c.pickupLocation_id = $location";
                                $statement = $sql;
                            }

                                //$statement = $sql . " ORDER BY ord_ID DESC ";
                                $rec_count = mysqli_num_rows($result);
                                    
                                $sql= $sql . " ORDER BY status desc;";          
                                $statement = $sql;
                                //print $sql;
                                $result = mysqli_query($conn, $sql);

                            }else{
                                //set semula tanpa filtering
                                $sql = "SELECT
                                im.*,
                                u.userName AS username, -- replace 'username' with the actual column name in the user table
                                i.name AS itemname, -- replace 'item_name' with the actual column name in the item table
                                i.image AS image, 
                                dd.dueDate AS duedate, -- replace 'due_date' with the actual column name in the duedate table
                                c.status AS status, -- replace 'confirmation_status' with the actual column name in the confirmation table
                                c.pickupLocation_id AS location
                                FROM
                                item_management im
                                LEFT JOIN user u ON im.userManager_id = u.user_id
                                LEFT JOIN item i ON im.item_id = i.item_id
                                LEFT JOIN due_date dd ON im.dueDate_id = dd.dueDate_id
                                LEFT JOIN confirmation c ON im.confirmation_id = c.confirmation_id WHERE itemManagement_id !='' and c.pickupLocation_id = $location_id  ORDER BY status desc;"; 

                                $result = mysqli_query($conn, $sql);
                                //print $sql;
                            }

                    
                        ?>
                        <table id="datatablesSimple" style=" --bs-table-hover-bg: none;">
                            <thead>
                                <tr>
                                    <th>Num.</th>
                                    <th>Resit ID</th>
                                    <th>JomPick ID</th>
                                    <th>Register Date</th>
                                    <th>Manage</th>
                                    <th>Location</th>
                                    <th>Owner Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Num.</th>
                                    <th>Resit ID</th>
                                    <th>JomPick ID</th>
                                    <th>Register Date</th>
                                    <th>Manage</th>
                                    <th>Location</th>
                                    <th>Owner Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $x=1;
                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                                    $resit = $row['resit_id'];
                                    $jompickid = $row['JomPick_ID'];
                                    $registerdate = $row['registerDate'];
                                    $username = $row['username'];
                                    $itemname = $row['itemname'];
                                    $image = $row['image'];
                                    $status = $row['status'];
                                    $location = $row['location'];

                                    if ($status == '1') {
                                        $status = 'Picked';
                                        $color = 'green';    
                                    } else if ($status == '2') {
                                        $status = 'Pick now';
                                        $color = 'orange';  
                                    } else if ($status == '3') {
                                        $status = 'Waiting';
                                        $color = 'red';  
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $resit; ?></td>
                                        <td><?php echo $jompickid; ?></td>
                                        <td><?php echo $registerdate; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $location; ?></td>
                                        <td><?php echo $itemname; ?></td>
                                        <td><img src="data:image/jpeg;base64,<?php echo htmlspecialchars(base64_encode($image), ENT_QUOTES, 'UTF-8'); ?>" width="150" height="150" /></td>
                                        <td ><div style="color:<?php echo $color; ?>;"><?php echo $status; ?></div></td> 
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm" style="margin-top:3px; color:white;"><i class="fas fa-edit"></i> Done </a>
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