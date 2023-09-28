$(document).ready(function () {
    showItemsData();
});

//validate form data
$(function() {
    $("#itemDetails").validate({
        rules: {
            itemName: {
                required: true
            },
            itemPic: {
                required: true,
                extension: "jpg|jpeg|png"
            },
            long_desc: {
                required: true
            },
            itemPrice: {
                required: true
            },
            "time[]": {
                required: true
            },
            sortID: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            itemName:{
                required: "Please enter item name"
            },
            itemPic: {
                required: "Please upload one image",
                extension: "Please upload file in these format only (jpg, jpeg, png)!"
            },
            long_desc: {
                required: "Please add description"
            },
            itemPrice: {
                required: "Please add price"
            },
            "time[]": {
                required: "Please select one time"
            },
            sortID:{
                required: "Please enter sort id"
            },
            status:{
                required: "Please select status"
            }
        },
        errorPlacement: function(error,element){
            if(element.is(":radio") || element.is(":checkbox")) {
                error.insertAfter(element.parents(".form-group"));
            }
            else {
                error.insertAfter(element);
            }
        }
    });
});

//validate form data
$(function() {
    $("#itemUpdateDetail").validate({
        rules: {
            updatedItemName: {
                required: true
            },
            updatedItemImage: {
                extension: "jpg|jpeg|png"
            },
            updatedLong_desc: {
                required: true
            },
            updatedItemPrice: {
                required: true
            },
            "updatedTime[]": {
                required: true
            },
            updatedSortID: {
                required: true
            },
            updatedStatus: {
                required: true
            }
        },
        messages: {
            updatedItemName:{
                required: "Please enter item name"
            },
            updatedItemImage: {
                extension: "Please upload file in these format only (jpg, jpeg, png)!"
            },
            updatedLong_desc: {
                required: "Please add description"
            },
            updatedItemPrice: {
                required: "Please add price"
            },
            "updatedTime[]": {
                required: "Please select one time"
            },
            updatedSortID:{
                required: "Please enter sort id"
            },
            updatedStatus:{
                required: "Please select status"
            }
        },
        errorPlacement: function(error,element){
            if(element.is(":radio") || element.is(":checkbox")) {
                error.insertAfter(element.parents(".form-group"));
            }
            else {
                error.insertAfter(element);
            }
        }
    });
});

//display items data
function showItemsData() {
    $.ajax({
        url: "ManageItems.php",
        type: "POST",
        data: {
            action: "showItemsData",
        },
        success: function(response) {
            $("#itemTable").html(response);
            $('#itemResult').DataTable({
                "order": [7, 'asc'],
                "columnDefs": [{"targets": [2,3,6,8], "orderable": false}],
                "pageLength": 5,
                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ]
            });
        }
    });
}

//delete item
function deleteItem(id) {
    swal({
        title: "Are you sure?",
        text: "Do you really want to remove this item?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((isDeleted) => {
        if (isDeleted) {
            $.ajax({
                url: "ManageItems.php",
                type: "POST",
                data: {
                    action: "deleteItem",
                    id: id,
                    columnName: "id"
                },
                success: function(response) {
                    swal("Deleted Item Successfully", {
                        icon: "success",
                    });
                    showItemsData();
                }
            });
        } 
        else {
          swal("Your item is safe!");
        }
    });
}

//update cms
function updateItem(id) {
    var valid = $("form[name='itemUpdateDetail']").valid();
    if(valid) {
        $.ajax({
            url: "ManageItems.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "updateItem",
                id: id
            },
            success: function(response) {
    
                //reset checkbox
                $("#Breakfast").attr("checked",false);
                $("#Lunch").attr("checked",false);
                $("#Dinner").attr("checked",false);
    
                //append values
                $("#id").val(response.id);
                $("#updatedItemName").val(response.name);
                $("#updatedCategory").val(response.category_id);
                $("#updateItemImage").attr("src","../item_images/"+response.image);
                $("#updatedLong_desc").val(response.description);
                $("#updatedItemPrice").val(response.price);
                $("#updatedSortID").val(response.sort_order);
                
                //selecting checkbox
                item_availabel_array=response.item_availabel_to.split(',');
                if(jQuery.inArray("Breakfast", item_availabel_array) !== -1) {
                    $("#Breakfast").attr("checked",true);
                }
                if(jQuery.inArray("Lunch", item_availabel_array) !== -1) {
                    $("#Lunch").attr("checked",true);
                }
                if(jQuery.inArray("Dinner", item_availabel_array) !== -1) {
                    $("#Dinner").attr("checked",true);
                }
    
                //selecting radio buttons
                if(response.status=="1") {
                    $("#updatedStatus_1").attr("checked","checked");
                }
                else {
                    $("#updatedStatus_2").attr("checked","checked");
                }
            }
        });
    }
}

//insert image preview
function itemImagePreview(image) {
    var reader=new FileReader();
    reader.onload=function (e) {
        $("#itemImage").attr('src',e.target.result);
        $("#itemImage").width(100);
        $("#itemImage").height(100);
    };
    reader.readAsDataURL(image.files[0]);
}
//updated image preview
function updatedItemImagePreview(image) {
    var reader=new FileReader();
    reader.onload=function (e) {
        $("#updateItemImage").attr('src',e.target.result);
    };
    reader.readAsDataURL(image.files[0]);
}


//redirecting admin to login page after logout
function logout() {
    $.ajax({
        url: "ManageItems.php",
        type: "POST",
        data: {
            action: "logout"
        },
        success: function(response) {
            $(location).attr("href","admin_login.php");
        }
    });
}
