<?php
    require_once("../common_files/configuration.php");

    class ManageCMS
    {
        private $databaseObj;

        function __construct() {
            $this->databaseObj=new database_operations(); //creating object of database operations class
        }

        public function showCMSData() {
            //get all the data from tables
            $cmsData = $this->databaseObj->selectData("cms");
            if(!empty($cmsData)) {

                //creating table
                $cmsTable = "<table id='cmsResult' class='table table-striped table-bordered mb-5'>
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>Page Name</th>
                        <th>Page Description</th>
                        <th>Meta Title</th>
                        <th>Meta Keywords</th>
                        <th>Meta Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($cmsData as $cmsDetails) {

                    $cmsTable.="
                    <tr>
                        <td>".$cmsDetails["page_title"]."</td>
                        <td>".$cmsDetails["name"]."</td>
                        <td>".$cmsDetails["page_desc"]."</td>
                        <td>".$cmsDetails["meta_title"]."</td>
                        <td>".$cmsDetails["meta_keywords"]."</td>
                        <td>".$cmsDetails["meta_desc"]."</td>
                        <td>"."<i class='fas fa-user-edit bg-warning' style='font-size: 22px;' data-toggle='modal' data-target='#updateModal' onclick='updateCMS(".$cmsDetails["id"].")'></i>"."</td>
                    </tr>";
                }
                $cmsTable.="</tbody></table>";
                return $cmsTable;
            }
        }
        
        //display modal to update data
        public function updateCMS($id) {

            //get data of id to update from category table
            $whereCondition = "where id='{$id}'";
            $existingCMS = $this->databaseObj->selectData("cms","*","",$whereCondition);
            return $existingCMS;
        }

        //store updated data to table
        public function updatedData($id, $pageTitle, $pageDesc, $metaTitle, $metaKeyword, $metaDesc) {
            $dataToUpdate = array("page_title"=>$pageTitle, "page_desc"=>$pageDesc, "meta_title"=>$metaTitle, "meta_keywords"=>$metaKeyword, "meta_desc"=>$metaDesc);
            $this->databaseObj->updateData("cms",$dataToUpdate,"id=".$id);
        }
    }

    //if Session is set then only display the page
    if(isset($_SESSION["admin"])) {
        
        if(isset($_POST["action"])) {
            
            //display all categories
            if($_POST["action"] == "showCmsData") {
                $selectCMS = new ManageCMS();
                $cmsTable = $selectCMS->showCMSData();
                echo $cmsTable;
                exit;
            }

            //insert data
            else if($_POST["action"] == "insertData") {

                //get data to insert
                $pageTitle = $_POST["pageTitle"];
                $pageName = $_POST["pageName"];
                $pageDesc = $_POST["pageDesc"];
                $metaTitle = $_POST["metaTitle"];
                $metaKeyword = $_POST["metaKeyword"];
                $metaDesc = $_POST["metaDesc"];

                $count = 0;
                $selectOperation = new database_operations();
                $existingCMS = $selectOperation->selectData("cms");
                foreach($existingCMS as $cmsDetails) {
                    if($cmsDetails["page_title"] == $pageTitle) {
                        $count++;
                    }
                }

                //Add cms only if its a new cms information
                if($count==0) {
                    $data = array("name"=>$pageName,"page_title"=>$pageTitle, "page_desc"=>$pageDesc, "meta_title"=>$metaTitle, "meta_keywords"=>$metaKeyword, "meta_desc"=>$metaDesc);
                    $insertCMS = new database_operations();
                    $data = $insertCMS->insertData("cms", $data);
                    echo "<div class='alert alert-success'>CMS added successfully</div>";
                    exit;
                }
                else {
                    echo "<div class='alert alert-danger'>You have already added this cms</div>";
                    exit;
                }
            }

            //update cms details
            else if($_POST["action"] == "updateCMS") {

                //get id to update
                $id = $_POST["id"];

                $selectCMS = new ManageCMS();
                $updateForm = $selectCMS->updateCMS($id);
                echo json_encode($updateForm[0]);
                exit;
            }

            //store updated data in tables
            else if($_POST["action"] == "updatedCMSData") {

                //get updated data
                $page_id = $_POST["page_id"];
                $page_title = $_POST["page_title"];
                $page_desc = $_POST["page_desc"];
                $meta_title = $_POST["meta_title"];
                $meta_keywords = $_POST["meta_keywords"];
                $meta_desc = $_POST["meta_desc"];

                $updateCMS = new ManageCMS();
                $updateCMS->updatedData($page_id, $page_title, $page_desc, $meta_title, $meta_keywords, $meta_desc);
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
    //if admin session is set then only display the page else redirecting to admin login page
    else {
        $adminLogin = "/backend/admin_login.php";
        header("Location:".$adminLogin);
    }
?>
<?php require_once 'header.php';?>
<?php include_once 'navbar.php';?>
            <!--Dashboard-->
            <header id="main-header" class="py-2 bg-info text-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                <i class="fas fa-utensils mr-2"></i>CMS
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <!--CMS Table-->
                <div class="container">
                    <div class="mt-5" id="msg"></div>
                    <div class="row mt-5">
                        <div class="col-md-3 ml-auto">
                            <a href="" class="btn btn-info btn-block" data-toggle="modal" data-target="#addCMSModal">+ Add CMS</a>
                        </div>
                    </div>
                    <div class="mt-5 mb-5" id="cmsTable"></div>
                </div>
            </div>

            <!--CMS Modal-->
            <div class="modal" id="addCMSModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Add CMS</h5>
                            <button class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="cmsDetails" name="cmsDetails" class="border border-dark">
                                <div class="form-group ml-2 mr-2">
                                    <label for="pageTitle" class="mt-1">Page Title:</label>
                                    <input type="text" name="pageTitle" id="pageTitle" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="pageName" class="mt-1">Page Name:</label>
                                    <input type="text" name="pageName" id="pageName" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="pageDesc" class="mt-1">Page Description:</label>
                                    <br>
                                    <textarea id="pageDesc" name="pageDesc" class="form-control" rows="4" cols="60"></textarea>
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="metaTitle" class="mt-1">Meta Title:</label>
                                    <input type="text" name="metaTitle" id="metaTitle" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="metaKeyword" class="mt-1">Meta Keywords:</label>
                                    <input type="text" name="metaKeyword" id="metaKeyword" class="form-control">
                                </div>
                                <div class="form-group ml-2 mr-2">
                                    <label for="metaDesc" class="mt-1">Meta Description:</label>
                                    <br>
                                    <textarea id="metaDesc" name="metaDesc" class="form-control" rows="4" cols="60"></textarea>
                                </div>
                                <div class="mb-2 ml-3">
                                    <button type="button" class="btn btn-success ml-4 mt-1" onclick="addCMS()">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--CMS Update Modal-->
            <div class="modal" id="updateModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Update CMS Details</h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="cmsUpdateDetails" name="cmsUpdateDetails" class="border border-dark">
                                    <input type="text" class="form-control" name="page_id" id="page_id" hidden>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedPageTitle" class="mt-1">Page Title:</label>
                                        <input type="text" name="updatedPageTitle" id="updatedPageTitle" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="pageName" class="mt-1">Page Name:</label>
                                        <input type="text" name="updatedPageName" id="updatedPageName" class="form-control" readonly>
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedPageDesc" class="mt-1">Page Description:</label>
                                        <br>
                                        <textarea name="updatedPageDesc" id="updatedPageDesc" class="form-control" rows="4" cols="60"></textarea>
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedMetaTitle" class="mt-1">Meta Title:</label>
                                        <input type="text" name="updatedMetaTitle" id="updatedMetaTitle" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedMetaKeyword" class="mt-1">Meta Keywords:</label>
                                        <input type="text" name="updatedMetaKeyword" id="updatedMetaKeyword" class="form-control">
                                    </div>
                                    <div class="form-group ml-2 mr-2">
                                        <label for="updatedMetaDesc" class="mt-1">Meta Description:</label>
                                        <br>
                                        <textarea name="updatedMetaDesc" id="updatedMetaDesc" class="form-control" rows="4" cols="60"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="updatedData" onclick="updatedCMSData()">Submit</button>
                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <script src="../js/ManageCMS.js"></script>
<?php require_once 'footer.php';?>
