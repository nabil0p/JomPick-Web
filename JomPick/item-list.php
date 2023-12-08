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
            <h1 class="mt-4">Item List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">Item List</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-search me-1"></i>Search</div>
                    </div>
                    <form method="post" action="add_item.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="itemid">Item ID:</label><br/>
                                            <input type="text" class="form-control" id="itemid" name="itemid" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="name">Name:</label><br/>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="Tnum">Tracking Number:</label><br/>
                                            <input type="text" class="form-control" id="Tnum" name="Tnum" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="type">Type:</label><br/>
                                            <input type="text" class="form-control" id="type" name="type" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div></div>
                            <div class="small text-white"><a href="#!" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</a></div>
                        </div>
                    </form>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-table me-1"></i> JomPick List</div>
                        <div class="small text-white"><a href="item-register.php" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                    <?Php
                        $sql = "SELECT item.*, item_type.name AS type_name FROM item LEFT JOIN item_type ON item.itemType_id = item_type.itemType_id"; 
                            //filtering listing
                            if (isset($_GET['carian'])) {
                                $itemid=$_GET['itemid'];
                                $name=$_GET['name'];
                                $location=$_GET['location'];
                                $trackingNumber=$_GET['trackingNumber'];
                                $type_name=$_GET['type_name'];


                            if($itemid!=""){
                                $sql= $sql . " and item_id = '$itemid'";
                                $statement = $sql;
                            } 
                            if($name!=""){
                                $sql= $sql . " and name = '$name'";
                                $statement = $sql;
                            }
                            if($location!=""){
                                $sql= $sql . " and location = '$location'";
                                $statement = $sql;
                            }
                            if($trackingNumber!=""){
                                $sql= $sql . " and trackingNumber = '$trackingNumber'";
                                $statement = $sql;
                            }

                            if($type_name!=""){
                                $sql= $sql . " and fullName = '$type_name'";
                                $statement = $sql;
                            }
                                //$statement = $sql . " ORDER BY ord_ID DESC ";
                                $rec_count = mysqli_num_rows($result);
                                    
                                $sql= $sql . " ORDER BY name asc";          
                                $statement = $sql;
                                //print $sql;
                                $result = mysqli_query($conn, $sql);

                            }else{
                                //set semula tanpa filtering
                                $sql = "SELECT item.*, item_type.name AS type_name FROM item LEFT JOIN item_type ON item.itemType_id = item_type.itemType_id ORDER BY item_id asc"; 
                                $result = mysqli_query($conn, $sql);
                                //print $sql;
                            }

                    
                        ?>
                        <table id="datatablesSimple" style=" --bs-table-hover-bg: none;">
                            <thead>
                                <tr>
                                    <th>Num.</th>
                                    <th>Item ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Image</th>
                                    <th>Tracking number</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Num.</th>
                                    <th>Item ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Image</th>
                                    <th>Tracking number</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $x=1;
                                    while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                                    $item_id = $row['item_id'];
                                    $name = $row['name'];
                                    $location = $row['location'];
                                    $image = $row['image'];
                                    $trackingNumber = $row['trackingNumber'];
                                    $type_name = $row['type_name'];

                                    ?>
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $item_id; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $location; ?></td>
                                        <td><img src="data:image/jpeg;base64,<?php echo htmlspecialchars(base64_encode($image), ENT_QUOTES, 'UTF-8'); ?>" width="150" height="150" /></td>
                                        <td><?php echo $trackingNumber; ?></td>
                                        <td><?php echo $type_name; ?></td>

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

    


<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "function/logout.php"; // Redirect to the logout page
        }
    }
</script>
    <!-- Foot -->
    <?php include 'includecode/foot.php' ?>
    <!-- Foot -->
</body>
</html>