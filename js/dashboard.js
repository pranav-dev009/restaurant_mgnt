//redirecting admin to login page after logout
function logout() {
    $.ajax({
        url: "dashboard.php",
        type: "POST",
        data: {
            action: "logout"
        },
        success: function(response) {
            $(location).attr("href","admin_login.php");
        }
    });
}
