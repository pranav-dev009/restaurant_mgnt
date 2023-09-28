<?php
    require_once("../common_files/configuration.php");

    class ManageItems
    {
        private $databaseObj;

        function __construct() {
            $this->databaseObj = new database_operations(); //creating object of database operations class
        }

        public function showItemsData() {
            global $path;
            $fields = "items.id,name,image,description,price,item_availabel_to,items.status,items.sort_order,menu_type";
            $joins = "LEFT JOIN category on items.category_id=category.id";
            //get all the data from tables
            $itemsData = $this->databaseObj->selectData("items", $fields, $joins);
            if(!empty($itemsData)) {

                //creating table
                $itemsTable = "<table id='itemResult' class='table table-striped table-bordered mb-5'>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th>Item Image</th>
                        <th>Item Description</th>
                        <th>Item Price</th>
                        <th>Item Availabel Time</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($itemsData as $itemsDetails) {

                    //check for status is active or not
                    if($itemsDetails['status']=='1') {
                        $status = "<span class='bg-success text-white'>Active</span>";
                    }
                    else {
                        $status = "<span class='bg-danger text-white'>In-active</span>";
                    }
                    $itemsTable.="
                    <tr>
                        <td>".$itemsDetails["menu_type"]."</td>
                        <td>".$itemsDetails["name"]."</td>
                        <td>"."<img width='100' height='100' src='/item_images/".$itemsDetails["image"]."'>"."</td>
                        <td>".$itemsDetails["description"]."</td>
                        <td>".$itemsDetails["price"]."</td>
                        <td>".$itemsDetails["item_availabel_to"]."</td>
                        <td>".$status."</td>
                        <td>".$itemsDetails["sort_order"]."</td>
                        <td>"."<i class='fas fa-user-edit bg-warning' style='font-size: 22px;' data-toggle='modal' data-target='#updateModal' onclick='updateItem(".$itemsDetails["id"].")'></i>"."<i class='far fa-trash-alt bg-danger mt-3 ml-3' style='font-size: 22px;' onclick='deleteItem(".$itemsDetails["id"].")'></i>"."</td>
                    </tr>";
                }
                $itemsTable.="</tbody></table>";
                return $itemsTable;
            }
        }

        //remove item
        public function deleteItem($id, $columnName) {

            //firstly get all the data from news table
            $itemData = $this->databaseObj->selectData("items");
            foreach($itemData as $itemDetails) {
                if($itemDetails["id"] == $id) {

                    //getting image names
                    $itemImage = $itemDetails["image"];
                    break;
                }
            }

            //images stored folder path
            $itemImagePath = "../item_images/".$itemImage;

            //remove images from physical location
            unlink($itemImagePath);

            //delete method to remove record from table
            $this->databaseObj->deleteData("items", $id, $columnName);
        }

        //display modal to update the record
        public function updateItem($id) {
            
            //get data of id to update from category table
            $whereCondition = "where id='{$id}'";
            $existingItem = $this->databaseObj->selectData("items","*","",$whereCondition);
            return $existingItem;
        }
    }

    //if Session is set then only display the page
    if(isset($_SESSION["admin"])) {
        
        //get data to insert
        if(isset($_POST["insertSubmit"])) {

            //get data to insert
            $category = $_POST["category"];
            $itemName = $_POST["itemName"];
            $long_desc = $_POST["long_desc"];
            $itemPrice = $_POST["itemPrice"];
            $status = $_POST["status"];
            $sortID = $_POST["sortID"];
            $time = implode(",", $_POST["time"]); 

            //getting the uploaded image
            $itemImageDetails = $_FILES["itemPic"];
            $itemImage = $itemImageDetails["name"];
            $itemImageName = pathinfo($itemImage, PATHINFO_FILENAME);
            $itemImageExtension = pathinfo($itemImage, PATHINFO_EXTENSION);
            
            //appending current date to image file
            $itemImagePic = $itemImageName.'_'.date('Y-m-d').'.'.$itemImageExtension;
            $itemImageFile = $_FILES["itemPic"]["tmp_name"];
            move_uploaded_file($itemImageFile,'../item_images/'.$itemImagePic);

            $data = array("category_id"=>$_POST["category"], "name"=>$_POST["itemName"], "image"=>$itemImagePic, "description"=>$_POST["long_desc"], "price"=>$_POST["itemPrice"], "item_availabel_to"=>$time, "status"=>$_POST["status"], "sort_order"=>$_POST["sortID"]);

            //insert data in table
            $insertOperation = new database_operations();
            $insertOperation->insertData("items", $data);

            $itemInfo = "<div class='alert alert-success mt-3'>Item Added Successfully</div>";
        }

        //get updated data
        if(isset($_POST["updatedSubmit"])) {
            //get id of the item updated
            $id = $_POST["id"];

            //get updated data
            $updatedCategory = $_POST["updatedCategory"];
            $updatedItemName = $_POST["updatedItemName"];
            $updatedLong_desc = $_POST["updatedLong_desc"];
            $updatedItemPrice = $_POST["updatedItemPrice"];
            $time = implode(",", $_POST["updatedTime"]);
            $updatedStatus = $_POST["updatedStatus"];
            $updatedSortID = $_POST["updatedSortID"];

            //get image details
            $itemImageDetails = $_FILES["updatedItemImage"];
            $itemImage = $itemImageDetails["name"];

            //if new image is added
            if($itemImage!="") { 
                //get data from items table
                $databaseObj = new database_operations();
                $existingItem = $databaseObj->selectData("items");
                foreach($existingItem as $itemDetails) {
                    //getting the old image
                    if($itemDetails["id"] == $id) {
                        $itemImage_path = "../item_images/".$itemDetails["image"];
                        break;
                    }
                }
                //deleting old image
                unlink($itemImage_path);
                $itemImageName = pathinfo($itemImage, PATHINFO_FILENAME);
                $itemImageExtension = pathinfo($itemImage, PATHINFO_EXTENSION);

                //appending current date to new image file
                $itemImagePic = $itemImageName.'_'.date('Y-m-d').'.'.$itemImageExtension;
                $itemImageFile = $_FILES["updatedItemImage"]["tmp_name"];
                move_uploaded_file($itemImageFile, '../item_images/'.$itemImagePic);

                //update the data
                $data = array("category_id"=>$updatedCategory, "name"=>$updatedItemName, "image"=>$itemImagePic, "description"=>$updatedLong_desc, "price"=>$updatedItemPrice, "item_availabel_to"=>$time, "status"=>$updatedStatus, "sort_order"=>$updatedSortID);
                $updateOperation = new database_operations();
                $updateOperation->updateData("items", $data, "id=".$id);

                $itemInfo = "<div class='alert alert-success mt-3'>Item Updated Successfully</div>";
            }
            else {
                $data = array("category_id"=>$updatedCategory, "name"=>$updatedItemName, "description"=>$updatedLong_desc, "price"=>$updatedItemPrice, "item_availabel_to"=>$time, "status"=>$updatedStatus, "sort_order"=>$updatedSortID);
                $updateOperation = new database_operations();
                $updateOperation->updateData("items", $data, "id=".$id);
                
                $itemInfo = "<div class='alert alert-success mt-3'>Item Updated Successfully</div>";
            }
        }
        
        if(isset($_POST["action"])) {
            
            //display all items data
            if($_POST["action"] == "showItemsData") {
                $selectItems = new ManageItems();
                $itemsTable = $selectItems->showItemsData();
                echo $itemsTable;
                exit;
            }

            //delete item
            else if($_POST["action"] == "deleteItem") {

                //get id to delete
                $id = $_POST["id"];
                $columnName = $_POST["columnName"];

                $selectItem = new ManageItems();
                $selectItem->deleteItem($id, $columnName);
                exit;
            }

            //update item data
            else if($_POST["action"] == "updateItem") {

                //get id to update
                $id = $_POST["id"];

                $selectItem = new ManageItems();
                $updateForm = $selectItem->updateItem($id);
                echo json_encode($updateForm[0]);
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
            <header id="main-header" class="py-2 bg-success text-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                <i class="fas fa-cookie-bite mr-2"></i>Items
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <!--Items Table-->
                <div class="container">
                    <?php echo $itemInfo; ?>
                    <div class="row mt-5">
                        <div class="col-md-3 ml-auto">
                            <a href="" class="btn btn-success btn-block" data-toggle="modal" data-target="#addItemsModal">+ Add Items</a>
                        </div>
                    </div>
                    <div class="mt-5 mb-5" id="itemTable"></div>
                </div>
            </div>

            <!--Items Modal-->
            <div class="modal" id="addItemsModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Add Item</h5>
                            <button class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="itemDetails" name="itemDetails" enctype='multipart/form-data' class="border border-dark">
                                <div class="form-group ml-2 mr-2">
                                    <label for="category" class="mt-1">Choose Category:</label>
                                    <select name="category" id="category" class="form-control form-select" required>
                                        <option value="">--Category--</option>
                                        <?php
                                            $categories = new database_operations();
                                            $whereCondition = "where status='1'";
                                            $data = $categories->selectData("category","*","",$whereCondition);
                                            foreach($data as $categories) {
                                                ?>
                                                <option value="<?php echo $categories["id"]; ?>"><?php echo $categories["menu_type"]; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="itemName" class="mt-1">Item Name:</label>
                                    <input type="text" name="itemName" id="itemName" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="itemPic" class="mt-1">Item Image:</label>
                                    <input type="file" name="itemPic" id="itemPic" class="form-control" onchange="itemImagePreview(this);">
                                    <img src="" id="itemImage">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="longDesc" class="mt-1">Long Description:</label>
                                    <br>
                                    <textarea id="long_desc" name="long_desc" class="form-control" rows="4" cols="60"></textarea>
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="itemPrice" class="mt-1">Item Price:</label>
                                    <input type="number" name="itemPrice" id="itemPrice" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <p class=" mt-1">Item is availabel to?:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="time[]" value="Breakfast">
                                        <label class="form-check-label" for="time">Breakfast</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="time[]" value="Lunch">
                                        <label class="form-check-label" for="time">Lunch</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="time[]" value="Dinner">
                                        <label class="form-check-label" for="time">Dinner</label>
                                    </div>
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
                                <div class="mb-5 ml-2">
                                    <input type="submit" name="insertSubmit" id="insertSubmit" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Items Update Modal-->
            <div class="modal" id="updateModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Update Item Details</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="itemUpdateDetail" name="itemUpdateDetail" enctype="multipart/form-data" class="border border-dark">
                                    <input type="text" class="form-control" name="id" id="id" hidden>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="itemName" class="mt-1">Item Name:</label>
                                        <input type="text" name="updatedItemName" id="updatedItemName" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="category" class="mt-1">Category:</label>
                                        <select name="updatedCategory" id="updatedCategory" class="form-select form-control">
                                        <?php
                                            $categories = new database_operations();
                                            $whereCondition = "where status='1'";
                                            $data = $categories->selectData("category","*","",$whereCondition);
                                            foreach($data as $categories) {
                                                ?>
                                                <option value="<?php echo $categories["id"]; ?>"><?php echo $categories["menu_type"]; ?></option>
                                                <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="itemImage" class="mt-1">Item Image:</label>
                                        <input type="file" name="updatedItemImage" id="updatedItemImage" accept="image/*" class="form-control" onchange="updatedItemImagePreview(this);">
                                        <img src="" id="updateItemImage" name="updatedItemImage" width="100" height="100">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="long_desc" class="mt-1">Long Description:</label>
                                        <br>
                                        <textarea id="updatedLong_desc" name="updatedLong_desc" class="form-control" rows="4" cols="60"></textarea>
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedItemPrice" class="mt-1">Item Price:</label>
                                        <input type="number" name="updatedItemPrice" id="updatedItemPrice" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedSortID" class="mt-1">Sort ID:</label>
                                        <input type="number" name="updatedSortID" id="updatedSortID" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <p class=" mt-1">Item is availabel to?:</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="updatedTime[]" id="Breakfast" value="Breakfast">
                                            <label class="form-check-label" for="time">Breakfast</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="updatedTime[]" id="Lunch" value="Lunch">
                                            <label class="form-check-label" for="time">Lunch</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="updatedTime[]" id="Dinner" value="Dinner">
                                            <label class="form-check-label" for="time">Dinner</label>
                                        </div>
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
                                    <div class="mt-2 mb-2 ml-2">
                                        <input type="submit" name="updatedSubmit" id="updatedSubmit" class="btn btn-success">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <script src="../js/ManageItems.js"></script>
<?php require_once 'footer.php';?>
