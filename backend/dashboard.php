<?php
    require_once("../common_files/configuration.php");
    
    //if Session is set then only display the page
    if(isset($_SESSION["admin"])) {

        //get total no. of categories, items, cms, users in our system
        $totalCategories = getTotalCategroies();
        $totalItems = getTotalItems();
        $totalAdmins = getTotalAdmins();
        $totalCMS = getTotalCMS();
        
        if(isset($_POST["action"])) {
            //if logout is clicked then destroy sessions
            if($_POST["action"] == "logout") {
                session_destroy();
                exit;
            }
        }
    }
    //if admin session is not set then only display the page else redirecting to admin login page
    else {
        $adminLogin = "/backend/admin_login.php";
        header("Location:".$adminLogin);
    }

    function getTotalCategroies() {
        $databaseObj = new database_operations();
        $categoriesData = $databaseObj->selectData("category");
        return count($categoriesData);
    }

    function getTotalItems() {
        $databaseObj = new database_operations();
        $itemsData = $databaseObj->selectData("items");
        return count($itemsData);
    }

    function getTotalAdmins() {
        $databaseObj = new database_operations();
        $adminData = $databaseObj->selectData("users");
        return count($adminData);
    }

    function getTotalCMS() {
        $databaseObj = new database_operations();
        $cmsData = $databaseObj->selectData("cms");
        return count($cmsData);
    }
?>
<?php require_once 'header.php';?>
<?php include_once 'navbar.php';?>
            <!--Dashboard-->
            <header id="main-header" class="py-2 bg-primary text-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                <i class="fas fa-user-cog mr-2"></i>Dashboard
                            </h1>
                        </div>
                    </div>
                </div>
            </header>
            <!--ACTIONS-->
            <section id ="action" class="py-4 mb-4 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="../index.php" class="btn btn-warning btn-block">Main Site</a>
                        </div>
                    </div>
                </div>
            </section>
            <!--Display Operations Info-->
            <section id="posts">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card text-center bg-danger text-white mb-3">
                                <div class="card-body">
                                    <h3>Categories</h3>
                                    <h2 class="display-4">
                                        <i class="fas fa-utensils mr-3"></i><?php echo $totalCategories; ?>
                                    </h2>
                                    <a href="ManageCategories.php" class="btn text-white border btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center bg-success text-white mb-3">
                                <div class="card-body">
                                    <h3>Items</h3>
                                    <h2 class="display-4">
                                        <i class="fas fa-cookie-bite mr-2"></i><?php echo $totalItems; ?>
                                    </h2>
                                    <a href="ManageItems.php" class="btn text-white border btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card text-center bg-info text-white mb-3">
                                <div class="card-body">
                                    <h3>CMS</h3>
                                    <h2 class="display-4">
                                        <i class="fas fa-info-circle mr-2"></i></i><?php echo $totalCMS; ?>
                                    </h2>
                                    <a href="ManageCMS.php" class="btn text-white border btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center bg-warning text-white mb-5">
                                <div class="card-body">
                                    <h3>Users</h3>
                                    <h2 class="display-4">
                                        <i class="fas fa-user-lock mr-2"></i><?php echo $totalAdmins; ?>
                                    </h2>
                                    <a href="ManageUsers.php" class="btn text-white border btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script src="<?php echo $path; ?>/restaurant_mgnt/js/dashboard.js"></script>
<?php require_once 'footer.php';?>
