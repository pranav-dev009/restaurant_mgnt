$(document).ready(function () {
    showUsersData();
});

//display users data
function showUsersData() {
    $.ajax({
        url: "ManageUsers.php",
        type: "POST",
        data: {
            action: "showUsersData",
        },
        success: function(response) {
            $("#userTable").html(response);
            $('#userResult').DataTable({
                "order": [0, 'asc'],
                "columnDefs": [{"targets": [2,3], "orderable": false}],
                "pageLength": 5,
                "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ]
            });
        }
    });
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
