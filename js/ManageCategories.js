$(document).ready(function () {
    //validate form data
    $("form[name='categoryDetails']").validate({
        rules: {
            categoryType:{
                required: true
            },
            sortID:{
                required: true
            },
            status:{
                required: true
            }
        },
        messages: {
            categoryType:{
                required: "Please enter category name"
            },
            sortID:{
                required: "Please enter sort id"
            },
            status:{
                required: "Please select status"
            }
        },
        errorPlacement: function(error,element){
            if(element.is(":radio")) {
                error.insertAfter(element.parents(".form-group"));
            }
            else {
                error.insertAfter(element);
            }
        }
    });
    
    //validate form data
    $("form[name='categoryUpdateDetails']").validate({
        rules: {
            updatedCategoryType:{
                required: true
            },
            updatedSortID:{
                required: true
            },
            updatedStatus:{
                required: true
            }
        },
        messages: {
            updatedCategoryType:{
                required: "Please enter category name"
            },
            updatedSortID:{
                required: "Please enter sort id"
            },
            updatedStatus:{
                required: "Please select status"
            }
        },
        errorPlacement: function(error,element){
            if(element.is(":radio")) {
                error.insertAfter(element.parents(".form-group"));
            }
            else {
                error.insertAfter(element);
            }
        }
    });
    showCategoriesData();
});

//display categories data
function showCategoriesData() {
    $.ajax({
        url: "ManageCategories.php",
        type: "POST",
        data: {
            action: "showCategoriesData",
        },
        success: function(response) {
            $("#categoryTable").html(response);
            $('#categoryResult').DataTable({
                "order": [1, 'asc'],
                "columnDefs": [{"targets": [2,3], "orderable": false}],
                "pageLength": 5,
                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ]
            });
        }
    });
}

//add category
function addCategory() {
    var valid = $("form[name='categoryDetails']").valid();
    if(valid) {
        $.ajax({
            url: "ManageCategories.php",
            type: "POST",
            data: {
                action: "insertData",
                categoryType: $("#categoryType").val(),
                sortID: $("#sortID").val(),
                status: $("#status:checked").val()
            },
            success: function(response) {
                $("form[name='categoryDetails']")[0].reset();
                $("#msg").html(response);
                $("#addCategoryModal").modal('hide');
                showCategoriesData();
            }
        });
    }
}

//delete category
function deleteCategory(id) {
    swal({
        title: "Are you sure?",
        text: "Do you really want to remove this category?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((isDeleted) => {
        if (isDeleted) {
            $.ajax({
                url: "ManageCategories.php",
                type: "POST",
                data: {
                    action: "deleteCategory",
                    id: id,
                    columnName: "id"
                },
                success: function(response) {
                    if(response=="success") {
                        swal("Deleted Category Successfully", {
                            icon: "success",
                        });
                        showCategoriesData();
                        $("#msg").html("");
                    } 
                    else {
                        swal("This category containes items, so can't remove that", {
                            icon: "info",
                        });
                        showCategoriesData();
                        $("#msg").html("");
                    }
                }
            });
        } 
        else {
          swal("Your category is safe!");
        }
    });
}

//update category
function updateCategory(id) {
    $.ajax({
        url: "ManageCategories.php",
        type: "POST",
        dataType: "json",
        data: {
            action: "updateCategory",
            id: id
        },
        success: function(response) {
            //append data in modal form
            $("#msg").html("");
            $("#category_id").val(response.id);
            $("#updatedCategoryType").val(response.menu_type);
            $("#updatedSortID").val(response.sort_order);
            if(response.status=="1") {
                $("#updatedStatus_1").attr("checked","checked");
            }
            else {
                $("#updatedStatus_2").attr("checked","checked");
            }
        }
    });
}

//store updated data in table
function updatedCategoryData() {
    var valid = $("form[name='categoryUpdateDetails']").valid();
    if(valid) {
        //get updated data
        $.ajax({
            url: "ManageCategories.php",
            type: "POST",
            data: {
                action: "updatedCategoryData",
                category_id: $("#category_id").val(),
                categoryType: $("#updatedCategoryType").val(),
                sort_order: $("#updatedSortID").val(),
                status: $('input[name="updatedStatus"]:checked').val()
            },
            success: function(response) {
                $("#msg").html(response);
                showCategoriesData();
                $("#updateModal").modal('hide');
            }
        });
    }
}

//redirecting admin to login page after logout
function logout() {
    $.ajax({
        url: "ManageCategories.php",
        type: "POST",
        data: {
            action: "logout"
        },
        success: function(response) {
            $(location).attr("href","admin_login.php");
        }
    });
}
