<?php
    require_once("../common_files/configuration.php");
    //if "admin" session is not set then only display page else redirect admin to dashboard page
    if(!isset($_SESSION["admin"])) {

        if(isset($_POST["submit"])) {

            //get username & pswd
            $name = $_POST["adminName"];
            $password = base64_encode($_POST["adminPswd"]);

            //creating object of database class
            $admin = new database_operations();

            //fetch data from admin table if username & password matches
            $whereCondition = "where name= '{$name}' and password= '{$password}'";
            $data = $admin->selectData("admin", "*", "", $whereCondition);
            if(count($data) == 1) {

                $_SESSION["admin"] = $name;
                //redirect to dashboard
                $dashboard = "/backend/dashboard.php";
                header("Location:".$dashboard);
            }
            //if incorrect details are entered
            else {
                $errorMessage = "<div class='alert alert-danger'>Invalid Credentails</div>";
            }
        }
    }
    else {
        $dashboard = "backend/dashboard.php";
        header("Location:".$dashboard);
    }
?>
<?php require_once 'header.php';?>
            <div class="row">
                <!-- Admin Login Image -->
                <div class="col-lg-6 d-none d-lg-block text-center" id="loginImg">
                    <img src="../common_images/admin_login.png" width="500" height="500" alt="adminImg">
                </div>
                <!-- Admin Login Form -->
                <div class="col-md-6">
                    <div class="card ml-2 mr-2" id="admin_login_form">
                        <div class="card-header bg-secondary">
                            <h3 class="text-white text-center">Admin Login</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $errorMessage; ?>
                            <form method="POST" id="adminDetails" name="adminDetails" class="mt-3">
                                <div class="form-group ml-3">
                                    <label for="adminName" class="mt-2">Username:</label>
                                    <input type="text" name="adminName" id="adminName" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="adminPswd" class="mt-2">Password:</label>
                                    <input type="password" name="adminPswd" id="adminPswd" class="form-control">
                                </div>
                                <div class="mt-2 ml-3 text-center">
                                    <input type="submit" name="submit" id="submit" value="Submit" class="mt-1 btn btn-success">
                                </div>
                            </form>
                            <div class="mt-3 ml-3 mb-3 text-center">
                                <a href="admin_registration.php" class="text-secondary">New User?, Register here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/js/admin_login.js"></script>
<?php require_once 'footer.php';?>
