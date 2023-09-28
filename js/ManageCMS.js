$(document).ready(function () {
    //validate form data
    $("form[name='cmsDetails']").validate({
        rules: {
            pageTitle: {
                required: true
            },
            pageName: {
                required: true
            },
            pageDesc: {
                required: true
            },
            metaTitle:{
                required: true
            },
            metaKeyword:{
                required: true
            },
            metaDesc:{
                required: true
            }
        },
        messages: {
            pageTitle: {
                required: "Please enter page title"
            },
            pageName: {
                required: "Please enter page name"
            },
            pageDesc: {
                required: "Please enter page description"
            },
            metaTitle:{
                required: "Please enter meta title"
            },
            metaKeyword:{
                required: "Please enter meta keywords"
            },
            metaDesc:{
                required: "Please enter meta description"
            }
            
        }
    });
    
    //validate form data
    $("form[name='cmsUpdateDetails']").validate({
        rules: {
            updatedPageTitle: {
                required: true
            },
            updatedPageDesc: {
                required: true
            },
            updatedMetaTitle:{
                required: true
            },
            updatedMetaKeyword:{
                required: true
            },
            updatedMetaDesc:{
                required: true
            }
        },
        messages: {
            updatedPageTitle: {
                required: "Please enter page title"
            },
            updatedPageDesc: {
                required: "Please enter page description"
            },
            updatedMetaTitle:{
                required: "Please enter meta title"
            },
            updatedMetaKeyword:{
                required: "Please enter meta keywords"
            },
            updatedMetaDesc:{
                required: "Please enter meta description"
            }
            
        }
    });
    showCMSData();
});

//display cms data
function showCMSData() {
    $.ajax({
        url: "ManageCMS.php",
        type: "POST",
        data: {
            action: "showCmsData",
        },
        success: function(response) {
            $("#cmsTable").html(response);
            $('#cmsResult').DataTable({
                "order": [0, 'asc'],
                "columnDefs": [{"targets": [1,4,5], "orderable": false}],
                "pageLength": 5,
                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ]
            });
        }
    });
}

//add cms
function addCMS() {
    var valid=$("form[name='cmsDetails']").valid();
    if(valid) {
        $.ajax({
            url: "ManageCMS.php",
            type: "POST",
            data: {
                action: "insertData",
                pageTitle: $("#pageTitle").val(),
                pageName: $("#pageName").val(),
                pageDesc: $("#pageDesc").val(),
                metaTitle: $("#metaTitle").val(),
                metaKeyword: $("#metaKeyword").val(),
                metaDesc: $("#metaDesc").val()
            },
            success: function(response) {
                $("form[name='cmsDetails']")[0].reset();
                $("#msg").html(response);
                $("#addCMSModal").modal('hide');
                showCMSData();
            }
        });
    }
}

//update cms
function updateCMS(id) {
    $.ajax({
        url: "ManageCMS.php",
        type: "POST",
        dataType: "json",
        data: {
            action: "updateCMS",
            id: id
        },
        success: function(response) {
            //append data in modal form
            $("#msg").html("");
            $("#page_id").val(response.id);
            $("#updatedPageName").val(response.name);
            $("#updatedPageTitle").val(response.page_title);
            $("#updatedPageDesc").val(response.page_desc);
            $("#updatedMetaTitle").val(response.meta_title);
            $("#updatedMetaKeyword").val(response.meta_keywords);
            $("#updatedMetaDesc").val(response.meta_desc);
        }
    });
}

//store updated data in table
function updatedCMSData() {
    var valid=$("form[name='cmsUpdateDetails']").valid();
    if(valid) {
        //get updated data
        $.ajax({
            url: "ManageCMS.php",
            type: "POST",
            data: {
                action: "updatedCMSData",
                page_id: $("#page_id").val(),
                page_title: $("#updatedPageTitle").val(),
                page_desc: $("#updatedPageDesc").val(),
                meta_title: $("#updatedMetaTitle").val(),
                meta_keywords: $("#updatedMetaKeyword").val(),
                meta_desc: $("#updatedMetaDesc").val()
            },
            success: function(response) {
                $("#msg").html(response);
                showCMSData();
                $("#updateModal").modal('hide');
            }
        });
    }
}

//redirecting admin to login page after logout
function logout() {
    $.ajax({
        url: "ManageCMS.php",
        type: "POST",
        data: {
            action: "logout"
        },
        success: function(response) {
            $(location).attr("href","admin_login.php");
        }
    });
}
