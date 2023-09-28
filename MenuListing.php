<?php
    require_once ("common_files/configuration.php");
    require_once ("common_files/cms_data.php");
    $_SESSION["menuItem"] = "MenuItem";

    class MenuListing
    {
        private $databaseObj;
        private $path;

        function __construct() {
            $this->databaseObj = new database_operations(); //creating object of database operations class
            // $this->path = "http://".$_SERVER['SERVER_NAME']."/pranavkolharkar";
        }

        public function menuList() {
            //getting all the items to display
            $menuList = "";
            $fields = "items.id,items.category_id,name,image,description,price,item_availabel_to,items.status,items.sort_order,category.status,menu_type";
            $joins = "LEFT JOIN category on items.category_id=category.id";
            $whereCondition = "where items.status='1' and category.status='1'";
            $orderBy = "order by items.sort_order";
            $menuData = $this->databaseObj->selectData("items", $fields, $joins, $whereCondition, $orderBy);
            if(!empty($menuData)) {
                $menuList.="<div class='row mb-5'>";
                foreach($menuData as $menuDetails) {
                    $menuList.="
                    <div class='card mt-5 ml-2' style='width:17rem'>
                        <div class='card-header text-white bg-dark text-center'>".$menuDetails['name']."</div>
                        <div class='card-body'>
                            <img class='card-img-top' width='300' height='300' src='/item_images/".$menuDetails['image']."'>
                            <p class='card-title'>".$menuDetails['menu_type']."</p>
                            <p class='card-text'>Item Availabel for: ".$menuDetails['item_availabel_to']."</p>
                        </div>
                        <div class='card-footer'><a href='MenuItem.php?item_id=".$menuDetails['id']."' class='text-primary'>View Item</a></div>
                    </div>";
                }
                $menuList.="</div>";
            }
            else {
                $menuList.="Sorry, currently we don't have any food items to display";
            }
            return $menuList;
        }

        public function filterMenuItems($menuType) {
            //getting all categories
            $menuList = "";
            $fields = "items.id,items.category_id,name,image,description,price,item_availabel_to,items.status,items.sort_order,category.status,category.menu_type";
            $joins = "LEFT JOIN category on items.category_id=category.id";
            $orderBy = "order by items.sort_order";
            if($menuType=="") {
                $whereCondition = "where category.status='1' and items.status='1'";
            }
            else {
                $whereCondition = "where items.status='1' and items.category_id='$menuType'";
            }
            $menuData = $this->databaseObj->selectData("items", $fields, $joins, $whereCondition, $orderBy);
            if(!empty($menuData)) {
                $menuList.="<div class='row mb-5'>";
                foreach($menuData as $menuDetails) {
                    $menuList.="
                    <div class='card mt-5 ml-2' style='width:17rem'>
                        <div class='card-header text-white bg-dark text-center'>".$menuDetails['name']."</div>
                        <div class='card-body'>
                            <img class='card-img-top' width='300' height='300' src='/item_images/".$menuDetails['image']."'>
                            <p class='card-title'>".$menuDetails['menu_type']."</p>
                            <p class='card-text'>Item Availabel for: ".$menuDetails['item_availabel_to']."</p>
                        </div>
                        <div class='card-footer'><a href='MenuItem.php?item_id=".$menuDetails['id']."' class='text-primary'>View Item</a></div>
                    </div>";
                }
                $menuList.="</div>";
            }
            else {
                $menuList.="Sorry, currently we don't have any food items to display";
            }
            return $menuList;
        }
    }

    if(isset($_POST["action"])) {
        
        //display all menu
        if($_POST["action"] == "showMenuList") {
            $menuList = new database_operations();
            $whereCondition = "where status='1'";
            $data = $menuList->selectData("category","*","",$whereCondition);
            $category = "<option value=''>--Categories--</option>";
            foreach($data as $categories) {
                $category.="<option value='{$categories['id']}'>{$categories['menu_type']}</option>";
            }
            echo $category;
            exit;
        }

        //display all items
        if($_POST["action"] == "showMenuItems") {
            $selectMenu = new MenuListing();
            $menuList = $selectMenu->menuList();
            echo $menuList;
            exit;
        }

        //filter items according to category
        if($_POST["action"] == "filterMenu") {
            $selectMenu = new MenuListing();
            $menuList = $selectMenu->filterMenuItems($_POST["menuType"]);
            echo $menuList;
            exit;
        }
    }
?>
<?php require_once 'header.php';?>
            <!-- For user to select menu type-->
            <div class="container mt-5">
                <section id="categories" class="">
                    <div class="form-group col-md-3">
                        <label for="menuType" class="mt-1">Filter by Menu:</label>
                        <select name="menuType" id="menuType" class="form-select form-control" onchange="filterMenuItems()">
                        </select>
                    </div>
                </section>
            </div>

            <!-- Menu List -->
            <section id="menu-items">
                <div class="container mb-5">
                    <div class="mt-5" id="menuList"></div>
                </div>
            </section>
        </div>
        <script src="js/MenuListing.js"></script>
<?php require_once 'footer.php';?>
