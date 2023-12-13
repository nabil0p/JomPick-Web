<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    &nbsp;&nbsp;&nbsp;&nbsp;<img src="assets/JomPick_logo1.jpg" alt="Logo" style="width:30px;height:30px;"/>
    <a class="navbar-brand ps-3" style="width: 190px;" href="admin_dashboard.php">JomPick</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div> -->
    </div>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="user-profile.php">Profile</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" onclick="logout()">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "function/logout.php"; // Redirect to the logout page
        }
    }
</script>