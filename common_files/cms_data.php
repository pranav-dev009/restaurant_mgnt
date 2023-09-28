<?php
//get current filename
$file = basename($_SERVER["SCRIPT_NAME"]);

$pageTitle = getPageTitle();
$pageDescription = getPageDescription();
$metaTitle = getMetaTitle();
$metaKeywords = getMetaKeywords();
$metaDescription = getMetaDescription();


//get page title
function getPageTitle() {
    global $file;
    $databaseObj = new database_operations();
    $whereCondition = "where name='{$file}'";
    $cmsData = $databaseObj->selectData("cms","*","",$whereCondition);
    if(!empty($cmsData)) {
        foreach($cmsData as $cmsDetails) {
            return $cmsDetails["page_title"];
            break;
        }
    }
}

//get page description
function getPageDescription() {
    global $file;
    $databaseObj = new database_operations();
    $whereCondition = "where name='{$file}'";
    $cmsData = $databaseObj->selectData("cms","*","",$whereCondition);
    if(!empty($cmsData)) {
        foreach($cmsData as $cmsDetails) {
            return $cmsDetails["page_desc"];
            break;
        }
    }
}

//get page description
function getMetaTitle() {
    global $file;
    $databaseObj = new database_operations();
    $whereCondition = "where name='{$file}'";
    $cmsData = $databaseObj->selectData("cms","*","",$whereCondition);
    if(!empty($cmsData)) {
        foreach($cmsData as $cmsDetails) {
            return $cmsDetails["meta_title"];
            break;
        }
    }
}

//get page description
function getMetaKeywords() {
    global $file;
    $databaseObj = new database_operations();
    $whereCondition = "where name='{$file}'";
    $cmsData = $databaseObj->selectData("cms","*","",$whereCondition);
    if(!empty($cmsData)) {
        foreach($cmsData as $cmsDetails) {
            return $cmsDetails["meta_keywords"];
            break;
        }
    }
}

//get page description
function getMetaDescription() {
    global $file;
    $databaseObj = new database_operations();
    $whereCondition = "where name='{$file}'";
    $cmsData = $databaseObj->selectData("cms","*","",$whereCondition);
    if(!empty($cmsData)) {
        foreach($cmsData as $cmsDetails) {
            return $cmsDetails["meta_desc"];
            break;
        }
    }
}
?>
