<?php
    require_once("../common_files/configuration.php");

    class ManageCategories
    {
        private $databaseObj;

        function __construct() {
            $this->databaseObj = new database_operations(); //creating object of database operations class
        }

        public function showCategoriesData() {
            //get all the data from tables
            $categoriesData = $this->databaseObj->selectData("category");
            if(!empty($categoriesData)) {

                //creating table
                $categoriesTable = "<table id='categoryResult' class='table table-striped table-bordered mb-5'>
                <thead>
                    <tr>
                        <th>Menu Type</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($categoriesData as $categoriesDetails) {

                    //check for status is active or not
                    if($categoriesDetails['status']=='1') {
                        $status = "<span class='bg-success text-white'>Active</span>";
                    }
                    else {
                        $status = "<span class='bg-danger text-white'>In-active</span>";
                    }
                    $categoriesTable.="
                    <tr>
                        <td>".$categoriesDetails["menu_type"]."</td>
                        <td>".$categoriesDetails["sort_order"]."</td>
                        <td>".$status."</td>
                        <td>"."<i class='fas fa-user-edit bg-warning' style='font-size: 22px;' data-toggle='modal' data-target='#updateModal' onclick='updateCategory(".$categoriesDetails["id"].")'></i>"."<i class='far fa-trash-alt bg-danger mt-3 ml-3' style='font-size: 22px;' onclick='deleteCategory(".$categoriesDetails["id"].")'></i>"."</td>
                    </tr>";
                }
                $categoriesTable.="</tbody></table>";
                return $categoriesTable;
            }
        }

        //if admin wants to remove any record
        public function deleteCategory($id, $columnName) {
            $count = 0;

            //get all the data from category table
            $existingCategory = $this->databaseObj->selectData("items");
            foreach($existingCategory as $categoriesDetails) {

                //checking if that category contains items
                if($categoriesDetails["category_id"] == $id) {
                    $count++;
                }
            }
            if($count == 0) { //if category=null then remove it
                //passing tablename,industry id to be removed & column name
                $this->databaseObj->deleteData("category", $id, $columnName);
            }
            return $count;
        }

        //if admin wants to update any category data
        public function updateCategory($id) {

            //get data of id to update from category table
            $whereCondition = "where id='{$id}'";
            $existingCategory = $this->databaseObj->selectData("category","*","",$whereCondition);
            return $existingCategory;
        }

        //update the data in tables
        public function updatedData($id, $categoryType, $sort_order, $status) {
            $dataToUpdate = array("menu_type"=>$categoryType, "sort_order"=>$sort_order, "status"=>$status);
            $this->databaseObj->updateData("category", $dataToUpdate, "id=".$id);
        }
    }

    //if Session is set then only display the page
    if(isset($_SESSION["admin"])) {
        
        if(isset($_POST["action"])) {
            
            //display all categories
            if($_POST["action"] == "showCategoriesData") {
                $selectCategories = new ManageCategories();
                $categoriesTable = $selectCategories->showCategoriesData();
                echo $categoriesTable;
                exit;
            }

            //insert data
            if($_POST["action"] == "insertData") {
                $count = 0;

                //get data to insert
                $categoryType = $_POST["categoryType"];
                $sortID = $_POST["sortID"];
                $status = $_POST["status"];

                $selectOperation = new database_operations();
                $existingCategory = $selectOperation->selectData("category");
                foreach($existingCategory as $categoryDetails) {
                    if($categoryDetails["menu_type"] == $categoryType) {
                        $count++;
                    }
                }

                //Add category only if its a new category
                if($count==0) {
                    $data = array("menu_type"=>$categoryType, "sort_order"=>$sortID, "status"=>$status);
                    $insertCategory = new database_operations();
                    $data = $insertCategory->insertData("category", $data);
                    echo "<div class='alert alert-success'>Category added successfully</div>";
                    exit;
                }
                else {
                    echo "<div class='alert alert-danger'>You have already added this category</div>";
                    exit;
                }
            }

            //remove category
            else if($_POST["action"] == "deleteCategory") {

                //get id to delete
                $id = $_POST["id"];
                $columnName = $_POST["columnName"];

                $selectCategories = new ManageCategories();
                $count = $selectCategories->deleteCategory($id, $columnName);
                if($count == 0) {
                    echo "success";
                }
                else {
                    echo "failure";
                }
                exit;
            }

            //get id of record to update
            else if($_POST["action"] == "updateCategory") {

                //get id to update
                $id = $_POST["id"];

                $selectCategory = new ManageCategories();
                $updateForm = $selectCategory->updateCategory($id);
                echo json_encode($updateForm[0]);
                exit;
            }

            //store updated data in table
            else if($_POST["action"] == "updatedCategoryData") {

                //get updated data
                $category_id = $_POST["category_id"];
                $categoryType = $_POST["categoryType"];
                $sort_order = $_POST["sort_order"];
                $status = $_POST["status"];

                $updateCategory = new ManageCategories();
                $updateCategory->updatedData($category_id, $categoryType, $sort_order, $status);
                echo "<div class='alert alert-success'>Successfully updated the record</div>";
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
            <header id="main-header" class="py-2 bg-danger text-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                <i class="fas fa-utensils mr-2"></i>Categories
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <!--Categories Table-->
                <div class="container">
                    <div class="mt-5" id="msg"></div>
                    <div class="row mt-5">
                        <div class="col-md-3 ml-auto">
                            <a href="" class="btn btn-danger btn-block" data-toggle="modal" data-target="#addCategoryModal">+ Add Category</a>
                        </div>
                    </div>
                    <div class="mt-5 mb-5" id="categoryTable"></div>
                </div>
            </div>

            <!--Category Modal-->
            <div class="modal" id="addCategoryModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Add Category</h5>
                            <button class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="categoryDetails" name="categoryDetails" class="border border-dark">
                                <div class="form-group ml-2 mr-2">
                                    <label for="categoryType" class="mt-1">Cateogory Type:</label>
                                    <input type="text" name="categoryType" id="categoryType" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="sortID" class="mt-1">Sort ID:</label>
                                    <input type="number" name="sortID" id="sortID" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <p class="mt-1">Status:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status" value="1">
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status" value="0">
                                        <label class="form-check-label" for="status">In-active</label>
                                    </div>
                                </div>
                                <div class="mt-2 mb-2 ml-3">
                                    <button type="button" class="btn btn-success ml-4 mt-1" onclick="addCategory()">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Category Update Modal-->
            <div class="modal" id="updateModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Update Category Details</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="categoryUpdateDetails" name="categoryUpdateDetails" class="border border-dark">
                                    <input type="text" class="form-control" name="category_id" id="category_id" hidden>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="categoryType" class="mt-1">Category Name:</label>
                                        <input type="text" name="updatedCategoryType" id="updatedCategoryType" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="sortID" class="mt-1">Sort ID:</label>
                                        <input type="number" name="updatedSortID" id="updatedSortID" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <p class="mt-1">Status:</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="updatedStatus" id="updatedStatus_1" value="1">
                                            <label class="form-check-label" for="status">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="updatedStatus" id="updatedStatus_2" value="0">
                                            <label class="form-check-label" for="status">In-active</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="updatedData" onclick="updatedCategoryData()">Submit</button>
                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <script src="../js/ManageCategories.js"></script>
<?php require_once 'footer.php';?>
