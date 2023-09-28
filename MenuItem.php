<?php
    require_once ("common_files/configuration.php");
    require_once ("common_files/cms_data.php");
    
    if(isset($_SESSION["menuItem"])) { //if session set, then display page

        $item_id = $_GET["item_id"]; //get item id to display its details
        $whereCondition = "where id='$item_id'";
        $databaseObj = new database_operations();
        $itemData = $databaseObj->selectData("items", "*", "", $whereCondition);
        if(!empty($itemData)) {
            foreach($itemData as $itemDetails) {

                //formatting item availabel time
                $item_availabel_to = $itemDetails["item_availabel_to"];
                $parts = explode(',', $item_availabel_to);
                $result = implode(', ', $parts);

                //append item information
                $itemInfo.="
                    <p id='item_heading'><strong>".$itemDetails["name"]."</strong></p>
                    <img id='item_img' src='/item_images/".$itemDetails['image']."'>
                    <p id='long_description' class='text-dark'>".$itemDetails["description"]."</p>
                    <p id='time' class='text-dark'>Item Is availabel for: ".$result."</p>
                    <p id='price' class='text-dark'>Price: ".$itemDetails["price"]."</p>";
            }
        }
    }
?>
<?php require_once 'header.php';?>
            <!-- Display item details -->
            <section id="itemDetails" class="mt-5 mb-5">
                <div class="container">
                    <?php echo $itemInfo; ?>
                </div>
            </section>
        </div>
<?php require_once 'footer.php';?>
