$(document).ready(function () {
    showMenuList();
    showMenuItems();
});

//show categories data
function showMenuList() {
    $.ajax({
        url: "MenuListing.php",
        type: "POST",
        data: {
            action: "showMenuList"
        },
        success: function(response) {
            $("#menuType").html(response);
        }
    });
}

//show items data
function showMenuItems() {
    $.ajax({
        url: "MenuListing.php",
        type: "POST",
        data: {
            action: "showMenuItems",
        },
        success: function(response) {
            $("#menuList").html(response);
        }
    });
}

//filter items by categories
function filterMenuItems() {
    var menuType = $("#menuType").val();
    $.ajax({
        url: "MenuListing.php",
        type: "POST",
        data: {
            action: "filterMenu",
            menuType: menuType
        },
        success: function(response) {
            $("#menuList").html(response);
        }
    });
}
