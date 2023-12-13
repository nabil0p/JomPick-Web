<?php

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

// Fetch user's name from the database
    $user_id = $_SESSION["id"];
    $sql = "SELECT userName, role_id FROM user WHERE LOWER(user_id) = LOWER('$user_id')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $user_role = $row ['role_id'];
    $user_name = $row["userName"];
?>

<?php  if (($user_role == '1')){ ?>
        <div class="sb-sidenav-menu">
                <div class="nav">
                        <div class="sb-sidenav-menu-heading" style="margin-top:-20px;">Dashboard</div>
                                <a class="nav-link" href="dashboard.php">
                                        <i class="fas fa-chart-area"></i>
                                        &nbsp;&nbsp;&nbsp;Analytics
                                </a>

                        <div class="sb-sidenav-menu-heading">Employee Management</div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLocation" aria-expanded="false" aria-controls="collapseLayouts">
                                        <i class="fas fa-location"></i>
                                        &nbsp;&nbsp;&nbsp;Location
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLocation" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="location-register.php">
                                                <i class="fa-solid fa-building"></i>
                                                        &nbsp;&nbsp;&nbsp;Registration
                                                </a>
                                                <a class="nav-link" href="location-list.php">
                                                        <i class="fas fa-table"></i>
                                                        &nbsp;&nbsp;&nbsp;List
                                                </a>
                                        </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseManager" aria-expanded="false" aria-controls="collapseLayouts">
                                        <i class="fa fa-address-card"></i>
                                        &nbsp;&nbsp;&nbsp;Manager
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseManager" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="manager-register.php">
                                                        <i class="fas fa-user-plus"></i>
                                                        &nbsp;&nbsp;&nbsp;Registration
                                                </a>
                                                <a class="nav-link" href="manager-list.php">
                                                        <i class="fas fa-table"></i>
                                                        &nbsp;&nbsp;&nbsp;List
                                                </a>
                                        </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStaff" aria-expanded="false" aria-controls="collapseLayouts">
                                        <i class="fa fa-address-card"></i>
                                        &nbsp;&nbsp;&nbsp;Staff
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseStaff" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="staff-register.php">
                                                        <i class="fa fa-user-plus"></i>
                                                        &nbsp;&nbsp;&nbsp;Registration
                                                </a>
                                                <a class="nav-link" href="staff-list.php">
                                                        <i class="fas fa-table"></i>
                                                        &nbsp;&nbsp;&nbsp;List
                                                </a>
                                        </nav>
                                </div>

                        <div class="sb-sidenav-menu-heading">JomPick Management</div>
                                <a class="nav-link" href="work-jompick.php">
                                <i class="fas fa-boxes"></i>
                                        &nbsp;&nbsp;&nbsp;JomPick Work
                                </a>
                                <a class="nav-link" href="item-register.php">
                                        <i class="fa fa-file-text"></i>
                                        &nbsp;&nbsp;&nbsp;Item Register 
                                </a>
                                <a class="nav-link" href="work-penalty.php">
                                        <i class="fas fa-money-bill"></i>
                                        &nbsp;&nbsp;&nbsp;Penalty
                                </a>
                                <a class="nav-link" href="item-list.php">
                                        <i class="fas fa-box"></i>
                                        &nbsp;&nbsp;&nbsp;Item List
                                </a>
                                <a class="nav-link" href="customer-list.php">
                                        <i class="fas fa-user"></i>
                                        &nbsp;&nbsp;&nbsp;Customer List
                                </a>
                </div>
        </div>
        <div class="sb-sidenav-footer">
                <div class="small">Logged in as Admin:</div>
                <?php echo $user_name; ?>
        </div>
<?php  } ?>

<?php  if (($user_role == '2')){ ?>
        <div class="sb-sidenav-menu">
                <div class="nav">
                        <div class="sb-sidenav-menu-heading" style="margin-top:-20px;">Dashboard</div>
                                <a class="nav-link" href="dashboard.php">
                                        <i class="fas fa-chart-area"></i>
                                        &nbsp;&nbsp;&nbsp;Analytics
                                </a>

                        <div class="sb-sidenav-menu-heading">Employee Management</div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStaff" aria-expanded="false" aria-controls="collapseLayouts">
                                        <i class="fa fa-address-card"></i>
                                        &nbsp;&nbsp;&nbsp;Staff
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseStaff" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="staff-register.php">
                                                        <i class="fa fa-user-plus"></i>
                                                        &nbsp;&nbsp;&nbsp;Registration
                                                </a>
                                                <a class="nav-link" href="staff-list.php">
                                                        <i class="fas fa-table"></i>
                                                        &nbsp;&nbsp;&nbsp;List
                                                </a>
                                        </nav>
                                </div>

                        <div class="sb-sidenav-menu-heading">JomPick Management</div>
                                <a class="nav-link" href="work-jompick.php">
                                <i class="fas fa-boxes"></i>
                                        &nbsp;&nbsp;&nbsp;JomPick Work
                                </a>
                                <a class="nav-link" href="item-register.php">
                                        <i class="fa fa-file-text"></i>
                                        &nbsp;&nbsp;&nbsp;Item Register 
                                </a>
                                <a class="nav-link" href="work-penalty.php">
                                        <i class="fas fa-money-bill"></i>
                                        &nbsp;&nbsp;&nbsp;Penalty
                                </a>
                                <a class="nav-link" href="customer-list.php">
                                        <i class="fas fa-user"></i>
                                        &nbsp;&nbsp;&nbsp;Customer List
                                </a>
                </div>
        </div>
        <div class="sb-sidenav-footer">
                <div class="small">Logged in as Admin:</div>
                <?php echo $user_name; ?>
        </div>

<?php  } ?>

<?php  if (($user_role == '3')){ ?>
        <div class="sb-sidenav-menu">
                <div class="nav">
                        <div class="sb-sidenav-menu-heading" style="margin-top:-20px;">Dashboard</div>
                                <a class="nav-link" href="dashboard.php">
                                        <i class="fas fa-chart-area"></i>
                                        &nbsp;&nbsp;&nbsp;Analytics
                                </a>

                        <div class="sb-sidenav-menu-heading">JomPick Management</div>
                                <a class="nav-link" href="work-jompick.php">
                                <i class="fas fa-boxes"></i>
                                        &nbsp;&nbsp;&nbsp;JomPick Work
                                </a>
                                <a class="nav-link" href="item-register.php">
                                        <i class="fa fa-file-text"></i>
                                        &nbsp;&nbsp;&nbsp;Item Register 
                                </a>
                                <a class="nav-link" href="work-penalty.php">
                                        <i class="fas fa-money-bill"></i>
                                        &nbsp;&nbsp;&nbsp;Penalty
                                </a>
                                <a class="nav-link" href="customer-list.php">
                                        <i class="fas fa-user"></i>
                                        &nbsp;&nbsp;&nbsp;Customer List
                                </a>
                </div>
        </div>
        <div class="sb-sidenav-footer">
                <div class="small">Logged in as Admin:</div>
                <?php echo $user_name; ?>
        </div>

<?php  } ?>