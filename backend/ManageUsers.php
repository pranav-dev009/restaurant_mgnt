<?php
    require_once("../common_files/configuration.php");

    class ManageUsers
    {
        private $databaseObj;

        function __construct() {
            $this->databaseObj = new database_operations(); //creating object of database operations class
        }

        public function showUsersData() {
            //get all the data from tables
            $usersData = $this->databaseObj->selectData("users");
            if(!empty($usersData)) {

                //creating table
                $usersTable = "<table id='userResult' class='table table-striped table-bordered mb-5'>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($usersData as $usersDetails) {
                    $usersTable.="
                    <tr>
                        <td>".$usersDetails["name"]."</td>
                        <td>".$usersDetails["email"]."</td>
                        <td>".$usersDetails["phone_no"]."</td>
                        <td>".$usersDetails["details"]."</td>
                    </tr>";
                }
                $usersTable.="</tbody></table>";
                return $usersTable;
            }
        }
    }

    //if Session is set then only display the page
    if(isset($_SESSION["admin"])) {
        
        if(isset($_POST["action"])) {
            
            //display users data
            if($_POST["action"] == "showUsersData") {
                $selectUsers = new ManageUsers();
                $usersTable = $selectUsers->showUsersData();
                echo $usersTable;
                exit;
            }
            //if logout is clicked then destroy sessions
            else if($_POST["action"] == "logout") {
                session_destroy();
                exit;
            }
        }
    }
    //if admin session is set then only display the page else redirectign to admin login page
    else {
        $adminLogin = "/backend/admin_login.php";
        header("Location:".$adminLogin);
    }
?>
<?php require_once 'header.php';?>
<?php include_once 'navbar.php';?>
            <!--Dashboard-->
            <header id="main-header" class="py-2 bg-warning text-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                <i class="fas fa-user-lock mr-2"></i>Users
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <!--Users Table-->
                <div class="container">
                    <div class="mt-5 mb-5" id="userTable"></div>
                </div>
            </div>
            <script src="../js/ManageUsers.js"></script>
<?php require_once 'footer.php';?>
