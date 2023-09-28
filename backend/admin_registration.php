<?php
    require_once("../common_files/configuration.php");
    //if "admin" session is not set then only display page else redirect admin to dashboard page
    if(!isset($_SESSION["admin"])) {

        if(isset($_POST["submit"])) {

            //get admin data
            $adminName = $_POST["adminName"];
            $adminPswd = base64_encode($_POST["adminPswd"]);
            $adminEmail = $_POST["adminEmail"];

            //admin created data
            $cDate = date("Y-m-d");

            //check if its a new user
            $admin = new database_operations();

            //fetch data from admin table if username found
            $whereCondition = "where email= '{$adminEmail}'";
            $data = $admin->selectData("admin", "*", "", $whereCondition); 

            if(!empty($data)) {
                $errorMessage = "<div class='alert alert-danger'>You have already registered, Please login</div>";
            }
            else {
                //insert data in database
                $data = array("name"=>$adminName, "email"=>$adminEmail, "password"=>$adminPswd, "created_date"=>$cDate);
                $insertOperation = new database_operations();
                $insertOperation->insertData("admin",$data);

                //redirect to login page
                $login = "/backend/admin_login.php";
                header("Location:".$login);
            }
        }

        //check if both passwords match
        if(isset($_POST["action"])) {
            if($_POST["action"] == "matchPasswords") {
                if($_POST["pswd"] == $_POST["confirmPswd"]) {
                    echo "Matched";
                    exit;
                }
                else {
                    echo "NotMatched";
                    exit;
                }
            }
        }
    }
?>
<?php require_once 'header.php';?>
            <div class="row">
                <!-- Admin Registration Image -->
                <div class="col-lg-6 d-none d-lg-block text-center" id="registerImg">
                    <img src="../common_images/admin_register.jpg" width="500" height="500" alt="adminImg">
                </div>
                <!-- Admin Registration Form -->
                <div class="col-md-6">
                    <div class="card ml-2 mr-2" id="admin_registration_form">
                        <div class="card-header bg-secondary">
                            <h3 class="text-white text-center">Admin Registration</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $errorMessage; ?>
                            <form method="POST" id="adminDetails" name="adminDetails" class="mt-3">
                                <div class="form-group ml-3">
                                    <label for="adminName" class="mt-2">Username:</label>
                                    <input type="text" name="adminName" id="adminName" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="adminEmail" class="mt-2">Email:</label>
                                    <input type="email" name="adminEmail" id="adminEmail" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="adminPswd" class="mt-2">Password:</label>
                                    <input type="password" name="adminPswd" id="adminPswd" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="confirmPswd" class="mt-2">Confirm Password:</label>
                                    <input type="password" name="confirmPswd" id="confirmPswd" class="form-control" oninput="matchPasswords()">
                                    <div class="mt-2" id="errmsg"></div>
                                </div>
                                <div class="mt-2 ml-3 text-center">
                                    <input type="submit" name="submit" id="submit" value="Submit" class="mt-1 btn btn-success">
                                </div>
                            </form>
                            <div class="mt-3 ml-3 mb-5 text-center">
                                <a href="admin_login.php" class="text-secondary">Already User?, Login here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/admin_register.js"></script>
<?php require_once 'footer.php';?>
