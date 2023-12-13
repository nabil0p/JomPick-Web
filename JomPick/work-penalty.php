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
            <h1 class="mt-4">Penalty</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Penalty</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-search me-1"></i>Search</div>
                    </div>
                    <form method="GET" action="work-penalty.php" enctype="multipart/form-data">
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
                                            <label for="itemmanager">Item Manager:</label><br/>
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
                        <div><i class="fas fa-table me-1"></i> Penalty</div>
                        <div class="small text-white"><a href="staff-register.php" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                    <?Php
                        $sql = "SELECT
                                im.*,
                                u.userName AS username, 
                                i.name AS itemname, 
                                dd.dueDate AS duedate, 
                                dd.status AS status,
                                p.status AS statuspayment 
                                FROM
                                item_management im
                                LEFT JOIN user u ON im.userManager_id = u.user_id
                                LEFT JOIN item i ON im.item_id = i.item_id
                                LEFT JOIN due_date dd ON im.dueDate_id = dd.dueDate_id
                                LEFT JOIN payment p ON dd.payment_id = p.payment_id WHERE itemManagement_id !=''"; 

                            //filtering listing
                            if (isset($_GET['carian'])) {
                                $resitid=$_GET['resitid'];
                                $jompickid=$_GET['jompickid'];
                                $itemmanager=$_GET['itemmanager'];
                                $itemname=$_GET['itemname'];
                                $status=$_GET['status'];

                            // if($status == "Early"){
                            //     $status= "2";
                            // } 
                            // if($status == "Ongoing"){
                            //     $status= "1";
                            // } 
                            // if($status == "Late"){
                            //     $status= "3";
                            // } 


                            if($resitid!=""){
                                $sql= $sql . " and resit_id = '$resitid'";
                                $statement = $sql;
                            } 
                            if($jompickid!=""){
                                $sql= $sql . " and JomPick_ID = '$jompickid'";
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
                                $sql= $sql . " and p.status = '$status'";
                                $statement = $sql;
                            }

                                //$statement = $sql . " ORDER BY ord_ID DESC ";
                                $rec_count = mysqli_num_rows($result);
                                    
                                $sql= $sql . " ORDER BY statuspayment desc;";          
                                $statement = $sql;
                                //print $sql;
                                $result = mysqli_query($conn, $sql);

                            }else{
                                //set semula tanpa filtering
                                $sql = "SELECT
                                im.*,
                                u.userName AS username, 
                                i.name AS itemname, 
                                i.image AS image, 
                                dd.dueDate AS duedate, 
                                dd.status AS status,
                                p.status AS statuspayment 
                                FROM
                                item_management im
                                LEFT JOIN user u ON im.userManager_id = u.user_id
                                LEFT JOIN item i ON im.item_id = i.item_id
                                LEFT JOIN due_date dd ON im.dueDate_id = dd.dueDate_id
                                LEFT JOIN payment p ON dd.payment_id = p.payment_id
                                ORDER BY statuspayment desc; "; 

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
                                    <th>Item Manager</th>
                                    <th>Item Name</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Num.</th>
                                    <th>Resit ID</th>
                                    <th>JomPick ID</th>
                                    <th>Item Manager</th>
                                    <th>Item Name</th>
                                    <th>Due Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $x=1;
                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                                    $resit = $row['resit_id'];
                                    $jompickid = $row['JomPick_ID'];
                                    $username = $row['username'];
                                    $itemname = $row['itemname'];
                                    $duedate = $row['duedate'];
                                    $status = $row['status'];
                                    $statuspayment = $row['statuspayment'];
                                    $button = '';

                                    if ($status == '1') {
                                        $status = 'Ongoing';
                                        $color1 = 'orange';    
                                    } else if ($status == '2') {
                                        $status = 'Early';
                                        $color1 = 'green';  
                                    } else if ($status == '3') {
                                        $status = 'Late';
                                        $color1 = 'red';  
                                    }
                                    
                                    if ($statuspayment == '1') {
                                        $statuspayment = 'Ongoing';
                                        $color = 'orange';  
                                        $button = '<a href="#" class="btn btn-warning btn-sm" style="margin-top:3px; color:white;"><div class="fa-solid fa-circle-play"></div> Ongoing </a>';
                                        
                                    }
                                    if ($statuspayment == '2') {
                                        $statuspayment = 'Pass';
                                        $color = 'blue';  
                                        $button = '<a href="#" class="btn btn-info btn-sm" style="margin-top:3px; color:white;"><i class="fa-regular fa-circle-stop"></i> Pass </a>';
                                    } if ($statuspayment == '3') {
                                        $statuspayment = 'Paid';
                                        $color = 'green';    
                                        $button = '<a href="#" class="btn btn-success btn-sm" style="margin-top:3px; color:white;"><span class="fa-regular fa-circle-check"></span> Paid </a>';
                                    } if ($statuspayment == '4') {
                                        $statuspayment = 'Unpaid';
                                        $color = 'red';  
                                        $button = '<a href="#" class="btn btn-danger btn-sm" style="margin-top:3px; color:white;"><i class="fa-regular fa-circle-xmark"></i> Pay </a>';
                                        
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $resit; ?></td>
                                        <td><?php echo $jompickid; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $itemname; ?></td>
                                        <td><?php echo $duedate; ?></td>
                                        <td ><div style="color:<?php echo $color1; ?>;"><?php echo $status; ?></div></td> 
                                        <td ><div style="color:<?php echo $color; ?>;"><?php echo $statuspayment; ?></div></td> 
                                        <td><?php echo $button; ?></td>
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