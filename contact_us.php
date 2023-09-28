<?php
    require_once ("common_files/configuration.php"); //including the database operation file
    require_once ("common_files/cms_data.php");

    if(isset($_POST["submit"])) {
        //get data
        $userName = $_POST["userName"];
        $userEmail = $_POST["userEmail"];
        $userPhoneno = $_POST["userPhoneno"];
        $userDetails = $_POST["userDetails"];
        
        //insert user data in tables
        $data = array("name"=>$userName,"email"=>$userEmail,"phone_no"=>$userPhoneno,"details"=>$userDetails);
        $insertOperation = new database_operations();
        $insertOperation->insertData("users",$data);
        $errorMessage = "<div class='alert alert-success'>Data saved!!</div>";
    }
?>
<?php require_once 'header.php';?>
            <section id="contactUS" class="mt-5">
                <img src="/common_images/contact_us.jpg" id="contactUSImage">
            </section>

            <div class="container mt-5">
                <section id="userForm">
                    <div class="row">
                        <div class="col-md-6 mt-5 mx-auto border border-dark mb-5">
                            <p class="mt-2 text-primary">Fill the Details</p>
                            <!-- Form to get user details -->
                            <div><?php echo $errorMessage; ?></div>
                            <form method="POST" id="userData" name="userData" class="mt-3">
                                <div class="form-group ml-3">
                                    <label for="userName" class="mt-2">Username:</label>
                                    <input type="text" name="userName" id="userName" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="userEmail" class="mt-2">Email:</label>
                                    <input type="text" name="userEmail" id="userEmail" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="userPhoneno" class="mt-2">Phone No:</label>
                                    <input type="tel" name="userPhoneno" id="userPhoneno" class="form-control">
                                </div>
                                <div class="form-group ml-3">
                                    <label for="userDetails" class="mt-2">User Details:</label>
                                    <br>
                                    <textarea id="userDetails" name="userDetails" class="form-control" rows="4" cols="60"></textarea>
                                </div>
                                <div class="mt-2 ml-3 mb-2 text-center">
                                    <input type="submit" name="submit" id="submit" value="Submit" class="mt-1 btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <script src="<?php echo $path; ?>/restaurant_mgnt/js/contact_us.js"></script>
<?php require_once 'footer.php';?>
